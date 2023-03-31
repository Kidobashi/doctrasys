<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offices;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class UserManagementController extends Controller
{
    //
    public function index()
    {
        $users = User::with('roles', 'office')
                ->paginate(10);

        $roles = Role::all();

        $offices = Offices::where('status', 1)->get();

        return view('admin.user-management')->with('users', $users)->with(['roles' => $roles])->with(['offices' => $offices]);
    }

    public function store(Request $request)
    {
        $password = $request->input('check_password');

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

        if (Hash::check($password, Auth::user()->password))
        {
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
        else
        {
            return back()->with('error', 'Wrong Administrator Password, Try Again');
        }
    }

    public function edit($id)
    {
        $user = User::with('roles', 'office')->findOrFail($id);

        return view('admin.modals.edit-user-modal', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name' => 'required|max:255|unique:users,name,' . $id,
            'email' => 'required|unique:users,email,' . $id . '|email|max:255',
            'assignedOffice' => 'required',
            'roles' => 'required',
            'check_password' => 'required',
        ];

        $messages = [
            'name.required' => "'Name' field is required",
            'email.required' => "'Email' field is required",
            'assignedOffice.required' => "'Office' field is required",
            'roles.required' => "'Role' field is required",
            'name.unique' => 'Name already exists',
            'email.unique' => 'Email already exists',
            'check_password' => 'Password is Required',
        ];

        $password = $request->input('check_password');

        $validatedData = Validator::make($request->all(), $rules, $messages);

        if (Hash::check($password, Auth::user()->password))
        {
            // The passwords match...
            $title_cased = ucwords($request->input('name'));

            $user->name = $title_cased;
            $user->email = $request->input('email');
            $user->assignedOffice = $request->input('assignedOffice');

            if ($request->input('roles')) {
                $role = Role::where('id', $request->input('roles'))->first();
                $user->roles()->sync([$role->id]);
            }

            $user->save();

            return back()->with('message', 'User Updated Successfully');
        }
        else {

            return back()->with('error', 'Wrong Administrator Password, Try Again');
        }
    }

    public function resetPassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Send password reset email
        $status = Password::sendResetLink(['email' => $user->email]);

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('message', 'Password reset link sent to user email');
        } else {
            return back()->with('error', 'Failed to send password reset link');
        }
    }

    public function enableUser(Request $request, $id)
    {
        $password = $request->input('check_password');

        if(Hash::check($password, Auth::user()->password))
        {
            $user = User::find($id);

            if (! $user) {
                // session()->flash('error', 'Office not found'. $id);
                return back()->with('error', 'User not found');
            }
            else{
                User::where('id', $user->id)->update( array('status' => 1 ));
                return back()->with('message', 'User enabled');
            }
        }
        else
        {
            return back()->with('error', 'Wrong Administrator Password');
        }
    }

    public function disableUser(Request $request, $id)
    {
        $password = $request->input('check_password');

        $user = User::find($id);
        if(Hash::check($password, Auth::user()->password))
        {
            if (! $user) {
                // session()->flash('error', 'Office not found'. $id);
                return back()->with('error', 'User not found');
            }
            else{
                User::where('id', $user->id)->update( array('status' => 2 ));
                return back()->with('message', 'User disabled');
            }
        }
        else
        {
            return back()->with('error', 'Wrong Administrator Password');
        }
    }

    public function checkPassword(Request $request)
    {
        $password = $request->input('password');
        if (Hash::check($password, Auth::user()->password)) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
