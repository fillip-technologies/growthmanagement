<?php

namespace App\Models;
use App\Models\Tasks;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class TaskUpdate extends Model
{
  protected $fillable= [
    'task_id',
    'user_id',
    'description',
    'files',
    'progress',
  ];
  public function task()
  {
    return $this->belongsTo(Tasks::class,'task_id');
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
