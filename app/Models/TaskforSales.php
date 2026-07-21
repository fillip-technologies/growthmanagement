<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskforSales extends Model
{
    protected $primaryKey = 'id';
    protected $tabl = "taskfor_sales";
    protected $fillable = ['leaddata_id','user_id','due_date','priority','task_des','assing_by'];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function leaddata(){
        return $this->belongsTo(LeadCreate::class,'leaddata_id');
    }
}
