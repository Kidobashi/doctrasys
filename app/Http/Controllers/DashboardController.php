<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Documents;
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

        // $mytime = Carbon::now()->format('Y-m-d');
        //  dd($mytime);
        $date = date('Y-m-d');
       $docsToday = Documents::where('created_at',  $date)->count();
    //    dd($docsToday);

        $receivedDocs = TrackingLogs::where('action', 1)->groupby('referenceNo')->count();

        return view('dashboard')->with(['totalDocs' => $totalDocs])->with('sentBack', $sentBack)->with('taggedDocs', $taggedDocs)->with('circulatingDocs', $circulatingDocs)->with('receivedDocs', $receivedDocs)->with('docsToday', $docsToday);
    }

    public function adminOffice()
    {
        $offices = Offices::all();

        return view('laravel-examples.offices')->with(['offices' => $offices]);
    }
}
