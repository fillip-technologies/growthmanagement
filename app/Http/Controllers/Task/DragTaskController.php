<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\AddTask;
use App\Models\User;
use Illuminate\Http\Request;

class DragTaskController extends Controller
{
    public function dragTask(){
        $employees =User::where("role_id","!=","1")->get();
        $tasks = AddTask::with('project')->get();

        return view('admin.dragTask.dragtask',compact('employees','tasks'));
    }
}
