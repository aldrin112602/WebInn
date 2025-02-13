<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HighestPossibleScoreGradingSheet extends Model
{
    use HasFactory;
    protected $fillable = [

        // for new added fields
        'grade_handle_id',
        

        // for written
        'highest_possible_written_1',
        'highest_possible_written_2',
        'highest_possible_written_3',
        'highest_possible_written_4',
        'highest_possible_written_5',
        'highest_possible_written_6',
        'highest_possible_written_7',
        'highest_possible_written_8',
        'highest_possible_written_9',
        'highest_possible_written_10',

        // for task
        'highest_possible_task_1',
        'highest_possible_task_2',
        'highest_possible_task_3',
        'highest_possible_task_4',
        'highest_possible_task_5',
        'highest_possible_task_6',
        'highest_possible_task_7',
        'highest_possible_task_8',
        'highest_possible_task_9',
        'highest_possible_task_10',


        'teacher_id'
    ];
}
