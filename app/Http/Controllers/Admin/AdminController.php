<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login_admin()
    {
        User::create([
            'name' => 'Admin',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('admin@123'),
            'role_id'=> '1',
            'designation'=>"C.O",
            'phone'=>'7545999990',
            'status'=>'active',
            'profile'=>'default.jpg'
        ]);

        return view('admin.login.signin');
    }

    public function admin_login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password, ])) {

            return redirect('/admin/dashboard');
        }

        return back()->with('error', 'Invalid credentials.');

    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect('/admin/login');
    }

    public function dashboard()
    {

        return view('admin.dashboard');
    }
}
