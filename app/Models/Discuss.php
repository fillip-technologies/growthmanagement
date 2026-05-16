<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discuss extends Model
{
    protected $table = 'discusses';

    protected $primaryKey = 'id';

    protected $fillable = ['chatCount', 'employee_id', 'project_id', 'textSMS'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function employee()
    {
        return $this->belongsTo(User::class);
    }
}
