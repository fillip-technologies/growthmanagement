<?php

namespace App\Http\Controllers;

use App\Mail\TaskSendEmail;
use App\Mail\UserRegistrationMail;
use App\Models\Performances;
use App\Models\Tasks;
use App\Models\Project;
use App\Models\User;
use App\Models\TaskUpdate;
use App\Models\ProjectLog;
use App\Models\Module;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ManegemantController extends Controller
{
    public function get_emp()
    {
        $employees = User::where('role', '!=', 'admin')->paginate(10);

        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'phone' => 'required|regex:/^\+?[0-9]{10,12}$/',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,employees,developer,designer,tester,intern',
        ]);

        $planPassword = $request->password;
        $employee = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($planPassword),
            'role' => $request->role,
            'status' => $request->status ?? 'pending',
        ]);

        Mail::to($request->email)->send(new UserRegistrationMail($employee, $planPassword));

        return redirect('get/all')->with('success', 'User Added email sent successfully :)');
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);
        if (Auth::guard('admin')->user()->role === 'admin') {
            $user = Auth::guard('admin')->user();
            $uid = $user->id;
            $get_report = Performances::with(['employee', 'task'])->where('employee_id', $uid)->get();
        }

        return view('admin.employees.edit', compact('user', 'get_report'));

    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        

        $request->validate([
            'name' => 'required|string|min:3',
            'phone' => 'required|regex:/^\+?[0-9]{10,12}$/',
            'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required|in:admin,employees,developer,designer,tester,intern',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'status' => $request->status ?? $user->status,
        ]);

        return redirect('get/all')->with('success', 'User Added SuccessFully :)');
    }

    public function destroy($id)
    {
        $users = User::findOrFail($id)->delete();
        if ($users) {
            return redirect('get/all')->with('success', 'User Deleted SuccessFully :)');
        }

        return redirect('get/all')->with('error', 'User Deleted SuccessFully :)');

    }

    // tasks working is going on

    // public function task_index()
    // {
    //     $tasks = Tasks::paginate(10);
    //     if (Auth::guard('admin')->user()->role === 'employees') {
    //         $id = Auth::guard('admin')->user()->id;
    //         $tasks = Tasks::where('assigned_to', $id)->paginate(10);
    //     }

    //     return view('admin.tasks.index', compact('tasks'));
    // }
    public function task_index()
{
    if (Auth::guard('admin')->user()->role === 'employees') {
        $id = Auth::guard('admin')->user()->id;

        $tasks = Tasks::with(['user', 'project']) 
            ->where('assigned_to', $id)
            ->paginate(10);
    } else {
        $tasks = Tasks::with(['user', 'project'])
            ->paginate(10);
    }

    return view('admin.tasks.index', compact('tasks'));
}

    public function task_form()
    {
         $projects = Project::all();
        $users = User::all();
        return view('admin.tasks.create', compact('projects', 'users'));
    }

    public function show_single_task($id) {}

    public function task_store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'attachments' => 'required|array',
            'priority' => 'required|in:1,2,3',
            'attachments.*' => 'file|max:10240',
            'task_name' => 'required|string|max:255',
            'deadline' => 'required|date',
            'assigned_to' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
            'status' => 'required|in:pending,in_progress,completed',
            'description' => 'nullable|string',
        ]);

        $files = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $name = time().'_'.$file->getClientOriginalName();
                $upload = 'tasks/'.$name;
                $file->move(public_path('tasks/'), $name);
                $files[] = $upload;
            }
        }

        $task = Tasks::create([
            'title' => $request->title,
            'task_name' => $request->task_name,
            'deadline' => $request->deadline,
            'priority' => $request->priority,
            'assigned_to' => $request->assigned_to,
            'status' => $request->status,
            'description' => $request->description,
            'attachments' => json_encode($files),
            'project_id' => $request->project_id, 
        ]);

        $user = User::find($request->assigned_to);
        Mail::to($user->email)->send(new TaskSendEmail($task, $user));
        if ($task) {
            return redirect('/task/all')->with('success', 'Task created & email sent successfully :)');
        }

        return redirect('/task/all')->with('error', 'Task created & email sent Failed !');

    }

    public function edit_task($id)
    {
        $task = Tasks::findOrFail($id);

        return view('admin.tasks.edit', compact('task'));
    }

    public function update_task(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'task_name' => 'required|string|max:255',
            'deadline' => 'required|date',
            'assigned_to' => 'required|exists:users,id',
            'status' => 'required|in:pending,in_progress,completed',
            'description' => 'nullable|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:10240',
        ]);

        $task = Tasks::findOrFail($id);

        if ($request->hasFile('attachments') && $task->attachments) {

            $oldFiles = json_decode($task->attachments, true);
            foreach ($oldFiles as $oldFile) {
                $filePath = public_path($oldFile);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        $newFiles = $task->attachments ? json_decode($task->attachments, true) : [];
        if ($request->hasFile('attachments')) {
            $newFiles = [];

            foreach ($request->file('attachments') as $file) {
                $name = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('tasks'), $name);

                $newFiles[] = 'tasks/'.$name;
            }
        }

        $task->update([
            'title' => $request->title,
            'task_name' => $request->task_name,
            'deadline' => $request->deadline,
            'assigned_to' => $request->assigned_to,
            'status' => $request->status,
            'description' => $request->description,
            'attachments' => json_encode($newFiles),
        ]);
        if (Auth::guard('admin')->user()->role === 'admin') {
            $user = User::select('email', 'name')->find($task->assigned_to);
            Mail::to($user->email)->send(new TaskSendEmail($task, $user));

            return redirect('/task/all')
                ->with('success', 'Task Updated & email sent successfully :)');
        }

        Performances::create([
            'task_id' => $task->id,
            'employee_id' => $request->assigned_to,
            'feedback' => $request->feedback ?? 'testing ',
        ]);

        return redirect('/task/all')
            ->with('success', 'Task Updated  successfully :)');

    }

    public function delete_task($id)
    {
        $task = Tasks::findOrFail($id);
        if ($task->attachments) {
            $files = json_decode($task->attachments, true);
            foreach ($files as $file) {
                $filePath = public_path($file);

                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }
        $task->delete();

        return redirect('/task/all')
            ->with('success', 'Task and attachments deleted successfully ✔');
    }
        
     public function view_task($id)
     {
          $task = Tasks::with('user', 'project','updates.user')->findOrFail($id);
          return view('admin.tasks.view', compact('task'));
     }      
   


    public function emp_perf(Request $request)
    {
        $request->validate([
            'task_id' => 'required|numeric|exists:tasks,id',
            'employee_id' => 'required|numeric',
            'feedback' => 'nullable|string',
        ]);

        return redirect('/task/all')
            ->with('success', 'Task Updated  successfully :)');

    }

    public function getempprefarmans()
    {
        if (Auth::guard('admin')->user()->role === 'employees') {
            $user = Auth::guard('admin')->user();
            $uid = $user->id;
            $perfermans = Performances::with(['employee', 'task'])->where('employee_id', $uid)->get();

            return view('admin.prefermas.feedback', compact('perfermans'));
        }
    }

    public function report($id, $uid)
    {
        if (Auth::guard('admin')->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $get_report = Performances::with(['employee', 'task'])
            ->where('task_id', $id)
            ->latest()
            ->first();

        if (! $get_report || ! $get_report->task) {
            return response()->json([
                'status' => false,
                'message' => 'Report or Task not found',
            ], 404);
        }

        $completedTasks = Tasks::with('employee')
            ->where('assigned_to', $uid)
            ->where('status', 'completed')
            ->get();
            

        $inProgressTasks = Tasks::with('employee')
            ->where('assigned_to', $uid)
            ->where('status', 'in_progress')
            ->get();

        $pendingTasks = Tasks::with('employee')
            ->where('assigned_to', $uid)
            ->where('status', 'pending')
            ->get();

        $completedCount = $completedTasks->count();
        $inProgressCount = $inProgressTasks->count();
        $pendingCount = $pendingTasks->count();

        $deadline = Carbon::parse($get_report->task->deadline);
        $created_at = Carbon::parse($get_report->created_at);

        $hours = $created_at->diffInHours($deadline, false);

        return view('admin.tasks.reports', compact(
            'get_report',
            'completedTasks',
            'inProgressTasks',
            'pendingTasks',
            'completedCount',
            'inProgressCount',
            'pendingCount',
            'deadline',
            'created_at',
            'hours'));

    }
    

public function store_update(Request $request)
{

     $task = Tasks::findOrFail($request->task_id);

    if (
        Auth::guard('admin')->user()->id != $task->assigned_to &&
        Auth::guard('admin')->user()->role !== 'admin'
    ) {
        abort(403, 'Unauthorized');
    }
    $files = [];

    if ($request->hasFile('files')) {
        foreach ($request->file('files') as $file) {
            $name = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('updates'), $name);
            $files[] = 'updates/'.$name;
        }
    }

    TaskUpdate::create([
        'task_id' => $request->task_id,
        'user_id' => Auth::guard('admin')->id(),
        'description' => $request->description,
        'files' => json_encode($files),
        'progress' => $request->progress,
    ]);
    $latestProgress = TaskUpdate::where('task_id', $request->task_id)
    ->orderBy('id', 'desc')
    ->value('progress');

Tasks::where('id', $request->task_id)
    ->update(['progress' => $latestProgress ?? 0]);
    return back()->with('success','Update added successfully');
}
    public function daily_works() {

    $projects = Project::all();
    $modules = Module::with('project')->get();

    $logs = ProjectLog::with(['user','project','module'])
        ->latest()
        ->get();

    return view('admin.daily_work.index', compact('projects','modules','logs'));
    }
    public function store_daily_work(Request $request) {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'module_id' => 'required|exists:modules,id',
            'work_date' => 'required|date',
            'work_done' => 'required|string',
            'progress' => 'nullable|integer|min:0|max:100',
        ]);

        ProjectLog::create([
            'project_id' => $request->project_id,
            'module_id' => $request->module_id,
            'user_id' => Auth::guard('admin')->id(),
            'work_date' => $request->work_date,
            'work_done' => $request->work_done,
            'progress' => $request->progress,
        ]);
         $maxProgress = ProjectLog::where('module_id', $request->module_id)
        ->max('progress');

    Module::where('id', $request->module_id)
        ->update(['progress' => $maxProgress]);


        return redirect()->route('daily.work')->with('success', 'Daily work log added successfully');
    }

    public function edit_daily_work($id) {
        $log = ProjectLog::findOrFail($id);
          if (
        Auth::guard('admin')->id() != $log->user_id &&
        Auth::guard('admin')->user()->role !== 'admin'
    ) {
        abort(403, 'Unauthorized');
    }
        $projects = Project::all();

        return view('admin.daily_work.edit', compact('log', 'projects'));
    }
    public function update_daily_work(Request $request, $id) {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'work_date' => 'required|date',
            'work_done' => 'required|string',
            'progress' => 'nullable|integer|min:0|max:100',
        ]);

        $log = ProjectLog::findOrFail($id);
          if (
        Auth::guard('admin')->id() != $log->user_id &&
        Auth::guard('admin')->user()->role !== 'admin'
    ) {
        abort(403, 'Unauthorized');
    }
        $log->update([
            'project_id' => $request->project_id,
            'work_date' => $request->work_date,
            'work_done' => $request->work_done,
            'progress' => $request->progress,
        ]);

        return redirect()->route('daily.work')->with('success', 'Daily work log updated successfully');
    }
}
