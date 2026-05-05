<?php

namespace App\Models;
use App\Models\Project;
use App\Models\User;
use App\Models\Module;

use Illuminate\Database\Eloquent\Model;

class ProjectLog extends Model
{
    protected $fillable = [
        'project_id',
        'user_id',
        'work_date',
        'work_done',
        'progress',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
