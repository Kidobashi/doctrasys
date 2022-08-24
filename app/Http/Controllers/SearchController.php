<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use Illuminate\Http\Request;
use App\Models\Offices;
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

        $result = Documents::where([['senderName', $creator],['created_at' ,$searchDate]])->get();

        return view('users.documents')->with(['result' => $result]);
    }

}
