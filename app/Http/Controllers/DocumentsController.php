<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use App\Models\Offices;
use App\Models\TrackingLogs;
use App\Models\User;
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

    public function getOfficeByUser($id)
    {
        $assOff = User::where('id', $id)->pluck('assignedOffice');

        $city = DB::table('users')
        ->join('offices', 'assignedOffice', 'offices.id')
        ->where('users.assignedOffice', $assOff)
        ->get();

        return response()->json($city);
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

        $users = User::all();

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

        return view('users.add')->with('docType', $docType)->with('offices', $offices)->with('refNo', $refNo)->with('senderOffice', $senderOffice)->with(['users' => $users]);
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
        $sender = Auth::user()->name;
        $senderOffice = Auth::user()->assignedOffice;
        $rcvId = request('receiverName');

        $receiverName = User::where('id', $rcvId )->first();

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
        ]);

        Documents::insert([
            'senderName' => $sender,
            'email' => request('email'),
            'receiverName' => $receiverName->name,
            'senderOffice' =>  $senderOffice,
            'receiverOffice' => request('receiverOffice'),
            'docType' => request('docType'),
            'referenceNo' => $refNo,
            'created_at' => date('Y-m-d'),
        ]);

        TrackingLogs::create([
            'senderName' => $sender,
            'receiverName' => $receiverName->name,
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

        $circs = Documents::where('email', $userDocs)
        ->join('offices', 'receiverOffice', 'offices.id')
        ->where('status', 1)
        ->orderBy('created_at', 'DESC')->get();

        $comps = Documents::where('email', $userDocs)
        ->join('offices', 'receiverOffice', 'offices.id')
        ->where('status', 2)
        ->orderBy('created_at', 'DESC')->get();

        $sentBack = Documents::where('email', $userDocs)
        ->join('offices', 'receiverOffice', 'offices.id')
        ->where('status', 3)
        ->orderBy('created_at', 'DESC')->get();

        $offices = Offices::all();

        $all = Documents::where('email', $userDocs)
        ->join('offices', 'receiverOffice', 'offices.id')
        ->orderBy('created_at', 'DESC')->get();

        return view('users.documents')->with(['all' => $all])->with(['circs' => $circs])->with(['comps' => $comps])->with(['sentBack' => $sentBack])->with(['offices' => $offices]);
    }
}
