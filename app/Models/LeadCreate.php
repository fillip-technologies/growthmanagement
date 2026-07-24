<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadCreate extends Model
{
    protected $table = "lead_creates";
    protected $primaryKey = 'id';
    protected $fillable = ['client_name','name','email','phone','company_name','industry','services','budget','lead_source','budget_type','lead_status','message','country','city','pin_code','state','created_by','start_date','end_date'];

    public function user(){
        return $this->belongsTo(User::class,'created_by');
    }

    public function taskforsales(){
        return $this->hasMany(TaskforSales::class);
    }

    public function headTask(){
        return $this->hasMany(TeamHeadTask::class,'lead_id');
    }
}
