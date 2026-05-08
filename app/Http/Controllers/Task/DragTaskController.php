<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Mail\AssingtaskMail;
use App\Models\AddTask;
use App\Models\AssingTask;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DragTaskController extends Controller
{
    public function dragTask()
    {

        $employees = User::where('role_id', '!=', '1')->get();
        $tasks = AddTask::with('project')->get();
        $asingTask = AssingTask::with('addtask', 'user')->get();

        return view('admin.dragTask.dragtask', compact('employees', 'tasks', 'asingTask'));
    }

    public function assignDragTask(Request $request)
    {
        $request->validate([
            'task_id' => 'required',
            'employee_id' => 'required',
        ]);

        $data = AssingTask::create([
            'addtask_id' => $request->task_id,
            'employee_id' => $request->employee_id,
        ]);
        $task = AddTask::with('project')->where('id', $request->task_id)->first();
        $user = User::find($request->employee_id);
        Mail::to($user->email)->send(new AssingtaskMail($task, $user));
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
