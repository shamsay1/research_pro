<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'students';

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

    /*
    |--------------------------------------------------------------------------
    | Research Proposals
    |--------------------------------------------------------------------------
    */

    public function researchProposals()
    {
        return $this->hasMany(
            ResearchProposal::class,
            'student_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Supervisor Assignments
    |--------------------------------------------------------------------------
    */

    public function supervisorAssignments()
    {
        return $this->hasMany(
            SupervisorAssignment::class,
            'student_id'
        );
    }
}