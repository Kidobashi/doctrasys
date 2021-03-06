<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use Illuminate\Http\Request;
use App\Models\Offices;
use App\Models\TrackingLogs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Dompdf\Dompdf;

class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $docs = Documents::all();

        return view('users.index', compact(['docs']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showOffices()
    {
        //
        $offices = Offices::all();

        $last = DB::table('documents')->latest('id')->first();

        $identity = $last->id + 1;
        $number = sprintf('%04d', $identity);
        $prefix = date('Ymd');
        // $prefix = strval(strftime("%Y%m%d"));
        $month = strval(strftime("%M"));
        $day = strval(strftime("%D"));
        $stringVal = strval($number);
        $refNo = "$prefix$stringVal";

        return view('users.add')->with('offices', $offices)->with('refNo', $refNo);
    }

    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        //
        // $sender = Auth::user()->email;

        $last = DB::table('documents')->latest('id')->first();

        $identity = $last->id + 1;
        $number = sprintf('%04d', $identity);
        $prefix = date('Ymd');
        // $prefix = strval(strftime("%Y%m%d"));
        $month = strval(strftime("%M"));
        $day = strval(strftime("%D"));
        $stringVal = strval($number);
        $refNo = "$prefix$stringVal";

        $qr = QrCode::format('png')->size('200')->merge('../public/images/cmulogo.png')->generate(url($refNo),'../public/qrcodes/qr'. $refNo .'.png');

        $request->validate([
            'senderName' => 'required',
            'receiverName' => 'required',
            'senderOffice' => 'required',
            'receiverOffice' => 'required',
        ]);

        Documents::create([
            'senderName' => request('senderName'),
            'receiverName' => request('receiverName'),
            'senderOffice' => request('senderOffice'),
            'receiverOffice' => request('receiverOffice'),
            'referenceNo' => $refNo,
        ]);

        TrackingLogs::create([
            'senderName' => request('senderName'),
            'receiverName' => request('receiverName'),
            'senderOffice' => request('senderOffice'),
            'receiverOffice' => request('receiverOffice'),
            'referenceNo' => $refNo,
        ]);

        return redirect('add-document')->with('message', 'Successfully Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function fileGenerator($token)
    {
        $last = DB::table('documents')->latest('id')->first();
        $identity = $last->id + 1;
        $number = sprintf('%04d', $identity);
        $prefix = date('Ymd');
        // $prefix = strval(strftime("%Y%m%d"));
        $month = strval(strftime("%M"));
        $day = strval(strftime("%D"));
        $stringVal = strval($number);
        $refNo = "$prefix$stringVal";

        $pdf = PDF::loadView('users.testpdf')->setOptions(['defaultFont' => 'sans-serif']);

        return $pdf->download('doc_qr_'.$refNo.'.pdf');
    }
}
