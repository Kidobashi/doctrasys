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
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use League\CommonMark\Node\Block\Document;

class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $docs = Documents::all();

        return view('users.index', compact(['docs']));
    }

    public function getOfficeByUser(Request $request)
    {
        $last = DB::table('documents')->latest('id')->first();

        $identity = $last->id;
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

            return response()->json($refNo);
        }
        else{
            $refNo = "$prefix$senderOffice$stringVal";

            return response()->json($refNo);
        }
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

        $document = new Documents();

        $identity = $last->id + 1;
        $number = sprintf('%04d', $identity);
        $prefix = date('Ymd');
        // $month = strval(strftime("%M"));
        // $day = strval(strftime("%D"));
        $stringVal = strval($number);

        if($senderOffice < 10)
        {
            $extraZero = '0';
            $refNo = "$prefix$extraZero$senderOffice$stringVal";
            return view('users.add')->with(['docType'=> $docType])->with(['offices'=> $offices])->with('refNo', $refNo)->with('senderOffice', $senderOffice)->with(['users' => $users])->with(['document' => $document]);
        }else{
            $refNo = "$prefix$senderOffice$stringVal";
            return view('users.add')->with(['docType'=> $docType])->with(['offices'=> $offices])->with('refNo', $refNo)->with('senderOffice', $senderOffice)->with(['users' => $users])->with(['document' => $document]);
        }
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

        $last = DB::table('documents')->latest('id')->first();

        $identity = $last->id;
        $number = sprintf('%04d', $identity);
        $prefix = date('Ymd');
        $stringVal = strval($number);

        if($senderOffice < 10)
        {
            $extraZero = '0';
            $refNo = "$prefix$extraZero$senderOffice$stringVal";

        $validatedData = $request->validate([
            'senderName' => 'required',
            'referenceNo' => 'required',
            'senderOffice' => 'required',
            'receiverOffice' => 'required',
            'docType' => 'required',
            'email' => 'required',
        ]);

        Documents::create($validatedData);

        TrackingLogs::create([
            'senderName' => $sender,
            'senderOffice' => $senderOffice,
            'receiverOffice' => request('receiverOffice'),
            'referenceNo' => $refNo,
        ]);

        $receiverOfficeName = Offices::findOrFail($validatedData['receiverOffice'])->officeName;
        $senderOfficeName = Offices::findOrFail($validatedData['senderOffice'])->officeName;
        $flashRefNo = $validatedData['referenceNo'];
        $flashDocType = DocumentType::findOrFail($validatedData['docType'])->documentName;

        $qrs = QrCode::format('png')->size('200')->merge('../public/images/cmulogo.png')->generate(url('qrinfo/'.$flashRefNo));
        $filename = 'qr'.$flashRefNo.'.png';
        $filePath = public_path('qrcodes/') . $filename;
        file_put_contents($filePath, $qrs);

        session()->flash('qrcode', asset('qrcodes/' . $filename));

            return redirect()->back()->with('message', "Successfully Added!")->with('dctyp', $flashDocType)->with('recv', $receiverOfficeName)->with('sndr', $senderOfficeName)->with('flashRefNo', $flashRefNo); //
        }
        else{
        // $qr = QrCode::format('png')->size('200')->merge('../public/images/cmulogo.png')->generate(url($refNo),'../public/qrcodes/qr'. $refNo .'.png');

        $refNo = "$prefix$senderOffice$stringVal";

        $validatedData = $request->validate([
            'referenceNo' => 'required',
            'senderName' => 'required',
            'senderOffice' => 'required',
            'receiverOffice' => 'required',
            'docType' => 'required',
            'email' => 'required',
        ]);

        Documents::create($validatedData);

        $receiverOfficeName = Offices::findOrFail($validatedData['receiverOffice'])->officeName;
        $senderOfficeName = Offices::findOrFail($validatedData['senderOffice'])->officeName;
        $flashRefNo = $validatedData['referenceNo'];
        $flashDocType = DocumentType::findOrFail($validatedData['docType'])->documentName;

        // $document = new Documents();
        // $document->senderName = $request->input('senderName');
        // $document->email = $request->input('email');
        // $document->senderOffice = $senderOffice;
        // $document->receiverOffice = $request->input('receiverOffice');
        // $document->docType = $request->input('docType');
        // $document->referenceNo = $request->input('referenceNo');
        // $document->created_at = date('Y-m-d');

        // $receiverOfficeName = Offices::find($document->receiverOffice);
        // $request->flash('receiverOfficeName', $receiverOfficeName->officeName);

        // $senderOfficeName = Offices::find($document->senderOffice);
        // $request->flash('item_name', $senderOfficeName->officeName);

        // $documentTypeName = DocumentType::find($document->docType);
        // $request->flash('docTypeName', $documentTypeName->documentName);

        // $document->save();

        TrackingLogs::create([
            'senderName' => $sender,
            'senderOffice' => $senderOffice,
            'receiverOffice' => request('receiverOffice'),
            'referenceNo' => $refNo,
        ]);

        // return response()->json($document);
        return redirect('add-document')->with('message', 'Successfully Added!')->with('dctyp', $flashDocType)->with('recv', $receiverOfficeName)->with('sndr', $senderOfficeName)->with('flashRefNo', $flashRefNo);
        }
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

        $offices = Offices::all();

        $all = Documents::where('email', $userDocs)
        ->join('offices', 'receiverOffice', 'offices.id')
        ->orderBy('created_at', 'DESC')->paginate(20);

        return view('users.documents')->with(['all' => $all])->with(['offices' => $offices]);
    }

    public function circulatingDocs()
    {
        $userDocs = Auth::user()->email;

        $offices = Offices::all();

        $circulating = Documents::where('email', $userDocs)
        ->join('offices', 'receiverOffice', 'offices.id')
        ->where('status', 1)
        ->orderBy('created_at', 'DESC')->paginate(20);

        return view('users.documentList.circulatingDocs')->with(['circulating' => $circulating])->with(['offices' => $offices]);
    }

    public function completedDocs()
    {
        $userDocs = Auth::user()->email;

        $offices = Offices::all();

        $completed = Documents::where('email', $userDocs)
        ->join('offices', 'receiverOffice', 'offices.id')
        ->where('status', 2)
        ->orderBy('created_at', 'DESC')->paginate(20);

        return view('users.documentList.completedDocs')->with(['completed' => $completed])->with(['offices' => $offices]);
    }

    public function sentBackDocs()
    {
        $userDocs = Auth::user()->email;

        $offices = Offices::all();

        $sentBack = Documents::where('email', $userDocs)
        ->join('offices', 'receiverOffice', 'offices.id')
        ->where('status', 3)
        ->orderBy('created_at', 'DESC')->paginate(20);

        return view('users.documentList.sentBackDocs')->with(['sentBack' => $sentBack])->with(['offices' => $offices]);
    }

    // public function fetchNames(Request $request)
    // {
    //     $officeFrom = $request->input('senderOfficeId');
    //     $officeTo = $request->input('receiverOfficeOfficeId');
    //     $docType = $request->input('docTypeId');

    //     $senderOfficeName = Offices::where('id', $officeFrom)->pluck('officeName');
    //     $receiverOfficeName = Offices::where('id', $officeTo)->pluck('officeName');
    //     $docTypeName = DocumentType::where('id', $docType)->pluck('documentName');

    //     return response()->json(['officeFrom' => $officeFrom, 'officeTo' => $officeTo, 'docType' => $docType]);

    //     // return response()->json(['senderOfficeName' => $senderOfficeName, 'receiverOfficeName' => $receiverOfficeName, 'docTypeName' => $docTypeName]);
    // }
}
