<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssingTask;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function employeeTask()
    {
        $id = Auth::guard('employee')->check() ? Auth::guard('employee')->user()->id : '';
        $tasks = AssingTask::with(['addtask', 'user'])->where('employee_id', $id)->get();
        return view('admin.taskList.employee_task', compact('tasks'));

    }
}
