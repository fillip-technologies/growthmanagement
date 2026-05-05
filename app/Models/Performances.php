<?php

namespace App\Models;

use App\Models\Tasks;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Performances extends Model
{
protected $fillable = [
'employee_id', 'task_id', 'reviewed_by', 'rating', 'feedback', 'score'
];


public function employee()
{
return $this->belongsTo(User::class, 'employee_id');
}


public function admin()
{
return $this->belongsTo(User::class);
}


public function task()
{
return $this->belongsTo(Tasks::class);
}
}
