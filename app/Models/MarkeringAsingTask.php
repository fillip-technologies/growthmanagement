<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarkeringAsingTask extends Model
{
protected $table = "markering_asing_tasks";
protected $primaryKey = 'id';
protected $fillable = ['employee_id','mrk_project_id','created_by'];

public function user(){
    return $this->belongsTo(User::class,'employee_id');
}

public function marketingpro(){
    return $this->belongsTo(MarketingProject::class,'mrk_project_id');
}
}
