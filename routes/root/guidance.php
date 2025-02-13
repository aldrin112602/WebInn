<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guidance\{
    GuidanceConversationController,
    GuidanceController as Guidance,
    GuidanceOtpController,
    GuidanceNotificationController,
    TwoFAController
};
use App\Http\Controllers\Student\ExportController;

// Guidance routes
Route::prefix('guidance')->group(function () {
    Route::get('login', [Guidance::class, 'login'])->name('guidance.login');
    Route::post('login', [Guidance::class, 'handleLogin'])->name('guidance.handleLogin');

    // for reset password
    Route::get('forgot-password', [GuidanceOtpController::class, 'request'])->name('guidance.password.request');
    Route::post('forgot-password', [GuidanceOtpController::class, 'sendOtp'])->name('guidance.password.otp');
    Route::get('reset-password', [GuidanceOtpController::class, 'reset'])->name('guidance.password.reset');
    Route::post('reset-password', [GuidanceOtpController::class, 'update'])->name('guidance.password.update');

    Route::get('verify-otp', [GuidanceOtpController::class, 'verifyFormOtp'])->name('guidance.verify-form.otp');

    Route::post('verify-otp', [GuidanceOtpController::class, 'verifyOtp'])->name('guidance.verify.otp');



    // Two-Factor Authentication (2FA) routes
    Route::get('2fa', [TwoFAController::class, 'index'])->name('guidance.2fa.index'); // Show 2FA form
    Route::post('2fa', [TwoFAController::class, 'verify'])->name('guidance.2fa.verify'); // Handle 2FA submission
    Route::get('/2fa/resend', [Guidance::class, 'resendOTP'])->name('guidance.2fa.resend');




    Route::middleware('auth:guidance')->group(function () {

        // Notification route
        Route::prefix('notifications')->group(function () {
            Route::get('/', [GuidanceNotificationController::class, 'index'])->name('guidance.notification');
            Route::post('/mark-all-as-read', [GuidanceNotificationController::class, 'markAllAsRead'])->name('guidance.notifications.markAllAsRead');
            Route::delete('/{id}', [GuidanceNotificationController::class, 'delete'])->name('guidance.notifications.delete');
            Route::delete('/', [GuidanceNotificationController::class, 'deleteSelected'])->name('guidance.deleteSelected.notifications');
        });

        // guidance exports
        Route::get('/export_attendance_history/{id}', [ExportController::class, 'exportAttendanceHistory'])->name('guidance.export_attendance_history');

        // attendance report
        Route::get('attendance_report', [Guidance::class, 'attendanceReport'])->name('guidance.attendance_report');


        // attendance history
        Route::get('attendance_history', [Guidance::class, 'attendanceHistory'])->name('guidance.attendance_history');
        Route::get('view_attendance_history/{id}', [Guidance::class, 'viewAttendanceHistory'])->name('guidance.view_attendance_history');

        // Add Guidance-specific routes here
        Route::get('dashboard', [Guidance::class, 'dashboard'])->name('guidance.dashboard');


        // chat conversation
        Route::get('/chats', [GuidanceConversationController::class, 'index'])->name('guidance.chats.index');
        Route::get('/chats/messages', [GuidanceConversationController::class, 'loadMessages'])->name('guidance.chats.loadMessages');
        Route::post('/chats/send', [GuidanceConversationController::class, 'sendMessage']);
        Route::get('chats/counts', [GuidanceConversationController::class, 'getMessageCounts'])->name('guidance.get_message_count');


        // Guidance logout route
        Route::post('logout', [Guidance::class, 'logout'])->name('guidance.logout');

        // Guidance profile routes
        Route::prefix('profile')->group(function () {
            Route::get('/', [Guidance::class, 'profile'])->name('guidance.profile');
            Route::post('updatePhoto', [Guidance::class, 'updateProfilePhoto'])->name('guidance.updateProfilePhoto');
            Route::delete('deletePhoto', [Guidance::class, 'deleteProfilePhoto'])->name('guidance.deleteProfilePhoto');
            Route::put('updateAccount', [Guidance::class, 'updateAccount'])->name('guidance.updateAccount');
            Route::put('updatePassword', [Guidance::class, 'updatePassword'])->name('guidance.updatePassword');
        });
    });
});
