<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectInfraResource extends Model
{
    protected $table = "project_infra_resources";
    protected $primaryKey = 'id';
    protected $fillable = ['project_id','domain_name','domain_registrar','hosting_provider','hosting_account_owner','ssl_certificate','email_service_provider','dns_management','cdn_provider','third_party_apis','renewal_date','responsible_team_member'];

    public function project(){
        return $this->belongsTo(Project::class);
    }
}
