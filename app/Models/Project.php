<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'created_by',
        'description',
        'start_date',
        'end_date',
        'status',
        'priority',
        'modules',

    ];

    protected $casts = ['modules' => 'array'];

    public function logs()
    {
        return $this->hasMany(ProjectLog::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function addtask()
    {
        return $this->hasMany(AddTask::class);
    }

    public function attendance()
    {
        return $this->hasMany(AttendanceInfo::class);
    }

    public function discuss()
    {
        return $this->hasMany(Discuss::class);
    }

    public function user(){
        return $this->belongsTo(User::class,'created_by');
    }

    public function projectInfraresource(){
        return $this->hasMany(ProjectInfraResource::class);
    }

    public function projecthumanresource(){
        return $this->hasMany(ProjectHumanResource::class,'project_id');
    }
    
}
