<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssignClassTeacherController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ClassSubjectController;
use App\Http\Controllers\ClassTimetableController;
use App\Http\Controllers\CommunicateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExaminationsController;
use App\Http\Controllers\FeesCollectionController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'AuthLogin']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('forgot-password', [AuthController::class, 'ForgotPassword']);
Route::post('forgot-password', [AuthController::class, 'PostForgotPassword']);
Route::get('reset/{token}', [AuthController::class, 'reset']);
Route::post('reset/{token}', [AuthController::class, 'PostReset']);

Route::group(['middleware' => 'admin'], function () {
    Route::get('admin/dashboard', [DashboardController::class, 'dashboard']);
    // Admin Done
    Route::prefix('admin/admin')->group(function () {
        Route::get('list', [AdminController::class, 'list']);
        Route::get('add', [AdminController::class, 'add']);
        Route::post('add', [AdminController::class, 'insert']);
        Route::get('edit/{id}', [AdminController::class, 'edit']);
        Route::post('edit/{id}', [AdminController::class, 'update']);
        Route::get('delete/{id}', [AdminController::class, 'delete']);

        Route::get('trash_bin', [AdminController::class, 'list']);
        // Route::get('remove/{id}', [AdminController::class, 'remove']);
        Route::get('restore/{id}', [AdminController::class, 'restore']);
    });
    // Teacher Done
    Route::prefix('admin/teacher')->group(function () {
        Route::get('list', [TeacherController::class, 'list']);
        Route::get('add', [TeacherController::class, 'add']);
        Route::post('add', [TeacherController::class, 'insert']);
        Route::get('edit/{id}', [TeacherController::class, 'edit']);
        Route::post('edit/{id}', [TeacherController::class, 'update']);
        Route::get('delete/{id}', [TeacherController::class, 'delete']);

        Route::get('trash_bin', [TeacherController::class, 'list']);
        Route::get('restore/{id}', [TeacherController::class, 'restore']);
        // Route::get('remove/{id}', [TeacherController::class, 'remove']);

        Route::post('export_excel', [TeacherController::class,'export_excel']);
    });

    // Student Done
    Route::prefix('admin/student')->group(function () {
        Route::get('list', [StudentController::class, 'list']);
        Route::get('show/{id}', [StudentController::class, 'show']);
        Route::get('add', [StudentController::class, 'add']);
        Route::post('add', [StudentController::class, 'insert']);
        Route::get('edit/{id}', [StudentController::class, 'edit']);
        Route::post('edit/{id}', [StudentController::class, 'update']);
        Route::get('delete/{id}', [StudentController::class, 'delete']);

        Route::get('trash_bin', [StudentController::class, 'list']);
        //Route::get('remove/{id}', [StudentController::class, 'remove']);
        Route::get('restore/{id}', [StudentController::class, 'restore']);

        Route::post('export_excel', [StudentController::class,'export_excel']);
    });

    // Parent Done
    Route::prefix('admin/parent')->group(function () {
        Route::get('list', [ParentController::class, 'list']);
        Route::get('add', [ParentController::class, 'add']);
        Route::post('add', [ParentController::class, 'insert']);
        Route::get('edit/{id}', [ParentController::class, 'edit']);
        Route::post('edit/{id}', [ParentController::class, 'update']);
        Route::get('delete/{id}', [ParentController::class, 'delete']);

        Route::get('my-student/{id}', [ParentController::class, 'myStudent']);
        Route::get('assign_student_parent/{student_id}/{parent_id}', [ParentController::class, 'AssignStudentParent']);
        Route::get('assign_student_parent_delete/{student_id}', [ParentController::class, 'AssignStudentParentDelete']);

        Route::get('trash_bin', [ParentController::class, 'list']);
        // Route::get('remove/{id}', [ParentController::class, 'remove']);
        Route::get('restore/{id}', [ParentController::class, 'restore']);
        Route::post('export_excel', [ParentController::class,'export_excel']);
    });
    // Class Done
    Route::prefix('admin/class')->group(function () {
        Route::get('list', [ClassController::class, 'list']);
        Route::get('add', [ClassController::class, 'add']);
        Route::post('add', [ClassController::class, 'insert']);
        Route::get('edit/{id}', [ClassController::class, 'edit']);
        Route::post('edit/{id}', [ClassController::class, 'update']);
        Route::get('delete/{id}', [ClassController::class, 'delete']);
        Route::get('trash_bin', [ClassController::class, 'list']);
        Route::get('restore/{id}', [ClassController::class, 'restore']);
        // Route::get('remove/{id}', [ClassController::class, 'remove']);
    });
    // subject URL Done
    Route::prefix('admin/subject')->group(function () {
        Route::get('list', [SubjectController::class, 'list']);
        Route::get('add', [SubjectController::class, 'add']);
        Route::post('add', [SubjectController::class, 'insert']);
        Route::get('edit/{id}', [SubjectController::class, 'edit']);
        Route::post('edit/{id}', [SubjectController::class, 'update']);
        Route::get('delete/{id}', [SubjectController::class, 'delete']);
        Route::get('trash_bin', [SubjectController::class, 'list']);
        Route::get('remove/{id}', [SubjectController::class, 'remove']);
        Route::get('restore/{id}', [SubjectController::class, 'restore']);
    });
    // assign_subject URL
    Route::prefix('admin/assign_subject')->group(function () {
        Route::get('list', [ClassSubjectController::class, 'list']);
        Route::get('add', [ClassSubjectController::class, 'add']);
        Route::post('add', [ClassSubjectController::class, 'insert']);
        Route::get('edit/{id}', [ClassSubjectController::class, 'edit']);
        Route::post('edit/{id}', [ClassSubjectController::class, 'update']);
        Route::get('edit_single/{id}', [ClassSubjectController::class, 'edit_single']);
        Route::post('edit_single/{id}', [ClassSubjectController::class, 'update_single']);
        Route::get('delete/{id}', [ClassSubjectController::class, 'delete']);
        Route::get('trash_bin', [ClassSubjectController::class, 'list']);
        Route::get('restore/{id}', [ClassSubjectController::class, 'restore']);
        // Route::get('remove/{id}', [ClassSubjectController::class, 'remove']);
    });

    // Class Timetable
    Route::prefix('admin/class_timetable')->group(function () {
        Route::get('list', [ClassTimetableController::class, 'list']);
        Route::post('get_subject', [ClassTimetableController::class, 'get_subject']);
        Route::post('add', [ClassTimetableController::class, 'insert_update']);
    });

    // Assign_Class_Teacher
    Route::prefix('admin/assign_class_teacher')->group(function () {
        Route::get('list', [AssignClassTeacherController::class, 'list']);
        Route::get('add', [AssignClassTeacherController::class, 'add']);
        Route::post('add', [AssignClassTeacherController::class, 'insert']);
        Route::get('edit/{id}', [AssignClassTeacherController::class, 'edit']);
        Route::post('edit/{id}', [AssignClassTeacherController::class, 'update']);
        Route::get('edit_single/{id}', [AssignClassTeacherController::class, 'edit_single']);
        Route::post('edit_single/{id}', [AssignClassTeacherController::class, 'update_single']);
        Route::get('delete/{id}', [AssignClassTeacherController::class, 'delete']);

        Route::get('trash_bin', [AssignClassTeacherController::class, 'list']);
        Route::get('restore/{id}', [AssignClassTeacherController::class, 'restore']);
        // Route::get('remove/{id}', [AdminController::class, 'remove']);
    });

    // Examinations
    Route::prefix('admin/examinations')->group(function () {
        //Exam
        Route::prefix('exam')->group(function () {
            Route::get('list', [ExaminationsController::class, 'exam_list']);
            Route::get('add', [ExaminationsController::class, 'exam_add']);
            Route::post('add', [ExaminationsController::class, 'exam_insert']);
            Route::get('edit/{id}', [ExaminationsController::class, 'exam_edit']);
            Route::post('edit/{id}', [ExaminationsController::class, 'exam_update']);
            Route::get('delete/{id}', [ExaminationsController::class, 'exam_delete']);

            Route::get('trash_bin', [ExaminationsController::class, 'exam_list']);
            // Route::get('remove/{id}', [AdminController::class, 'remove']);
            Route::get('restore/{id}', [ExaminationsController::class, 'exam_restore']);
        });

        Route::get('my_exam_result/print', [ExaminationsController::class,'myExamResultPrint']);

        // Exam Schedule
        Route::get('exam_schedule', [ExaminationsController::class, 'exam_schedule']);
        Route::post('exam_schedule_insert', [ExaminationsController::class, 'exam_schedule_insert']);

        // Marks
        Route::get('marks_register', [ExaminationsController::class, 'marks_register']);
        Route::post('submit_marks_register', [ExaminationsController::class, 'submit_marks_register']);
        Route::post('single_submit_marks_register', [ExaminationsController::class, 'single_submit_marks_register']);

        // Marks Grade
        Route::prefix('marks_grade')->group(function () {
            Route::get('', [ExaminationsController::class, 'marks_grade']);
            Route::get('add', [ExaminationsController::class, 'marks_grade_add']);
            Route::post('add', [ExaminationsController::class, 'marks_grade_insert']);

            Route::get('edit/{id}', [ExaminationsController::class, 'marks_grade_edit']);
            Route::post('edit/{id}', [ExaminationsController::class, 'marks_grade_update']);
            Route::get('delete/{id}', [ExaminationsController::class, 'marks_grade_delete']);
        });
    });

    // Admin Attendance
    Route::prefix('admin/attendance')->group(function () {
        // Attendance
        Route::get('student', [AttendanceController::class, 'AttendanceStudent']);
        Route::post('student/save', [AttendanceController::class, 'AttendanceStudentSubmit']);

        Route::get('report', [AttendanceController::class, 'AttendanceReport']);
        Route::post('report_export_excel', [AttendanceController::class, 'AttendanceReportExportExcel']);

        // Kiểm tra ngày
        Route::post('attendance_date', [AttendanceController::class, 'AttendanceDate']);
        Route::post('attendance_date_submit', [AttendanceController::class, 'AttendanceDateSubmit']);
    });

    // Admin Communicate
    Route::prefix('admin/communicate')->group(function () {
        // Notice Board
        Route::prefix('notice_board')->group(function () {
            // Notice Board
            Route::get('list', [CommunicateController::class, 'NoticeBoard']);
            Route::get('add', [CommunicateController::class, 'AddNoticeBoard']);
            Route::post('add', [CommunicateController::class, 'InsertNoticeBoard']);

            Route::get('edit/{id}', [CommunicateController::class, 'EditNoticeBoard']);
            Route::post('edit/{id}', [CommunicateController::class, 'UpdateNoticeBoard']);
            // Route::get('delete/{id}', [CommunicateController::class, 'DeleteNoticeBoard']);
        });

        // Send Mail
        Route::get('send_email', [CommunicateController::class, 'SendEmail']);
        Route::post('send_email', [CommunicateController::class, 'SendEmailUser']);

        Route::get('search_user', [CommunicateController::class, 'SearchUser']);
    });

    // Home Work
    Route::prefix('admin/homework/homework')->group(function () {
        Route::get('', [HomeworkController::class, 'Homework']);
        Route::get('add', [HomeworkController::class, 'HomeworkAdd']);
        Route::post('add', [HomeworkController::class, 'HomeworkInsert']);
        Route::get('edit/{id}', [HomeworkController::class, 'HomeworkEdit']);
        Route::post('edit/{id}', [HomeworkController::class, 'HomeworkUpdate']);
        Route::get('delete/{id}', [HomeworkController::class, 'HomeworkDelete']);
        Route::get('trash_bin/', [HomeworkController::class, 'HomeworkTrashBin']);

        Route::get('restore/{id}', [HomeworkController::class, 'HomeworkRestore']);
        Route::get('submitted/{id}', [HomeworkController::class, 'HomeworkSubmitted']);
    });

    Route::get('admin/homework/homework_report', [HomeworkController::class,'HomeworkReport']);

    Route::get('admin/fees_collection/collect_fees', [FeesCollectionController::class, 'CollectFees']);

    Route::get('admin/fees_collection/collect_fees_report', [FeesCollectionController::class, 'CollectFeesReport']);
    Route::post('admin/fees_collection/export_collect_fees_report', [FeesCollectionController::class, 'ExportCollectFeesReport']);

    Route::get('admin/fees_collection/collect_fees/add_fees/{student_id}', [FeesCollectionController::class, 'CollectFeesAdd']);
    Route::post('admin/fees_collection/collect_fees/add_fees/{student_id}', [FeesCollectionController::class, 'CollectFeesInsert']);



    // Admin Account
    Route::get('admin/account', [UserController::class, 'MyAccount']);
    Route::post('admin/account', [UserController::class, 'UpdateMyAccountAdmin']);

    // Admin Setting
    Route::get('admin/setting', [UserController::class, 'Setting']);
    Route::post('admin/setting', [UserController::class, 'UpdateSetting']);

    // Password
    Route::get('admin/change_password', [UserController::class, 'change_password']);
    Route::post('admin/change_password', [UserController::class, 'update_change_password']);
});


