<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssingTask;
use App\Models\Tasks;
use Illuminate\Support\Facades\Auth;

class InternController extends Controller
{
    public function InternTask()
    {
        $id = Auth::guard('intern')->check() ? Auth::guard('intern')->user()->id : '';
        $tasks = AssingTask::with(['addtask', 'user'])->where('employee_id', $id)->get();

        return view('admin.taskList.intern_task', compact('tasks'));

    }
}
