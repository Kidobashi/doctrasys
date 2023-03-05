<?php

namespace App\Http\Controllers;

use App\Models\BasisOfReturn;
use App\Models\Documents;
use App\Models\Offices;
use App\Models\TrackingHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Arr;
use App\Models\Comments;
// use App\Models\Issues;
use App\Models\LackingDocuments;
use App\Models\PrimaryReasonOfReturn;
use App\Models\User;

use function GuzzleHttp\json_encode;

class QrController extends Controller
{
    //
    public function index(){
        return Documents::all();
    }

    public function qrInfo($referenceNo)
    {
    $documents_query = Documents::where('referenceNo', $referenceNo);
    $document_id = $documents_query->pluck('id')->first();

    // Fetch all offices that should appear as a dropdown selection.
    $selectOffice = Offices::all();

    // Fetch office data where documents were offered.
    $officeN = DB::table('documents')
                ->join('offices', 'receiverOffice_id', 'offices.id')
                ->where('documents.referenceNo', $referenceNo)
                ->first();

    // Fetch all offices from DB.
    $offices = Offices::all();

    // Fetch document data from DB suing reference no.
    $data = DB::table('documents')
              ->join('offices', 'senderOffice_id', 'offices.id')
              ->where('referenceNo','LIKE', "%{$referenceNo}%")
              ->first();

    // Fetch document type data from DB using reference no.
    $docCategory = DB::table('documents')
                     ->join('document_type', 'docType', 'document_type.id')
                     ->where('referenceNo','LIKE', "%{$referenceNo}%")
                     ->first();

    // Fetch tracking log info from DB using reference no, sorted by newest to oldest.
    $light = TrackingHistory::join('offices', 'receiverOffice', 'offices.id')
                         ->where('referenceNo', 'LIKE', "%{$referenceNo}%")
                         ->latest()
                         ->first();

    // Fetch previous tracking log info from DB using reference no, sorted by newest to oldest.
    $lightPrev = TrackingHistory::join('offices', 'prevOffice', 'offices.id')
                   ->where('referenceNo','LIKE', "%{$referenceNo}%")
                   ->orderBy('created_at', 'DESC')
                   ->latest()
                   ->first();

    // Fetch tracking log info from DB using reference no, sorted by newest to oldest.
    $trackings       = TrackingHistory::join('offices', 'receiverOffice', 'offices.id')
                                   ->where('referenceNo', $referenceNo)
                                   ->orderBy('created_at', 'DESC')
                                   ->get();

    // Fetch tracking log info of the previous office from DB using reference no, sorted by newest to oldest.
    $prev            = TrackingHistory::join('offices', 'prevOffice', 'offices.id')
                         ->where('referenceNo','LIKE', "%{$referenceNo}%")
                         ->orderBy('created_at', 'DESC')
                         ->get();

    // Fetch issue info from DB using reference number.
    // $issue           = Issues::where('docRefNo','LIKE', "%{$referenceNo}%")->first();
    $primaryReason = PrimaryReasonOfReturn::all();

    $lacking         = LackingDocuments::all();

    // Fetch status info from DB using reference number.
    $status = Documents::where('referenceNo', $referenceNo)->first();

    // Merge both arrays together.
    $altdata = array_merge(['prev' => $prev], ['trackings' => $trackings]);

    $selectOffice = Offices::all();

    $getDocumentCreator = Documents::where('referenceNo', $referenceNo)->pluck('senderOffice_id')->first();

    $serializedData = BasisOfReturn::where('referenceNumber', $referenceNo)->pluck('lacking_doc_id');
    $unserialized = $serializedData->map(function($item)
    {
        return unserialize($item);
    });
    // dd($returnedLackingDocuments);

    return view('users.qrinfo')
        ->with('status', $status)
        ->with('offices', $offices)
        ->with('officeN', $officeN)
        ->with('docCategory', $docCategory)
        ->with('data', $data)
        ->with('lightPrev', $lightPrev)
        ->with('light', $light)
        ->with(['altdata' => $altdata])
        ->with(['selectOffice' => $selectOffice])
        ->with(['lacking'=> $lacking])
        ->with(['primaryReason'=> $primaryReason])
        ->with('getDocumentCreator', $getDocumentCreator)
        ->with(['boxArray' => $unserialized]);
    }


