<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectHumanResource extends Model
{
    protected $fillable = ['project_id','project_manager','developer','designer','qa_engineer'];
    protected $table = "project_human_resources";
    protected $primaryKey = 'id';

    public function project(){
        return $this->belongsTo(Project::class,'project_id');
    }
}
