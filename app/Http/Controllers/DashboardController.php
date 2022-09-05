<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Documents;
use App\Models\DocumentType;
use App\Models\Offices;
use App\Models\TrackingLogs;
use Illuminate\Support\Carbon;

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

        $receivedDocs = TrackingLogs::where('action', 1)->groupby('referenceNo')->count();

        return view('dashboard')->with(['totalDocs' => $totalDocs])->with('sentBack', $sentBack)->with('taggedDocs', $taggedDocs)->with('circulatingDocs', $circulatingDocs)->with('receivedDocs', $receivedDocs)->with('docsToday', $docsToday);
    }

    public function adminOffice()
    {
        $offices = Offices::all();

        return view('laravel-examples.offices')->with(['offices' => $offices]);
    }

    public function addOffice(Request $request)
    {
        $request->validate([
            'officeName' => 'required',
        ]);

        Offices::insert([
            'officeName' => request('officeName'),
        ]);

        return redirect('offices')->withSuccess(__('Office Added successfully.'));
    }

    public function deleteOffice($id)
    {
        Offices::destroy($id);

        return redirect('offices')->withSuccess(__('Office deleted successfully.'));
    }

    public function docTypes()
    {
        $docType = DocumentType::all();

        return view('laravel-examples.documentType')->with(['docType' => $docType]);
    }

    public function addDocType(Request $request)
    {
        $request->validate([
            'documentName' => 'required',
        ]);

        DocumentType::insert([
            'documentName' => request('documentName'),
        ]);

        return redirect('docType')->withSuccess(__('Document Type Added successfully'));
    }

    public function deleteDocType($id)
    {
        DocumentType::destroy($id);

        return redirect('docType')->withSuccess(__('Document Type deleted successfully.'));
    }
}
