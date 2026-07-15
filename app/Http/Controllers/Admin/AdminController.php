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
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Pagination\LengthAwarePaginator;

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



public function clientLeads(Request $request)
{
    try {

        $response = Http::get('https://lead.filliptechnologies.com/api/leadlist');

        if (!$response->successful()) {
            return back()->with('error', 'Unable to fetch leads.');
        }

        $leads = collect($response->json('data.leads', []));

        // Search
        if ($request->filled('search')) {
            $search = strtolower($request->search);

            $leads = $leads->filter(function ($lead) use ($search) {
                return str_contains(strtolower($lead['name'] ?? ''), $search)
                    || str_contains(strtolower($lead['email'] ?? ''), $search)
                    || str_contains(strtolower($lead['phone'] ?? ''), $search);
            })->values();
        }

        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $currentItems = $leads->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginatedLeads = new LengthAwarePaginator(
            $currentItems,
            $leads->count(),
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );
        

        return view('admin.leads.ClientLeads', compact('paginatedLeads'));

    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }
}

public function autherprofile(){
    return view('profiles.profile');
}


}
