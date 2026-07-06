<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AttendanceExport;
use App\Http\Controllers\Controller;
use App\Models\AddTask;
use App\Models\AttendanceInfo;
use App\Models\Project;
use App\Models\TakeLeave;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function login_admin()
    {
        // dd(Hash::make('admin@123'));
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
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $tasks = Project::whereBetween('end_date', [$startOfWeek, $endOfWeek])
            ->orderBy('end_date', 'desc')
            ->get();

        return view('admin.reports.weekly', compact('tasks'));
    }

    public function report()
    {
        $reports = AddTask::with(['project', 'user'])->paginate(10);
        return view('admin.reports.report', compact('reports'));
    }

    public function attendanceList(Request $request)
    {
        $query = AttendanceInfo::with(['employee', 'project']);
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        $attendances = $query->orderBy('date', 'desc')->paginate(8);

        return view('admin.attendance.listingattendance', compact('attendances'));
    }

    public function export()
    {
        return Excel::download(new AttendanceExport, 'attendance.xlsx');
    }

    public function leaveLive(Request $request)
    {
        $datas = TakeLeave::with(['employee'])->paginate(10);

        return view('admin.attendance.leaveList', compact('datas'));
    }
}
