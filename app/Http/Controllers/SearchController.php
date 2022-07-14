<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use Illuminate\Http\Request;
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

        if($data === null){
            return view('users.index')->with(Session::flash('message', 'Document does not exist'));
        }
        else{
            return view('users.index')->with('data', $data);
        }

        // return view('users.index')->with('data', $data);
    }
}
