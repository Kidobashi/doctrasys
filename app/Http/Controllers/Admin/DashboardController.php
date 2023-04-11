<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Documents;
use App\Models\DocumentType;
use App\Models\LackingDocuments;
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
        $approvedDocs = Documents::where('status', 12)->count();
         //Sent Back/Status 3
        $sentBackDocs = Documents::where('status', 5)
                    ->orWhere('status', 11)->count();

        $documents = Offices::leftJoin('documents', 'offices.id', '=', 'documents.senderOffice_id')
            ->select('offices.id', 'offices.officeName', DB::raw('count(documents.id) as total'))
            ->groupBy('offices.id', 'offices.officeName')
            ->orderByDesc('total')
            ->get();

            // Extract the data from the query results
            $officeNames = $documents->pluck('officeName')->toArray();
            $totalDocuments = $documents->pluck('total')->toArray();

            // Create the chart data as a JSON object
            $chartData = [
                'labels' => $officeNames,
                'datasets' => [
                    [
                        'label' => 'Total Documents',
                        'backgroundColor' => '#007bff',
                        'data' => $totalDocuments,
                    ]
                ]
            ];

            // Create the chart options as a JSON object
            $chartOptions = [
                'scales' => [
                    'yAxes' => [
                        [
                            'ticks' => [
                            'beginAtZero' => true,
                        ],
                    ],
                ],
            ],
        ];

        $documentTypes = DocumentType::leftJoin('documents', 'document_type.id', '=', 'documents.docType')
                ->select('document_type.id', 'document_type.docType', DB::raw('COUNT(documents.id) as total'))
                ->groupBy('document_type.id', 'document_type.docType')
                ->orderByDesc('total')
                ->get();

        // Extract the data from the query results
        $docTypes = $documentTypes->pluck('docType')->toArray();
        $docTypeCounts = $documentTypes->pluck('total')->toArray();

         $docTypeChartData = [
                'labels' => $docTypes,
                'datasets' => [
                    [
                        'label' => 'Total Documents',
                        'backgroundColor' => '#007bff',
                        'data' => $docTypeCounts,
                    ]
                ]
            ];

            // Create the chart options as a JSON object
            $docTypeChartOptions = [
                'scales' => [
                    'yAxes' => [
                        [
                            'ticks' => [
                            'beginAtZero' => true,
                        ],
                    ],
                ],
            ],
        ];

        $data = [
            'labels' => ['Documents'],
            'datasets' => [
                [
                    'label' => 'Created',
                    'backgroundColor' => '#36a2eb',
                    'data' => [$totalDocs],
                ],
                [
                    'label' => 'Approved',
                    'backgroundColor' => '#4bc0c0',
                    'data' => [$approvedDocs],
                ],
                [
                    'label' => 'Rejected',
                    'backgroundColor' => '#ff6384',
                    'data' => [$sentBackDocs],
                ],
            ]
        ];


        $date = date('Y-m-d');
        $docsToday = Documents::where('created_at',  $date)->count();
        $receivedDocs = TrackingHistory::where('action', 1)->groupby('referenceNo')->count();

        return view('admin.dashboard', compact('data', 'documents', 'chartData', 'chartOptions', 'documentTypes', 'docTypeChartData', 'docTypeChartOptions'))
        ->with(['totalDocs' => $totalDocs])
        ->with('sentBack', $sentBackDocs)
        ->with('taggedDocs', $approvedDocs)
        ->with('circulatingDocs', $circulatingDocs)
        ->with('receivedDocs', $receivedDocs)
        ->with('docsToday', $docsToday);
    }

    public function adminOffice()
    {
        $offices = Offices::paginate(15);

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

    public function updateOffice(Request $request, $id)
    {
        $rules = [
            'officename' => 'required | unique:offices,officeName,except,id|max:255',
        ];

        $messages = [
            'officename.required' => "This field is required",
            'officenme.unique' => 'Already Exists',
        ];

        $validatedData = Validator::make($request->all(), $rules, $messages);

        if($validatedData->fails()){
            return back()->with('error', $validatedData->errors()->first());
        }
        else
        {
            $title_cased = ucwords($request->input('officename'));

            $office = Offices::findOrFail($id);
            $office->officeName = $title_cased;
            $office->save();

            return back()->with('message', 'Updated Successfully');
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

    public function updateDocType(Request $request, $id)
    {
        $rules = [
            'doctype' => 'required | unique:document_type,docType,except,id|max:255',
        ];

        $messages = [
            'doctype.required' => "This field is required",
            'doctype.unique' => 'Already Exists',
        ];

        $validatedData = Validator::make($request->all(), $rules, $messages);

        if($validatedData->fails()){
            return back()->with('error', $validatedData->errors()->first());
        }
        else
        {
            $title_cased = ucwords($request->input('doctype'));

            $doctype = DocumentType::findOrFail($id);
            $doctype->doctype = $title_cased;
            $doctype->save();

            return back()->with('message', 'Updated Successfully');
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

        $lackingDocs = LackingDocuments::all();

        return view('admin.types-of-report')->with(['reports' => $reports])->with(['lackingDocs' => $lackingDocs]);
    }

    public function editTypeOfReport($id)
    {
        $reports = PrimaryReasonOfReturn::findOrFail($id);

        return view('admin.modals.edit-type-report-modal')->with('reports', $reports);
    }

    public function updateTypeOfReport(Request $request, $id)
    {
        $rules = [
            'reason' => 'required| unique:primary_reason_of_returns,reason| max:255',
        ];

        $messages = [
            'reason.required' => "This field is required",
            'reason.unique' => 'Already Exists',
        ];

        $validatedData = Validator::make($request->all(), $rules, $messages);

        if($validatedData->fails()){
            return back()->with('error', $validatedData->errors()->first());
        }
        else
        {
            $title_cased = ucwords($request->input('reason'));

            $lackingdocument = PrimaryReasonOfReturn::findOrFail($id);
            $lackingdocument->reason = $title_cased;
            // Update other fields as needed
            $lackingdocument->save();

            return back()->with('message', 'Updated Successfully');
        }
    }

    public function addTypeOfReport(Request $request)
    {
        $rules = [
            'report' => 'required | unique:primary_reason_of_returns,reason,except,id',
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
            $title_cased = ucwords($request->input('report'));

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

    public function addRequiredDocument(Request $request)
    {
        $rules = [
            'requiredDoc' => 'required | unique:lacking_documents,name,except,id',
        ];

        $messages = [
            'requiredDoc.required' => "This field is required",
            'requiredDoc.unique' => 'Already Exists',
        ];

        $validatedData = Validator::make($request->all(), $rules, $messages);

        if($validatedData->fails()){
            return back()->with('error', $validatedData->errors()->first());
        }
        else
        {
            $title_cased = ucwords($request->input('requiredDoc'));

            LackingDocuments::insert([
                'name' => $title_cased,
            ]);

            return back()->with('message', 'Added Successfully');
        }
    }

    public function editRequiredDocument($id)
    {
        $lackingdocument = LackingDocuments::findOrFail($id);

        return view('admin.modals.edit-required-document-modal')->with('lackingdocument', $lackingdocument);
    }

    public function updateRequiredDocument(Request $request, $id)
    {
        $rules = [
            'name' => 'required| unique:lacking_documents,name| max:255',
        ];

        $messages = [
            'name.required' => "This field is required",
            'name.unique' => 'Already Exists',
        ];

        $validatedData = Validator::make($request->all(), $rules, $messages);

        if($validatedData->fails()){
            return back()->with('error', $validatedData->errors()->first());
        }
        else
        {
            $title_cased = ucwords($request->input('name'));

            $lackingdocument = LackingDocuments::findOrFail($id);
            $lackingdocument->name = $title_cased;
            $lackingdocument->save();

            return back()->with('message', 'Updated Successfully');
        }
    }


    public function enableRequiredDocument($id)
    {
        $primaryReason = LackingDocuments::find($id);

        if (! $primaryReason) {
            return back()->with('error', 'Type of Report not found');
        }
        else{
            LackingDocuments::where('id', $primaryReason->id)->update( array('status' => 1 ));
            return back()->with('message', 'Document Requirement Enabled');
        }
    }

    public function disableRequiredDocument($id)
    {
        $requiredDoc = LackingDocuments::find($id);

        if (! $requiredDoc) {
            return back()->with('error', 'No results found');
        }
        else{
            LackingDocuments::where('id', $requiredDoc->id)->update( array('status' => 2 ));
            return back()->with('message', 'Document Requirement Disabled');
        }
    }
}
