<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\{
    AnnouncementControler,
    QRCodeScanController,
    StudentController as Student,
    StudentOtpController,
    GradeController,
    StudentNotificationController,
    TwoFAController,
    ExportController
};
use App\Http\Controllers\Admin\AdminNotificationController;


// Student routes
Route::prefix('student')->group(function () {
    Route::get('login', [Student::class, 'login'])->name('student.login');
    Route::post('login', [Student::class, 'handleLogin'])->name('student.handleLogin');

    // for reset password
    Route::get('forgot-password', [StudentOtpController::class, 'request'])->name('student.password.request');
    Route::post('forgot-password', [StudentOtpController::class, 'sendOtp'])->name('student.password.otp');
    Route::get('reset-password', [StudentOtpController::class, 'reset'])->name('student.password.reset');
    Route::post('reset-password', [StudentOtpController::class, 'update'])->name('student.password.update');
    Route::get('verify-otp', [StudentOtpController::class, 'verifyFormOtp'])->name('student.verify-form.otp');
    Route::post('verify-otp', [StudentOtpController::class, 'verifyOtp'])->name('student.verify.otp');



    // Two-Factor Authentication (2FA) routes
    Route::get('2fa', [TwoFAController::class, 'index'])->name('student.2fa.index'); // Show 2FA form
    Route::post('2fa', [TwoFAController::class, 'verify'])->name('student.2fa.verify'); // Handle 2FA submission
    Route::get('/2fa/resend', [Student::class, 'resendOTP'])->name('student.2fa.resend');



    /***
     * ///////////////////////////
     * /// MIDDLEWARE: STUDENT ///
     * ///////////////////////////
     */

    Route::middleware('auth:student')->group(function () {

        // request profile update
        Route::post('/profile/request_update', [AdminNotificationController::class, 'createNotificationForAll'])->name('student.request_profile_update');

        // announcement
        Route::get('/announcement', [AnnouncementControler::class, 'announcements'])->name('student.announcement');

        Route::get('/unseenAnnouncements',[AnnouncementControler::class, 'getUnseenAnnouncements'])->name('student.getUnseenAnnouncements');

        // Notification route
        Route::prefix('notifications')->group(function () {
            Route::get('/', [StudentNotificationController::class, 'index'])->name('student.notification');
            
            Route::post('/mark-all-as-read', [StudentNotificationController::class, 'markAllAsRead'])->name('student.notifications.markAllAsRead');
            
            Route::delete('/{id}', [StudentNotificationController::class, 'delete'])->name('student.notifications.delete');
            
            Route::delete('/', [StudentNotificationController::class, 'deleteSelected'])->name('student.deleteSelected.notifications');


            Route::get('/unseenNotif',[StudentNotificationController::class, 'getUnseenNotifications'])->name('student.getUnseenNotifications');

        });


        // grades
        Route::get('grades', [GradeController::class, 'grades'])->name('student.grades');
        Route::get('viewGrades', [GradeController::class, 'viewGrades'])->name('student.viewGrades');
        // download grade
        Route::get('download_grades', [ExportController::class, 'exportGrades'])->name('student.download_grade');

        // scan qr
        Route::post('/qr/scan', [QRCodeScanController::class, 'scanQRCode'])->name('qr.scan');
        Route::get('/qr/scan', [QRCodeScanController::class, 'scanQRCodeGet'])->name('qr.scan.get');


        // download attendance
        Route::get('/attendance_download/{id}', [ExportController::class, 'exportAttendanceHistory'])->name('student.download_attendance_history');


        // attendance history
        Route::get('attendance_history', [Student::class, 'attendanceHistory'])->name('student.attendance_history');

        // enrolled subjects
        Route::get('enrolled_subjects', [Student::class, 'enrolledSubjects'])->name('student.enrolled_subjects');


        // Add Student-specific routes here
        Route::get('dashboard', [Student::class, 'dashboard'])->name('student.dashboard');


        // Student logout route
        Route::post('logout', [Student::class, 'logout'])->name('student.logout');

        // Student profile routes
        Route::prefix('profile')->group(function () {
            Route::get('/', [Student::class, 'profile'])->name('student.profile');
            Route::post('updatePhoto', [Student::class, 'updateProfilePhoto'])->name('student.updateProfilePhoto');
            Route::delete('deletePhoto', [Student::class, 'deleteProfilePhoto'])->name('student.deleteProfilePhoto');
            Route::put('updateAccount', [Student::class, 'updateAccount'])->name('student.updateAccount');
            Route::put('updatePassword', [Student::class, 'updatePassword'])->name('student.updatePassword');
        });
    });
});
