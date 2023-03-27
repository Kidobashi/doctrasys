<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Documents;
use App\Models\DocumentType;
use App\Models\Offices;
use App\Models\TrackingHistory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $totalDocs = Documents::all()->count();
        //Circulating Documents/Status 1
        $circulatingDocs = Documents::where('status', 1)->count();
        //Tagged Status Finished/Received By Intended User
        $taggedDocs = Documents::where('status', 2)->count();
         //Sent Back/Status 3
        $sentBack = Documents::where('status', 3)->count();

        $date = date('Y-m-d');
        $docsToday = Documents::where('created_at',  $date)->count();

        $receivedDocs = TrackingHistory::where('action', 1)->groupby('referenceNo')->count();

        return view('admin.dashboard')
        ->with(['totalDocs' => $totalDocs])
        ->with('sentBack', $sentBack)
        ->with('taggedDocs', $taggedDocs)
        ->with('circulatingDocs', $circulatingDocs)
        ->with('receivedDocs', $receivedDocs)
        ->with('docsToday', $docsToday);
    }

    public function adminOffice()
    {
        $offices = Offices::paginate(5);

        return view('admin.offices')->with(['offices' => $offices]);
    }

    public function addOffice(Request $request)
    {
        $request->validate([
            'officeName' => 'required|unique:offices,officeName,except,id',
        ]);

        Offices::insert([
            'officeName' => request('officeName'),
        ]);

        return redirect('offices')->withSuccess(__('Office Added successfully.'));
    }

    public function deleteOffice($id, Request $request)
    {
        $office = Offices::find($id);

        if (! $office) {
            session()->flash('error', 'Office not found'. $id);
            return back()->with('error', 'Office not found');
        }
        else{
            Offices::where('id', $office->id)->update( array('status' => 2 ));
            return back()->with('message', 'Office updated successfully');
        }
    }

    public function enableOffice($id)
    {
        $office = Offices::find($id);

        if (! $office) {
            session()->flash('error', 'Office not found'. $id);
            return back()->with('error', 'Office not found');
        }
        else{
            Offices::where('id', $office->id)->update( array('status' => 1 ));
            return back()->with('message', 'Office updated successfully');
        }
    }

    public function docTypes()
    {
        $docType = DocumentType::paginate(5);

        return view('admin.documentType')->with(['docType' => $docType]);
    }

    public function addDocType(Request $request)
    {
        $request->validate([
            'documentName' => 'required',
        ]);

        DocumentType::insert([
            'docType' => request('documentName'),
        ]);

        return back()->with('message', 'Document Type Added Successfully');;
    }

    public function enableDocType($id)
    {
        $docType = DocumentType::find($id);

        if (! $docType) {
            // session()->flash('error', 'Office not found'. $id);
            return back()->with('error', 'Document type not found');
        }
        else{
            DocumentType::where('id', $docType->id)->update( array('status' => 1 ));
            return back()->with('message', 'Document type enabled');
        }
    }

    public function deleteDocType($id)
    {
        $docType = DocumentType::find($id);

        if (! $docType) {
            // session()->flash('error', 'Office not found'. $id);
            return back()->with('error', 'Document type not found');
        }
        else{
            DocumentType::where('id', $docType->id)->update( array('status' => 2 ));
            return back()->with('message', 'Document type disabled');
        }
    }

    public function mostDocumentsByOffice()
    {
        $currentPage = request()->query('documents_page', 1); // Use 'documents_page' instead of 'page'
        $cacheKey = 'mostDocumentsByOffice_' . $currentPage;
        $cacheMinutes = 60;

        $documents = Cache::remember($cacheKey, $cacheMinutes, function () {
            return Offices::leftJoin('documents', 'offices.id', '=', 'documents.senderOffice_id')
                ->select('offices.id', 'offices.officeName', DB::raw('count(documents.id) as total'))
                ->groupBy('offices.id', 'offices.officeName')
                ->orderByDesc('total')
                ->paginate(5, ['*'], 'documents_page'); // Add 'documents_page' as the custom parameter
         });

        return $documents;
    }

    public function mostTypes()
    {
        $currentPage = request()->query('types_page', 1); // Use 'types_page' instead of 'page'
        $cacheKey = 'mostTypes_' . $currentPage;
        $cacheMinutes = 60;

        $documentTypes = Cache::remember($cacheKey, $cacheMinutes, function () {
            return DocumentType::leftJoin('documents', 'document_type.id', '=', 'documents.docType')
                ->select('document_type.id', 'document_type.docType', DB::raw('COUNT(documents.id) as total'))
                ->groupBy('document_type.id', 'document_type.docType')
                ->orderByDesc('total')
                ->paginate(3, ['*'], 'types_page');
        });

        return $documentTypes;
    }

}
