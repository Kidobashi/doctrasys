<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use App\Models\Offices;
use App\Models\TrackingLogs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Arr;
use App\Models\Comments;
use App\Models\Issues;

class QrController extends Controller
{
    //
    public function index(){
        return Documents::all();
    }

    public function qrInfo($referenceNo){

        $id = Documents::where('referenceNo', $referenceNo)->pluck('id')->first();

        $comments = Comments::where('documents_id', $id)->orderBy('created_at', 'DESC')->get();

        $latestComments = Comments::where('documents_id', $id)->orderBy('created_at', 'DESC')->take(4)->get();

        $officeN = DB::table('documents')
        ->join('offices', 'receiverOffice', 'offices.id')
        ->where('documents.referenceNo', $referenceNo)
        ->first();

        $offices = Offices::all();

        $data = DB::table('documents')
        ->join('offices', 'senderOffice', 'offices.id')
        ->where('referenceNo','LIKE', "%{$referenceNo}%")
        ->first();

        // $issue = Issues::where('referenceNo', $referenceNo)->first();

        $docCategory = DB::table('documents')
        ->join('document_type', 'docType', 'document_type.id')
        ->where('referenceNo','LIKE', "%{$referenceNo}%")
        ->first();

        $light = TrackingLogs::join('offices', 'receiverOffice', 'offices.id')
        ->where('referenceNo', 'LIKE', "%{$referenceNo}%")->latest()->first();

        $lightPrev = DB::table('tracking_logs')
        ->join('offices', 'prevOffice', 'offices.id')
        ->where('referenceNo','LIKE', "%{$referenceNo}%")
        ->orderBy('created_at', 'DESC')
        ->latest()->first();

        $trackings = TrackingLogs::join('offices', 'receiverOffice', 'offices.id')
        ->where('referenceNo', $referenceNo)
        ->orderBy('created_at', 'DESC')
        ->get();

        $prev = DB::table('tracking_logs')
        ->join('offices', 'prevOffice', 'offices.id')
        ->where('referenceNo','LIKE', "%{$referenceNo}%")
        ->orderBy('created_at', 'DESC')
        ->get();

        $issue = Issues::where('docRefNo','LIKE', "%{$referenceNo}%")->first();

        $status = Documents::where('referenceNo', $referenceNo)->first();

        $altdata = array_merge(['prev' => $prev] , ['trackings' => $trackings]);

        return view('users.qrinfo')->with('issue', $issue)->with('status', $status)->with('offices', $offices)->with('officeN', $officeN)->with('docCategory', $docCategory)->with('latestComments', $latestComments)->with(['comments'=> $comments])->with('lightPrev', $lightPrev)->with('light', $light)->with(['altdata' => $altdata])->with('data', $data)->with(['prev' => $prev])->with(['trackings' => $trackings]);
    }

    public function saveQr(){
        $last = DB::table('documents')->latest('id')->first();

        $identity = $last->id;
        $number = sprintf('%04d', $identity);
        $prefix = date('Ymd');
        // $prefix = strval(strftime("%Y%m%d"));
        $month = strval(strftime("%M"));
        $day = strval(strftime("%D"));
        $stringVal = strval($number);
        $refNo = "$prefix$stringVal";

        $qr = QrCode::size(200)->generate(url($refNo),);

        return view('users.add');
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

        $doc = Documents::where('referenceNo', $referenceNo)->first();
        $newSender = Auth::user()->name;
        $newSenderOffice = Auth::user()->assignedOffice;
        $newReceiver = $request->input('receiverName');
        $newOfficeReceiver = $request->input('receiverOffice');

        TrackingLogs::create([
            'senderName' => $newSender,
            'receiverName' => $newReceiver,
            'senderOffice' => $newSenderOffice,
            'receiverOffice' => $newOfficeReceiver,
            'referenceNo' => $referenceNo,
            'action' => $request->input('action'),
            'prevOffice' => $doc->receiverOffice,
            'prevReceiver' => $doc->receiverName,
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
        // $sender = Auth::user()->email;
        // $senderOffice = Auth::user()->assignedOffice;
        $doc = Documents::where('referenceNo', $referenceNo)->first();
        $newReceiver = $request->input('receiverName');
        $newOfficeReceiver = $request->input('receiverOffice');
        // Documents::where('referenceNo', $referenceNo)->update( array('receiverName' => $newReceiver, 'receiverOffice' => $newOfficeReceiver));

        TrackingLogs::create([
            'senderName' => Auth::user()->name,
            'receiverName' => $doc->receiverName,
            'senderOffice' => Auth::user()->assignedOffice,
            'receiverOffice' => $doc->receiverOffice,
            'referenceNo' => $referenceNo,
            'action' => $request->input('action'),
        ]);

        return redirect('qrinfo/'.$referenceNo)->with('status', 'Profile updated!');
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

        Issues::create([
            'docRefNo' => $doc->referenceNo,
            'details' => $request->input('details'),
            'email' => $request->input('email'),
        ]);

        TrackingLogs::create([
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

        TrackingLogs::create([
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
}
