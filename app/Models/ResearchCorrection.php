<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearchCorrection extends Model
{
    protected $fillable = [
        'research_proposal_id',
        'supervisor_id',
        'comment',
        'status',
        'documentary'
    ];

    public function research()
    {
        return $this->belongsTo(
            ResearchProposal::class,
            'research_proposal_id'
        );
    }

    public function supervisor()
    {
        return $this->belongsTo(
            SystemUser::class,
            'supervisor_id'
        );
    }
}