    public function search(Request $request)
    {
        //
        $output = "";
        $last = DB::table('documents')->latest('id')->first();

        $identity = $last->id + 1;
        $number = sprintf('%04d', $identity);
        $prefix = date('Ymd');
    // $prefix = strval(strftime("%Y%m%d"));
        $month = strval(strftime("%M"));
            $day = strval(strftime("%D"));
            $stringVal = strval($number);
            // $refNo = "$prefix$stringVal";

            $senderOffice = Auth::user()->assignedOffice;

            if($senderOffice < 10)
            {
                $extraZero = '0';
                $refNo = "$prefix$extraZero$senderOffice$stringVal";
            }
             else{
                $refNo = "$prefix$senderOffice$stringVal";
            }


        return view('users.add', compact('refNo'));
    }

    public function selectOffice()
    {
        $selectOffice = Offices::all();

        return view('users.qrinfo')->with(['selectOffice' => $selectOffice]);
    }

    public function altSearch(Request $request)
    {
        $search = $request->input('search');

        if($request->ajax())
        {
            $output = "";
            $results = DB::table('users')
            ->join('offices', 'assignedOffice', 'offices.id')
            ->where('name', $search )
            ->orWhere('email',$search )
            ->orwhere('phone',$search )
            ->get();
        }
        return response($results);
    }

    public function forward($referenceNo){

        $doc = Documents::where('referenceNo', $referenceNo)->first();
        $offices = Offices::all();

        $officeN = DB::table('documents')
        ->join('offices', 'receiverOffice', 'offices.id')
        ->where('documents.referenceNo', $referenceNo)
        ->first();

        return view('partials.forward')->with('officeN', $officeN)->with('offices', $offices)->with('doc', $doc)->with('success', 'Forwarded Successfully!');
    }

    public function update($referenceNo,Request $request){

        $doc = TrackingHistory::where('referenceNo', $referenceNo)
        ->orderBy('created_at', 'DESC')->first();

        $newOffice = $request->input('receiverOffice');

        $prevOffice = $doc->receiverOffice;
        $prevReceiver = $doc->receiverName;
        $newSender = Auth::user()->name;
        $newSenderOffice = Auth::user()->assignedOffice;
        $newReceiver = $request->input('receiverName');
        $newOfficeReceiver = User::where('name', $newReceiver)->first();

        TrackingHistory::create([
            'senderName' => $newSender,
            'receiverName' => $newReceiver,
            'senderOffice' => $newSenderOffice,
            'receiverOffice' => $newOffice,
            'referenceNo' => $referenceNo,
            'action' => $request->input('action'),
            'prevOffice' => $prevOffice,
            'prevReceiver' => $prevReceiver,
        ]);

        return redirect('qrinfo/'.$referenceNo)->with('success', 'Forwarded Sucessfully');
    }

    public function receive($referenceNo){

        $doc = Documents::where('referenceNo', $referenceNo)->first();
        $offices = Offices::all();

        $officeN = DB::table('documents')
        ->join('offices', 'receiverOffice', 'offices.id')
        ->where('documents.referenceNo', $referenceNo)
        ->first();

        return view('users.receive')->with('officeN', $officeN)->with('offices', $offices)->with('doc', $doc)->with('message', 'Successfully Added!');
    }

    public function receiveDoc($referenceNo,Request $request){
        $doc = TrackingHistory::where('referenceNo', $referenceNo)
        ->orderBy('created_at', 'DESC')->first();
        $prevOffice = $doc->receiverOffice;
        $prevReceiver = $doc->receiverName;
        $newReceiver = $request->input('receiverName');
        $newOfficeReceiver = $request->input('receiverOffice');

        $initial = Documents::where('referenceNo', $referenceNo)->first();

        // if($initial->receiverName == Auth::user()->name){

            $success = 2;

            Documents::where('referenceNo', $referenceNo)->update( array('status' => $success));

            TrackingHistory::create([
                'senderName' => Auth::user()->name,
                'receiverName' => $doc->receiverName,
                'senderOffice' => Auth::user()->assignedOffice,
                'receiverOffice' => $doc->receiverOffice,
                'referenceNo' => $referenceNo,
                'action' => $success,
                'prevOffice' => $prevOffice,
                'prevReceiver' => $prevReceiver,
            ]);

            // return redirect('qrinfo/'.$referenceNo)->with('success', 'Received by Intended User');
        // }
        // else{

        // TrackingLogs::create([
        //     'senderName' => Auth::user()->name,
        //     'receiverName' => $doc->receiverName,
        //     'senderOffice' => Auth::user()->assignedOffice,
        //     'receiverOffice' => $doc->receiverOffice,
        //     'referenceNo' => $referenceNo,
        //     'action' => $request->input('action'),
        //     'prevOffice' => $prevOffice,
        //     'prevReceiver' => $prevReceiver,
        // ]);

        return redirect('qrinfo/'.$referenceNo)->with('success', 'Received');
        // }
    }

