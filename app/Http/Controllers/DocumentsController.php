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
use Illuminate\Support\Facades\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

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

        $offices = Offices::where('status', 1)->get();

        // Pass documents data to users.index view
        return view('users.index', compact(['docs']))->with(['offices' => $offices]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showOffices()
    {
        //
        $eachDocTypeCount = DocumentType::leftJoin('documents', 'document_type.id', '=', 'documents.docType')
        ->where('documents.user_id', Auth::user()->id)
        ->select('document_type.id', 'document_type.docType', DB::raw('COUNT(documents.id) as total'))
        ->groupBy('document_type.id', 'document_type.docType')
        ->get();

        $totalDocByUser = Documents::where('user_id', Auth::user()->id)->count();

        $last = DB::table('documents')->latest('id')->first();

        $offices = Offices::where('status', 1)->get();

        $users = User::all();

        $assignedOffice = Auth::user()->assignedOffice;

        $docType = DocumentType::where('status', 1)->get();

        $document = new Documents();

        if(isset($last))
        {
            $identity = $last->id + 1;
        }
        else{
            $identity = 1;
        }

        $number = sprintf('%04d', $identity);
        $prefix = date('Ymd');
        $stringVal = strval($number);

        if($assignedOffice < 10)
        {
            $extraZero = '0';
            $refNo = "$prefix$extraZero$assignedOffice$stringVal";
            return view('users.add')->with(['docType'=> $docType])->with(['offices'=> $offices])->with('refNo', $refNo)->with(['users' => $users])->with(['document' => $document])->with(['eachDocTypeCount' => $eachDocTypeCount])->with('totalDocByUser', $totalDocByUser);
        }else{
            $refNo = "$prefix$assignedOffice$stringVal";
            return view('users.add')->with(['docType'=> $docType])->with(['offices'=> $offices])->with('refNo', $refNo)->with(['users' => $users])->with(['document' => $document])->with(['eachDocTypeCount' => $eachDocTypeCount])->with('totalDocByUser', $totalDocByUser);
        }
    }

    public function showStats()
    {
        $eachDocTypeCount = DocumentType::leftJoin('documents', 'document_type.id', '=', 'documents.docType')
                ->select('document_type.id', 'document_type.docType', DB::raw('COUNT(documents.id) as total'))
                ->groupBy('document_type.id', 'document_type.docType')
                ->get();

        return view('users.add')->with(['eachDocTypeCount' => $eachDocTypeCount]);
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
             'referenceNo' => 'required',
             'senderOffice_id' => 'required',
             'receiverOffice_id' => 'required',
             'docType' => 'required',
             'user_id' => 'required',
         ]);

         if($senderOffice == $validatedData['receiverOffice_id'])
         {
            return redirect()->back()->with('error', "You can't send document to yourself");
         }
         else {
            Documents::create($validatedData);

            TrackingHistory::create([
                'senderOffice' => $validatedData['senderOffice_id'],
                'receiverOffice' => $validatedData['receiverOffice_id'],
                'referenceNo' => $validatedData['referenceNo'],
                'status' => 1,
                'action' => 1,
                'user_id' => $validatedData['user_id'],
            ]);

            $receiverOfficeName = Offices::findOrFail($validatedData['receiverOffice_id'])->officeName;
            $senderOfficeName = Offices::findOrFail($validatedData['senderOffice_id'])->officeName;
            $flashRefNo = $validatedData['referenceNo'];
            $flashDocType = DocumentType::findOrFail($validatedData['docType'])->docType;

            $qrs = QrCode::format('png')->size('200')->errorCorrection('H')->generate(url('qrinfo/'.$flashRefNo));
            $filename = 'qr'.$flashRefNo.'.png';
            $filePath = public_path('qrcodes/') . $filename;
            file_put_contents($filePath, $qrs);

            // public_path('qrcodes/'.$filename);
            session()->flash('qrcode', asset('qrcodes/' . $filename));

            return redirect()->back()->with('message', "Successfully Added!")
                             ->with('dctyp', $flashDocType)
                             ->with('recv', $receiverOfficeName)
                             ->with('sndr', $senderOfficeName)
                             ->with('flashRefNo', $flashRefNo);
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

    public function userDocs(Request $request)
{
    // Define the user ID and fetch necessary models
    $userId = Auth::user()->id;
    $offices = Offices::where('status', 1)->get(['id', 'officeName']);
    $allDocTypes = DocumentType::where('status', 1)->get(['id', 'docType']);

    // Build the documents query with optional search parameter
    $documents = Documents::where('user_id', $userId);
    if ($query = $request->input('search')) {
        $documents->where('referenceNo', 'LIKE', "%$query%");
    }

    // Apply sorting and pagination, returning error if no results
    $all = $documents->orderBy('created_at', $request->get('sort', 'desc'))
                     ->paginate(20);
    if ($all->isEmpty() && $query) {
        return back()->with('error', 'No results found');
    }

    // Fetch totals using a single query with subqueries for each status
    $totals = Documents::selectRaw("
            COUNT(*) AS total_doc,
            SUM(status IN (9,10)) AS total_approved,
            SUM(status IN (1,2,3,4,5,6,7,8)) AS total_processing,
            SUM(status = 11) AS total_rejected
        ")
        ->where('user_id', $userId)
        ->first();
    // dd($totals);
    // Return the view with all necessary data
    return view('users.documents', compact('all', 'offices', 'allDocTypes', 'totals'));
}

    public function downloadQrCode(Request $request)
    {
        $referenceNo = $request->input('referenceNo');
        $filepath = public_path('qrcodes/qr'.$referenceNo.'.png');

        return Response::download($filepath);
    }

    public function googleDocu(Request $request)
    {
        $validatedData = $request->validate([
            'referenceNo' => 'required',
            'senderOffice_id' => 'required',
            'receiverOffice_id' => 'required',
            'docType' => 'required',
            'user_id' => 'required',
        ]);
    }
}
