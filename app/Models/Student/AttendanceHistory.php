<?php

namespace App\Models\Student;

use App\Models\Admin\SubjectModel;
use App\Models\Teacher\TeacherAccount;
use App\Models\TeacherGradeHandle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_model_id',
        'student_id',
        'teacher_id',
        'grade_handle_id',
        'status',
        'date',
        'time_in'
    ];



     // Define relationships if necessary
     public function student()
     {
         return $this->belongsTo(StudentAccount::class, 'student_id');
     }
 
     public function subject()
     {
         return $this->belongsTo(SubjectModel::class, 'subject_model_id');
     }
 
     public function teacher()
     {
         return $this->belongsTo(TeacherAccount::class, 'teacher_id');
     }
 
     public function gradeHandle()
     {
         return $this->belongsTo(TeacherGradeHandle::class, 'grade_handle_id');
     }

}
