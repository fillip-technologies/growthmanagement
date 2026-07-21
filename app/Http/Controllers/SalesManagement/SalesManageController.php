<?php

namespace App\Http\Controllers\SalesManagement;

use App\Http\Controllers\Controller;
use App\Models\LeadCreate;
use App\Models\TaskforSales;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class SalesManageController extends Controller
{
    public function salesEmployee(){

       $employees = [];
        if(Auth::guard('marketing_manager')){
        $employees = User::where('department','Sales Department')->paginate(10);
        return view('admin.employees.index',compact('employees'));
        }

    }

   public function leadedata(Request $request)
{
    try {
        $response = Http::get('https://version2.filliptechnologies.com/api/integrations/leads');

        if (!$response->successful()) {
            return back()->with('error', 'Unable to fetch leads.');
        }

        $fillipLeads = collect($response->json('leads'));
        if ($request->filled('search')) {
            $search = strtolower($request->search);

            $fillipLeads = $fillipLeads->filter(function ($item) use ($search) {
                return str_contains(strtolower($item['name'] ?? ''), $search)
                    || str_contains(strtolower($item['email'] ?? ''), $search)
                    || str_contains(strtolower($item['phone'] ?? ''), $search);
            })->values();
        }

        $perPage = 8;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $fillipLeads->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginatedLeads = new LengthAwarePaginator(
            $currentItems,
            $fillipLeads->count(),
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        return view('admin.leads.fillipleaddata',compact('paginatedLeads'));

    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }
}

public function createleadform(){
    return view('admin.leads.createlead');
}

public function index()
{

    $leads = LeadCreate::paginate(10);
    return view('admin.leads.listingdata',compact('leads'));
}

public function createLeadsdata(Request $request)
{

    $request->validate([
        'created_by'   => 'required|exists:users,id',
        'name'         => 'required|string',
        'email'        => 'required|email',
        'phone'        => 'required|min:10|max:15',
        'company_name' => 'required|string',
        'industry'     => 'required|string',
        'services'     => 'required|string',
        'budget'       => 'required',
        'lead_source'  => 'required',
        'lead_status'  => 'required|in:contacted,in_progress,converted,lost,pending,new',
        'message'      => 'nullable|string',
        'country'      => 'required',
        'city'         => 'required',
        'budget_type'=>   'required',
        'pin_code'     => 'required',
        'state'        => 'required',
        'client_id'=>'required'
    ]);

    $data = LeadCreate::create([
        'client_id'=>  $request->client_id,
        'created_by'   => $request->created_by,
        'name'         => $request->name,
        'email'        => $request->email,
        'phone'        => $request->phone,
        'company_name' => $request->company_name,
        'industry'     => $request->industry,
        'services'     => $request->services,
        'budget'       => $request->budget,
        'budget_type'=>$request->budget_type,
        'lead_source'  => $request->lead_source,
        'lead_status'  => $request->lead_status,
        'message'      => $request->message,
        'country'      => $request->country,
        'city'         => $request->city,
        'pin_code'     => $request->pin_code,
        'state'        => $request->state,
    ]);

    if($data){
    return back()->with('success','Create Leads SuccessFully');
    }else{
     return back()->with('error','Something wend wrong');
    }
}

    public function projectuser(){

        $leads = LeadCreate::all();
        $employees = User::where('role','sales_manager')->get();
        return view('admin.leads.dragtaskac', compact('employees', 'leads'));

    }
public function assingtaskforsales(Request $request)
{
    $request->validate([
        'leaddata_id'   => 'required|array|min:1',
        'leaddata_id.*' => 'required|exists:lead_creates,id',
        'due_date'      => 'required|date',
        'task_des'      => 'required|string',
        'priority'      => 'required|in:low,medium,high,urgent',
        'assing_by'     => 'required|exists:users,id',
    ]);

    $assignedBy = Auth::guard('account_manager')->id();

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

    public function reportforsales(){
        $reports = TaskforSales::with(['user','leaddata'])->paginate(10);
    return view('admin.leads.salestaskreport',compact('reports'));
    }

    public function viewtaskdetails($id){
        $viewDetails = TaskforSales::with(['user','leaddata'])->where('leaddata_id',$id)->first();
        dd($viewDetails);
    }

}