Route::group(['middleware' => 'teacher'], function () {
    Route::get('teacher/dashboard', [DashboardController::class, 'dashboard']);

    // My Student Done
    Route::get('teacher/my_student', [StudentController::class, 'MyStudent']);

    // My Class, Subject And Class Timetable Done
    Route::get('teacher/my_class_subject', [AssignClassTeacherController::class, 'MyClassSubject']);
    Route::get('teacher/my_class_subject/class_timetable/{class_id}/{subject_id}', [ClassTimetableController::class, 'MyTimetableTeacher']);

    // Exam Timetable Done
    Route::get('teacher/my_exam_timetable', [ExaminationsController::class, 'MyExamTimetableTeacher']);

    // My Calendar Done
    Route::get('teacher/my_calendar', [CalendarController::class, 'MyCalendarTeacher']);

    // Marks
    Route::get('teacher/marks_register', [ExaminationsController::class, 'marks_register_teacher']);
    Route::post('teacher/submit_marks_register', [ExaminationsController::class, 'submit_marks_register']);
    Route::post('teacher/single_submit_marks_register', [ExaminationsController::class, 'single_submit_marks_register']);

    Route::get('teacher/my_exam_result/print', [ExaminationsController::class,'myExamResultPrint']);


    Route::post('teacher/class_timetable/get_subject', [ClassTimetableController::class, 'get_subject']);


    // Attendance
    Route::prefix('teacher/attendance')->group(function () {
        Route::get('student', [AttendanceController::class, 'AttendanceStudentTeacher']);
        Route::post('student/save', [AttendanceController::class, 'AttendanceStudentSubmit']);

        Route::get('report', [AttendanceController::class, 'AttendanceReportTeacher']);
        Route::post('report_export_excel', [AttendanceController::class, 'AttendanceReportExportExcel']);
        // kiểm tra ngày
        Route::post('attendance_date', [AttendanceController::class, 'AttendanceDate']);
        Route::post('attendance_date_submit', [AttendanceController::class, 'AttendanceDateSubmit']);
    });

    // Homework
    Route::prefix('teacher/homework/homework')->group(function () {
        Route::get('', [HomeworkController::class, 'HomeworkTeacher']);
        Route::get('add', [HomeworkController::class, 'HomeworkAddTeacher']);
        Route::post('add', [HomeworkController::class, 'HomeworkInsertTeacher']);
        Route::get('edit/{id}', [HomeworkController::class, 'HomeworkEditTeacher']);
        Route::post('edit/{id}', [HomeworkController::class, 'HomeworkUpdateTeacher']);
        Route::get('delete/{id}', [HomeworkController::class, 'HomeworkDelete']);

        Route::get('submitted/{id}', [HomeworkController::class, 'HomeworkSubmittedTeacher']);
    });

    // Notice Board
    Route::get('teacher/my_notice_board', [CommunicateController::class, 'MyNoticeBoardUser']);

    // Account
    Route::get('teacher/account', [UserController::class, 'MyAccount']);
    Route::post('teacher/account', [UserController::class, 'UpdateMyAccountTeacher']);

    // Change password
    Route::get('teacher/change_password', [UserController::class, 'change_password']);
    Route::post('teacher/change_password', [UserController::class, 'update_change_password']);
});


