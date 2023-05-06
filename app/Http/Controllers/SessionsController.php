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
                return redirect()->route('admin.dashboard')->with('message', 'Login Success');
            } else {
                return redirect()->route('index')->with('message', 'Login Success');
            }
        } else {
            // Authentication failed, redirect back to login page with error message
            return redirect()->route('index')->with('error', 'Invalid login credentials.');
        }
    }

    public function destroy()
    {

        Auth::logout();

        return redirect('/')->with(['message'=>'You\'ve been logged out.']);
    }
}
