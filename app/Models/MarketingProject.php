<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketingProject extends Model
{
    protected $table = "marketing_projects";
    protected $primaryKey = 'id';
    protected $fillable = ['project_name','task_name','what_be_do',"created_by",'attechment',"start_date","end_date",'status','priority'];

    public function user(){
        return $this->belongsTo(User::class,'created_by');
    }
    public function mark_task_assing(){
        return $this->hasMany(MarkeringAsingTask::class,'mrk_project_id');
    }
}
