<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use App\Models\Offices;
use App\Models\TrackingLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrController extends Controller
{
    //
    public function index(){
        return Documents::all();
    }

    public function qrInfo($referenceNo){

        $data = DB::table('documents')
        ->join('offices', 'senderOffice', 'offices.id')
        ->where('referenceNo','LIKE', "%{$referenceNo}%")
        ->first();

        $alt = DB::table('documents')
        ->join('offices', 'receiverOffice', 'offices.id')
        ->where('referenceNo','LIKE', "%{$referenceNo}%")
        ->first();

        $secAlt = DB::table('documents')
        ->join('offices', 'senderOffice', 'offices.id')
        ->where('referenceNo','LIKE', "%{$referenceNo}%")
        ->first();

        $trackings = DB::table('tracking_logs')
        ->join('offices', 'receiverOffice', 'offices.id')
        ->where('referenceNo', $referenceNo)->get();


        return view('users.qrinfo')->with('data', $data)->with(['trackings' => $trackings])->with('alt', $alt)->with('secAlt', $secAlt);
    }

    public function saveQr(){
        $last = DB::table('documents')->latest('id')->first();

        $identity = $last->id + 1;
        $number = sprintf('%04d', $identity);
        $prefix = date('Ymd');
        // $prefix = strval(strftime("%Y%m%d"));
        $month = strval(strftime("%M"));
        $day = strval(strftime("%D"));
        $stringVal = strval($number);
        $refNo = "$prefix$stringVal";

        $qr = QrCode::size(100)->generate(url($refNo),);

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

    public function receive($referenceNo){

        $doc = Documents::where('referenceNo', $referenceNo)->first();
        $offices = Offices::all();

        $officeN = DB::table('documents')
        ->join('offices', 'receiverOffice', 'offices.id')
        ->where('documents.referenceNo', $referenceNo)
        ->first();

        return view('users.receive')->with('officeN', $officeN)->with('offices', $offices)->with('doc', $doc)->with('message', 'Successfully Added!');
    }

    // public function receive($referenceNo, Request $request)
    // {
    //     $doc = Documents::where('referenceNo', $referenceNo)->first();
    //     $offices = Offices::all();

    //     $officeN = DB::table('documents')
    //     ->join('offices', 'receiverOffice', 'offices.id')
    //     ->where('documents.referenceNo', $referenceNo)
    //     ->first();

    //     $newReceiver = $request->input('receiverName');
    //     $newOfficeReceiver = $request->input('receiverOffice');

    //     Documents::where('referenceNo', $referenceNo)->update( array('receiverName' => $newReceiver, 'receiverOffice' => $newOfficeReceiver));

    //     TrackingLogs::create([
    //         'senderName' => $doc->senderName,
    //         'receiverName' => $newReceiver,
    //         'senderOffice' => $doc->senderOffice,
    //         'receiverOffice' => $newOfficeReceiver,
    //         'referenceNo' => $referenceNo,
    //         'action' => $request->input('action'),
    //     ]);

    //     return view('users.receive')->with('officeN', $officeN)->with('offices', $offices)->with('doc', $doc)->with('message', 'Successfully Added!');
    // }

}
