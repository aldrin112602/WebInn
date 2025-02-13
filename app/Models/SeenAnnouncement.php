<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeenAnnouncement extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'announcement_id',
        'is_seen',
        'grade_handle_id'
    ];
}
