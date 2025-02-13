<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Factories\HasFactory, Model};

class FaceScan extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'time',
        'time_out'
    ];
}
