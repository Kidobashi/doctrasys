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
    $latestTracking = TrackingHistory::join('offices', 'receiverOffice', 'offices.id')
                         ->where('referenceNo', 'LIKE', "%{$referenceNo}%")
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

    $getDocumentCreator = Documents::where('referenceNo', $referenceNo)->first();
    $documentWithIssue = BasisOfReturn::where('referenceNumber', $referenceNo)->first();
    $primaryIssue = PrimaryReasonOfReturn::where('id', $documentWithIssue->primary_reason_of_return_id)->first();
    $serializedData = BasisOfReturn::where('referenceNumber', $referenceNo)->pluck('lacking_doc_id');
    $unserialized = $serializedData->map(function($item)
    {
        return unserialize($item);
    });

    return view('users.qrinfo')
        ->with('status', $status)
        ->with('offices', $offices)
        ->with('officeN', $officeN)
        ->with('docCategory', $docCategory)
        ->with('data', $data)
        ->with('getDocumentCreator', $getDocumentCreator)
        ->with('primaryIssue', $primaryIssue)
        ->with('documentWithIssue', $documentWithIssue)
        ->with('latestTracking', $latestTracking)
        ->with(['altdata' => $altdata])
        ->with(['selectOffice' => $selectOffice])
        ->with(['lacking'=> $lacking])
        ->with(['primaryReason'=> $primaryReason])
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

    public function receive($referenceNo){

        $doc = Documents::where('referenceNo', $referenceNo)->first();
        $offices = Offices::all();

        $officeN = DB::table('documents')
        ->join('offices', 'receiverOffice', 'offices.id')
        ->where('documents.referenceNo', $referenceNo)
        ->first();

        return view('users.receive')->with('officeN', $officeN)->with('offices', $offices)->with('doc', $doc)->with('message', 'Successfully Added!');
    }

    public function receiveDoc($referenceNo, Request $request)
    {
        $checkIfExist = TrackingHistory::where('referenceNo', $referenceNo)
        ->where('senderOffice', '=', Auth::user()->assignedOffice)
        ->exists();

        if($checkIfExist == true)
        {
            return redirect('qrinfo/'.$referenceNo)->with('error', 'As you have a history of modifying this document, You cannot modify the status of this document!');
        }
        else
        {
            $document = Documents::where('referenceNo', $referenceNo)->first();

            if(Auth::user()->assignedOffice == $document->senderOffice_id)
            {
                return redirect('qrinfo/'.$referenceNo)->with('error', 'As the creator of this document, You cannot modify the status of this document!');
            }
            else
            {
                $validatedData = $request->validate([
                    'status' => 'required',
                    'action' => 'required',
                    'senderOffice' => 'required',
                ]);

                Documents::where('referenceNo', $referenceNo)->update( array('status' => $validatedData['status'] ));

                TrackingHistory::create([
                    'referenceNo' => $referenceNo,
                    'receiverOffice' => $document->receiverOffice_id,
                    'senderOffice' => $validatedData['senderOffice'],
                    'action' => $validatedData['action'],
                    'status' => $validatedData['status'],
                ]);

                return redirect('qrinfo/'.$referenceNo)->with('message', 'This document is now received by You');
            }
        }
    }

    public function processDoc($referenceNo, Request $request)
    {
        $document = Documents::where('referenceNo', $referenceNo)->first();

        if(Auth::user()->assignedOffice == $document->senderOffice_id)
        {
            return redirect('qrinfo/'.$referenceNo)->with('error', 'As the creator of this document, You cannot modify the status of this document!');
        }
        else
        {
            $validatedData = $request->validate([
                'status' => 'required',
                'action' => 'required',
                'senderOffice' => 'required',
            ]);

            Documents::where('referenceNo', $referenceNo)->update( array('status' => $validatedData['status'] ));

            TrackingHistory::create([
                'referenceNo' => $referenceNo,
                'receiverOffice' => $document->receiverOffice_id,
                'senderOffice' => $validatedData['senderOffice'],
                'action' => $validatedData['action'],
                'status' => $validatedData['status'],
            ]);
            return redirect('qrinfo/'.$referenceNo)->with('message', 'This document is now being processed by You');
        }
    }

    public function forwardDoc($referenceNo, Request $request)
    {
        $document = Documents::where('referenceNo', $referenceNo)->first();

        if(Auth::user()->assignedOffice == $document->senderOffice_id)
        {
            return redirect('qrinfo/'.$referenceNo)->with('error', 'As the creator of this document, You cannot modify the status of this document!');
        }
        else
        {
            $validatedData = $request->validate([
                'status' => 'required',
                'action' => 'required',
                'senderOffice' => 'required',
                'receiverOffice' => 'required',
            ]);

            Documents::where('referenceNo', $referenceNo)->update( array('status' => $validatedData['status'] ));

            TrackingHistory::create([
                'referenceNo' => $referenceNo,
                'receiverOffice' => $validatedData['receiverOffice'],
                'senderOffice' => $validatedData['senderOffice'],
                'action' => $validatedData['action'],
                'status' => $validatedData['status'],
            ]);

            return redirect('qrinfo/'.$referenceNo)->with('message', 'You have forwarded this Document');
        }
    }

    public function rejectDocument($referenceNo, Request $request)
    {
        $document = Documents::where('referenceNo', $referenceNo)->first();

        if(Auth::user()->assignedOffice == $document->senderOffice_id)
        {
            return redirect('qrinfo/'.$referenceNo)->with('error', 'As the creator of this document, You cannot modify the status of this document!');
        }
        else
        {
            $validatedData = $request->validate([
                'status' => 'required',
                'action' => 'required',
                'others' => 'required',
                'receiverOffice_id' => 'required',
                'primary_reason_of_return_id' => 'required',
            ]);

            Documents::where('referenceNo', $referenceNo)->update( array('status' => $validatedData['status'] ));

            TrackingHistory::create([
                'referenceNo' => $referenceNo,
                'receiverOffice' => $validatedData['receiverOffice_id'],
                'senderOffice' => $document->senderOffice_id,
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

            return redirect('qrinfo/'.$referenceNo)->with('message', 'This Document has been rejected by You');
        }
    }

    public function returnToSender($referenceNo, Request $request)
    {
        $document = Documents::where('referenceNo', $referenceNo)->first();

        if(Auth::user()->assignedOffice == $document->senderOffice_id)
        {
            return redirect('qrinfo/'.$referenceNo)->with('error', 'As the creator of this document, You cannot modify the status of this document!');
        }
        else
        {
            $validatedData = $request->validate([
                'status' => 'required',
                'action' => 'required',
                'senderOffice' => 'required',
            ]);

            Documents::where('referenceNo', $referenceNo)->update( array('status' => $validatedData['status'] ));

            TrackingHistory::create([
                'referenceNo' => $referenceNo,
                'receiverOffice' => $document->senderOffice_id,
                'senderOffice' => $validatedData['senderOffice'],
                'action' => $validatedData['action'],
                'status' => $validatedData['status'],
            ]);

            return redirect('qrinfo/'.$referenceNo)->with('message', 'This document is being returned to the sender by You');
        }
    }

    public function resubmitDoc($referenceNo, Request $request)
    {
        $document = Documents::where('referenceNo', $referenceNo)->first();

        if(Auth::user()->assignedOffice != $document->senderOffice_id)
        {
            return redirect('qrinfo/'.$referenceNo)->with('error', 'You do not have the permission to resubmit this document.');
        }
        else
        {
            $validatedData = $request->validate([
                'status' => 'required',
                'action' => 'required',
                'senderOffice' => 'required',
            ]);

            Documents::where('referenceNo', $referenceNo)->update( array('status' => $validatedData['status'] ));

            TrackingHistory::create([
                'referenceNo' => $referenceNo,
                'receiverOffice' => $document->receiverOffice_id,
                'senderOffice' => $validatedData['senderOffice'],
                'action' => $validatedData['action'],
                'status' => $validatedData['status'],
            ]);

            return redirect('qrinfo/'.$referenceNo)->with('message', 'This document is being resubmitted');
        }
    }

}
