<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadCreate extends Model
{
    protected $table = "lead_creates";
    protected $primaryKey = 'id';
    protected $fillable = ['client_id','name','email','phone','company_name','industry','services','budget','lead_source','budget_type','lead_status','message','country','city','pin_code','state','created_by'];

    public function user(){
        return $this->belongsTo(User::class,'created_by');
    }
}
