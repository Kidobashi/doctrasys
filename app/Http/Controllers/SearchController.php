<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use Illuminate\Http\Request;
use App\Models\Offices;
use App\Models\TrackingLogs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SearchController extends Controller
{
    //
    public function index(){
        $index = Documents::all();

        return $index;
    }

    public function search(Request $request){
        $search = $request['search'];
        $data = Documents::where('referenceNo', $search)->first();

        return view('users.index')->with('data', $data);
    }

    public function dateFilter(Request $request)
    {
        $searchDate = $request['dateSearch'];
        $creator =  Auth::user()->name;

        $data = Documents::where([['senderName', $creator],['created_at' ,$searchDate]])
        ->join('offices', 'receiverOffice', 'offices.id')
        ->orderBy('created_at', 'asc')
        ->get()
        ->unique('referenceNo');

        return view('users.searchByDate')->with(['data' => $data]);
    }

    public function rcvOfficeFilter(Request $request)
    {
        $searchOffice = $request['receiverOffice'];
        $creator =  Auth::user()->name;

        $data = Documents::where([['senderName', $creator],['created_at' ,$searchOffice]])
        ->join('offices', 'receiverOffice', 'offices.id')
        ->orderBy('created_at', 'asc')
        ->get()
        ->unique('referenceNo');

        return view('users.filterByReceivingOffice')->with(['data' => $data]);
    }
}
