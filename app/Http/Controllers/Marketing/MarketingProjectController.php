<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Mail\AssingtaskMail;
use App\Models\AddTask;
use App\Models\AssingTask;
use App\Models\MarkeringAsingTask;
use App\Models\MarketingProject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MarketingProjectController extends Controller
{
    public function createProject(Request $request){

        $user_id = null;
        if(Auth::guard('marketing_manager')->check()){
         $logindata = Auth::guard('marketing_manager')->user();
         $user_id = $logindata->id;
         }
        $request->validate([
            'created_by'=>'required|exists:users,id',
            'project_name'=>'required|string',
            'task_name'=>'required|string',
            'what_be_do'=>'required|string',
            'status'=>'required|in:active,pending,ongoing',
            'priority'=>'required|in:low,medium,high',
            'start_date'=>'required|date',
            'end_date'=>'required|date',
            'attechment'=>'nullable'
        ]);
        $uploasfile = null;
        if($request->hasFile('attechment')){
            $file = $request->file('attechment');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $uploasfile = "projectfile/" . $filename;
            $file->move(public_path('projectfile'),$filename);
        }

        $createdata = MarketingProject::create([
            'created_by'=>$user_id,
            'project_name'=>$request->project_name,
            'task_name'=>$request->task_name,
            'what_be_do'=>$request->what_be_do,
            'status'=>$request->status,
            'priority'=>$request->priority,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
            'attechment'=>$uploasfile
        ]);

        if($createdata){
            return back()->with('success','Create Project SuccessFully');
        }else{
            return back()->with('error','Something went wrong');
        }

    }

    public function listproject(){
        $projects = MarketingProject::all();
        return view('marketing.projects.index',compact('projects'));
    }

    public function projectform(){
        return view('marketing.projects.create_project');
    }

    public function editproduct($id){
        $project = MarketingProject::findOrFail($id);
        return view('marketing.projects.edit_project',compact('project'));
    }

    public function updatdproduct(Request $request ,$id){


        $request->validate([
            'created_by'=>'required|exists:users,id',
            'project_name'=>'required|string',
            'task_name'=>'required|string',
            'what_be_do'=>'required|string',
            'status'=>'required|in:active,pending,ongoing',
            'priority'=>'required|in:low,medium,high',
            'start_date'=>'required|date',
            'end_date'=>'required|date',
            'attechment'=>'nullable'
        ]);
          $updated = MarketingProject::findOrFail($id);
          $existFile = $updated->attechment;
          $uploasfile = $existFile;

        if($request->hasFile('attechment')){
         if($existFile && file_exists(public_path($existFile))){
         unlink(public_path($existFile));
        }
            $file = $request->file('attechment');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $uploasfile = "projectfile/".$filename;
            $file->move(public_path('projectfile'), $filename);
     }

         $updata = $updated->update([
            'created_by'=>$request->created_by,
            'project_name'=>$request->project_name,
            'task_name'=>$request->task_name,
            'what_be_do'=>$request->what_be_do,
            'status'=>$request->status,
            'priority'=>$request->priority,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
            'attechment'=>$uploasfile
          ]);

        if($updata){
            return back()->with('success','Project Updated SuccessFull');
        }else{
            return back()->with('error','Something went wrong');
        }
    }

    public function deleteProject($id){
        $deletedata = MarketingProject::findOrFail($id);
        $existFile = $deletedata->attechment;
        if($existFile && file_exists(public_path($existFile))){
          unlink(public_path($existFile));
        }
        $deletedata->delete();
        return back()->with('success','Project Deleted SuccessFul');
    }

     public function dragTask()
    {
     if(Auth::guard('marketing_manager')->check()){
        $employees = User::where('department', 'Marketing Department')->get();
        $tasks = MarketingProject::all();
        $asingTask = MarkeringAsingTask::with(['marketingpro','user'])->get();
        return view('marketing.dragTask.dragtask',compact('employees','tasks','asingTask'));
        }

    }

    public function assignDragTask(Request $request)
    {

        $request->validate([
            'task_id' => 'required',
            'employee_id' => 'required',
            'assigned_by'=>'required|exists:users,id',
        ]);
        $id = null;
        if (Auth::guard('marketing_manager')->check()) {
        $id = Auth::guard('marketing_manager')->id();
        }

        $data = MarkeringAsingTask::create([
            'mrk_project_id' => $request->task_id,
            'employee_id' => $request->employee_id,
            'created_by' => $id,
        ]);
         $task = MarketingProject::where('id', $request->task_id)->first();
         $user = User::find($request->employee_id);
         Mail::to($user->email)
        ->send(new AssingtaskMail($user, $task));
        if ($data) {
            return back()->with('success', 'Task Assing SuccessFul with email');
        } else {
            return back()->with('error', 'Something went wring');
        }
    }
}
