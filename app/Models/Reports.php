<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
protected $fillable = [
'employee_id', 'month', 'year', 'total_tasks', 'completed_tasks', 'average_rating', 'growth_score'
];


public function employee()
{
return $this->belongsTo(User::class, 'employee_id');
}

}
