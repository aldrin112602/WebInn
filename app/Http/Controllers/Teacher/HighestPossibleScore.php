<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HighestPossibleScoreGradingSheet;
use App\Models\StudentGrade;
use Illuminate\Support\Facades\Auth;

class HighestPossibleScore extends Controller
{
    /**
     * Handle the submission of the highest possible scores and student scores.
     */
    public function store(Request $request)
    {
        
        // return response()->json($request->all(), 200);
        
        // Validate incoming data
        $validatedData = $request->validate([
            'highest_possible_written_1' => 'integer|min:5|max:10|nullable',
            'highest_possible_written_2' => 'integer|min:5|max:10|nullable',
            'highest_possible_written_3' => 'integer|min:5|max:10|nullable',
            'highest_possible_written_4' => 'integer|min:5|max:10|nullable',
            'highest_possible_written_5' => 'integer|min:5|max:10|nullable',
            'highest_possible_written_6' => 'integer|min:5|max:10|nullable',
            'highest_possible_written_7' => 'integer|min:5|max:10|nullable',
            'highest_possible_written_8' => 'integer|min:5|max:10|nullable',
            'highest_possible_written_9' => 'integer|min:5|max:10|nullable',
            'highest_possible_written_10' => 'integer|min:5|max:10|nullable',

            'highest_possible_task_1' => 'integer|min:5|max:10|nullable',
            'highest_possible_task_2' => 'integer|min:5|max:10|nullable',
            'highest_possible_task_3' => 'integer|min:5|max:10|nullable',
            'highest_possible_task_4' => 'integer|min:5|max:10|nullable',
            'highest_possible_task_5' => 'integer|min:5|max:10|nullable',
            'highest_possible_task_6' => 'integer|min:5|max:10|nullable',
            'highest_possible_task_7' => 'integer|min:5|max:10|nullable',
            'highest_possible_task_8' => 'integer|min:5|max:10|nullable',
            'highest_possible_task_9' => 'integer|min:5|max:10|nullable',
            'highest_possible_task_10' => 'integer|min:5|max:10|nullable',
            
            'studentScores' => 'array', 
            'studentScores.*.student_id' => 'required|integer',
            'studentScores.*.written_scores' => 'array',
            'studentScores.*.task_scores' => 'array',
            'studentScores.*.grade' => 'nullable|string',
            'studentScores.*.strand' => 'nullable|string',
            'studentScores.*.section' => 'nullable|string',
            'studentScores.*.subject' => 'nullable|string',
            'studentScores.*.semester' => 'nullable|string',
            'studentScores.*.quarter' => 'nullable|string',
            'studentScores.*.track' => 'nullable|string',
            'studentScores.*.written_total' => 'nullable|numeric',
            'studentScores.*.written_ps' => 'nullable|numeric',
            'studentScores.*.written_ws' => 'nullable|numeric',
            'studentScores.*.task_total' => 'nullable|numeric',
            'studentScores.*.task_ps' => 'nullable|numeric',
            'studentScores.*.task_ws' => 'nullable|numeric',
            'studentScores.*.quarter_total' => 'nullable|numeric',
            'studentScores.*.quart_ps' => 'nullable|numeric',
            'studentScores.*.quart_ws' => 'nullable|numeric',
            'studentScores.*.initial_grade' => 'nullable|numeric',
            'studentScores.*.quarterly_grade' => 'nullable|numeric',
            'studentScores.*.grade_handle_id' => 'required|integer|exists:teacher_grade_handles,id',
        ]);

        // Save or update the highest possible scores
        $highestPossibleData = array_filter($validatedData, fn($key) => str_starts_with($key, 'highest_possible_'), ARRAY_FILTER_USE_KEY);
        $existingGradingSheet = HighestPossibleScoreGradingSheet::updateOrCreate(
            ['teacher_id' => Auth::id()],
            array_merge($highestPossibleData, ['teacher_id' => Auth::id()])
        );

        // Process student scores data
        $studentScores = $validatedData['studentScores'];
        foreach ($studentScores as $studentData) {
            $studentGrade = StudentGrade::updateOrCreate(
                [
                    'student_id' => $studentData['student_id'],
                    'teacher_id' => Auth::id(),
                    'grade' => $studentData['grade'],
                    'strand' => $studentData['strand'],
                    'section' => $studentData['section'],
                    'subject' => $studentData['subject'],
                    'semester' => $studentData['semester'],
                    'quarter' => $studentData['quarter'],
                    'track' => $studentData['track'],
                ],
                [
                    'grade' => $studentData['grade'],
                    'strand' => $studentData['strand'],
                    'section' => $studentData['section'],

                    // added on 11/30/2024
                    'subject' => $studentData['subject'],
                    'semester' => $studentData['semester'],
                    'quarter' => $studentData['quarter'],
                    'track' => $studentData['track'],
                    // end -> added on 11/30/2024

                    
                    'grade_handle_id' => $studentData['grade_handle_id'],
                    'written_total' => $studentData['written_total'] ?? 0,
                    'written_ps' => $studentData['written_ps'] ?? 0,
                    'written_ws' => $studentData['written_ws'] ?? 0,
                    'task_total' => $studentData['task_total'] ?? 0,
                    'task_ps' => $studentData['task_ps'] ?? 0,
                    'task_ws' => $studentData['task_ws'] ?? 0,
                    'quart_1' => $studentData['quarter_total'] ?? 0,
                    'quart_ps' => $studentData['quart_ps'] ?? 0,
                    'quart_ws' => $studentData['quart_ws'] ?? 0,
                    'initial_grade' => $studentData['initial_grade'] ?? 0,
                    'quarterly_grade' => $studentData['quarterly_grade'] ?? 0,
                ]
            );

            // Update written and task scores separately
            foreach ($studentData['written_scores'] as $key => $score) {
                $studentGrade->setAttribute($key, $score);
            }

            foreach ($studentData['task_scores'] as $key => $score) {
                $studentGrade->setAttribute($key, $score);
            }

            $studentGrade->save();
        }

        return response()->json([
            'message' => 'Data has been successfully saved.',
            'highestPossibleData' => $existingGradingSheet,
            'studentGrades' => $studentScores
        ], 201);
    }
}
