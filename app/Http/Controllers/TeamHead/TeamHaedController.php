<?php

namespace App\Http\Controllers\TeamHead;

use App\Http\Controllers\Controller;
use App\Models\AddTask;
use App\Models\AssingTask;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamHaedController extends Controller
{
    public function teammember(){
        $employees = [];
        if(Auth::guard('team_leader')){
        $employees = User::where('role','employee')->where('department','IT Department')->paginate(10);
        return view('admin.employees.index',compact('employees'));
        }else{
         $data = User::where('role','employee')->where('department','Marketing Department')->get();
        }
    }

    public function teamheadlogout(Request $request){
        Auth::guard('team_leader')->logout();
         $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function TeamheaddragTask()
    {
           $id = Auth::guard('team_leader')->check() ? Auth::guard('team_leader')->user()->id : "";
           $employees = User::where('role','employee')->where('department','IT Department')->get();
           $tasks = AddTask::with('project')->get();
           $asingTask = AssingTask::with('addtask', 'user')->get();

           return view('admin.dragTask.dragtask', compact('employees','asingTask','tasks'));


    }
     public function Teamheadreport()
    {
        $reports = AddTask::with(['project', 'user'])->paginate(10);
        return view('admin.reports.report', compact('reports'));
    }
}
