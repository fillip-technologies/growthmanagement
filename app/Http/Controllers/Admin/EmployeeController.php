<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AddTask;
use App\Models\AssingTask;
use App\Models\MarkeringAsingTask;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function employeeTask()
    {

        if(Auth::guard('employee')->check()){
         $id = Auth::guard('employee')->check() ? Auth::guard('employee')->user()->id : '';
         $tasks = AssingTask::with(['addtask', 'user'])->where('employee_id', $id)->get();
         return view('admin.taskList.employee_task', compact('tasks'));
        }elseif(Auth::guard('team_leader')->check()){
         $id = Auth::guard('team_leader')->check() ? Auth::guard('team_leader')->user()->id : '';
         $tasks = AssingTask::with(['addtask', 'user'])->where('employee_id', $id)->get();
         return view('admin.taskList.employee_task', compact('tasks'));
      }

    }

    public function status(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'progress' => 'nullable',
            'employee_id' => 'nullable',
            'project_id' => 'required',
        ]);
        $getdata = Project::findOrFail($request->project_id);
        $getdata->update([
            'status' => $request->status,
        ]);
        $task = AddTask::where('project_id', $request->project_id)->first();
        if ($task) {
            $task->update([
                'progress' => $request->progress,
                'employee_id' => $request->employee_id,
            ]);

        }

        return back()->with('success', 'Status Updated Successfully');
    }
}
