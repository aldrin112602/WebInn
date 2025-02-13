<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Factories\HasFactory, Model};

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'position',
        'history',
        'description',
        'user_id'
    ];
}
