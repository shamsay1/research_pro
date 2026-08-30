<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'title',
        'message',
        'supervisor_id',
        'is_read'
    ];
    public function supervisor()
    {
        return $this->belongsTo(
            SystemUser::class,
            'supervisor_id'
        );
    }
}
