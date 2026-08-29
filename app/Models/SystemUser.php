<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SystemUser extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'email',
        'phone',
        'reg_number',
        'password',
        'status',
        'role',
        'passsword',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function supervisorAssignments()
{
    return $this->hasMany(
        SupervisorAssignment::class,
        'teacher_id'
    );
}

public function researchCorrections()
{
    return $this->hasMany(
        ResearchCorrection::class,
        'supervisor_id'
    );
}

public function students()
{
    return $this->hasManyThrough(
        Student::class,
        SupervisorAssignment::class,
        'teacher_id',
        'id',
        'id',
        'student_id'
    );
}
}