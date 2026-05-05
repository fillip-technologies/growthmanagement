<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\TaskSendEmail;
use App\Models\Tasks;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
   
    public function index()
    {
        $task = Tasks::all();
        if ($task->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Task Not Fount',
                'data' => null,
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'All Tasks Here',
            'data' => $task,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


   public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'         => 'required|string|max:255',
            'attachments'   => 'required|array',
            'attachments.*' => 'file|max:10240',
            'task_name'     => 'required|string|max:255',
            'deadline'      => 'required|date',
            'assigned_to'   => 'required|exists:users,id',
            'status'        => 'required|in:pending,in_progress,completed',
            'description'   => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Errors',
                'errors'  => $validator->errors(),
            ], 422);
        }


        $files = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $name = time().'_'.$file->getClientOriginalName();
                $path = $file->storeAs('tasks/attachments', $name, 'public');
                $files[] = $path;
            }
        }


        $task = Tasks::create([
            'title'       => $request->title,
            'task_name'   => $request->task_name,
            'deadline'    => $request->deadline,
            'assigned_to' => $request->assigned_to,
            'status'      => $request->status,
            'description' => $request->description,
            'attechment'  => $files,
        ]);

        $user = User::find($request->assigned_to);
        Mail::to($user->email)->send(new TaskSendEmail($task, $user));

        return response()->json([
            'status'  => true,
            'message' => 'Task created & email sent successfully',
            'data'    => $task,
        ]);
    }


    public function show(string $id)
    {

        $task = Tasks::findOnFail($id);
        if (! $task) {
            return response()->json([
                'status' => false,
                'message' => 'Single Task Not Fount',
                'data' => null,
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'Tasks Here',
            'data' => $task,
        ], 200);
    }


    public function edit(string $id)
    {
        $task = Tasks::findOrFail($id);
        if (! $task) {
            return response()->json([
                'status' => false,
                'message' => 'Task Not Fount',
                'data' => null,
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'Tasks Here',
            'data' => $task,
        ], 200);
    }


   public function update(Request $request, string $id)
{

    $validator = Validator::make($request->all(), [
        'title'         => 'required|string|max:255',
        'task_name'     => 'required|string|max:255',
        'deadline'      => 'required|date',
        'assigned_to'   => 'required|exists:users,id',
        'status'        => 'required|in:pending,in_progress,completed',
        'description'   => 'nullable|string',
        'attachments'   => 'nullable|array',
        'attachments.*' => 'file|max:10240',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status'  => false,
            'message' => 'Validation Errors',
            'errors'  => $validator->errors(),
        ], 400);
    }


    $task = Tasks::findOrFail($id);

    $newFiles = [];

    if ($request->hasFile('attachments')) {
        foreach ($request->file('attachments') as $file) {
            $name = time().'_'.$file->getClientOriginalName();
            $path = $file->storeAs('tasks/attachments', $name, 'public');
            $newFiles[] = $path;
        }
    }


    $task->update([
        'title'       => $request->title,
        'task_name'   => $request->task_name,
        'deadline'    => $request->deadline,
        'assigned_to' => $request->assigned_to,
        'status'      => $request->status,
        'description' => $request->description,
        'attechment'  => $newFiles,
    ]);


    $user_email = User::where('id', $task->assigned_to)->select('email', 'name')->first();

    Mail::to($user_email->email)
        ->send(new TaskSendEmail($task, $user_email));

    return response()->json([
        'status'      => true,
        'message'     => 'Task Updated Successfully & Email Sent',
        'data'        => $task,
        'user_email'  => $user_email,
    ]);
}



    public function destroy(string $id)
    {
        $task = Tasks::findOnFail($id);
        if (! $task) {
            return response()->json([
                'status' => false,
                'message' => ' Task Not Fount',
                'data' => null,
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'Tasks Deleted SuccessFully !',
            'data' => $task,
        ], 200);
    }
}
