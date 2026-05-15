<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AddTask;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = User::with('role')->where('role_id', '!=', '1')->get();

        return view('admin.projects.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
            'priority' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        $data = Project::create($request->all());
        if ($data) {
            AddTask::create(['project_id' => $data->id]);
        }

        return redirect()->route('project.list')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $project = Project::findorFail($id);

        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $project = Project::findorFail($id);
// dd($project);
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'status' => 'required',
            'modules' => 'nullable|array',
            'priority' => 'required',
            'modules.*' => 'nullable',
        ]);

        $project = Project::findOrFail($id);

        $projectupdate = $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'priority' => $request->priority,
            'modules' => json_encode($request->modules),
        ]);

        if ($projectupdate) {
            return redirect()->route('project.list')
                ->with('success', 'project update successfully');
        } else {
            return back()->with('error', 'Something went wrong');
        }

    }

    public function destroy($id)
    {

        Project::findOrFail($id)->delete();

        return redirect()->route('project.list')
            ->with('success', 'Project deleted successfully');
    }

    public function getmoduls(Request $request)
    {
        $id = $request->id;
        $getmodel = Project::where('id', $id)->select('modules')->get();

        return response()->json([
            'data' => $getmodel,
        ]);
    }

    public function addtotask($id)
    {
        $id = trim($id);
        $data = AddTask::where('project_id',$id)->first();
        if (!empty($data)) {
            return back()->with('success', 'Task Already Added');
        } else {
           AddTask::create([
                'project_id' => $id,
            ]);
        }

        return back()->with('success', 'Add Task SuccessFul');

    }
}
