<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AddTask;
use App\Models\AttendanceInfo;
use App\Models\Project;
use App\Models\ProjectHumanResource;
use App\Models\ProjectInfraResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $employees = User::with('role')->where('role', '!=', 'super_admin')->get();
        return view('admin.projects.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'created_by'=>'nullable',
            'client_name'=>'required|string',
            'description' => 'required',
            'status' => 'required',
            'priority' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        $data = Project::create($request->all());
        ProjectInfraResource::create([
        "project_id"=>$data->id,
        'domain_name'=>$request->domain_name,
        'domain_registrar'=>$request->domain_registrar,
        'hosting_provider'=>$request->hosting_provider,
        'hosting_account_owner'=>$request->hosting_account_owner,
        'ssl_certificate'=>$request->ssl_certificate,
        'email_service_provider'=>$request->email_service_provider,
        'dns_management'=>$request->dns_management,
        'cdn_provider'=>$request->cdn_provider,
        'third_party_apis'=>$request->third_party_apis,
        'renewal_date'=>$request->renewal_date,
        'responsible_team_member'=>$request->responsible_team_member
         ]);
         ProjectHumanResource::create([
            "project_id"=>$data->id,
            'project_manager'=>$request->project_manager,
            'developer'=>$request->developer,
            'designer'=>$request->designer,
            'qa_engineer'=>$request->qa_engineer
         ]);
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


    public function edit($id)
    {
        $project = Project::with(['projectInfraresource','projecthumanresource'])->findOrFail($id);
        return view('admin.projects.edit', compact('project'));
    }

   public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required',
        'client_name'=> 'required|string',
        'description' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
        'status' => 'required',
        'priority' => 'required',
        'modules' => 'nullable|array',
        'modules.*' => 'nullable',
    ]);

       $project = Project::findOrFail($id);
        DB::transaction(function () use ($request, $project) {
        $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'client_name'=>$request->client_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'priority' => $request->priority,
            'modules' => json_encode($request->modules ?? []),
        ]);

        ProjectHumanResource::updateOrCreate(
            ['project_id' => $project->id],
            [
                'project_manager' => $request->project_manager,
                'developer' => $request->developer,
                'designer' => $request->designer,
                'qa_engineer' => $request->qa_engineer,
            ]
        );

         ProjectInfraResource::updateOrCreate(
            ['project_id' => $project->id],
            [
                'domain_name' => $request->domain_name,
                'domain_registrar' => $request->domain_registrar,
                'hosting_provider' => $request->hosting_provider,
                'hosting_account_owner' => $request->hosting_account_owner,
                'ssl_certificate' => $request->ssl_certificate,
                'email_service_provider' => $request->email_service_provider,
                'dns_management' => $request->dns_management,
                'cdn_provider' => $request->cdn_provider,
                'third_party_apis' => $request->third_party_apis,
                'renewal_date' => $request->renewal_date,
                'responsible_team_member' => $request->responsible_team_member,
            ]
        );
    });

    return back()->with('success', 'Project updated successfully');
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

    public function projectInfo($id){
        $data = AttendanceInfo::with(['employee','project'])->findOrFail($id);
        return view('admin.projects.project_info',compact('data'));
    }

    public function projectView($id){
        return view('admin.projects.view_project');
    }
}
