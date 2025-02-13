<?php

namespace App\Models\Admin;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\{
    Database\Eloquent\Factories\HasFactory,
    Foundation\Auth\User as Authenticatable,
    Notifications\Notifiable
};

use App\Models\{
    Teacher\TeacherAccount,
    Student\StudentAccount,
    TeacherGradeHandle
};

class SubjectModel extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'subject_models';

    protected $fillable = [
        'subject',
        'teacher_id',
        'time',
        'day',
        'grade_handle_id',
        'subject_track'
    ];

    public function teacherAccount()
    {
        return $this->belongsTo(TeacherAccount::class, 'teacher_id');
    }

public function teacherHandle()
{
    return $this->hasOne(TeacherGradeHandle::class, 'teacher_id');
}


    // Define the students relationship
    public function students()
    {
        return $this->belongsToMany(StudentAccount::class, 'student_subjects', 'subject_id', 'student_id');
    }
}
