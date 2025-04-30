<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAttempt extends Model
{

    protected $fillable = [
        'user_agent',
        'attempts',
        'is_restricted',
        'last_attempt_at',
        'restricted_at',
    ];

    protected $casts = [
        'is_restricted' => 'boolean',
        'last_attempt_at' => 'datetime',
        'restricted_at' => 'datetime',
    ];
}
