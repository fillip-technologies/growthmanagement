<?php

namespace App\Models;
use App\Models\Performances;
use App\Models\User;
use App\Models\Project;
use App\Models\TaskUpdate;
use App\Models\Module;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $fillable = [
        'title', 'description', 'assigned_to', 'status', 'priority', 'deadline','task_name','attachments','project_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function performance()
    {
        return $this->hasOne(Performances::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function updates()
    {
        return $this->hasMany(TaskUpdate::class,'task_id');
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
