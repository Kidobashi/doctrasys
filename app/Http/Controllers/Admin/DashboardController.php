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

        return view('admin.dashboard')->with(['totalDocs' => $totalDocs])->with('sentBack', $sentBack)->with('taggedDocs', $taggedDocs)->with('circulatingDocs', $circulatingDocs)->with('receivedDocs', $receivedDocs)->with('docsToday', $docsToday);
    }

    public function adminOffice()
    {
        $offices = Offices::paginate(10);

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
        $docType = DocumentType::all();

        return view('admin.documentType')->with(['docType' => $docType]);
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
