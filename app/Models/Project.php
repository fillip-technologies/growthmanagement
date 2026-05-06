<?php

namespace App\Models;
use App\Models\ProjectLog;
use App\Models\Module;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
        'modules'

    ];

    protected $casts = ['modules'=>'array'];
    public function logs()
    {
        return $this->hasMany(ProjectLog::class);
    }
    public function modules()
    {
        return $this->hasMany(Module::class);
    }

}
