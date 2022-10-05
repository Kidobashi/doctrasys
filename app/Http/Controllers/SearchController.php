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
        $checkdata = Documents::where('referenceNo', $search)->exists();

        if($checkdata)
        {
            $data = Documents::where('referenceNo', $search)->first();
            return redirect('qrinfo/'.$data->referenceNo);
        }
        else
        {
            return redirect('index')->with('success', 'No Results Found');
        }
    }

    public function getSearch(Request $request){

        $search = $request['search'];

        $data = Documents::where('referenceNo', $search)->first();
        $exist = Documents::findOrFail($data);

        return redirect('qrinfo/'.$search);
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
