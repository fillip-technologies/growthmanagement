<?php

namespace App\Http\Controllers\Task;

use App\Events\AssingneTaskEvent;
use App\Http\Controllers\Controller;
use App\Mail\AssingtaskMail;
use App\Models\AddTask;
use App\Models\AssingTask;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DragTaskController extends Controller
{
    public function dragTask()
    {

        $employees = User::where('role', '!=', 'super_admin')->get();
        $tasks = AddTask::with('project')->get();
        $asingTask = AssingTask::with('addtask', 'user')->get();
        return view('admin.dragTask.dragtask', compact('employees', 'tasks', 'asingTask'));
    }

    public function assignDragTask(Request $request)
    {

        $request->validate([
            'task_id' => 'required',
            'employee_id' => 'required',
            'assigned_by'=>'required|exists:users,id',
        ]);
        $id = null;
        if (Auth::guard('team_leader')->check()) {
        $id = Auth::guard('team_leader')->id();
        } elseif (Auth::guard('project_manager')->check()) {
        $id = Auth::guard('project_manager')->id();
        }elseif(Auth::guard('super_admin')->check()){
        $id = Auth::guard('super_admin')->id();
        }

        $data = AssingTask::create([
            'addtask_id' => $request->task_id,
            'employee_id' => $request->employee_id,
            'assigned_by' => $id,
        ]);
         $task = AddTask::with('project')->where('id', $request->task_id)->first();
         $user = User::find($request->employee_id);
         Mail::to($user->email)
        ->send(new AssingtaskMail($user, $task));

        if ($data) {
            return back()->with('success', 'Task Assing SuccessFul with email');
        } else {
            return back()->with('error', 'Something went wring');
        }
    }

    public function deleteAddTask(Request $request)
    {
        try {

            $task = AddTask::findOrFail($request->id);

            $task->delete();

            return response()->json([
                'status' => true,
                'message' => 'Task Deleted Successfully',
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);

        }
    }

    public function assingdeletetask(Request $request)
    {
        try {
              $id = trim($request->id);
              AssingTask::findOrFail($id)->delete();
              return response()->json([
                'status' => true,
                'message' => 'Task Deleted Successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }


    }
}
