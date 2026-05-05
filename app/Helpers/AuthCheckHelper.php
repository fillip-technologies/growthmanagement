<?php

use Illuminate\Support\Facades\Auth;

if (! function_exists('AdminLogin')) {
    function AdminLogin()
    {
        if (Auth::guard('admin')->check()) {
            $admindata = Auth::guard('admin')->user();
            return $admindata;
        } else {
            return redirect()->route('admin');
        }
    }
}
if (! function_exists('EmpLogin')) {
    function EmpLogin()
    {
        if (Auth::guard('employee')->check()) {
            $empdata = Auth::guard('employee')->user();

            return $empdata;
        } else {
            return redirect()->route('admin');
        }
    }
}

if (! function_exists('HrLogin')) {
    function HrLogin()
    {
        if (Auth::guard('hr')->check()) {
            $hrdata = Auth::guard('hr')->user();

            return $hrdata;
        } else {
            return redirect()->route('admin');
        }
    }
}

if (! function_exists('InternLogin')) {
    function InternLogin()
    {
        if (Auth::guard('intern')->check()) {
            $Interndata = Auth::guard('intern')->user();

            return $Interndata;
        } else {
            return redirect()->route('admin');
        }
    }
}
