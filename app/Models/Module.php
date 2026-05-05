<?php

namespace App\Models;
use App\Models\Project;
use App\Models\User;
use App\Models\ProjectLog;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['project_id', 'name', 'assigned_to', 'progress'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function logs()
    {
        return $this->hasMany(ProjectLog::class);
    }
}
