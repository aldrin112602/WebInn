<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    GradeHandleController,
    AdminController as Admin,
    AdminCreateController as AdminCreate,
    AccountManagementController as AccountManagement,
    ExcelController,
    SubjectController,
    AdminOtpController,
    deleteSelected,
    attendanceController as Attendace,
    AdminConversationController,
    AdminNotificationController,
    FaceScanController,
    TwoFAController
};
use App\Http\Controllers\Student\ExportController;
use App\Http\Controllers\FaceRecognitionController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\GradeController;

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('login', [Admin::class, 'login'])->name('admin.login');
    Route::post('login', [Admin::class, 'handleLogin'])->name('admin.handleLogin');

    // for reset password
    Route::get('forgot-password', [AdminOtpController::class, 'request'])->name('admin.password.request');
    Route::post('forgot-password', [AdminOtpController::class, 'sendOtp'])->name('admin.password.otp');
    Route::get('reset-password', [AdminOtpController::class, 'reset'])->name('admin.password.reset');
    Route::post('reset-password', [AdminOtpController::class, 'update'])->name('admin.password.update');
    Route::get('verify-otp', [AdminOtpController::class, 'verifyFormOtp'])->name('admin.verify-form.otp');
    Route::post('verify-otp', [AdminOtpController::class, 'verifyOtp'])->name('admin.verify.otp');

    // Two-Factor Authentication (2FA) routes
    Route::get('2fa', [TwoFAController::class, 'index'])->name('admin.2fa.index'); // Show 2FA form
    Route::post('2fa', [TwoFAController::class, 'verify'])->name('admin.2fa.verify'); // Handle 2FA submission
    Route::get('/2fa/resend', [Admin::class, 'resendOTP'])->name('admin.2fa.resend');



    /***
     * ///////////////////////////
     * /// MIDDLEWARE: ADMIN ///
     * ///////////////////////////
     */
    Route::middleware('auth:admin')->group(function () {
        
        // grades
        Route::get('student/grade/student_list', [AccountManagement::class, 'grade_student_list'])->name('admin.grade.student_list');
        Route::get('student/grades/{id}', [GradeController::class, 'admin_grades'])->name('admin.student.grades');
        Route::get('student/viewGrades', [GradeController::class, 'viewGrades'])->name('admin.student.viewGrades');
        // download grade
        Route::get('student/download_grades/{id}', [ExportController::class, 'exportGrades'])->name('admin.student.download_grade');


        // pattern for face recognition
        Route::post('/face-recognition/create-pattern', [FaceRecognitionController::class, 'createPattern'])->name('face.recognition.create');
        Route::get('/face-recognition/set-pattern', [FaceRecognitionController::class, 'setPattern'])->name('face.recognition.set');


        // face scan
        Route::get('/facescan', [FaceScanController::class, 'index'])->name('admin.facescan');


        // Notification route
        Route::prefix('notifications')->group(function () {
            Route::get('/', [AdminNotificationController::class, 'index'])->name('admin.notification');
            Route::post('/mark-all-as-read', [AdminNotificationController::class, 'markAllAsRead'])->name('admin.notifications.markAllAsRead');
            Route::delete('/{id}', [AdminNotificationController::class, 'delete'])->name('admin.notifications.delete');
            Route::delete('/', [AdminNotificationController::class, 'deleteSelected'])->name('admin.deleteSelected.notifications');
        });


        Route::prefix('/teacher')->group(function () {
            // subject list
            Route::get('/subject_list', [SubjectController::class, 'teacherSubjectList'])->name('admin.teacher.subject_list');
            // export subject list
            Route::prefix('export')->group(function () {
                Route::get('subject_list', [ExcelController::class, 'exportTeacherSubjectList'])->name('admin.teacher.export.subject');
            });

            Route::get('/create', [SubjectController::class, 'viewCreateSubject'])->name('admin.teacher.create.subject');
            Route::post('/create', [SubjectController::class, 'createSubject'])->name('admin.teacher.handleCreate.subject');
            Route::delete('/{id}', [SubjectController::class, 'deleteSubject'])->name('admin.teacher.delete.subject');
            Route::get('/{id}/edit', [SubjectController::class, 'viewEditSubject'])->name('admin.teacher.edit.subject');
            Route::put('/{id}', [SubjectController::class, 'updateSubject'])->name('admin.teacher.update.subject');

        });





        // dashboard
        Route::get('dashboard', [Admin::class, 'dashboard'])->name('admin.dashboard');

        // history
        Route::get('history', [Admin::class, 'history'])->name('admin.history');

        // view student subjects route
        Route::get('/student/subjects/{id}', [SubjectController::class, 'viewStudentSubjects'])->name('admin.view.subjects');
        Route::post('/student/subjects/add', [SubjectController::class, 'addSubject'])->name('admin.add.subject');
        Route::delete('/student/subjects/delete/{studentId}/{subjectId}', [SubjectController::class, 'deleteStudentSubject'])->name('admin.delete.studentSubject');


        

        // chat conversation
        Route::get('/chats', [AdminConversationController::class, 'index'])->name('admin.chats.index');
        Route::get('/chats/messages', [AdminConversationController::class, 'loadMessages'])->name('admin.chats.loadMessages');
        Route::post('/chats/send', [AdminConversationController::class, 'sendMessage']);
        Route::get('chats/counts', [AdminConversationController::class, 'getMessageCounts'])->name('admin.get_message_count');


        // for attendace
        Route::prefix('attendance')->group(function () {
            Route::get('report', [Attendace::class, 'attendaceReport'])->name('admin.attendance.report');
            Route::get('absent', [Attendace::class, 'attendaceAbsent'])->name('admin.attendance.absent');
            Route::get('present', [Attendace::class, 'attendacePresent'])->name('admin.attendance.present');

            Route::get('view_attendance_history/{id}', [Attendace::class, 'viewAttendanceHistory'])->name('admin.view_attendance_history');

            // export attendance
            Route::get('export_attendance_history/{id}', [ExportController::class, 'exportAttendanceHistory'])->name('admin.export_attendance_history');
        });


        // for deleting selected accounts
        Route::delete('/admin/delete-selected-students', [deleteSelected::class, 'deleteSelectedStudents'])->name('admin.delete.selected.students');
        Route::delete('/admin/delete-selected-admins', [deleteSelected::class, 'deleteSelectedAdmins'])->name('admin.delete.selected.admins');
        Route::delete('/admin/delete-selected-teachers', [deleteSelected::class, 'deleteSelectedTeachers'])->name('admin.delete.selected.teachers');
        Route::delete('/admin/delete-selected-guidances', [deleteSelected::class, 'deleteSelectedGuidances'])->name('admin.delete.selected.guidances');
        Route::delete('/admin/delete-selected-subjects', [deleteSelected::class, 'deleteSelectedSubjects'])->name('admin.delete.selected.subjects');


        // Admin profile routes
        Route::prefix('profile')->group(function () {
            Route::get('/', [Admin::class, 'profile'])->name('admin.profile');
            Route::post('updatePhoto', [Admin::class, 'updateProfilePhoto'])->name('admin.updateProfilePhoto');
            Route::delete('deletePhoto', [Admin::class, 'deleteProfilePhoto'])->name('admin.deleteProfilePhoto');
            Route::put('updateAccount', [Admin::class, 'updateAccount'])->name('admin.updateAccount');
            Route::put('updatePassword', [Admin::class, 'updatePassword'])->name('admin.updatePassword');
        });

        // Admin create accounts routes
        Route::prefix('create')->group(function () {
            Route::get('admin', [AdminCreate::class, 'viewCreateAdmin'])->name('admin.create.admin');
            Route::get('teacher', [AdminCreate::class, 'viewCreateTeacher'])->name('admin.create.teacher');
            Route::get('guidance', [AdminCreate::class, 'viewCreateGuidance'])->name('admin.create.guidance');
            Route::get('student', [AdminCreate::class, 'viewCreateStudent'])->name('admin.create.student');
            Route::post('admin', [AdminCreate::class, 'createAdmin'])->name('admin.handleCreate.admin');
            Route::post('teacher', [AdminCreate::class, 'createTeacher'])->name('admin.handleCreate.teacher');
            Route::post('guidance', [AdminCreate::class, 'createGuidance'])->name('admin.handleCreate.guidance');
            Route::post('student', [AdminCreate::class, 'createStudent'])->name('admin.handleCreate.student');
        });

        // Admin subjects routes
        Route::prefix('subject')->group(function () {
            Route::get('/', [SubjectController::class, 'subject'])->name('admin.subject');
            Route::get('list', [SubjectController::class, 'subject_list'])->name('admin.subject_list');
            Route::get('create', [SubjectController::class, 'viewCreateSubject'])->name('admin.create.subject');
            Route::post('create', [SubjectController::class, 'createSubject'])->name('admin.handleCreate.subject');
            Route::delete('{id}', [SubjectController::class, 'deleteSubject'])->name('admin.delete.subject');
            Route::get('{id}/edit', [SubjectController::class, 'viewEditSubject'])->name('admin.edit.subject');
            Route::put('{id}', [SubjectController::class, 'updateSubject'])->name('admin.update.subject');
        });

        // Admin logout route
        Route::post('logout', [Admin::class, 'logout'])->name('admin.logout');

        // Account management routes
        Route::prefix('account_management')->group(function () {
            Route::get('student_list', [AccountManagement::class, 'student_list'])->name('admin.student_list');
            Route::get('admin_list', [AccountManagement::class, 'admin_list'])->name('admin.admin_list');
            Route::get('teacher_list', [AccountManagement::class, 'teacher_list'])->name('admin.teacher_list');
            Route::get('guidance_list', [AccountManagement::class, 'guidance_list'])->name('admin.guidance_list');


            // grade handle
            // Grade handle routes
            Route::get('grade_handle/{id}', [AccountManagement::class, 'viewGradeHandle'])->name('admin.view.grade_handle');
            Route::get('grade_handle/add/{id}', [AccountManagement::class, 'viewAddHandleGrade'])->name('admin.view.add_grade_handle');
            Route::post('grade_handle/add/{id}', [AccountManagement::class, 'submitAddHandleGrade'])->name('admin.submit.add_grade_handle');
            Route::get('grade_handle/edit/{id}', [GradeHandleController::class, 'viewUpdateGradeHandle'])->name('admin.edit.grade_handle');
            Route::put('grade_handle/update/{id}', [GradeHandleController::class, 'updateGradeHandle'])->name('admin.update.grade_handle');
            Route::delete('grade_handle/delete', [GradeHandleController::class, 'deleteGradeHandle'])->name('admin.delete.grade_handle');





            Route::prefix('student')->group(function () {
                Route::delete('{id}', [AccountManagement::class, 'deleteStudent'])->name('admin.delete.student');
                Route::get('{id}/edit', [AccountManagement::class, 'editStudent'])->name('admin.edit.student');
                Route::put('{id}', [AccountManagement::class, 'updateStudent'])->name('admin.update.student');
            });

            Route::prefix('teacher')->group(function () {
                Route::delete('{id}', [AccountManagement::class, 'deleteTeacher'])->name('admin.delete.teacher');
                Route::get('{id}/edit', [AccountManagement::class, 'editTeacher'])->name('admin.edit.teacher');
                Route::put('{id}', [AccountManagement::class, 'updateTeacher'])->name('admin.update.teacher');
            });

            Route::prefix('admin')->group(function () {
                Route::delete('{id}', [AccountManagement::class, 'deleteAdmin'])->name('admin.delete.admin');
                Route::get('{id}/edit', [AccountManagement::class, 'editAdmin'])->name('admin.edit.admin');
                Route::put('{id}', [AccountManagement::class, 'updateAdmin'])->name('admin.update.admin');
            });

            Route::prefix('guidance')->group(function () {
                Route::delete('{id}', [AccountManagement::class, 'deleteGuidance'])->name('admin.delete.guidance');
                Route::get('{id}/edit', [AccountManagement::class, 'editGuidance'])->name('admin.edit.guidance');
                Route::put('{id}', [AccountManagement::class, 'updateGuidance'])->name('admin.update.guidance');
            });
        });

        // Accounts exporting routes
        Route::prefix('export')->group(function () {
            Route::get('admin_list', [ExcelController::class, 'exportAdminList'])->name('admin.export.admin');
            Route::get('student_list', [ExcelController::class, 'exportStudentList'])->name('admin.export.student');
            Route::get('guidance_list', [ExcelController::class, 'exportGuidanceList'])->name('admin.export.guidance');
            Route::get('teacher_list', [ExcelController::class, 'exportTeacherList'])->name('admin.export.teacher');
            Route::get('subject_list', [ExcelController::class, 'exportSubjectList'])->name('admin.export.subject');
        });
    });
});
