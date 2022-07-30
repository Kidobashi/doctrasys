<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use App\Models\DocumentType;
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

        $assignedOffice = Auth::user()->assignedOffice;

        $senderOffice = Offices::where('id', $assignedOffice)->pluck('officeName')->first();

        $docType = DocumentType::all();

        // $assignedOffice = Offices::where('')->first();

        $identity = $last->id + 1;
        $number = sprintf('%04d', $identity);
        $prefix = date('Ymd');
        // $prefix = strval(strftime("%Y%m%d"));
        $month = strval(strftime("%M"));
        $day = strval(strftime("%D"));
        $stringVal = strval($number);
        $refNo = "$prefix$stringVal";

        return view('users.add')->with('docType', $docType)->with('offices', $offices)->with('refNo', $refNo)->with('senderOffice', $senderOffice);
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
        $sender = Auth::user()->email;
        $senderOffice = Auth::user()->assignedOffice;

        // dd($senderOffice);

        $last = DB::table('documents')->latest('id')->first();

        $identity = $last->id + 1;
        $number = sprintf('%04d', $identity);
        $prefix = date('Ymd');
        // $prefix = strval(strftime("%Y%m%d"));
        $month = strval(strftime("%M"));
        $day = strval(strftime("%D"));
        $stringVal = strval($number);
        $refNo = "$prefix$stringVal";

        // $qr = QrCode::format('png')->size('200')->merge('../public/images/cmulogo.png')->generate(url($refNo),'../public/qrcodes/qr'. $refNo .'.png');

        $request->validate([
            'senderName' => 'required',
            'receiverName' => 'required',
            'senderOffice' =>  'required',
            'receiverOffice' => 'required',
            'email' => 'required',
        ]);

        Documents::create([
            'senderName' => request('senderName'),
            'email' => request('email'),
            'receiverName' => request('receiverName'),
            'senderOffice' =>  $senderOffice,
            'receiverOffice' => request('receiverOffice'),
            'docType' => request('docType'),
            'referenceNo' => $refNo,
        ]);

        TrackingLogs::create([
            'senderName' => $sender,
            'receiverName' => request('receiverName'),
            'senderOffice' => $senderOffice,
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
        // $assignedOffice = Auth::user()->assignedOffice;

        // $senderOffice = Offices::where('id', $assignedOffice)->pluck('officeName');

        // dd($senderOffice);

        // return view('users.add')->with('senderOffice', $senderOffice);
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

    public function userDocs()
    {
        $userDocs = Auth::user()->email;

        $docs = Documents::where('email', $userDocs)
        ->join('offices', 'receiverOffice', 'offices.id')
        ->orderBy('created_at', 'DESC')->paginate(5);

        return view('users.documents')->with(['docs' => $docs]);
    }
}
