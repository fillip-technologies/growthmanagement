<?php

use App\Models\Role;
use App\Models\User;
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
