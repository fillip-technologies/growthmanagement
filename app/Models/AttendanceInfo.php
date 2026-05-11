<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class AttendanceInfo extends Model
{
    protected $fillable = [
        'employee_id',
        'start_work',
        'lunch_start',
        'lunch_count',
        'event_count',
        'lunch_out',
        'status',
        'date',
        'day',
        'leave',
        'reasion',
        'end_work',
        'total_hours',
        'project_id',
        'today_works'
    ];

    protected $casts = [
        'start_work' => 'datetime',
        'lunch_start' => 'datetime',
        'lunch_out' => 'datetime',
        'end_work' => 'datetime',
        'date' => 'date',
        'total_hours' => 'string'
    ];


    public function employee()
    {
        return $this->belongsTo(User::class,'emoloyee_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }


}
