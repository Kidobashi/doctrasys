<?php

namespace App\Http\Controllers;

use App\Models\Documents;
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

        return view('users.qrinfo')->with('data', $data);
    }

    public function saveQr(){
        $last = DB::table('documents')->latest('id')->first();

        $identity = $last->id + 1;
        $number = sprintf('%04d', $identity);
        $prefix = strval(strftime("%Y"));
        $stringVal = strval($number);
        $refNo = "$prefix$stringVal";

        $qr = QrCode::size(100)->generate(url($refNo),);

        return view('users.add');
    }

    public function forward($referenceNo){

        $doc = Documents::where('referenceNo', $referenceNo)->first();

        return view('partials.forward')->with('doc', $doc)->with('message', 'Successfully Added!');;
    }

    public function update($referenceNo,Request $request){

        $doc = Documents::find($referenceNo);
        $doc->receiverName = $request->input('receiverName');
        $doc->save();

        return view('users.qrinfo')->with('message', 'Successfully Forwarded!');;
    }

}
