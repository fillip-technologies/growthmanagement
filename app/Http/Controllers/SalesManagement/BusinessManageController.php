<?php

namespace App\Http\Controllers\SalesManagement;

use App\Http\Controllers\Controller;
use App\Models\TaskforSales;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessManageController extends Controller
{
     public function BDAEmployee(){

        $employees = [];
        if(Auth::guard('sales_manager')){
        $employees = User::where('department','Sales Department')->paginate(10);
        return view('admin.employees.index',compact('employees'));
        }

    }

    public function mytask(){
        $id = Auth::guard('sales_manager')->check() ? Auth::guard('sales_manager')->id() : "";
        $leads = TaskforSales::with(['user','leaddata'])->where('user_id',$id)->get();
        return view('admin.leads.mytask',compact('leads'));
    }

    public function assingtaskforsales(Request $request)
{
    $request->validate([
        'leaddata_id'   => 'required|min:1',
        'due_date'      => 'required|date',
        'task_des'      => 'required|string',
        'priority'      => 'required|in:low,medium,high,urgent',
        'assing_by'     => 'required|exists:users,id',
        'user_id'=>'required'
    ]);

    $assignedBy = Auth::guard('sales_manager')->id();

    foreach ($request->leaddata_id as $leadId) {

        TaskforSales::create([
            'leaddata_id' => $leadId,
            'due_date'    => $request->due_date,
            'task_des'    => $request->task_des,
            'priority'    => $request->priority,
            'assing_by'   => $assignedBy,
            'user_id'     => $request->assing_by,
        ]);

    }

    return back()->with('success', 'Tasks assigned successfully.');
}
}
