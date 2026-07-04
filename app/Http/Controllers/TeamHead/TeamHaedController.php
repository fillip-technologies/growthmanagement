<?php

namespace App\Http\Controllers\TeamHead;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamHaedController extends Controller
{
    public function teammember(){
        $employees = [];
        if(Auth::guard('team_leader')){
        $employees = User::where('role','employee')->where('department','IT Department')->paginate(10);
        return view('admin.employees.index',compact('employees'));
        }else{
         $data = User::where('role','employee')->where('department','Marketing Department')->get();
        }
    }

    public function teamheadlogout(Request $request){
        Auth::guard('team_leader')->logout();
         $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
