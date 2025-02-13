<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StudentHandle;


class StudentGrade extends Model
{
    use HasFactory;

    // Specify which columns can be mass-assigned
    protected $fillable = [
        'teacher_id',
        'student_id',
        'grade_handle_id',
        'grade',
        'strand',
        'section',
        
        // added on 11/30/2024
        'semester',
        'quarter',
        'track',
        'subject',
        // End added on 11/30/2024

        'written_1',
        'written_2',
        'written_3',
        'written_4',
        'written_5',
        'written_6',
        'written_7',
        'written_8',
        'written_9',
        'written_10',
        'written_total',
        'written_ps',
        'written_ws',
        'task_1',
        'task_2',
        'task_3',
        'task_4',
        'task_5',
        'task_6',
        'task_7',
        'task_8',
        'task_9',
        'task_10',
        'task_total',
        'task_ps',
        'task_ws',
        'quart_1',
        'quart_ps',
        'quart_ws',
        'initial_grade',
        'quarterly_grade'
        
    ];

    public function studentHandle()
    {
        return $this->belongsTo(StudentHandle::class, 'student_id', 'id');
    }
}
