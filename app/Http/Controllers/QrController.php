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

class QrController extends Controller
{
    //
    public function index(){
        return Documents::all();
    }

    public function qrInfo($referenceNo){
        $id = Documents::where('referenceNo', $referenceNo)->pluck('id')->first();

        $comments = Comments::where('documents_id', $id)->orderBy('created_at', 'DESC')->get();

        $data = DB::table('documents')
        ->join('offices', 'senderOffice', 'offices.id')
        ->where('referenceNo','LIKE', "%{$referenceNo}%")
        ->first();

        $light = TrackingLogs::join('offices', 'receiverOffice', 'offices.id')
        ->where('referenceNo', 'LIKE', "%{$referenceNo}%")->latest()->first();

        $lightPrev = DB::table('tracking_logs')
        ->join('offices', 'prevOffice', 'offices.id')
        ->where('referenceNo','LIKE', "%{$referenceNo}%")
        ->orderBy('created_at', 'DESC')
        ->latest()->first();

        // dd($light);

        $trackings = TrackingLogs::join('offices', 'receiverOffice', 'offices.id')
        ->where('referenceNo', $referenceNo)
        ->orderBy('created_at', 'DESC')
        ->get();

        $prev = DB::table('tracking_logs')
        ->join('offices', 'prevOffice', 'offices.id')
        ->where('referenceNo','LIKE', "%{$referenceNo}%")
        ->orderBy('created_at', 'DESC')
        ->get();

        $altdata = array_merge(['prev' => $prev] , ['trackings' => $trackings]);

        return view('users.qrinfo')->with(['comments'=> $comments])->with('lightPrev', $lightPrev)->with('light', $light)->with(['altdata' => $altdata])->with('data', $data)->with(['prev' => $prev])->with(['trackings' => $trackings]);
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

        return view('partials.forward')->with('officeN', $officeN)->with('offices', $offices)->with('doc', $doc)->with('message', 'Successfully Added!');
    }

    public function update($referenceNo,Request $request){

        $doc = Documents::where('referenceNo', $referenceNo)->first();
        $newReceiver = $request->input('receiverName');
        $newOfficeReceiver = $request->input('receiverOffice');
        // $prevOffice = $request->input('prevOffice');
        // $prevReceiver = $request->input('prevReceiver');

        Documents::where('referenceNo', $referenceNo)->update( array('receiverName' => $newReceiver, 'receiverOffice' => $newOfficeReceiver));

        TrackingLogs::create([
            'senderName' => $doc->senderName,
            'receiverName' => $newReceiver,
            'senderOffice' => $doc->senderOffice,
            'receiverOffice' => $newOfficeReceiver,
            'referenceNo' => $referenceNo,
            'action' => $request->input('action'),
            'prevOffice' => $doc->receiverOffice,
            'prevReceiver' => $doc->receiverName,
        ]);

        return redirect('qrinfo/'.$referenceNo)->with('status', 'Profile updated!');
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
        Documents::where('referenceNo', $referenceNo)->update( array('receiverName' => $newReceiver, 'receiverOffice' => $newOfficeReceiver));

        TrackingLogs::create([
            'senderName' => $doc->senderName,
            'receiverName' => $newReceiver,
            'senderOffice' => $doc->senderOffice,
            'receiverOffice' => $newOfficeReceiver,
            'referenceNo' => $referenceNo,
            'action' => $request->input('action'),
        ]);

        return redirect('qrinfo/'.$referenceNo)->with('status', 'Profile updated!');
    }

}
