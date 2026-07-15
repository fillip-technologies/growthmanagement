<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\MarketingProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
