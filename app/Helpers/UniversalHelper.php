<?php

use App\Models\Role;
use App\Models\User;

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
        ];
    }
}
