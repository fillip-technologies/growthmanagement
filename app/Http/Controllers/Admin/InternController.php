<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssingTask;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InternController extends Controller
{
    public function InternTask()
    {
        $id = Auth::guard('intern')->check() ? Auth::guard('intern')->user()->id : '';
        $tasks = AssingTask::with(['addtask', 'user'])->where('employee_id', $id)->get();

        return view('admin.taskList.intern_task', compact('tasks'));

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
