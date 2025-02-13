<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    PublicController,
    FaceRecognitionController,
    SendMailAttendance
};
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {

    $guards = [
        'admin' => 'admin.dashboard',
        'teacher' => 'teacher.dashboard',
        'student' => 'student.dashboard',
        'guidance' => 'guidance.dashboard'
    ];

    foreach ($guards as $guard => $route) {
        if (Auth::guard($guard)->check()) {
            return redirect()->route($route);
        }
    }


    return view('welcome');
});
Route::get('/login', [PublicController::class, 'login'])->name('login');












// face recognition and pattern routes
Route::get('/face_recognition', [FaceRecognitionController::class, 'showFaceRecognition'])->name('face.recognition');
Route::post('/face_recognition', [PublicController::class, 'faceScanAttendance'])->name('face.attendance');

Route::get('/face_recognition/student-labels', [FaceRecognitionController::class, 'getStudentLabels'])->name('fetch_labels');
Route::get('/face_recognition/student-info/{label}', [FaceRecognitionController::class, 'getStudentInfo']);

Route::get('/face_recognition_auth', [FaceRecognitionController::class, 'viewPattern'])->name('face.recognition.pattern_auth');

Route::post('/face-recognition/validate-pattern', [FaceRecognitionController::class, 'validatePattern'])->name('face.recognition.validate');



// For testing sendMailSttendance
Route::get('/send_mail_attendance', [SendMailAttendance::class, 'sendAttendance'])->name('attendance.sendMail');