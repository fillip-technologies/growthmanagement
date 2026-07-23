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

    public function assingform(){
        return view('admin.sales.assingtask');
    }

    public function assingtaskforsales(Request $request)
{
    $request->validate([
        'leaddata_id'   => 'required|min:1',
        'due_date'      => 'required|date',
        'task_des'      => 'required|string',
        'priority'      => 'required|in:low,medium,high,urgent',
        'assing_by'     => 'nullable|exists:users,id',
        'user_id'=>'required'
    ]);

    $assignedBy = Auth::guard('sales_manager')->check() ? Auth::guard('sales_manager')->id() : "";

        TaskforSales::create([
            'leaddata_id' => $request->leaddata_id,
            'due_date'    => $request->due_date,
            'task_des'    => $request->task_des,
            'priority'    => $request->priority,
            'assing_by'   => $assignedBy,
            'user_id'     => $request->user_id,
        ]);

    return back()->with('success', 'Tasks assigned successfully.');
}

    public function reportforsales(){
    $id = Auth::guard('sales_manager')->check() ? Auth::guard('sales_manager')->id() : "";
    $reports = TaskforSales::with(['user','leaddata'])->where('assing_by',$id)->paginate(10);
    return view('admin.leads.salestaskreport',compact('reports'));
    }

    public function viewtaskdetails($id,$user_id){
        $data = TaskforSales::with(['user','leaddata'])->where('leaddata_id',$id)->where('user_id',$user_id)->first();
        return view('admin.leads.viewtaskdetails',compact('data'));
    }

}
