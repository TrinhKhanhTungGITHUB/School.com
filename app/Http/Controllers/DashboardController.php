<?php

namespace App\Http\Controllers;

use App\Models\AssignClassTeacherModel;
use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\ExamModel;
use App\Models\HomeworkModel;
use App\Models\HomeworkSubmitModel;
use App\Models\NoticeBoardModel;
use App\Models\StudentAddFeesModel;
use App\Models\StudentAttendanceModel;
use App\Models\SubjectModel;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Brian2694\Toastr\Facades\Toastr;

class DashboardController extends Controller
{
    // Done
    public function dashboard()
    {
        $data['header_title'] = 'Dashboard';
        if (Auth::user()->user_type == 1) {
            $data['getTotalFees'] = StudentAddFeesModel::getTotalFees();
            $data['getTotalTodayFees'] = StudentAddFeesModel::getTotalTodayFees();
            $data['TotalAdmin'] = User::getTotalUser(1);
            $data['TotalTeacher'] = User::getTotalUser(2);
            $data['TotalStudent'] = User::getTotalUser(3);
            $data['TotalParent'] = User::getTotalUser(4);
            $data['TotalExam'] = ExamModel::getTotalExam();
            $data['TotalClass'] = ClassModel::getClass(1);
            $data['TotalSubject'] = SubjectModel::getTotalSubject();

            if (session('success_login')) {
                Toastr::info('Successful login.', 'Message');
            } else {
                Toastr::info('This is your dashboard.', 'Message');
            }
            return view('admin.dashboard', $data);
        } else if (Auth::user()->user_type == 2) {
            $data['TotalStudent'] = User::getTeacherStudent(Auth::user()->id, 1);
            $data['TotalClass'] = AssignClassTeacherModel::getMyClassSubjectGroup(Auth::user()->id, 1);
            $data['TotalSubject'] = AssignClassTeacherModel::getMyClassSubjectCount(Auth::user()->id);
            $data['TotalNoticeBoard'] = NoticeBoardModel::getRecordUserCount(Auth::user()->user_type);
            if (session('success_login')) {
                Toastr::info('Successful login.', 'Message');
            } else {
                Toastr::info('This is your dashboard.', 'Message');
            }
            return view('teacher.dashboard', $data);
        } else if (Auth::user()->user_type == 3) {
            $data['TotalPaidAmount'] = StudentAddFeesModel::TotalPaidAmountStudent(Auth::user()->id);
            $data['TotalSubject'] = ClassSubjectModel::MySubject(Auth::user()->class_id, 1);
            $data['TotalNoticeBoard'] = NoticeBoardModel::getRecordUserCount(Auth::user()->user_type);
            $data['TotalHomework'] = HomeworkModel::getRecordStudentCount(Auth::user()->class_id, Auth::user()->id);
            $data['TotalSubmittedHomework'] = HomeworkSubmitModel::getRecordStudentCount(Auth::user()->id);
            $data['TotalAttendance'] = StudentAttendanceModel::getRecordStudentCount(Auth::user()->id);

            if (session('success_login')) {
                Toastr::info('Successful login.', 'Message');
            } else {
                Toastr::info('This is your dashboard.', 'Message');
            }
            return view('student.dashboard', $data);
        } else if (Auth::user()->user_type == 4) {
            $student_ids = User::getMyStudentIds(Auth::user()->id);
            $class_ids = User::getMyStudentClassIds(Auth::user()->id);


            if (!empty($student_ids)) {
                $data['TotalPaidAmount'] = StudentAddFeesModel::TotalPaidAmountStudentParent($student_ids);
                $data['TotalAttendance'] = StudentAttendanceModel::getRecordStudentParentCount($student_ids);
                $data['TotalSubmittedHomework'] = HomeworkSubmitModel::getRecordStudentParentCount($student_ids);
            } else {
                $data['TotalPaidAmount'] = 0;
                $data['TotalAttendance'] = 0;
                $data['TotalSubmittedHomework'] = 0;
            }

            $data['getTotalFees'] = StudentAddFeesModel::getTotalFees();

            $data['TotalStudent'] = User::getMyStudentCount(Auth::user()->id);
            $data['TotalNoticeBoard'] = NoticeBoardModel::getRecordUserCount(Auth::user()->user_type);

            if (session('success_login')) {
                Toastr::info('Successful login.', 'Message');
            } else {
                Toastr::info('This is your dashboard.', 'Message');
            }
            return view('parent.dashboard', $data);
        }
    }
}
