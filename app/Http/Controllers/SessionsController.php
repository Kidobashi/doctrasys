<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class SessionsController extends Controller
{
    public function create()
    {
        return view('session.login-session');
    }

    public function authenticate(Request $request)
    {
        // Attempt to authenticate the user
        if (Auth::attempt($request->only('email', 'password'))) {
            // Authentication successful, redirect to appropriate page
            if (User::find(auth()->id())->hasRole('Admin')) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('index');
            }
        } else {
            // Authentication failed, redirect back to login page with error message
            return redirect()->route('login')->with('error', 'Invalid login credentials.');
        }
    }
    // public function store(Request $request)
    // {
    //     $attributes = request()->validate([
    //         'email'=>'required|email',
    //         'password'=>'required'
    //     ]);

    //     if(Auth::attempt($attributes))
    //     {
    //         session()->regenerate();
    //         return back()->with(['message'=>'You are logged in.']);
    //     }
    //     else{

    //         return back()->withErrors(['email'=>'Email or password invalid.']);
    //     }
    //     // // Attempt to authenticate the user
    //     // if (Auth::attempt($request->only('email', 'password'))) {
    //     //     // Authentication successful, redirect to appropriate page
    //     //     if (Auth::user()->role->name === 'Admin') {
    //     //         return redirect()->route('admin.dashboard');
    //     //     } else {
    //     //         return redirect()->route('user.dashboard');
    //     //     }
    //     // } else {
    //     //     // Authentication failed, redirect back to login page with error message
    //     //     return redirect()->route('login')->with('error', 'Invalid login credentials.');
    //     // }
    // }


    public function destroy()
    {

        Auth::logout();

        return redirect('/index')->with(['message'=>'You\'ve been logged out.']);
    }
}