Route::group(['middleware' => 'student'], function () {

    Route::get('student/dashboard', [DashboardController::class, 'dashboard']);

    Route::get('student/my_calendar', [CalendarController::class, 'MyCalendar']);

    Route::get('student/my_subject', [SubjectController::class, 'MySubject']);

    Route::get('student/my_timetable', [ClassTimetableController::class, 'MyTimetable']);

    Route::get('student/my_exam_timetable', [ExaminationsController::class, 'MyExamTimetable']);

    Route::get('student/my_exam_result', [ExaminationsController::class, 'myExamResult']);
    Route::get('student/my_exam_result/print', [ExaminationsController::class, 'myExamResultPrint']);

    // Attendance
    Route::get('student/my_attendance', [AttendanceController::class, 'MyAttendanceStudent']);
    // Notice Board
    Route::get('student/my_notice_board', [CommunicateController::class, 'MyNoticeBoardUser']);

    // Home Work
    Route::get('student/my_homework', [HomeworkController::class, 'HomeWorkStudent']);
    Route::get('student/my_homework/submit_homework/{id}', [HomeworkController::class, 'SubmitHomeWork']);
    Route::post('student/my_homework/submit_homework/{id}', [HomeworkController::class, 'SubmitHomeWorkInsert']);
    Route::get('student/my_submitted_homework', [HomeworkController::class, 'HomeWorkSubmittedStudent']);

    // Account
    Route::get('student/account', [UserController::class, 'MyAccount']);
    Route::post('student/account', [UserController::class, 'UpdateMyAccountStudent']);

    //Change password
    Route::get('student/change_password', [UserController::class, 'change_password']);
    Route::post('student/change_password', [UserController::class, 'update_change_password']);

    // Fees Collection
    Route::get('student/fees_collection', [FeesCollectionController::class, 'CollectFeesStudent']);
    Route::post('student/fees_collection', [FeesCollectionController::class, 'CollectFeesStudentPayment']);

    // Route::get('student/paypal/payment-error', [FeesCollectionController::class, 'PaymentError']);
    // Route::get('student/paypal/payment-success', [FeesCollectionController::class, 'PaymentSuccess']);

    Route::get('student/stripe/payment-error', [FeesCollectionController::class, 'PaymentError']);
    Route::get('student/stripe/payment-success', [FeesCollectionController::class, 'PaymentSuccessStripe']);
});

