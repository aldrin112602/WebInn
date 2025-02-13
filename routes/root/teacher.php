<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ExcelController;
use App\Http\Controllers\Teacher\{
    Announcement,
    GradeHandleController,
    StudentController,
    Account,
    Attendance,
    QRCodeController,
    TeacherController as Teacher,
    TeacherOtpController,
    TeacherConversationController,
    SubjectController as Subject,
    Present,
    StudentsGradeController,
    TeacherNotificationController,
    attendanceController,
    FaceScanController,
    HighestPossibleScore,
    TwoFAController,
    ClassHistory,
    ExportController as TeacherExportController
};

use App\Http\Controllers\Student\ExportController;

// Teacher routes
Route::prefix('teacher')->group(function () {
    // login handle
    Route::get('login', [Teacher::class, 'login'])->name('teacher.login');
    Route::post('login', [Teacher::class, 'handleLogin'])->name('teacher.handleLogin');
    // for reset password/ FORGOT Password
    Route::get('forgot-password', [TeacherOtpController::class, 'request'])->name('teacher.password.request');
    Route::post('forgot-password', [TeacherOtpController::class, 'sendOtp'])->name('teacher.password.otp');
    Route::get('reset-password', [TeacherOtpController::class, 'reset'])->name('teacher.password.reset');
    Route::post('reset-password', [TeacherOtpController::class, 'update'])->name('teacher.password.update');
    Route::get('verify-otp', [TeacherOtpController::class, 'verifyFormOtp'])->name('teacher.verify-form.otp');
    Route::post('verify-otp', [TeacherOtpController::class, 'verifyOtp'])->name('teacher.verify.otp');




    // Two-Factor Authentication (2FA) routes
    Route::get('2fa', [TwoFAController::class, 'index'])->name('teacher.2fa.index'); // Show 2FA form
    Route::post('2fa', [TwoFAController::class, 'verify'])->name('teacher.2fa.verify'); // Handle 2FA submission
    Route::get('/2fa/resend', [Teacher::class, 'resendOTP'])->name('teacher.2fa.resend');


    /***
     * ///////////////////////////
     * /// MIDDLEWARE: TEACHER ///
     * ///////////////////////////
     */
    Route::middleware('auth:teacher')->group(function () {


        // Form 137 routes
        Route::get('/form_137_front/{id}', [StudentsGradeController::class, 'form137Front'])->name('teacher.form_137_front');
        Route::get('/form_137_back/{id}', [StudentsGradeController::class, 'form137Back'])->name('teacher.form_137_back');

        // Report card routes
        Route::get('/report_card_front/{id}', [StudentsGradeController::class, 'reportCardFront'])->name('teacher.report_card_front');
        Route::get('/report_card_back/{id}', [StudentsGradeController::class, 'reportCardBack'])->name('teacher.report_card_back');


        // routes for class histories
        Route::get('/class_history', [ClassHistory::class, 'index'])->name('teacher.class_history');
        Route::get('view_class_history/{id}', [ClassHistory::class, 'view_class_history'])->name('teacher.view_class_history');

        // export class history
        Route::get('/export_class_history', [TeacherExportController::class, 'exportClassHistory'])->name('teacher.export_class_history');

        // highest possible scores
        Route::post('/highest-possible-scores', [HighestPossibleScore::class, 'store'])->name('teacher.addHighestPossibleScore');

        // Announcement routes
        Route::prefix('announcements')->group(function () {
            Route::get('/', [Announcement::class, 'announcements'])->name('teacher.announcements');
            Route::post('/create', [Announcement::class, 'makeAnnouncement'])->name('teacher.make_announcement');
            Route::get('/edit/{id}', [Announcement::class, 'editAnnouncement'])->name('teacher.edit_announcement');
            Route::put('/update/{id}', [Announcement::class, 'updateAnnouncement'])->name('teacher.update_announcement');
            Route::delete('/delete/{id}', [Announcement::class, 'deleteAnnouncement'])->name('teacher.delete_announcement');
        });


        // face scan
        Route::get('/facescan', [FaceScanController::class, 'index'])->name('teacher.facescan');


        // mark attendance manually
        Route::post('/mark-attendance', [QRCodeController::class, 'markAttendanceManually'])->name('markAttendanceManually');

        // for attendace
        Route::prefix('attendance')->group(function () {
            Route::get('report', [attendanceController::class, 'attendaceReport'])->name('teacher.attendance.report');
            Route::get('absent', [attendanceController::class, 'attendaceAbsent'])->name('teacher.attendance.absent');
            Route::get('present', [attendanceController::class, 'attendacePresent'])->name('teacher.attendance.present');

            Route::get('view_attendance_history/{id}', [attendanceController::class, 'viewAttendanceHistory'])->name('teacher.view_attendance_history');

            // export attendance
            Route::get('export_attendance_history/{id}', [ExportController::class, 'exportAttendanceHistory'])->name('teacher.export_attendance_history');
        });


        // Notification route
        Route::prefix('notifications')->group(function () {
            Route::get('/', [TeacherNotificationController::class, 'index'])->name('teacher.notification');
            Route::post('/mark-all-as-read', [TeacherNotificationController::class, 'markAllAsRead'])->name('teacher.notifications.markAllAsRead');
            Route::delete('/{id}', [TeacherNotificationController::class, 'delete'])->name('teacher.notifications.delete');
            Route::delete('/', [TeacherNotificationController::class, 'deleteSelected'])->name('teacher.deleteSelected.notifications');
        });

        // students grade
        Route::get('grading', [StudentsGradeController::class, 'grading'])->name('teacher.grading');


        // for announcement
        Route::post('announcement', [Announcement::class, 'makeAnnouncement'])->name('teacher.make_announcement');


        Route::prefix('student')->group(function () {
            // view student subjects
            Route::get('subjects/{id}', [Subject::class, 'viewStudentSubjects'])->name('teacher.view.subjects');
            Route::post('subjects/add', [Subject::class, 'addSubject'])->name('teacher.add.subject');
            Route::delete('subjects/delete/{studentId}/{subjectId}', [Subject::class, 'deleteStudentSubject'])->name('teacher.delete.studentSubject');

            // Update, delete student account
            Route::delete('{id}', [StudentController::class, 'deleteStudent'])->name('teacher.delete.student');
            Route::get('{id}/edit', [StudentController::class, 'editStudent'])->name('teacher.edit.student');
            Route::put('{id}', [StudentController::class, 'updateStudent'])->name('teacher.update.student');
        });

        // generate qr code
        Route::get('/generate-qr-code/{subjectId}/{teacherId}', [QRCodeController::class, 'generateQRCode'])->name('generateQR');


        Route::post('/getPresentCount', [Present::class, 'presentCount'])->name('getPresentCount');
        Route::post('/getAbsentCount', [Present::class, 'absentCount'])->name('getAbsentCount');



        // present and absent
        Route::get('/presents', [Attendance::class, 'presents'])->name('teacher.attendance.presents');
        Route::get('/absents', [Attendance::class, 'absents'])->name('teacher.attendance.absents');



        // deleting selected students account
        Route::delete('/delete-selected-students', [Account::class, 'deleteSelectedStudents'])->name('teacher.delete.selected.students');

        // delete student single account
        // Route::delete('delete_student', [Account::class, 'deleteStudentAccount'])->name('teacher.delete.student');

        // adding student
        Route::get('/add_student', [Account::class, 'viewAddStudent'])->name('teacher.add.student');
        Route::post('/add_student', [Account::class, 'submitAddStudent'])->name('teacher.submit.student');

        // dashboard
        Route::get('dashboard', [Teacher::class, 'dashboard'])->name('teacher.dashboard');


        // Student list
        Route::get('/student_list', [StudentController::class, 'index'])->name('teacher.student_list');


        // Grade handle routes
        Route::get('grade_handle/get-grade-id', [GradeHandleController::class, 'getGradeId'])->name('get.grade.id');
        Route::get('grade_handle/add', [GradeHandleController::class, 'viewAddHandleGrade'])->name('teacher.view.add_grade_handle');
        Route::post('grade_handle/add', [GradeHandleController::class, 'submitAddHandleGrade'])->name('teacher.submit.add_grade_handle');
        Route::get('grade_handle/edit/{id}', [GradeHandleController::class, 'viewUpdateGradeHandle'])->name('teacher.edit.grade_handle');
        Route::put('grade_handle/update/{id}', [GradeHandleController::class, 'updateGradeHandle'])->name('teacher.update.grade_handle');
        Route::delete('grade_handle/delete', [GradeHandleController::class, 'deleteGradeHandle'])->name('teacher.delete.grade_handle');


        // subject list
        Route::get('/subject_list', [Subject::class, 'subjectList'])->name('teacher.subject_list');


        // Subject routes
        Route::get('/my_subjects', [Subject::class, 'index'])->name('teacher.subjects');
        Route::prefix('subject')->group(function () {
            Route::get('create', [Subject::class, 'viewCreateSubject'])->name('teacher.create.subject');
            Route::post('create', [Subject::class, 'createSubject'])->name('teacher.handleCreate.subject');
            Route::delete('{id}', [Subject::class, 'deleteSubject'])->name('teacher.delete.subject');
            Route::get('{id}/edit', [Subject::class, 'viewEditSubject'])->name('teacher.edit.subject');
            Route::put('{id}', [Subject::class, 'updateSubject'])->name('teacher.update.subject');
        });

        // delete selected subjects
        Route::delete('delete-selected-subjects', [Subject::class, 'deleteSelectedSubjects'])->name('delete.selected.subjects');

        // chat conversation
        Route::get('/chats', [TeacherConversationController::class, 'index'])->name('teacher.chats.index');
        Route::get('/chats/messages', [TeacherConversationController::class, 'loadMessages'])->name('teacher.chats.loadMessages');
        Route::post('/chats/send', [TeacherConversationController::class, 'sendMessage']);
        Route::get('chats/counts', [TeacherConversationController::class, 'getMessageCounts'])->name('teacher.get_message_count');


        // Teacher logout route
        Route::post('logout', [Teacher::class, 'logout'])->name('teacher.logout');

        // teacher profile routes
        Route::prefix('profile')->group(function () {
            Route::get('/', [Teacher::class, 'profile'])->name('teacher.profile');
            Route::post('updatePhoto', [Teacher::class, 'updateProfilePhoto'])->name('teacher.updateProfilePhoto');
            Route::delete('deletePhoto', [Teacher::class, 'deleteProfilePhoto'])->name('teacher.deleteProfilePhoto');
            Route::put('updateAccount', [Teacher::class, 'updateAccount'])->name('teacher.updateAccount');
            Route::put('updatePassword', [Teacher::class, 'updatePassword'])->name('teacher.updatePassword');
        });


        // export subjects list
        Route::prefix('export')->group(function () {
            Route::get('subject_list', [ExcelController::class, 'exportTeacherSubjectList'])->name('teacher.export.subject');

            Route::get('student_list', [ExcelController::class, 'teacherExportStudentList'])->name('teacher.export.student');
        });
    });
});
