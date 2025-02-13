<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\{Present, QrGenerate};
use App\Models\Student\AttendanceHistory;
use Illuminate\{Http\Request, Support\Carbon, Support\Facades\Auth};



class QRCodeScanController extends Controller
{
    public function scanQRCode(Request $request)
    {
        // Authenticate student
        $studentId = Auth::id();

        // Destructure JSON data
        [
            'attendance_id' => $attendanceId,
            'subject_id' => $subjectId,
            'teacher_id' => $teacherId,
            'grade_handle_id' => $gradeHandleId,
            'expiration' => $expiration,
            'client_teacher_id' => $clientTeacherId,
            'client_subject_id' => $clientSubjectId,
        ] = $request->json()->all();

        if (!$attendanceId) {
            return response()->json(['error' => 'Attendance ID missing from QR code data.'], 400);
        }

        // Check if the attendance record exists with matching subject and teacher IDs
        $qrRecord = QrGenerate::where('qr_code_id', $attendanceId)
            ->where('subject_id', $subjectId)
            ->where('teacher_id', $teacherId)
            ->where('subject_id', $clientSubjectId)
            ->where('teacher_id', $clientTeacherId)
            ->first();

        if (!$qrRecord) {
            return response()->json(['error' => 'Invalid QR code data.'], 400);
        }

        // Check expiration
        if (now()->timestamp > $expiration) {
            return response()->json(['error' => 'QR code has expired.'], 400);
        }

        // Check if the student has already recorded attendance today
        $today = Carbon::today();
        $existingAttendance = Present::where('student_id', $studentId)
            ->where('subject_id', $subjectId)
            ->where('teacher_id', $teacherId)
            ->where('grade_handle_id', $gradeHandleId)
            ->whereDate('created_at', $today)
            ->exists();

        if ($existingAttendance) {
            return response()->json(['error' => 'Attendance already recorded for today.'], 400);
        }

        // Record attendance
        $newAttendance = new Present([
            'student_id' => $studentId,
            'subject_id' => $subjectId,
            'teacher_id' => $teacherId,
            'grade_handle_id' => $gradeHandleId,
        ]);


        // subject_model_id	grade_handle_id	teacher_id	student_id	status	time_in	date
        AttendanceHistory::create([
            'subject_model_id' => $subjectId,
            'grade_handle_id' => $gradeHandleId,
            'teacher_id' => $teacherId,
            'student_id' => $studentId,
            'status' => 'Present' ,
            'date' => date('Y-m-d'),
            'time_in' => date('H:i:s'),
        ]);





        $newAttendance->save();

        return response()->json(['success' => 'Attendance recorded successfully.'], 200);
    }

    public function scanQRCodeGet()
    {
        $user = Auth::user();
        return view('student.qr_scan', [
            'user' => $user
        ]);
    }
}
