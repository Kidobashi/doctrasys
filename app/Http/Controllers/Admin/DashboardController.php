<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Documents;
use App\Models\DocumentType;
use App\Models\Offices;
use App\Models\PrimaryReasonOfReturn;
use App\Models\TrackingHistory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illumninate\Support\Str;

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
        $rules = [
            'officeName' => 'required | unique:offices,officeName,except,id',
        ];

        $messages = [
            'officeName.required' => "This field is required",
            'officeName.unique' => 'Already Exists',
        ];

        $validatedData = Validator::make($request->all(), $rules, $messages);

        if($validatedData->fails()){
            return back()->with('error', $validatedData->errors()->first());
        }
        else
        {
            $title_cased = ucwords($validatedData['officeName']);

            Offices::insert([
                'officeName' => $title_cased,
            ]);

            return redirect('offices')->with('message', 'Office Added successfully.');
        }
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

        $rules = [
            'docType' => 'required | unique:document_type,docType,except,id',
        ];

        $messages = [
            'docType.required' => "This field is required",
            'docType.unique' => 'Already Exists',
        ];

        $validatedData = Validator::make($request->all(), $rules, $messages);

        if($validatedData->fails()){
            return back()->with('error', $validatedData->errors()->first());
        }
        else
        {
            $title_cased = ucwords($validatedData['docType']);

            DocumentType::insert([
                'docType' => $title_cased,
            ]);

            return back()->with('message', 'Document Type Added Successfully');
        }
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

    public function typesOfReports()
    {
        $reports = PrimaryReasonOfReturn::paginate(5);

        return view('admin.types-of-report')->with(['reports' => $reports]);
    }

    public function addTypeOfReport(Request $request)
    {
        $rules = [
            'report' => 'required | unique:document_type,docType,except,id',
        ];

        $messages = [
            'report.required' => "This field is required",
            'report.unique' => 'Already Exists',
        ];

        $validatedData = Validator::make($request->all(), $rules, $messages);

        if($validatedData->fails()){
            return back()->with('error', $validatedData->errors()->first());
        }
        else
        {
            $title_cased = ucwords($validatedData['report']);

            PrimaryReasonOfReturn::insert([
                'reason' => $title_cased,
            ]);

            return back()->with('message', 'Type of report Added Successfully');
        }
    }

    public function enableTypeOfReport($id)
    {
        $primaryReason = PrimaryReasonOfReturn::find($id);

        if (! $primaryReason) {
            // session()->flash('error', 'Office not found'. $id);
            return back()->with('error', 'Type of Report not found');
        }
        else{
            PrimaryReasonOfReturn::where('id', $primaryReason->id)->update( array('status' => 1 ));
            return back()->with('message', 'Type of Report enabled');
        }
    }

    public function deleteTypeOfReport($id)
    {
        $primaryReason = PrimaryReasonOfReturn::find($id);

        if (! $primaryReason) {
            // session()->flash('error', 'Office not found'. $id);
            return back()->with('error', 'Type of Report not found');
        }
        else{
            PrimaryReasonOfReturn::where('id', $primaryReason->id)->update( array('status' => 2 ));
            return back()->with('message', 'Type of report disabled');
        }
    }
}
