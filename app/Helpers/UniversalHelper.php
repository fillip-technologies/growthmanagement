<?php

use App\Models\LeadCreate;
use App\Models\Role;
use App\Models\TaskforSales;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;



if (! function_exists('role')) {
    function role()
    {
       return [
            'super_admin'=>'Super Admin',
            'employee'=>"Employee",
            'project_manager'=>'Project Manager',
            'team_leader'=>'Team Leader',
            "marketing_manager"=>"Marketing Manager",
            "account_manager"=> "Account Manager",
            "hr_manager"=> "Hr Manager",
            'sales_manager'=>"Sales Manager"
       ];
    }
}

if (! function_exists('FileUpload')) {
    function FileUpload($request)
    {
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $upload = public_path('employees');
            $file->move($upload, $filename);
            $data = 'employees/'.$filename;

            return $data;
        }

        return null;
    }
}

if (! function_exists('department')) {
    function department()
    {
        return [
            'Hr Department',
            'Marketing Department',
            'IT Department',
            'Sales Department',
        ];
    }
}

if (!function_exists('fillipLeads')) {

    function fillipLeads()
    {
        try {
            $response = Http::get('https://lead.filliptechnologies.com/api/leadlist');
            if (!$response->successful()) {
                return collect();
            }
            return collect($response->json('data.leads'))
                ->map(function ($lead) {
                    return [
                        'id'   => $lead['id'] ?? null,
                        'name' => $lead['name'] ?? null,
                    ];
                });

        } catch (\Exception $e) {
            return collect();
        }
    }
}

if(!function_exists('saleEmployee')){
    function saleEmployee(){
      $data = User::where('role','employee')->where('department','Sales Department')->select('id','name')->get();
      return $data;
    }
}

if(!function_exists('mytasks')){
    function mytasks(){
        if(Auth::guard('sales_manager')->check()){
        $id = Auth::guard('sales_manager')->id();
        $task = TaskforSales::with(['user','leaddata'])->where('user_id',$id)->get();
        return $task;
        }

    }
}
