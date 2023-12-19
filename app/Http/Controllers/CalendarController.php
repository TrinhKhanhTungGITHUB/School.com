<?php

namespace App\Http\Controllers;

use App\Models\AssignClassTeacherModel;
use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\ClassSubjectTimetableModel;
use App\Models\ExamScheduleModel;
use App\Models\User;
use App\Models\WeekModel;
use Auth;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function MyCalendar()
    {
        // timetable
        $data['header_title'] = 'My Calendar';
        Toastr::info('This is your calendar.', 'Message');
        
        // $data = ($this->getTimetable(Auth::user()->class_id));
        // dd($data);
        // $events = []; // Mảng để lưu trữ các sự kiện

        // foreach ($data as $value) {
        //     foreach ($value['week'] as $week) {
        //         $event = [
        //             'title' => $value['name'],
        //             'daysOfWeek' => [$week['fullcalendar_day']],
        //             'startTime' => $week['start_time'],
        //             'endTime' => $week['end_time'],
        //         ];

        //         dump($event);
        //     }
        // }
        // // dd(); // Bạn có thể sử dụng dd() ở cuối nếu muốn


        $data['getMyTimetable'] = $this->getTimetable(Auth::user()->class_id);

        $data['getExamTimetable'] = $this->getExamTimetable(Auth::user()->class_id);


        return view('student.my_calendar', $data);
    }

    public function getTimetable($class_id)
    {
        $result =array();
        $getRecord = ClassSubjectModel::MySubject($class_id);
        foreach ($getRecord as $value) {
            $dataS['name'] = $value->subject_name;


            $getWeek = WeekModel::getRecord();
            $week = array();
            foreach ($getWeek as $valueW) {
                $dataW = array();
                // $dataW['week_id'] = $valueW->id;
                $dataW['week_name'] = $valueW->name;
                $dataW['fullcalendar_day'] = $valueW->fullcalendar_day;

               $classSubject = ClassSubjectTimetableModel::getRecordClassSubject($value->class_id, $value->subject_id, $valueW->id);
            //    dump($classSubject);
                // dd(ClassSubjectTimetableModel::getRecordClassSubject(4, 2, 5));
                if (!empty($classSubject)) {
                    $dataW['start_time'] = $classSubject->start_time;
                    $dataW['end_time'] = $classSubject->end_time;
                    $dataW['room_number'] = $classSubject->room_number;
                    $week[] = $dataW;
                }
            }
            // dump($week);
            $dataS['week'] = $week;

            // dump($dataS);
            $result[] = $dataS;

        }

        return $result;
    }
    public function getExamTimetable($class_id)
    {
        $getExam = ExamScheduleModel::getExamByClass($class_id);
        $result = array();
        foreach ($getExam as $value) {
            $dataE = array();
            $dataE['name'] = $value->exam_name;
            $dataE['exam_id'] = $value->exam_id;
            $getExamTimetable = ExamScheduleModel::getExamTimetable($value->exam_id, $class_id);
            $resultS = array();

            foreach ($getExamTimetable as $valueS) {
                $dataS = array();
                $dataS['subject_name'] = $valueS->subject_name;
                $dataS['exam_date'] = $valueS->exam_date;
                $dataS['start_time'] = $valueS->start_time;
                $dataS['end_time'] = $valueS->end_time;
                $dataS['room_number'] = $valueS->room_number;
                $dataS['full_marks'] = $valueS->full_marks;
                $dataS['passing_marks'] = $valueS->passing_marks;
                $resultS[] = $dataS;
            }

            $dataE['exam'] = $resultS;
            $result[] = $dataE;
        }

        if(!empty($result))
        {
            $data['getRecord'] = $result;
        }

        return $result;
    }


    // parent side
    public function MyCalendarParent($student_id)
    {
        $getStudent = User::getSingle($student_id);

        $data['getMyTimetable'] = $this->getTimetable($getStudent->class_id);
        $data['getExamTimetable'] = $this->getExamTimetable($getStudent->class_id);

        $data['getStudent'] = $getStudent;
        $data['header_title'] = 'Student Calendar';
        Toastr::info('This is your child'.'s calendar..', 'Message');

        return view('parent.my_calendar', $data );
    }

    // teacher side
    public function MyCalendarTeacher()
    {
        $teacher_id = Auth::user()->id;

        $data['getClassTimetable'] = AssignClassTeacherModel::getCalendarTeacher($teacher_id);

        $data['getExamTimetable'] = ExamScheduleModel::getExamTimetableTeacher($teacher_id);
        $data['header_title'] = 'My Calendar';

        Toastr::info('This is your calendar.', 'Message');
        return view('teacher.my_calendar', $data);
    }

}
