<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AddTask extends Model
{
    protected $table = "add_tasks";
    protected $fillable = ['project_id'];
    protected $primaryKey = 'id';

    public function project(){
        return $this->belongsTo(Project::class);
    }
}
