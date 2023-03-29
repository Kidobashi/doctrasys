<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offices;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserManagementController extends Controller
{
    //
    public function index()
    {
        $users = User::with('roles', 'office')
                // ->leftJoin('offices', 'users.assignedOffice', '=', 'offices.id')
                ->paginate(10);
                // dd($users);
                // dd($users->map(function ($user) {
                //     return [
                //         'user_id' => $user->id,
                //         'user_name' => $user->name,
                //         'roles' => $user->roles->pluck('name')->toArray(),
                //     ];
                // }));
        $roles = Role::all();

        // $user_roles = User::paginate(10);

        $offices = Offices::where('status', 1)->get();

        return view('admin.user-management')->with('users', $users)->with(['roles' => $roles])->with(['offices' => $offices]);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255|unique:users',
            'email' => 'required|unique:users|email|max:255',
            'password' => 'required|min:8|confirmed',
            'assignedOffice' => 'required',
            'roles' => 'required',
        ];

        $messages = [
            'name.required' => "'Name' field is required",
            'email.required' => "'Email' field is required",
            'name.required' => "'Password' field is required",
            'assignedOffice.required' => "'Office' field is required",
            'roles.required' => "'Role' field is required",
            'password.required' => "'Password' field is required",
            'name.unique' => 'Name already exists',
            'email.unique' => 'Email already exists',
            'password.confirmed' => 'Password does not match',
            'password.min' => 'Password must be at least 8 characters long',
        ];

        $validatedData = Validator::make($request->all(), $rules, $messages);

        if($validatedData->fails()){
            return back()->with('error', $validatedData->errors()->first());
        }
        else
        {
            $title_cased = ucwords($request->input('name'));

            $user = User::create([
                'name' => $title_cased,
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'assignedOffice' => $request->input('assignedOffice'),
            ]);

            if ($request->input('roles')) {
                $role = Role::where('id', $request->input('roles'))->first();
                $user->roles()->sync([$role->id]);
            }

            return back()->with('message', 'User Added Successfully');
        }
    }
}
