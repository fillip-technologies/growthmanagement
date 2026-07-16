<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\AddTask;
use App\Models\AssingTask;
use App\Models\MarkeringAsingTask;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketingEmployeeController extends Controller
{
    public function MarketingdragTask()
    {
           $id = Auth::guard('marketing_manager')->check() ? Auth::guard('marketing_manager')->user()->id : "";
           $employees = User::where('role','employee')->where('department','Marketing Department')->get();
           $tasks = AddTask::with('project')->get();
           $asingTask = AssingTask::with('addtask', 'user')->get();
           return view('admin.dragTask.dragtask', compact('employees','asingTask','tasks'));


    }
}
