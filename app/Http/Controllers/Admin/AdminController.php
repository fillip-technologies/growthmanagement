<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tasks;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login_admin()
    {

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

    public function weeklyReport()
    {
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::SUNDAY);

        $tasks = Tasks::with('user')
            ->whereBetween('deadline', [$startOfWeek, $endOfWeek])
            ->get();

        return view('admin.reports.weekly', compact('tasks'));
    }
}
