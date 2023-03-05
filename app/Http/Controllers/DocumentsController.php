<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use App\Models\Offices;
use App\Models\TrackingHistory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
// use Barryvdh\DomPDF\Facade\Pdf;
// use Barryvdh\DomPDF\PDF as DomPDFPDF;
// use Dompdf\Dompdf;
// use Illuminate\Pagination\LengthAwarePaginator;
// use Illuminate\Pagination\Paginator;
// use League\CommonMark\Node\Block\Document;

class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retrieve all documents from Documents class
        $docs = Documents::all();

        // Pass documents data to users.index view
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

        $users = User::all();

        // $last = DB::table('documents')->latest('id')->first();

        $assignedOffice = Auth::user()->assignedOffice;

        $senderOffice = Offices::where('id', $assignedOffice)->pluck('officeName')->first();

        $docType = DocumentType::all();

        $document = new Documents();

        $identity = 1;
        $number = sprintf('%04d', $identity);
        $prefix = date('Ymd');
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

         $validatedData = $request->validate([
             'senderName' => 'required',
             'referenceNo' => 'required',
             'senderOffice_id' => 'required',
             'receiverOffice_id' => 'required',
             'docType' => 'required',
             'email' => 'required',
         ]);

         Documents::create($validatedData);

         TrackingHistory::create([
             'senderName' => $validatedData['senderName'],
             'senderOffice' => $validatedData['senderOffice_id'],
             'receiverOffice' => $validatedData['receiverOffice_id'],
             'referenceNo' => $validatedData['referenceNo'],
             'status' => 1,
             'action' => 1,
         ]);

         $receiverOfficeName = Offices::findOrFail($validatedData['receiverOffice_id'])->officeName;
         $senderOfficeName = Offices::findOrFail($validatedData['senderOffice_id'])->officeName;
         $flashRefNo = $validatedData['referenceNo'];
         $flashDocType = DocumentType::findOrFail($validatedData['docType'])->documentName;

         $qrs = QrCode::format('png')->size('200')->merge('../public/images/cmulogo.png')->generate(url('qrinfo/'.$flashRefNo));
         $filename = 'qr'.$flashRefNo.'.png';
         $filePath = public_path('qrcodes/') . $filename;
         file_put_contents($filePath, $qrs);

         session()->flash('qrcode', asset('qrcodes/' . $filename));

         return redirect()->back()->with('message', "Successfully Added!")
                             ->with('dctyp', $flashDocType)
                             ->with('recv', $receiverOfficeName)
                             ->with('sndr', $senderOfficeName)
                             ->with('flashRefNo', $flashRefNo);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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

    public function userDocs()
    {
        $userEmail = Auth::user()->email;

        $offices = Offices::all();

        $all = Documents::where('email', $userEmail)
            ->join('offices', 'receiverOffice_id', 'offices.id')
            ->orderBy('created_at', 'DESC')
            ->paginate(20);

        return view('users.documents')->with(['all' => $all])->with(['offices' => $offices]);
    }

    public function circulatingDocs()
    {
        $userEmail = Auth::user()->email;

        $circulating = Documents::where('email', $userEmail)
            ->join('offices', 'receiverOffice_id', 'offices.id')
            ->where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->paginate(20);

        return view('users.documentList.circulatingDocs')->with(['circulating' => $circulating]);
    }

    public function completedDocs()
    {
        $userEmail = Auth::user()->email;

        $completed = Documents::where('email', $userEmail)
            ->join('offices', 'receiverOffice_id', 'offices.id')
            ->where('status', 2)
            ->orderBy('created_at', 'DESC')
            ->paginate(20);

        return view('users.documentList.completedDocs')->with(['completed' => $completed]);
    }

    public function sentBackDocs()
    {
        $userDocs = Auth::user()->email;

        $offices = Offices::all();

        $sentBack = Documents::where('email', $userDocs)
            ->join('offices', 'receiverOffice_id', 'offices.id')
            ->where('status', 3)
            ->orderBy('created_at', 'DESC')->paginate(20);

        return view('users.documentList.sentBackDocs')->with(['sentBack' => $sentBack])->with(['offices' => $offices]);
    }
}
