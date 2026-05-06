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
            'user_type' => 'required',
            'password' => 'required',
        ]);

        if ($request->user_type == 'admin') {

            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                $request->session()->regenerate();

                return redirect()->route('admin.dashboard');
            } else {
                return back()->with('error', 'Hello '.ucfirst($request->user_type).', your invalid credentials.');
            }

        } elseif ($request->user_type == 'employee') {

            if (Auth::guard('employee')->attempt(['email' => $request->email, 'password' => $request->password])) {
                $request->session()->regenerate();

                return redirect()->route('employee.dashboard');
            } else {
                return back()->with('error', 'Hello '.ucfirst($request->user_type).', your invalid credentials.');
            }

        } elseif ($request->user_type == 'intern') {
            if (Auth::guard('intern')->attempt(['email' => $request->email, 'password' => $request->password])) {

                $request->session()->regenerate();

                return redirect()->route('intern.dashboard');
            } else {
                return back()->with('error', 'Hello '.ucfirst($request->user_type).', your invalid credentials.');
            }

        } else {
            return back()->with('error', 'Unauthorized')->withInput();
        }
    }

    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();

        }
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');

    }
    public function emplogout(Request $request)
    {
        if (Auth::guard('employee')->check()) {
            Auth::guard('employee')->logout();

        }
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function internLogout(Request $request)
    {
        if (Auth::guard('intern')->check()) {
            Auth::guard('intern')->logout();
        }

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
