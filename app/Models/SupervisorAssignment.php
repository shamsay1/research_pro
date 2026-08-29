<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupervisorAssignment extends Model
{
    protected $fillable = [
        'student_id',
        'teacher_id',
        'supervisor_type',
        'status'
    ];


    public function student()
    {
        return $this->belongsTo(
            Student::class,
            'student_id'
        );
    }


    public function teacher()
    {
        return $this->belongsTo(
            SystemUser::class,
            'teacher_id'
        );
    }
}