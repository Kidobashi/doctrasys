<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Documents;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $totalDocs = Documents::all()->count();
        //Tagged Status Finished/Received By Intended User
        $sentBack = Documents::where('status', 3)->count();
        //Sent Back/Status 3
        return view('dashboard')->with(['totalDocs' => $totalDocs])->with('sentBack', $sentBack);
    }
}
