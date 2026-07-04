<?php

use Illuminate\Support\Facades\Auth;

if (! function_exists('SuperAdminLogin')) {
    function SuperAdminLogin()
    {
        if (Auth::guard('super_admin')->check()) {
            $admindata = Auth::guard('super_admin')->user();
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

if (! function_exists('HrManagerLogin')) {
    function HrManagerLogin()
    {
        if (Auth::guard('hr_manager')->check()) {
            $hrdata = Auth::guard('hr_manager')->user();

            return $hrdata;
        } else {
            return redirect()->route('admin');
        }
    }
}

if (! function_exists('ProjectManagerLogin')) {
    function ProjectManagerLogin()
    {
        if (Auth::guard('project_manager')->check()) {
            $data = Auth::guard('project_manager')->user();

            return $data;
        } else {
            return redirect()->route('admin');
        }
    }
}

if (! function_exists('TeamLeaderLogin')) {
    function TeamLeaderLogin()
    {
        if (Auth::guard('team_leader')->check()) {
            $data = Auth::guard('team_leader')->user();
            return $data;
        } else {
            return redirect()->route('admin');
        }
    }
}

if (! function_exists('SalesLogin')) {
    function SalesLogin()
    {
        if (Auth::guard('sales_manager')->check()) {
            $data = Auth::guard('sales_manager')->user();
            return $data;
        } else {
            return redirect()->route('admin');
        }
    }
}

if (! function_exists('MarketingLogin')) {
    function MarketingLogin()
    {
        if (Auth::guard('sales_manager')->check()) {
            $data = Auth::guard('sales_manager')->user();
            return $data;
        } else {
            return redirect()->route('admin');
        }
    }
}

