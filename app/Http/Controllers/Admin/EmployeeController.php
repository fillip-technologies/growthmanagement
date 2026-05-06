<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tasks;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function employeeTask()
    {
        $id = Auth::guard('employee')->check() ? Auth::guard('employee')->user()->id : '';
        $tasks = Tasks::with(['project'])->where('assigned_to', $id)->get();

        return view('admin.taskList.employee_task', compact('tasks'));

    }
}
