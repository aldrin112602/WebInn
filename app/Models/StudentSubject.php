<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Factories\HasFactory, Model};
use App\Models\Student\StudentAccount;

class StudentSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'subject_id',
        'teacher_id',
        'grade_handle_id'
    ];

    public function studentAccount()
    {
        return $this->belongsTo(StudentAccount::class, 'id');
    }
}
