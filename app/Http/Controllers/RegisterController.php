<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Offices;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function create()
    {
        $offices = Offices::all();

        return view('session.register')->with('offices', $offices);
    }

    public function store()
    {
        $attributes = request()->validate([
            'assignedOffice' => ['required'],
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users', 'email')],
            'password' => ['required', 'min:5', 'max:20'],
            'agreement' => ['accepted']
        ]);

        $attributes['password'] = bcrypt($attributes['password']);

        // Create the user
        $user = User::create($attributes);

        // Assign a role to the user
        $role = Role::where ('name', 'User')->first(); // Replace "admin" with the actual name of the role you want to assign
        $user->roles()->sync([$role->id]);

        event(new Registered($user));

        // Log in the user and redirect to the dashboard
        Auth::login($user);

        return redirect('/index')->with('message', 'Your account has been created.');
    }
}
