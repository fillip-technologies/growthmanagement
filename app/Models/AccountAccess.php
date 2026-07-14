<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountAccess extends Model
{
    protected $table = "";
    protected $primaryKey = 'id';

    protected $fillable = ['name','email','text_password','designation','created_by'];


    public function user(){
        return $this->belongsTo(User::class,'created_by');
    }

    protected $hidden = ['text_password'];
}
