<?php

namespace App\Models;
use App\Models\Performances;
use App\Models\Reports;
use App\Models\Tasks;
use App\Models\Project;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'designation',
        'profile',
        'phone',
        'status',
        'department',
        'joinig_date',
        'employeeID',
        'adhar_card',
        'pan_card',
        '10th_certificate',
        '12th_certificate',
        'graduation'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function tasks()
    {
        return $this->hasMany(Tasks::class, 'assigned_to');
    }


    public function performances()
    {
        return $this->hasMany(Performances::class, 'employee_id');
    }


    public function reviewedPerformances()
    {
        return $this->hasMany(Performances::class);
    }


    public function reports()
    {
        return $this->hasMany(Reports::class, 'employee_id');
    }

     public function assingtask(){
        return $this->hasMany(AssingTask::class);
    }

    public function role(){
        return $this->belongsTo(Role::class,'role_id');
    }

    public function addtask(){
        return $this->hasMany(AddTask::class);
    }

    public function attendance(){
        return $this->hasMany(AttendanceInfo::class,'employee_id');
    }

    public function takeleave(){
        return $this->hasMany(TakeLeave::class,'employee_id');
    }

    public function discuss(){
        return $this->hasMany(Discuss::class);
    }

    public function accountget(){
        return $this->hasMany(AccountAccess::class,'created_by');
    }

    public function mark_task_assing(){
        return $this->hasMany(MarkeringAsingTask::class,'employee_id');
    }

    public function marketproject(){
        return $this->hasMany(MarketingProject::class,"created_by");
    }

    public function project(){
        return $this->hasMany(Project::class,'created_by');
    }

    public function leadcreate(){
        return $this->hasMany(LeadCreate::class,'created_by');
    }

    public function taskforsale(){
        return  $this->hasMany(TaskforSales::class);
    }




}
