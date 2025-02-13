<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\{QrGenerate, TeacherGradeHandle, StudentHandle};
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\SubjectModel;
use App\Models\Student\{StudentAccount, AttendanceHistory};
use Illuminate\Http\{Request, JsonResponse};

class QRCodeController extends Controller
{
    public function generateQRCode($subjectId, $teacherId)
    {
        $attendanceId = uniqid();
        $user = Auth::guard('teacher')->user();
        $expiration = now()->addMinutes(15)->timestamp;
        $handleSubjects = TeacherGradeHandle::where('teacher_id', $user->id)->get();
        $grade_handle = TeacherGradeHandle::where('teacher_id', $user->id)->first();
        $studentsHandle = StudentHandle::where('teacher_id', $user->id)->get();
        $currentDate = now()->toDateString();
        $studentIds = $studentsHandle->pluck('student_id');
        $students = StudentAccount::whereIn('id', $studentIds)->get();
        $presentCount = 0;
        $absentCount = 0;

        foreach ($students as $student) {
            $attendance = AttendanceHistory::where('student_id', $student->id)
                ->where('subject_model_id', $subjectId)
                ->where('teacher_id', $teacherId)
                ->where('grade_handle_id', $grade_handle->id)
                ->where('date', $currentDate)
                ->first();

            if ($attendance && $attendance->status === 'Present') {
                $student->status = 'Present';
                $student->time_in = $attendance->time_in;
                $presentCount++;
            } else {
                $student->status = 'Absent';
                $student->time_in = null;
                $absentCount++;
            }
        }

        $allStudentsCount = $students->count();

        QrGenerate::create([
            'subject_id' => $subjectId,
            'teacher_id' => $teacherId,
            'qr_code_id' => $attendanceId,
        ]);

        $data = json_encode([
            'attendance_id' => $attendanceId,
            'subject_id' => $subjectId,
            'teacher_id' => $teacherId,
            'expiration' => $expiration,
            'grade_handle_id' => $grade_handle->id,
        ]);

        $subject = SubjectModel::where('id', $subjectId)
            ->where('teacher_id', $teacherId)
            ->first();

        return view('teacher.subject.qr_generate', [
            'data' => $data,
            'handleSubjects' => $handleSubjects,
            'grade_handle' => $grade_handle,
            'user' => $user,
            'allStudentsCount' => $allStudentsCount,
            'presentCount' => $presentCount, 
            'absentCount' => $absentCount, 
            'students' => $students,
            'subject' => $subject
        ]);
    }

    public function markAttendanceManually(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:student_accounts,id',
            'subject_id' => 'required|exists:subject_models,id',
        ]);

        $studentId = $validated['student_id'];
        $subjectId = $validated['subject_id'];
        $teacherId = Auth::guard('teacher')->id();
        $gradeHandleId = TeacherGradeHandle::where('teacher_id', $teacherId)
            ->value('id');

        $currentDate = now()->toDateString();

        $existingAttendance = AttendanceHistory::where('student_id', $studentId)
            ->where('subject_model_id', $subjectId)
            ->where('teacher_id', $teacherId)
            ->where('grade_handle_id', $gradeHandleId)
            ->where('date', $currentDate)
            ->first();

        if ($existingAttendance) {
            if ($existingAttendance->status === 'Present') {
                return response()->json(['success' => false, 'message' => 'Attendance is already marked as present.']);
            } else {
                $existingAttendance->update([
                    'status' => 'Present',
                    'time_in' => now(),
                ]);

                return response()->json(['success' => true, 'message' => 'Attendance updated to present.']);
            }
        } else {
            AttendanceHistory::create([
                'student_id' => $studentId,
                'subject_model_id' => $subjectId,
                'teacher_id' => $teacherId,
                'grade_handle_id' => $gradeHandleId,
                'status' => 'Present',
                'date' => $currentDate,
                'time_in' => now(),
            ]);

            return response()->json(['success' => true, 'message' => 'Attendance marked as present.']);
        }
    }
}
