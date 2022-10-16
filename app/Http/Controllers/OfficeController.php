<?php

namespace App\Http\Controllers;

use App\Models\Offices;
use App\Models\User;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    //
    public function index(){

        $offices = Offices::all();

        return view('auth.register', compact(['offices']));
    }

    public function store(Request $office)
    {
        User::create([
            'assignedOffice' => request('assignedOffice')
        ]);
    }
}
