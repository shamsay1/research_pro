<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResearchProposal extends Model
{
    use HasFactory;


    protected $fillable = [
        'student_id',
        'title',
        'document',
        'status',
    ];


    /*
    |--------------------------------------------------------------------------
    | Student
    |--------------------------------------------------------------------------
    */

    public function student()
    {
        return $this->belongsTo(
            Student::class,
            'student_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Corrections
    |--------------------------------------------------------------------------
    */

    public function corrections()
    {
        return $this->hasMany(
            ResearchCorrection::class,
            'research_proposal_id'
        );
    }
}