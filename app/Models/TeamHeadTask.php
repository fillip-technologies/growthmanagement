<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamHeadTask extends Model
{
    protected $primaryKey = 'id';
    protected $table = "team_head_tasks";
    protected $fillable = ['lead_id','user_id','status','priority','created_by','description','due_date'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function leaddata(){
        return $this->belongsTo(LeadCreate::class);
    }
}
