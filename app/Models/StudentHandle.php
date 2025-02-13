<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Factories\HasFactory, Model};
use App\Models\Student\StudentAccount;
use App\Models\Admin\SubjectModel;

class StudentHandle extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'teacher_id',
        'grade_handle_id'
    ];

    public function studentAccount()
    {
        return $this->belongsTo(StudentAccount::class, 'student_id', 'id');
    }

    // public function studentsAccount()
    // {
    //     return $this->belongsTo(StudentAccount::class, 'student_id', 'id');
    // }


    public function gradeHandle()
    {
        return $this->belongsTo(TeacherGradeHandle::class, 'grade_handle_id');
    }

    public function subject()
    {
        return $this->belongsTo(SubjectModel::class, 'grade_handle_id');
    }

    public function account()
    {
        return $this->hasOne(StudentAccount::class, 'id', 'student_id');
    }
}
