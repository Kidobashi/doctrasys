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
            return redirect('/')->with('success', 'No Results Found');
        }
    }
}
