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

        $userDocs = Auth::user()->email;

        $circs = Documents::where('email', $userDocs)
        ->join('offices', 'receiverOffice', 'offices.id')
        ->where('status', 1)
        ->orderBy('created_at', 'DESC')->get();

        $comps = Documents::where('email', $userDocs)
        ->join('offices', 'receiverOffice', 'offices.id')
        ->where('status', 2)
        ->orderBy('created_at', 'DESC')->get();

        $sentBack = Documents::where('email', $userDocs)
        ->join('offices', 'receiverOffice', 'offices.id')
        ->where('status', 3)
        ->orderBy('created_at', 'DESC')->get();

        $offices = Offices::all();

        return view('users.documents')->with(['result' => $result])->with(['circs' => $circs])->with(['comps' => $comps])->with(['sentBack' => $sentBack])->with(['offices' => $offices]);
    }

}
