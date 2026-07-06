<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'role' => 'required',
            'password' => 'required',
        ]);

        if ($request->role == 'super_admin') {

            if (Auth::guard('super_admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                 $authUser = Auth::guard('super_admin')->user();
                  $request->session()->regenerate();
                 if($authUser->role == 'super_admin'){
                  return redirect()->route('admin.dashboard');
                 }else{
                   return redirect()->route('admin')->with('error', 'Invalid Credentials');
                 }
            } else {
                return back()->with('error', 'Hello '.ucfirst($request->role).', your invalid credentials.');
            }

        }elseif ($request->role == 'employee') {
            if(Auth::guard('employee')->attempt(['email'=>$request->email,'password'=>$request->password])){
                $request->session()->regenerate();
                $authUser= Auth::guard('employee')->user();
                if($authUser->role == 'employee'){
                    return redirect()->route('employee.dashboard');
                }else{
                   return redirect()->route('admin')->with('error', 'Invalid Credentials');
                 }

            }else {
                return back()->with('error', 'Hello '.ucfirst($request->role).', your invalid credentials.');
            }
        }elseif ($request->role == 'team_leader') {
            if(Auth::guard('team_leader')->attempt(['email'=>$request->email,'password'=>$request->password])){
                $request->session()->regenerate();
                $authUser= Auth::guard('team_leader')->user();
                if($authUser->role == 'team_leader'){
                    return redirect()->route('teamhead.dashboard');
                }else{
                   return redirect()->route('admin')->with('error', 'Invalid Credentials');
                }

            }else {
                return back()->with('error', 'Hello '.ucfirst($request->role).', your invalid credentials.');
            }
            }elseif ($request->role == 'project_manager') {
                if(Auth::guard('project_manager')->attempt(['email'=>$request->email,'password'=>$request->password])){
                    $request->session()->regenerate();
                    $authUser= Auth::guard('project_manager')->user();
                    if($authUser->role == 'project_manager'){
                        return redirect()->route('admin.dashboard');
                    }else{
                    return redirect()->route('admin')->with('error', 'Invalid Credentials');
                    }

                }else {
                    return back()->with('error', 'Hello '.ucfirst($request->role).', your invalid credentials.');
                }
            }else{
            return redirect('/')->with('error','Username And Password Invalide');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('super_admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');

    }
   public function emplogout(Request $request)
{
    Auth::guard('employee')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
}


    public function update_password()
    {
        return view('admin.include.change_password');
    }

    public function update(Request $request)
    {

        $request->validate([
            'current_password' => ['required'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
        ]);

        $admin = auth('admin')->user();

        if (! $admin) {
            return redirect()->back()->withErrors(['error' => 'Unauthorized access']);
        }
        if (! Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors([
                'current_password' => 'Current password does not match',
            ]);
        }
        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect()
            ->route('admin')
            ->with('status', 'Password changed successfully');
    }
}
