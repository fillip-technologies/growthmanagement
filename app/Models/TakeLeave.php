<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TakeLeave extends Model
{
    protected $table = "take_leaves";
    protected $primaryKey = 'id';
    protected  $fillable = ['from_date','to_date','reason','employee_id','status'];

    public function employee(){
        return $this->belongsTo(User::class,'employee_id');
    }
}
