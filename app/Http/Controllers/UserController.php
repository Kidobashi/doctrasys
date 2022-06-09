<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index()
    {
        $user = User::all();
        
        return view('laravel-examples.user-management')->with(['user'=> $user]);
    }
}