    public function processDoc($referenceNo, Request $request)
    {
        $success = $request->input('status');
        // dd($success);

        Documents::where('referenceNo', $referenceNo)->update( array('status' => $success));

        return redirect('qrinfo/'.$referenceNo);
    }

    public function sendBack($referenceNo, Request $request)
    {
        $doc = Documents::where('referenceNo', $referenceNo)->first();

        $sendBack = $request->input('status');
        Documents::where('referenceNo', $referenceNo)->update( array('status' => $sendBack));

        $prev = DB::table('tracking_logs')
        ->where('referenceNo','LIKE', "%{$referenceNo}%")
        ->orderBy('created_at', 'DESC')
        ->first();

        $owner = Documents::where('referenceNo','LIKE', "%{$referenceNo}%")
        ->first();

        // Issues::create([
        //     'docRefNo' => $doc->referenceNo,
        //     'details' => $request->input('details'),
        //     'email' => $request->input('email'),
        // ]);

        TrackingHistory::create([
            'senderName' => Auth::user()->name,
            'receiverName' => $owner->senderName,
            'senderOffice' => Auth::user()->assignedOffice,
            'receiverOffice' => $owner->senderOffice,
            'referenceNo' => $referenceNo,
            'action' => 4,
            'status' => 3,
        ]);

        return redirect('qrinfo/'.$referenceNo)->with('sentBack', 'Issue Reported');
    }

    public function fixIssue($referenceNo, Request $request)
    {
        $sendBack = $request->input('status');
        Documents::where('referenceNo', $referenceNo)->update( array('status' => $sendBack));

        $prev = DB::table('tracking_logs')
        ->where('referenceNo','LIKE', "%{$referenceNo}%")
        ->orderBy('created_at', 'DESC')
        ->first();

        TrackingHistory::create([
            'senderName' => $prev->senderName,
            'receiverName' => $prev->receiverName,
            'senderOffice' => $prev->senderOffice,
            'receiverOffice' => $prev->receiverOffice,
            'referenceNo' => $referenceNo,
            'action' => $request->input('action'),
            'status' => 4,
        ]);

        return redirect('qrinfo/'.$referenceNo)->with('fixIssue', 'Issue Fixed, You may forward it now');
    }

    public function returnRejectedDocument($referenceNo, Request $request)
    {

        $validatedData = $request->validate([
            'status' => 'required',
            'action' => 'required',
            'others' => 'required',
            'receiverOffice_id' => 'required',
            'primary_reason_of_return_id' => 'required',
        ]);

        $document = Documents::where('referenceNo', $referenceNo)->pluck('senderOffice_id')->first();

        Documents::where('referenceNo', $referenceNo)->update( array('status' => $validatedData['status'] ));

        TrackingHistory::create([
            'referenceNo' => $referenceNo,
            'receiverOffice' => $validatedData['receiverOffice_id'],
            'senderOffice' => $document,
            'action' => $validatedData['action'],
            'status' => $validatedData['status'],
        ]);

        $data = serialize($request->input('lacking_doc_id'));

        $basis = new BasisOfReturn();
        $basis->referenceNumber = $referenceNo;
        $basis->primary_reason_of_return_id = $validatedData['primary_reason_of_return_id'];
        $basis->lacking_doc_id = $data;
        $basis->others = $validatedData['others'];
        $basis->save();
        // BasisOfReturn::create([
        //     'referenceNumber' => $referenceNo,
        //     'primary_reason_of_return_id' => $validatedData['primary_reason_of_return_id'],
        //     'lacking_doc_id' => serialize($validatedData['lacking_doc_id']),
        //     'others' => $validatedData['others'],
        // ]);

        return redirect('qrinfo/'.$referenceNo)->with('message', 'Ayos Ka');
    }
}
