<?php

namespace App\Http\Controllers;

use App\Exports\ExporAttendance;
use App\Http\Requests\Attendance\AttendanceSubmitRequest;
use App\Models\AssignClassTeacherModel;
use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\ClassSubjectTimetableModel;
use App\Models\StudentAttendanceModel;
use App\Models\User;
use Auth;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function AttendanceStudent(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();

        if (!empty($request->get('attendance_date')) && !empty($request->get('class_id')) && !empty($request->get('subject_id'))) {
            $data['getStudent'] = User::getStudentClassSubject($request->get('class_id'), $request->get('subject_id'), 1);
            $data['getSubject'] = ClassSubjectModel::MySubject($request->get('class_id'));
            if (User::getStudentClassSubject($request->get('class_id'), $request->get('subject_id'), 1)->count() > 0) {
                Toastr::info(' Search successful. Here are the results.', 'Message');
            } else {
                Toastr::error('Search failed. Check the entered information again.', 'Error');
            }
        }
        else
        {
            Toastr::info('Enter information to search', 'Message');
        }

        $data['header_title'] = 'Student Attendance';

        return view('admin.attendance.student', $data);
    }

    public function AttendanceStudentSubmit(AttendanceSubmitRequest $request) //Done
    {
        $error = array();
        $check_attendance = StudentAttendanceModel::CheckAlreadyAttendance($request->student_id, $request->class_id, $request->attendance_date, $request->subject_id);

        if (!empty($check_attendance)) {
            $attendance = $check_attendance;
        } else {
            $attendance = new StudentAttendanceModel;
            $attendance->student_id = $request->student_id;
            $attendance->class_id = $request->class_id;
            $attendance->subject_id = $request->subject_id;
            $attendance->attendance_date = $request->attendance_date;
            $attendance->created_by = Auth::user()->id;
        }
        $attendance->attendance_type = $request->attendance_type;
        $attendance->save();

        $json['message'] = "Attendance Successfully Saved";
        echo json_encode($json);
    }

    public function AttendanceReport(Request $request)
    {
        $data['header_title'] = 'Attendance Report';

        $data['getClass'] = ClassModel::getClass();

        if (empty($request->class_id) && empty($request->subject_id)) {
            Toastr::info('Please enter complete search information.', 'Message');
            return view('admin.attendance.report', $data);
        }

        $data['getSubject'] = ClassSubjectModel::MySubject($request->get('class_id'));
        $data['getRecord'] = StudentAttendanceModel::getRecord();

        if (StudentAttendanceModel::getRecord()->count() > 0) {
            Toastr::info(' Search successful. Here are the results.', 'Message');
        } else {
            Toastr::error('Search failed. Check the entered information again.', 'Error');
        }
        // dd($data);
        return view('admin.attendance.report', $data);
    }

    public function AttendanceReportExportExcel(Request $request)
    {
        return Excel::download(new ExporAttendance, 'AttendanceReport_'.date('d-m-Y H:i:s').'.xlsx');
    }

    public function AttendanceDate(Request $request) // Done
    {
        $dayTime = array();
        $classSubjectTime = ClassSubjectTimetableModel::getDayClassSubjectTime($request->class_id, $request->subject_id);

        if ($classSubjectTime->count() != 0) {
            $json['message'] = 1;
            foreach ($classSubjectTime as $value) {
                $dayTime[] = $value->week_id;
            }
            $json['data'] = $dayTime;
            echo json_encode($json);
        } else {
            $json['message'] = 0;
            echo json_encode($json);
        }
    }

    public function AttendanceDateSubmit(Request $request) // Done
    {
        // $dataTimeArray = json_decode($request->dataTime)->data;
        $dataTimeArray = json_decode($request->dataTime);
        $currentDate = Carbon::now('Asia/Ho_Chi_Minh');

        $date1 = Carbon::parse($request->attendance_date);
        $date2 = Carbon::parse($currentDate);

        if($date1->gt($date2))
        {
            $json['message'] = 2;
            return response()->json($json);
        }

        $date_thu = date('w', strtotime($request->attendance_date));
        if (!in_array($date_thu, $dataTimeArray)) {
            $json['message'] = 1;
            return response()->json($json);
        }

    }

    // teacher side
    public function AttendanceStudentTeacher(Request $request)
    {
        $data['header_title'] = 'Student Attendance';

        $getClass = AssignClassTeacherModel::getMyClassSubjectGroup(Auth::user()->id);

        if ($getClass->count() === 0) {
            Toastr::warning('You do not have any classes yet.', 'Message');
            return view('teacher.attendance.student', $data);
        }

        $data['getClass'] = $getClass;

        if (!empty($request->get('attendance_date')) && !empty($request->get('class_id')) && !empty($request->get('subject_id'))) {
            $data['getStudent'] = User::getStudentClassSubject($request->get('class_id'), $request->get('subject_id'),1);
            $data['getSubject'] = ClassSubjectModel::MySubject($request->get('class_id'));
            if (User::getStudentClassSubject($request->get('class_id'), $request->get('subject_id'), 1)->count() > 0) {
                Toastr::info(' Search successful. Here are the results.', 'Message');
            } else {
                Toastr::error('Search failed. Check the entered information again.', 'Error');
            }
        }
        else
        {
            Toastr::info('Enter information to search', 'Message');
        }
        return view('teacher.attendance.student', $data);
    }

    public function AttendanceReportTeacher(Request $request)
    {
        $data['header_title'] = 'Attendance Report';

        $getClass = AssignClassTeacherModel::getMyClassSubjectGroup(Auth::user()->id);

        if($getClass === 0)
        {
            Toastr::warning('You do not have any classes yet.','Message');
            return view('teacher.attendance.report', $data);
        }
        $data['getClass'] = $getClass;

        if(empty($request->class_id) && empty($request->subject_id))
        {
            Toastr::info('Please enter complete search information.', 'Message');
            return view('teacher.attendance.report', $data);
        }

        $data['getSubject'] = ClassSubjectModel::MySubject($request->get('class_id'));

        $classArray = array();
        foreach ($getClass as $value) {
            $classArray[] = $value->class_id;
        }

        $data['getRecord'] = StudentAttendanceModel::getRecordTeacher($classArray);

        if (session('error')) {
            Toastr::error('No Information Found  ', 'Error');
        } else if (session('updated')) {
            Toastr::success('Class updated successfully', 'Message');
        } else if (session('deleted')) {
            Toastr::warning('Class delete successfully ', 'Warning');
        } else {
            Toastr::info(' Search successful. Here are the results.', 'Message');
        }
        return view('teacher.attendance.report', $data);
    }

    // student side
    public function MyAttendanceStudent(Request $request)
    {
        $class_id = (User::select('users.class_id')->where('users.id', '=', Auth::user()->id)->first())->class_id;
        $getSubject = ClassSubjectModel::MySubject($class_id);

        $data['getRecord'] = StudentAttendanceModel::getRecordStudent(Auth::user()->id);

        $data['getSubject'] = $getSubject;
        $data['header_title'] = 'My Attendance';
        if (StudentAttendanceModel::getRecordStudent(Auth::user()->id)->count() > 0) {
            Toastr::info(' Search successful. Here are the results.', 'Message');
        } else {
            Toastr::error('Search failed. Check the entered information again.', 'Error');
        }
        return view('student.my-attendance', $data);
    }

    // parent side

    public function MyAttendanceParent($student_id, Request $request)
    {
        $getStudent = User::getSingle($student_id);
        $data['getStudent'] = $getStudent;
        $class_id = $getStudent->class_id;
        $getSubject = ClassSubjectModel::MySubject($class_id);

        $data['getRecord'] = StudentAttendanceModel::getRecordParent($student_id);

        $data['getSubject'] = $getSubject;
        $data['header_title'] = 'Student Attendance ';
        return view('parent.my-attendance', $data);
    }
}
