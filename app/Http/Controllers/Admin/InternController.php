<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tasks;
use Illuminate\Support\Facades\Auth;

class InternController extends Controller
{
    public function employeeTask()
    {
        $id = Auth::guard('intern')->check() ? Auth::guard('intern')->user()->id : '';
         $tasks = Tasks::with(['project'])->where('assigned_to', $id)->get();

        return view('admin.taskList.intern_task', compact('tasks'));

    }
}
