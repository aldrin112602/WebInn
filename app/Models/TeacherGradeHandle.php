<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Factories\HasFactory, Model};
use App\Models\Teacher\TeacherAccount;
use App\Models\Admin\SubjectModel;



class TeacherGradeHandle extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'grade',
        'strand',
        'section',
        // newly added columns
        'semester',
        'quarter',
        'subject',
        'track',

    ];

    public function teacher()
    {
        return $this->belongsTo(TeacherAccount::class, 'teacher_id');
    }

    public function teacherHandle()
    {
        return $this->belongsTo(SubjectModel::class, 'teacher_id');
    }


    public function students()
    {
        return $this->hasMany(StudentHandle::class, 'grade_handle_id');
    }


    public function subjects()
    {
        return $this->hasMany(SubjectModel::class, 'grade_handle_id', 'id');
    }
}
