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
        $userId = Auth::user()->id;

        $offices = Offices::where('status', 1)->get();

        $allDocTypes = DocumentType::where('status', 1)->get();

        $query = $request->input('search');

        if ($query) {
            $all = Documents::where('user_id', $userId)
                ->where('referenceNo', 'LIKE', '%' . $query . '%')
                ->paginate(20);
            if ($all->isEmpty()) {
                return back()->with('error', 'No results found');
            }
        } else {
            $all = Documents::where('user_id', $userId)
            ->orderBy('documents.created_at', $request->get('sort', 'asc'))
            ->paginate(20);
        }

        $totalDoc = Documents::where('user_id', $userId)->count();

        $totalApproved = Documents::where('user_id', $userId)
        ->where(function ($query) {
            $query->where('status', 9)->orWhere('status', 10);
        })
        ->count();

        $totalProcessing = Documents::where('user_id', $userId)
        ->where(function ($query) {
            $query->where('status', 1)->orWhere('status', 2)->orWhere('status', 3)
            ->orWhere('status', 4)->orWhere('status', 5)->orWhere('status', 6)
            ->orWhere('status', 7)->orWhere('status', 8);
        })
        ->count();

        $totalRejected = Documents::where('user_id', $userId)
        ->where(function ($query) {
            $query->where('status', 11);
        })
        ->count();


        return view('users.documents')->with(['all' => $all])
        ->with(['offices' => $offices])
        ->with(['allDocTypes' => $allDocTypes])
        ->with('totalDoc', $totalDoc)
        ->with('totalApproved', $totalApproved)
        ->with('totalProcessing', $totalProcessing)
        ->with('totalRejected', $totalRejected);
    }

    public function circulatingDocs()
    {
        $userId = Auth::user()->id;

        $circulating = Documents::where('user_id', $userId )
            ->join('offices', 'receiverOffice_id', 'offices.id')
            ->where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->paginate(20);

        return view('users.documentList.circulatingDocs')->with(['circulating' => $circulating]);
    }

    public function completedDocs()
    {
        $userId = Auth::user()->id;

        $completed = Documents::where('user_id', $userId)
            ->join('offices', 'receiverOffice_id', 'offices.id')
            ->where('status', 2)
            ->orderBy('created_at', 'DESC')
            ->paginate(20);

        return view('users.documentList.completedDocs')->with(['completed' => $completed]);
    }

    public function sentBackDocs()
    {
        $userId = Auth::user()->id;

        $offices = Offices::all();

        $sentBack = Documents::where('user_id', $userId)
            ->join('offices', 'receiverOffice_id', 'offices.id')
            ->where('status', 3)
            ->orderBy('created_at', 'DESC')->paginate(20);

        return view('users.documentList.sentBackDocs')->with(['sentBack' => $sentBack])->with(['offices' => $offices]);
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
