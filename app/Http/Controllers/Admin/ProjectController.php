<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Project;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();
        return view('admin.projects.index' , compact("projects"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = User::where('role', '!=', 'admin')->get();
        return view("admin.projects.create", compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $request->validate([
        "name" => "required",
        "employee_id" => "required|exists:users,id",
        "description" => "required",
        "status"=>"required",
        "start_date"=>"required|date",
        "end_date"=>"required|date|after_or_equal:start_date",
       ]);
       Project::create($request->all());
       return redirect()->route('projects.index')
                        ->with('success','Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
       $project= Project::findorFail($id);
       return view("admin.projects.show" , compact("project")); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $project=Project::with('modules.user')->findorFail($id);
         $employees = User::where('role', '!=', 'admin')->get();
        return view("admin.projects.edit" , compact("project", "employees"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            "name" => "required",
            "description" => "required",
            "start_date" => "required|date",
            "end_date" => "required|date|after_or_equal:start_date",
            "status" => "required"
                      ]);
            return redirect() -> route("projects.index")
            ->with("success","project update successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        
        $project->delete();
        return redirect() -> route("projects.index")
        ->with("success" ,"Project deleted successfully");
    }
}
