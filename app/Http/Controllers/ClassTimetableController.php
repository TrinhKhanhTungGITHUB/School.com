<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\ClassTimetable\ClassTimetableRequest;
use App\Http\Requests\Admin\ClassTimetableListRequest;
use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\ClassSubjectTimetableModel;
use App\Models\SubjectModel;
use App\Models\User;
use App\Models\WeekModel;
use Auth;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class ClassTimetableController extends Controller
{
    public function list(ClassTimetableListRequest $request)
    {
        $data['header_title'] = 'Class Timetable';
        $data['getClass'] = ClassModel::getClass();
        $check = 0;

        if (!empty($request->class_id)) {

            $getSubject = ClassSubjectModel::MySubject($request->class_id);

            $data['getSubject'] = $getSubject;

        }

        $classAlready = ClassSubjectModel::getAlreadyFirst($request->class_id, $request->subject_id);

        if (!empty($classAlready)) {
            $data['getClassSubject'] = ClassSubjectModel::getSingleByClassSubject($request->class_id, $request->subject_id);
            $getWeek = WeekModel::getRecord();
            $week = [];

            foreach ($getWeek as $value) {
                $dataW = [
                    'week_id' => $value->id,
                    'week_name' => $value->name,
                    'start_time' => '',
                    'end_time' => '',
                    'room_number' => '',
                ];

                if (!empty($request->class_id) && !empty($request->subject_id)) {
                    $classSubject = ClassSubjectTimetableModel::getRecordClassSubject($request->class_id, $request->subject_id, $value->id);

                    if (!empty($classSubject)) {
                        $dataW['start_time'] = $classSubject->start_time;
                        $dataW['end_time'] = $classSubject->end_time;
                        $dataW['room_number'] = $classSubject->room_number;
                    }
                }

                $week[] = $dataW;
            }

            $data['week'] = $week;
        } else {
            $check = 1;
        }
        if (empty($request->all())) {
            Toastr::info('Please enter complete information', 'Message');
        } else {
            if ($check == 0) {
                $message = '';
                $type = 'info';

                if (session('success')) {
                    $message = 'Class Timetable successfully Saved';
                    $type = 'success';
                } else if (session('error')) {
                    $message = 'Not Found';
                    $type = 'error';
                } else if (session('error_1')) {
                    $message = 'Start time is greater than end time.';
                    $type = 'error';
                } else if (session('error_2')) {
                    $message = 'Enter missing data.';
                    $type = 'error';
                } else {
                    $message = 'Search successful. Here are the results.';
                }

                Toastr::$type($message, 'Message');
            } else if ($request->subject_id == null) {
                if ($getSubject->count() == 0) {
                    Toastr::error('This class does not have any subjects yet', 'Message');
                } else {
                    Toastr::error('You have not chosen a subject yet.', 'Message');
                }
            } else {
                Toastr::error('Not Found', 'Message');
            }
        }
        return view('admin.class_timetable.list', $data);

    }

    public function get_subject(Request $request)
    {
        $getSubject = ClassSubjectModel::MySubject($request->class_id);

        $html = "<option value= ''> Select Subject </option>";
        foreach ($getSubject as $value) {
            $html .= "<option value ='" . $value->subject_id . "'> " . $value->subject_name . " </option>";
        }

        $json['html'] = $html;
        return json_encode($json);
    }

    public function insert_update(Request $request)
    {
        //   dd($request->all());
        $hasAtLeastOneRecord = false;

        foreach ($request->timetable as $index => $timetable) {
            // Bỏ qua nếu tất cả ba trường rỗng trong khi 'week_id' có giá trị
            if (isset($timetable['week_id']) && empty($timetable['start_time']) && empty($timetable['end_time']) && empty($timetable['room_number'])) {
                $checkClassSubjectTimetable = ClassSubjectTimetableModel::getRecordClassSubject($request->class_id, $request->subject_id, $timetable['week_id']);
                if (!empty($checkClassSubjectTimetable)) {
                    ClassSubjectTimetableModel::getDeleteRecord($request->class_id, $request->subject_id, $timetable['week_id']);
                }
                continue;
            }

            // Kiểm tra giá trị của 'start_time' và 'end_time'
            if (!empty($timetable['start_time']) && !empty($timetable['end_time']) && $timetable['start_time'] >= $timetable['end_time']) {
                return redirect()->back()->with('error_1', "Start time is greater than end time");
            }

            // Kiểm tra giá trị của 'week_id', 'start_time', 'end_time', 'room_number'
            if (
                isset($timetable['week_id']) &&
                isset($timetable['start_time']) &&
                isset($timetable['end_time']) &&
                isset($timetable['room_number'])
            ) {
                if (
                    !empty($timetable['week_id']) ||
                    !empty($timetable['start_time']) ||
                    !empty($timetable['end_time']) ||
                    !empty($timetable['room_number'])
                ) {
                    // Nếu tồn tại, cập nhật thông tin; ngược lại, thêm mới
                    ClassSubjectTimetableModel::updateOrCreate(
                        [
                            'class_id' => $request->class_id,
                            'subject_id' => $request->subject_id,
                            'week_id' => $timetable['week_id'],
                        ],
                        [
                            'start_time' => $timetable['start_time'],
                            'end_time' => $timetable['end_time'],
                            'room_number' => $timetable['room_number'],
                        ]
                    );

                    $hasAtLeastOneRecord = true;
                }
            } else {
                return redirect()->back()->with('error_2', "Enter missing data");
            }
        }

        // Chỉ hiển thị thông báo nếu có ít nhất một bản ghi có giá trị
        if ($hasAtLeastOneRecord) {
            return redirect()->back()->with('success', "Class Timetable successfully Saved");
        } else {
            return redirect()->back();
        }
    }


    // student side
    public function MyTimetable(Request $request)
    {
        $data['header_title'] = 'Class Timetable';
        $data['getClass'] = ClassModel::getClassName(Auth::user()->class_id);
        $result = [];

        $getSubject = ClassSubjectModel::MySubject(Auth::user()->class_id);
        $data['getSubject'] = $getSubject;

        if ($getSubject->count() == 0) {
            Toastr::error('This class does not have any subjects yet.', 'Error');
        } else if (!empty($request->subject_id)) {
            $getRecord = ClassSubjectModel::getMySubjectSingle(Auth::user()->class_id, $request->subject_id);
            if ($getRecord->count() > 0) {
                foreach ($getRecord as $value) {
                    $dataS = ['name' => $value->subject_name];
                    $getWeek = WeekModel::getRecord();
                    $week = [];

                    foreach ($getWeek as $valueW) {
                        $dataW = ['week_name' => $valueW->name];
                        $classSubject = ClassSubjectTimetableModel::getRecordClassSubject($value->class_id, $value->subject_id, $valueW->id);

                        if (!empty($classSubject)) {
                            $dataW['start_time'] = $classSubject->start_time;
                            $dataW['end_time'] = $classSubject->end_time;
                            $dataW['room_number'] = $classSubject->room_number;
                        } else {
                            $dataW['start_time'] = '';
                            $dataW['end_time'] = '';
                            $dataW['room_number'] = '';
                        }
                        $week[] = $dataW;
                    }

                    $dataS['week'] = $week;
                    $result[] = $dataS;
                }

                $data['getRecord'] = $result;
                Toastr::info('Search successful. Here are the results.', 'Message');
            } else {
                Toastr::error('Search failed. Check the entered information again.', 'Error');
            }
        } else {
            Toastr::info('Please enter a subject to search.', 'Message');
        }

        return view('student.my_timetable', $data);
    }

    // teacher side
    public function MyTimetableTeacher($class_id, $subject_id)
    {
        $data['header_title'] = 'Class Timetable';

        $checkInput = ClassSubjectModel::getAlreadyFirst($class_id, $subject_id);
        if (!empty($checkInput)) {
            $data['getClass'] = ClassModel::getSingle($class_id);
            $data['getSubject'] = SubjectModel::getSingle($subject_id);
            $getWeek = WeekModel::getRecord();
            $week = array();
            foreach ($getWeek as $valueW) {
                $dataW = array();
                $dataW['week_name'] = $valueW->name;

                $classSubject = ClassSubjectTimetableModel::getRecordClassSubject($class_id, $subject_id, $valueW->id);

                if (!empty($classSubject)) {
                    $dataW['start_time'] = $classSubject->start_time;
                    $dataW['end_time'] = $classSubject->end_time;
                    $dataW['room_number'] = $classSubject->room_number;
                } else {
                    $dataW['start_time'] = '';
                    $dataW['end_time'] = '';
                    $dataW['room_number'] = '';
                }

                $result[] = $dataW;
            }

            $data['getRecord'] = $result;
            Toastr::info(' Search successful. Here are the results.', 'Message');
        } else {
            Toastr::error('Error: There are no classes with that subject.', 'Message');
        }

        return view('teacher.my_timetable', $data);
    }

    // parent side
    public function MyTimetableParent($class_id, $subject_id, $student_id)
    {
        $data['header_title'] = 'Class Timetable';

        $data['getClass'] = ClassModel::getSingle($class_id);
        $data['getSubject'] = SubjectModel::getSingle($subject_id);
        $data['getStudent'] = User::getSingle($student_id);

        $getWeek = WeekModel::getRecord();
        $week = array();
        foreach ($getWeek as $valueW) {
            $dataW = array();
            $dataW['week_name'] = $valueW->name;

            $classSubject = ClassSubjectTimetableModel::getRecordClassSubject($class_id, $subject_id, $valueW->id);

            if (!empty($classSubject)) {
                $dataW['start_time'] = $classSubject->start_time;
                $dataW['end_time'] = $classSubject->end_time;
                $dataW['room_number'] = $classSubject->room_number;
            } else {
                $dataW['start_time'] = '';
                $dataW['end_time'] = '';
                $dataW['room_number'] = '';
            }

            $result[] = $dataW;
        }

        $data['getRecord'] = $result;

        Toastr::info('Search successful. Here are the results.', 'Message');
        return view('parent.my_timetable', $data);
    }
}