Route::group(['middleware' => 'parent'], function () {

    Route::get('parent/dashboard', [DashboardController::class, 'dashboard']);

    Route::prefix('parent/my_student')->group(function () {
        Route::get('/', [ParentController::class, 'myStudentParent']);

        Route::get('subject/{student_id}', [SubjectController::class, 'ParentStudentSubject']);
        Route::get('subject/class_timetable/{class_id}/{subject_id}/{student_id}', [ClassTimetableController::class, 'MyTimetableParent']);

        Route::get('exam_timetable/{student_id}', [ExaminationsController::class, 'ParentMyExamTimetable']);
        Route::get('exam_result/{student_id}', [ExaminationsController::class, 'ParentMyExamResult']);
        Route::get('my_exam_result/print', [ExaminationsController::class, 'myExamResultPrint']);
        Route::get('calendar/{student_id}', [CalendarController::class, 'myCalendarParent']);
        Route::get('attendance/{student_id}', [AttendanceController::class, 'myAttendanceParent']);

        // Homework
        Route::get('homework/{id}', [HomeworkController::class, 'HomeworkStudentParent']);
        Route::get('submitted_homework/{id}', [HomeworkController::class, 'SubmittedHomeworkStudentParent']);
    });

    // Notice Board
    Route::get('parent/my_notice_board', [CommunicateController::class, 'MyNoticeBoardUser']);
    Route::get('parent/my_student_notice_board', [CommunicateController::class, 'MyStudentNoticeBoardParent']);

    // Account
    Route::get('parent/account', [UserController::class, 'MyAccount']);
    Route::post('parent/account', [UserController::class, 'UpdateMyAccountParent']);

    //Change Password
    Route::get('parent/change_password', [UserController::class, 'change_password']);
    Route::post('parent/change_password', [UserController::class, 'update_change_password']);
});
