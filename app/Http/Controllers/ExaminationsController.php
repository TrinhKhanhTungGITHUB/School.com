<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\ExamListRequest;
use App\Http\Requests\Admin\ExamSchedule\ExamScheduleInsertRequest;
use App\Http\Requests\Admin\ExamSchedule\ExamScheduleListRequest;
use App\Http\Requests\Admin\ExamScheduleRequest;
use App\Http\Requests\Exam\ExamRequest;
use App\Http\Requests\Marks\MarksGradeRequest;
use App\Models\AssignClassTeacherModel;
use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\ExamModel;
use App\Models\ExamScheduleModel;
use App\Models\MarksGradeModel;
use App\Models\MarksRegisterModel;
use App\Models\SettingModel;
use App\Models\User;
use Auth;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class ExaminationsController extends Controller
{
    // Admin CRUD Exam
    public function exam_list(ExamListRequest $request)
    {
        if (\Request::segment(4) == 'list') {
            $data['header_title'] = 'Exam List';

            if (session('error')) {
                Toastr::error('No Information Found  ', 'Error');
            } else if (session('updated')) {
                Toastr::success('Exam updated successfully', 'Message');
            } else if (session('deleted')) {
                Toastr::warning('Exam delete successfully ', 'Warning');
            } else {
                if (ExamModel::getRecord(0)->count() > 0) {
                    Toastr::info(' Search successful. Here are the results.', 'Message');
                } else {
                    Toastr::error('Search failed. Check the entered information again.', 'Error');
                }
            }

            if (!empty($request->paginate)) {
                $getRecord = ExamModel::getRecord(0)->orderBy('exam.id', 'desc')->paginate($request->paginate);
            } else {
                $getRecord = ExamModel::getRecord(0)->orderBy('exam.id', 'desc')->paginate(10);
            }

            $data['getRecord'] = $getRecord;
            return view('admin.examinations.exam.list', $data);
        } else if (\Request::segment(4) == 'trash_bin') {
            $data['header_title'] = 'Trash Bin Exam List';

            if (session('error')) {
                Toastr::error('No Information Found  ', 'Error');
            } else if (session('restore')) {
                Toastr::success('Restore Exam successfully', 'Message');
            } else if (session('deleted')) {
                Toastr::warning('Exam delete successfully ', 'Warning');
            } else {
                if (ExamModel::getRecord(1)->count() > 0) {
                    Toastr::info('Search successful. Here are the results.', 'Message');
                } else {
                    Toastr::error('Search failed. Trash Bin empty.', 'Error');
                }
            }

            if (!empty($request->paginate)) {
                $getRecord = ExamModel::getRecord(1)->orderBy('id', 'desc')->paginate($request->paginate);
            } else {
                $getRecord = ExamModel::getRecord(1)->orderBy('id', 'desc')->paginate(10);
            }

            $data['getRecord'] = $getRecord;

            return view('admin.examinations.exam.list', $data);
        }
    }

    public function exam_add()
    {
        $data['header_title'] = 'Add New Exam';

        Toastr::info('Please complete all information.', 'Message');
        if (session('success')) {
            Toastr::success('Exam created successfully ', 'Message');
        }

        return view('admin.examinations.exam.add', $data);
    }

    public function exam_insert(ExamRequest $request)
    {
        $exam = new ExamModel;
        $exam->name = trim($request->name);
        $exam->note = trim($request->note);
        $exam->created_by = Auth::user()->id;

        $exam->save();

        return redirect('admin/examinations/exam/add')->with('success', 'Exam created successfully');
    }

    public function exam_edit($id)
    {
        $data['getRecord'] = ExamModel::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['header_title'] = 'Edit Exam';
            Toastr::info('Please fully update the information.', 'Message');

            return view('admin.examinations.exam.edit', $data);
        } else {
            return redirect('admin/examinations/exam/list')->with('error', 'Not Found');
        }
    }

    public function exam_update(ExamRequest $request, $id)
    {
        $exam = ExamModel::getSingle($id);
        $exam->name = trim($request->name);
        $exam->note = trim($request->note);
        $exam->status = trim($request->status);

        $exam->save();
        return redirect('admin/examinations/exam/list')->with('updated', 'Exam update successfully');
    }

    public function exam_delete($id)
    {
        $exam = ExamModel::getSingle($id);
        if ($exam != null) {
            $exam->is_delete = 1;
            $exam->save();
            return redirect('admin/examinations/exam/list')->with('deleted', 'Exam Delete successfully');
        } else {
            return redirect('admin/examinations/exam/list')->with('error', 'Not Found');
        }
    }

    public function exam_restore($id)
    {
        $exam = ExamModel::getSingle($id);
        if (!empty($exam) && $exam->is_delete == 1) {
            $exam->is_delete = 0;
            $exam->save();
            return redirect('admin/examinations/exam/trash_bin')->with('restore', 'Restore exam successfully');
        } else {
            return redirect('admin/examinations/exam/trash_bin')->with('error', 'Not Found');
        }
    }

    //-------------------------------------------------------------------------------//

    // Admin exam schedule List
    public function exam_schedule(ExamScheduleListRequest $request)
    {
        // dd($request->all());
        $data['getClass'] = ClassModel::getClass();
        $data['getExam'] = ExamModel::getExam();

        if (!empty($request->all())) {
            $checkClass = ClassModel::getSingle($request->class_id);
            $checkExam = ExamModel::getSingle($request->exam_id);
            if (!empty($checkClass) && !empty($checkExam)) {
                $result = array();
                $message = "";
                if (!empty($request->get('exam_id')) && !empty($request->get('class_id'))) {
                    $getSubject = ClassSubjectModel::MySubject($request->class_id);
                    if ($getSubject->count() > 0) {
                        $message = "has subject";
                        foreach ($getSubject as $value) {
                            $dataS = array();
                            $dataS['subject_id'] = $value->subject_id;
                            // $dataS['class_id'] = $value->class_id;
                            $dataS['subject_name'] = $value->subject_name;
                            // $dataS['subject_type'] = $value->subject_type;
                            $ExamSchedule = ExamScheduleModel::getRecordSingle($request->get('exam_id'), $request->get('class_id'), $value->subject_id);
                            if (!empty($ExamSchedule)) {
                                $dataS['exam_date'] = $ExamSchedule->exam_date;
                                $dataS['start_time'] = $ExamSchedule->start_time;
                                $dataS['end_time'] = $ExamSchedule->end_time;
                                $dataS['room_number'] = $ExamSchedule->room_number;
                                $dataS['full_marks'] = $ExamSchedule->full_marks;
                                $dataS['passing_marks'] = $ExamSchedule->passing_marks;
                            } else {
                                $dataS['exam_date'] = '';
                                $dataS['start_time'] = '';
                                $dataS['end_time'] = '';
                                $dataS['room_number'] = '';
                                $dataS['full_marks'] = '';
                                $dataS['passing_marks'] = '';
                            }

                            $result[] = $dataS;

                        }
                    } else {
                        $message = "no subject";
                    }
                }

                // dd($result);
                $data['getRecord'] = $result;
                if (session('success')) {
                    Toastr::success('Exam Schedule successfully Saved ', 'Message');
                } else if (session('error_1')) {
                    Toastr::error('Start time is greater than end time', 'Message');
                } else if (session('error_2')) {
                    Toastr::error('Error Enter missing data.', 'Message');
                } else if (session('error_3')) {
                    Toastr::error('Error Enter Marks ', 'Message');
                } else if (session('error_4')) {
                    Toastr::error('Error enter exam date: There is a year smaller than the current year', 'Message');
                } else if ($message == "has subject") {
                    Toastr::info(' Search successful. Here are the results.', 'Message');
                } else if ($message == "no subject") {
                    Toastr::error('This class does not have any subjects yet.', 'Message');
                } else {
                    Toastr::warning('Please enter search information.', 'Message');
                }
            } else {
                Toastr::error('No results were found', 'Message');
            }
        } else {
            Toastr::info('Please enter enough search information', 'Message');
        }
        $data['header_title'] = "Exam Schedule";
        return view('admin.examinations.exam_schedule', $data);
    }

    // Admin update insert exam schedule
    public function exam_schedule_insert(ExamScheduleInsertRequest $request)
    {
        $error = array();
        foreach ($request->schedule as $schedule) {
            if (
                !empty($schedule['subject_id']) && !empty($schedule['exam_date'])
                && !empty($schedule['start_time']) && !empty($schedule['end_time']) &&
                !empty($schedule['room_number']) && !empty($schedule['full_marks']) && !empty($schedule['passing_marks'])
            ) {
                if (intval(date('Y', strtotime($schedule['exam_date'])) >= intval(date('Y')))) {
                    if ($schedule['start_time'] < $schedule['end_time']) {
                        // dd('time chuan');
                        if (
                            is_numeric($schedule['full_marks']) && is_numeric($schedule['passing_marks']) &&
                            intval($schedule['full_marks']) > 0 &&
                            intval($schedule['passing_marks']) > 0 &&
                            intval($schedule['full_marks']) <= 100 &&
                            intval($schedule['passing_marks']) < 100 &&
                            intval($schedule['full_marks']) > intval($schedule['passing_marks'])
                        ) {
                            $examScheduleAlready = ExamScheduleModel::where('class_id', '=', $request->class_id)
                                ->where('exam_id', '=', $request->exam_id)
                                ->where('subject_id', '=', $schedule['subject_id'])
                                ->first();
                            if (!empty($examScheduleAlready)) {
                                // Nếu đã tồn tại, cập nhật thông tin
                                $examScheduleAlready->exam_date = $schedule['exam_date'];
                                $examScheduleAlready->start_time = $schedule['start_time'];
                                $examScheduleAlready->end_time = $schedule['end_time'];
                                $examScheduleAlready->room_number = $schedule['room_number'];
                                $examScheduleAlready->full_marks = $schedule['full_marks'];
                                $examScheduleAlready->passing_marks = $schedule['passing_marks'];
                                $examScheduleAlready->created_by = Auth::user()->id;
                                $examScheduleAlready->save();
                            } else {
                                // Neu chua ton tai them moi
                                $exam = new ExamScheduleModel;
                                $exam->exam_id = $request->exam_id;
                                $exam->class_id = $request->class_id;
                                $exam->subject_id = $schedule['subject_id'];
                                $exam->exam_date = $schedule['exam_date'];
                                $exam->start_time = $schedule['start_time'];
                                $exam->end_time = $schedule['end_time'];
                                $exam->room_number = $schedule['room_number'];
                                $exam->full_marks = $schedule['full_marks'];
                                $exam->passing_marks = $schedule['passing_marks'];
                                $exam->created_by = Auth::user()->id;

                                $exam->save();
                            }
                        } else {
                            $error['0'] = 'Error Enter Marks ';
                            continue;
                        }

                    } else {
                        $error['1'] = 'Start time is greater than end time';
                        continue;
                    }
                } else {
                    $error['3'] = " Error enter exam date: There is a year smaller than the current year ";
                    continue;
                }
                // dd('Nhập đủ');

            } else if (
                empty($schedule['exam_date']) && empty($schedule['start_time']) && empty($schedule['end_time']) &&
                empty($schedule['room_number']) && empty($schedule['full_marks']) &&
                empty($schedule['passing_marks'])
            ) {
                $checkExamSchedule = ExamScheduleModel::getRecordSingle($request->exam_id, $request->class_id, $schedule['subject_id']);
                if (!empty($checkExamSchedule)) {
                    ExamScheduleModel::getDeleteRecord($request->exam_id, $request->class_id, $schedule['subject_id']);
                }
                continue;
            } else //Thông báo lỗi như nào
            {
                $error['2'] = 'Error Enter missing data';
                continue;
            }
        }
        if (!empty($error)) {
            if (!empty($error['2'])) {
                return redirect()->back()->with('error_2', $error['2']);
            } else if (!empty($error["3"])) {
                return redirect()->back()->with("error_4", $error["3"]);
            } else if (!empty($error["1"])) {
                return redirect()->back()->with("error_1", $error["1"]);

            } else {
                return redirect()->back()->with("error_3", $error["0"]);
            }
        } else {
            return redirect()->back()->with('success', "Exam Schedule successfully Saved");
        }
    }

    // ---------------------------------------------------------------------------------//
    // Admin Exam Grade

    public function marks_grade()
    {
        $data['header_title'] = "Marks Grade";
        $data['getRecord'] = MarksGradeModel::getRecord();

        if (session('error')) {
            Toastr::error('No Information Found  ', 'Error');
        } else if (session('updated')) {
            Toastr::success('Marks Grade updated successfully', 'Message');
        } else if (session('deleted')) {
            Toastr::warning('Marks Grade delete successfully ', 'Warning');
        } else {
            if (MarksGradeModel::getRecord()->count() > 0) {
                Toastr::info(' Search successful. Here are the results.', 'Message');
            } else {
                Toastr::error('Search failed. Check the entered information again.', 'Error');
            }
        }
        return view('admin.examinations.marks_grade.list', $data);
    }


    public function marks_grade_add()
    {
        $data['header_title'] = "Add New Marks Grade";
        Toastr::info('Please complete all information.', 'Message');
        if (session('success')) {
            Toastr::success('Marks Grade created successfully ', 'Message');
        }

        return view('admin.examinations.marks_grade.add', $data);
    }

    public function marks_grade_insert(MarksGradeRequest $request)
    {
        $mark = new MarksGradeModel;
        $mark->name = trim($request->name);
        $mark->percent_to = trim($request->percent_to);
        $mark->percent_from = trim($request->percent_from);
        $mark->created_by = Auth::user()->id;
        $mark->save();

        return redirect('admin/examinations/marks_grade/add')->with('success', 'Marks grade created successfully');
    }

    public function marks_grade_edit($id)
    {
        $data['getRecord'] = MarksGradeModel::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['header_title'] = 'Edit Marks Grade';
            Toastr::info('Please fully update the information.', 'Message');

            return view('admin.examinations.marks_grade.edit', $data);
        } else {
            return redirect('admin/examinations/marks_grade')->with('error', 'Not Found');
        }
    }

    public function marks_grade_update(MarksGradeRequest $request, $id)
    {
        $marks_grade = MarksGradeModel::getSingle($id);
        $marks_grade->name = trim($request->name);
        $marks_grade->percent_from = trim($request->percent_from);
        $marks_grade->percent_to = trim($request->percent_to);
        $marks_grade->created_by = Auth::user()->id;

        $marks_grade->save();
        return redirect('admin/examinations/marks_grade')->with('updated', 'Marks Grade update successfully');
    }

    public function marks_grade_delete($id)
    {
        $marks_grade = MarksGradeModel::getSingle($id);
        if ($marks_grade != null) {
            $marks_grade->delete();
            return redirect('admin/examinations/marks_grade')->with('updated', 'Marks Grade deleted successfully');
        } else {
            return redirect('admin/examinations/marks_grade')->with('error', 'Not Found');
        }
    }

    // student side work

    public function MyExamTimetable(Request $request) // Student exam by class_id
    {
        $data['header_title'] = "My Exam Timetable";
        $class_id = Auth::user()->class_id;
        $getExam = ExamScheduleModel::getExamByClass($class_id);

        $data['getExam'] = $getExam;
        if ($getExam->count() == 0) {
            Toastr::error('Your class does not have any exams yet.', 'Error');
        } else if (!empty($request->exam_id)) {
            $getExamName = ExamScheduleModel::getExamName($request->exam_id, $class_id);
            if (!empty($getExamName)) {
                $data['getExamName'] = $getExamName;
                $getRecord = ExamScheduleModel::getExamSingleTimetable($request->exam_id, $class_id);
                $data['getRecord'] = $getRecord;
                Toastr::info('Search successful. Here are the results.', 'Message');

            } else {
                Toastr::error('Search failed. Check the entered information again.', 'Error');
            }
        } else {
            Toastr::info('Please enter a exam to search.', 'Message');
        }

        return view('student.my_exam_timetable', $data);
    }

    public function myExamResult(Request $request)
    {
        $data['header_title'] = "My Exam Result";
        $student_id = Auth::user()->id;
        $getExam = MarksRegisterModel::getExam(Auth::user()->id);
        $data['getExam'] = $getExam;
        if ($getExam->count() == 0) {
            Toastr::error('Your class does not have any exams yet.', 'Error');
        } else if (!empty($request->exam_id)) {
            $getExamName = MarksRegisterModel::getExamName($request->exam_id, $student_id);
            if (!empty($getExamName)) {
                $data['getExamName'] = $getExamName;
                $result = array();
                $getExamSubject = MarksRegisterModel::getExamSubject($request->exam_id, Auth::user()->id);
                if ($getExamSubject->count() > 0) {
                    foreach ($getExamSubject as $exam) {
                        $total_score = $exam['class_work'] + $exam['test_work'] + $exam['home_work'] + $exam['exam'];

                        $dataS = array();
                        $dataS['subject_name'] = $exam['subject_name'];
                        $dataS['class_work'] = $exam['class_work'];
                        $dataS['test_work'] = $exam['test_work'];
                        $dataS['home_work'] = $exam['home_work'];
                        $dataS['exam'] = $exam['exam'];
                        $dataS['total_score'] = $total_score;
                        $dataS['full_marks'] = $exam['full_marks'];
                        $dataS['passing_marks'] = $exam['passing_marks'];
                        $dataSubject[] = $dataS;
                    }
                    $dataE['subject'] = $dataSubject;
                    $result[] = $dataE;
                    //  dd($result);
                    $data['getRecord'] = $result;
                    Toastr::info('Search successful. Here are the results.', 'Message');
                } else {
                    Toastr::error('Search failed. Check the entered information again.', 'Error');
                }
            } else {
                Toastr::error('Search failed. Check the entered information again.', 'Error');
            }
        } else {
            Toastr::info('Please enter a exam to search.', 'Message');
        }

        return view('student.my_exam_result', $data);
    }

    public function myExamResultPrint(Request $request)
    {
        $exam_id = $request->exam_id;
        $student_id = $request->student_id;

        $data['getSetting'] = SettingModel::getSingle();

        $getExam = ExamModel::getSingle($exam_id);
        $getStudent = User::getSingle($student_id);

        if (!empty($getExam) && !empty($getStudent)) {
            $data['getExam'] = ExamModel::getSingle($exam_id);
            $data['getStudent'] = User::getSingle($student_id);

            $getClass = MarksRegisterModel::getClass($exam_id, $student_id);
            $getExamSubject = MarksRegisterModel::getExamSubject($exam_id, $student_id);
            if (!empty($getClass) && !empty($getExamSubject)) {
                $data['getClass'] = $getClass;

                $dataSubject = array();
                foreach ($getExamSubject as $exam) {
                    $total_score = $exam['class_work'] + $exam['test_work'] + $exam['home_work'] + $exam['exam'];

                    $dataS = array();
                    $dataS['subject_name'] = $exam['subject_name'];
                    $dataS['class_work'] = $exam['class_work'];
                    $dataS['test_work'] = $exam['test_work'];
                    $dataS['home_work'] = $exam['home_work'];
                    $dataS['exam'] = $exam['exam'];
                    $dataS['total_score'] = $total_score;
                    $dataS['full_marks'] = $exam['full_marks'];
                    $dataS['passing_marks'] = $exam['passing_marks'];
                    $dataSubject[] = $dataS;
                }
                $data['getExamMark'] = $dataSubject;
                return view('exam_result_print', $data);
            } else {
                // return redirect('teacher/marks_register')->with('error_exam_result_1', 'No scores have been entered for this student');
                return redirect()->back()->with('error_exam_result_1', 'No scores have been entered for this student');
            }
        } else {
            // return redirect('teacher/marks_register')->with('error_exam_result_2', 'No found exam result for student in exam');
            return redirect()->back()->with('error_exam_result_2', 'No found exam result for student in exam');
        }
    }
    // teacher side work
    public function MyExamTimetableTeacher(Request $request)
    {
        $result = array();
        $data['header_title'] = "My Exam Timetable";

        $getExam = ExamScheduleModel::getExamTeacher(Auth::user()->id);

        if ($getExam->count() == 0) {
            Toastr::warning('You do not have any exam yet.', 'Message');
            return view('teacher.my_exam_timetable', $data);
        }
        $data['getExam'] = $getExam;

        // Lấy ra các lớp học mà giáo viên hiện đang giảng dạy
        $getClass = AssignClassTeacherModel::getMyClassSubjectGroup(Auth::user()->id);

        if ($getClass->count() === 0) {
            Toastr::warning('You do not have any classes yet.', 'Message');
            return view('teacher.my_exam_timetable', $data);
        }

        $data['getClass'] = $getClass;


        if (empty($request->class_id) && empty($request->exam_id)) {
            Toastr::info('Please enter complete search information.', 'Message');
            return view('teacher.my_exam_timetable', $data);
        }

        $checkClass = AssignClassTeacherModel::getAlreadyFirst($request->class_id, Auth::user()->id);

        if (empty($checkClass)) {
            Toastr::error('You do not have this class.', 'Message');
            return view('teacher.my_exam_timetable', $data);
        }

        $data['class_name'] = ClassModel::getSingle($request->class_id)->name;
        $data['exam_name'] = ExamModel::getSingle($request->exam_id)->name;

        $getRecord = ExamScheduleModel::getRecordExamClass($request->exam_id, $request->class_id);
        if ($getRecord->count() === 0) {
            Toastr::error('This class does not have this test.', 'Message');
            return view('teacher.my_exam_timetable', $data);
        }

        $data['getRecord'] = $getRecord;
        Toastr::info('Search successful. Here are the results.', 'Message');
        return view('teacher.my_exam_timetable', $data);
    }

    // parent side work
    public function ParentMyExamTimetable(Request $request, $student_id)
    {
        $data['header_title'] = "Exam Timetable";
        $data['student_id'] = $student_id;
        $getStudent = User::getSingle($student_id);
        if (empty($student) || $student_id != 3) {
            Toastr::error('No results were found.', 'Message');
        } else {
            $data['getStudent'] = $getStudent;
            $class_id = $getStudent->class_id;
            $getExam = ExamScheduleModel::getExamByClass($class_id);

            $data['getExam'] = $getExam;
            if ($getExam->count() == 0) {
                Toastr::error('Your class does not have any exams yet.', 'Error');
            } else if (!empty($request->exam_id)) {
                $getExamName = ExamScheduleModel::getExamName($request->exam_id, $class_id);
                if (!empty($getExamName)) {
                    $data['getExamName'] = $getExamName;
                    $getRecord = ExamScheduleModel::getExamSingleTimetable($request->exam_id, $class_id);
                    $data['getRecord'] = $getRecord;
                    // dd($getRecord);
                    Toastr::info('Search successful. Here are the results.', 'Message');

                } else {
                    Toastr::error('Search failed. Check the entered information again.', 'Error');
                }
            } else {
                Toastr::info('Please enter a exam to search.', 'Message');
            }
        }


        return view('parent.my_exam_timetable', $data);
    }

    public function ParentMyExamResult(Request $request, $student_id)
    {
        $data['header_title'] = "My Student Exam Result";
        $data['getStudent'] = User::getSingle($student_id);
        $data['student_id'] = $student_id;

        $getExam = MarksRegisterModel::getExam($student_id);
        $data['getExam'] = $getExam;
        if ($getExam->count() == 0) {
            Toastr::error('Your class does not have any exams yet.', 'Error');
        } else if (!empty($request->exam_id)) {
            $getExamName = MarksRegisterModel::getExamName($request->exam_id, $student_id);
            if (!empty($getExamName)) {
                $data['getExamName'] = $getExamName;
                $result = array();
                $getExamSubject = MarksRegisterModel::getExamSubject($request->exam_id, $student_id);
                if ($getExamSubject->count() > 0) {
                    foreach ($getExamSubject as $exam) {
                        $total_score = $exam['class_work'] + $exam['test_work'] + $exam['home_work'] + $exam['exam'];
                        $dataS = array();
                        $dataS['subject_name'] = $exam['subject_name'];
                        $dataS['class_work'] = $exam['class_work'];
                        $dataS['test_work'] = $exam['test_work'];
                        $dataS['home_work'] = $exam['home_work'];
                        $dataS['exam'] = $exam['exam'];
                        $dataS['total_score'] = $total_score;
                        $dataS['full_marks'] = $exam['full_marks'];
                        $dataS['passing_marks'] = $exam['passing_marks'];
                        $dataSubject[] = $dataS;
                    }
                    $dataE['subject'] = $dataSubject;
                    $result[] = $dataE;
                    $data['getRecord'] = $result;
                    Toastr::info('Search successful. Here are the results.', 'Message');
                } else {
                    Toastr::error('Search failed. Check the entered information again.', 'Error');
                }
            } else {
                Toastr::error('Search failed. Check the entered information again.', 'Error');
            }
        } else {
            Toastr::info('Please enter a exam to search.', 'Message');
        }
        return view('parent.my_exam_result', $data);
    }

    // Admin Teacher Marks
    public function marks_register(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getExam'] = ExamModel::getExam();

        if (!empty($request->all())) {
            if (session('error_exam_result_1')) {
                Toastr::error('No scores have been entered for this student', 'Error');
            } else if (session('error_exam_result_2')) {
                Toastr::error('No found exam result for student in exam', 'Error');
            }
            if (!empty($request->get('exam_id')) && !empty($request->get('class_id'))) {
                $getSubject = ExamScheduleModel::getSubject($request->get('exam_id'), $request->get('class_id'));
                $getStudent = User::getStudentClass($request->get('class_id'));

                if ($getSubject->count() > 0 && $getStudent->count() > 0) {
                    $data['getSubject'] = $getSubject;
                    $data['getStudent'] = $getStudent;
                    Toastr::info(' Search successful. Here are the results.', 'Message');
                } else {
                    Toastr::error('This class has no such test.', 'Error');
                }
            }
        } else {
            Toastr::info('Please enter complete search information', 'Message');
        }

        $data['header_title'] = "Marks Register";
        return view('admin.examinations.marks_register', $data);
    }

    public function submit_marks_register(Request $request)
    {
        $error = array();
        if (!empty($request->mark)) {

            foreach ($request->mark as $mark) {
                $getExamSchedule = ExamScheduleModel::getSingle($mark['id']);
                // dd($mark,$getExamSchedule);

                $full_marks = $getExamSchedule->full_marks;

                $class_work = !empty($mark['class_work']) ? $mark['class_work'] : 0;
                $home_work = !empty($mark['home_work']) ? $mark['home_work'] : 0;
                $test_work = !empty($mark['test_work']) ? $mark['test_work'] : 0;
                $exam = !empty($mark['exam']) ? $mark['exam'] : 0;

                // $exam = !empty($mark['full_marks']) ? $mark['full_marks'] : 0;
                // $exam = !empty($mark['passing_marks']) ? $mark['passing_marks'] : 0;

                $total_mark = $class_work + $home_work + $test_work + $exam;
                if ($full_marks > $total_mark) {
                    if (
                        is_numeric($class_work) && is_numeric($home_work) && is_numeric($test_work) && is_numeric($exam) &&
                        intval($class_work) >= 0 && intval($home_work) >= 0 && intval($test_work) >= 0 && intval($exam) >= 0 &&
                        intval($class_work) <= 100 && intval($home_work) <= 100 && intval($test_work) <= 100 && intval($exam) <= 100
                    ) {
                        $getMark = MarksRegisterModel::CheckAlreadyMark($request->student_id, $request->exam_id, $request->class_id, $mark['subject_id']);
                        if (!empty($getMark)) {
                            $save = $getMark;
                        } else {
                            $save = new MarksRegisterModel;
                            $save->student_id = $request->student_id;
                            $save->exam_id = $request->exam_id;
                            $save->class_id = $request->class_id;
                            $save->subject_id = $mark['subject_id'];
                            $save->created_by = Auth::user()->id;
                        }
                        $save->class_work = $class_work;
                        $save->home_work = $home_work;
                        $save->test_work = $test_work;
                        $save->exam = $exam;

                        $save->full_marks = $full_marks;
                        $save->passing_marks = $getExamSchedule->passing_marks;
                        $save->save();
                    } else {
                        $error[0] = 'Error Enter';
                        continue;
                    }
                } else {
                    $error[1] = "Mark Register successfully saved. Some Subject mark greater than full mark";
                }
            }
        }
        if (!empty($error[0])) {
            $json['message'] = $error[0];
            echo json_encode($json);
        } else if (!empty($error[1])) {
            $json['message'] = $error[1];
            echo json_encode($json);
        } else {
            $json['message'] = "Mark Register Single Subject successfully saved";
            echo json_encode($json);
        }
    }

    public function single_submit_marks_register(Request $request)
    {
        $error = array();
        $id = $request->id;
        $getExamSchedule = ExamScheduleModel::getSingle($id);

        $full_marks = $getExamSchedule->full_marks;

        $class_work = !empty($request->class_work) ? $request->class_work : 0;
        $home_work = !empty($request->home_work) ? $request->home_work : 0;
        $test_work = !empty($request->test_work) ? $request->test_work : 0;
        $exam = !empty($request->exam) ? $request->exam : 0;

        $total_mark = $class_work + $home_work + $test_work + $exam;
        if ($full_marks > $total_mark) {
            if (
                is_numeric($class_work) && is_numeric($home_work) && is_numeric($test_work) && is_numeric($exam) &&
                intval($class_work) >= 0 && intval($home_work) >= 0 && intval($test_work) >= 0 && intval($exam) >= 0 &&
                intval($class_work) <= 100 && intval($home_work) <= 100 && intval($test_work) <= 100 && intval($exam) <= 100
            ) {
                $getMark = MarksRegisterModel::CheckAlreadyMark($request->student_id, $request->exam_id, $request->class_id, $request->subject_id);
                if (!empty($getMark)) {
                    $save = $getMark;
                } else {
                    $save = new MarksRegisterModel;
                    $save->student_id = $request->student_id;
                    $save->exam_id = $request->exam_id;
                    $save->class_id = $request->class_id;
                    $save->subject_id = $request->subject_id;
                    $save->created_by = Auth::user()->id;

                }
                $save->class_work = $class_work;
                $save->home_work = $home_work;
                $save->test_work = $test_work;
                $save->exam = $exam;

                $save->full_marks = $full_marks;
                $save->passing_marks = $getExamSchedule->passing_marks;
                $save->save();
            } else {
                $error[0] = "Error Enter ";
            }
        } else {
            $error[1] = "Your total mark greater than full mark";
        }


        if (!empty($error[0])) {
            $json['message'] = $error[0];
            echo json_encode($json);
        } else if (!empty($error[1])) {
            $json['message'] = $error[1];
            echo json_encode($json);
        } else {
            $json['message'] = "Mark Register Single Subject successfully saved";
            echo json_encode($json);
        }
    }

    // Teacher Marks
    public function marks_register_teacher(Request $request)
    {
        $data['header_title'] = "Marks Register";
        // Lấy ra tất cả các lớp của giáo viên này
        $getClass = AssignClassTeacherModel::getMyClassSubjectGroup(Auth::user()->id);

        if ($getClass->count() === 0) {
            Toastr::warning('You do not have any classes yet.', 'Message');
            return view('teacher.my_exam_timetable', $data);
        }

        $data['getClass'] = $getClass;
        $getExam = ExamScheduleModel::getExamTeacher(Auth::user()->id);
        if ($getExam->count() == 0) {
            Toastr::warning('You do not have any exam yet.', 'Message');
            return view('teacher.my_exam_timetable', $data);
        }

        $data['getExam'] = $getExam;


        if (empty($request->class_id) && empty($request->exam_id)) {
            Toastr::info('Please enter complete search information.', 'Message');
            return view('teacher.my_exam_timetable', $data);
        }


        $checkClass = AssignClassTeacherModel::getAlreadyFirst($request->class_id, Auth::user()->id);

        if (empty($checkClass)) {
            Toastr::error('You do not have this class.', 'Message');
            return view('teacher.my_exam_timetable', $data);
        }

        $getSubject = ExamScheduleModel::getSubject($request->get('exam_id'), $request->get('class_id'));
        $getStudent = User::getStudentClass($request->get('class_id'));
        if (session('error_exam_result_1')) {
            Toastr::error('No scores have been entered for this student', 'Error');
        } else if (session('error_exam_result_2')) {
            Toastr::error('No found exam result for student in exam', 'Error');
        }

        if ($getSubject->count() > 0 && $getStudent->count() > 0) {
            $data['getSubject'] = $getSubject;
            $data['getStudent'] = $getStudent;
            Toastr::info(' Search successful. Here are the results.', 'Message');
        } else {
            Toastr::error('This class has no such test.', 'Error');
        }

        return view('teacher.marks_register', $data);
    }
}
