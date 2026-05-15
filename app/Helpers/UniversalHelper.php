<?php

use App\Models\Role;

if (! function_exists('role')) {
    function role()
    {
        $roles = Role::select('id', 'role')->get();

        return $roles;
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
