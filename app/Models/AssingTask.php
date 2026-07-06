<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssingTask extends Model
{
    protected $table = "assing_tasks";
    protected $fillable = ['addtask_id','employee_id','assigned_by'];
    protected $primaryKey = 'id';

    public function addtask(){
        return $this->belongsTo(AddTask::class,'addtask_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'employee_id');
    }


}
