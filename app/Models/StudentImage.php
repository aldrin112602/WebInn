<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Factories\HasFactory, Model};
use App\Models\Student\StudentAccount;

class StudentImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'image_path',
    ];

    public function student()
    {
        return $this->belongsTo(StudentAccount::class, 'student_id');
    }
}
