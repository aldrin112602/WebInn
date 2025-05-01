<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\FaceScan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TeacherGradeHandle;
use App\Models\Student\StudentAccount;
use Carbon\Carbon;

class FaceScanController extends Controller
{
   public function index(Request $request) {
    $user = Auth::user();
    
    // Start with a base query for face scans
    $query = FaceScan::query();
    
    // Apply any date filters if needed (you can add this)
    if ($request->has('date') && $request->date != '') {
        $query->whereDate('created_at', $request->date);
    }
    
    // Get all the face scans with their related student information using a join
    $attendanceRecords = $query->join('student_accounts', 'face_scans.student_id', '=', 'student_accounts.id')
        ->select(
            'face_scans.*', 
            'student_accounts.id_number',
            'student_accounts.username',
            'student_accounts.name',
            'student_accounts.grade',
            'student_accounts.strand',
            'student_accounts.gender'
        );
    
    // Apply filters to the joined query
    if ($request->has('gender') && $request->gender != '' && $request->gender != 'All') {
        $attendanceRecords->where('student_accounts.gender', $request->gender);
    }
    
    if ($request->has('strand') && $request->strand != '' && $request->strand != 'All') {
        $attendanceRecords->where('student_accounts.strand', $request->strand);
    }
    
    if ($request->has('grade') && $request->grade != '' && $request->grade != 'All') {
        $attendanceRecords->where('student_accounts.grade', $request->grade);
    }
    
    // Paginate the results
    $attendanceList = $attendanceRecords->orderBy('face_scans.created_at', 'desc')->paginate(10);
    
    // Format the time for display
    $attendanceList->map(function($record) {
        $record->time_in = Carbon::parse($record->time)->format('h:i A');
        $record->scan_date = Carbon::parse($record->created_at)->format('Y-m-d');
        $record->scan_created_at = Carbon::parse($record->created_at)->format('Y-m-d h:i A');
        return $record;
    });
    
    // Return the view with relevant data
    return view('admin.facescan.index', [
        'user' => $user,
        'attendance_list' => $attendanceList,
    ]);
}
}
