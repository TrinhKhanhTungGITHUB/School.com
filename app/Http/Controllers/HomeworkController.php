<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomeworkRequest;
use App\Http\Requests\SubmitHomeworkRequest;
use App\Models\AssignClassTeacherModel;
use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\HomeworkModel;
use App\Models\HomeworkSubmitModel;
use App\Models\User;
use Auth;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeworkController extends Controller
{
    // Admin side work

    public function HomeworkReport(Request $request)
    {
        $data['getRecord'] = HomeworkSubmitModel::getHomeworkReport();
        $data['getClass'] = ClassModel::getClass();

        if (!empty($request->class_id)) {
            $data['getSubject'] = ClassSubjectModel::MySubject($request->class_id);
        }
        $data['header_title'] = 'Homework Report';

        if (session('error')) {
            Toastr::error('No Information Found  ', 'Error');
        } else if (session('success')) {
            Toastr::success('Homework created successfully  ', 'Message');
        } else if (session('updated')) {
            Toastr::success('Homework updated successfully', 'Message');
        } else if (session('deleted')) {
            Toastr::warning('Homework delete successfully ', 'Warning');
        } else {
            if (HomeworkSubmitModel::getHomeworkReport()->count() > 0) {
                Toastr::info(' Search successful. Here are the results.', 'Message');
            } else {
                Toastr::error('Search failed. Check the entered information again.', 'Error');
            }
        }
        return view('admin.homework.report', $data);
    }
    public function Homework(Request $request)
    {
        $data['getRecord'] = HomeworkModel::getRecord();
        $data['getClass'] = ClassModel::getClass();

        if (!empty($request->class_id)) {
            $data['getSubject'] = ClassSubjectModel::MySubject($request->class_id);
        }
        $data['header_title'] = 'Homework';

        if (session('error')) {
            Toastr::error('No Information Found  ', 'Error');
        } else if (session('success')) {
            Toastr::success('Homework created successfully  ', 'Message');
        } else if (session('updated')) {
            Toastr::success('Homework updated successfully', 'Message');
        } else if (session('deleted')) {
            Toastr::warning('Homework delete successfully ', 'Warning');
        } else {
            if (HomeworkModel::getRecord()->count() > 0) {
                Toastr::info(' Search successful. Here are the results.', 'Message');
            } else {
                Toastr::error('Search failed. Check the entered information again.', 'Error');
            }
        }
        return view('admin.homework.list', $data);
    }

    public function HomeworkAdd(Request $request)
    {
        $data['header_title'] = 'Homework Add';
        $data['getClass'] = ClassModel::getClass();

        if (!empty($request->class_id)) {
            $data['getSubject'] = ClassSubjectModel::MySubject($request->class_id);
        }

        return view('admin.homework.add', $data);
    }

    public function HomeworkInsert(HomeworkRequest $request)
    {
        $homework = new HomeworkModel;
        $homework->class_id = trim($request->class_id);
        $homework->subject_id = trim($request->subject_id);
        $homework->homework_date = trim($request->homework_date);
        $homework->submission_date = trim($request->submission_date);
        $homework->description = trim($request->description);
        $homework->created_by = Auth::user()->id;

        if (!empty($request->file('document_file'))) {
            $ext = $request->file('document_file')->getClientOriginalExtension();
            $file = $request->file('document_file');
            $timestamp = now()->format('YmdHis'); // Lấy ngày giờ hiện tại dưới dạng YmdHis (năm tháng ngày giờ phút giây)
            $randomStr = Str::random(3); // Tạo chuỗi ngẫu nhiên gồm 3 ký tự
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = strtolower($originalName . $timestamp . $randomStr . '.' . $ext);
            $file->move('upload/homework/', $filename);

            $homework->document_file = $filename;
        }
        $homework->save();

        return redirect('admin/homework/homework')->with('success', 'Homework successfully');
    }

    public function HomeworkEdit(Request $request, $id)
    {
        $getRecord = HomeworkModel::getSingle($id);
        if (!empty($getRecord)) {
            $data['getRecord'] = $getRecord;
            $data['getSubject'] = ClassSubjectModel::MySubject($getRecord->class_id);
            $data['header_title'] = 'Homework Edit';
            $data['getClass'] = ClassModel::getClass();

            if (!empty($request->class_id)) {
                $data['getSubject'] = ClassSubjectModel::MySubject($request->class_id);
            }
            return view('admin.homework.edit', $data);
        } else {
            return redirect('admin/homework/homework')->with('error', 'Not Found');
        }
    }

    public function HomeworkUpdate(HomeworkRequest $request, $id)
    {
        $homework = HomeworkModel::getSingle($id);

        $homework->class_id = trim($request->class_id);
        $homework->subject_id = trim($request->subject_id);
        $homework->homework_date = trim($request->homework_date);
        $homework->submission_date = trim($request->submission_date);
        $homework->description = trim($request->description);
        $homework->created_by = Auth::user()->id;

        if (!empty($request->file('document_file'))) {
            $ext = $request->file('document_file')->getClientOriginalExtension();
            $file = $request->file('document_file');
            $timestamp = now()->format('YmdHis'); // Lấy ngày giờ hiện tại dưới dạng YmdHis (năm tháng ngày giờ phút giây)
            $randomStr = Str::random(3); // Tạo chuỗi ngẫu nhiên gồm 3 ký tự
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = strtolower($originalName . $timestamp . $randomStr . '.' . $ext);
            $file->move('upload/homework/', $filename);

            $homework->document_file = $filename;
        }
        $homework->save();

        return redirect('admin/homework/homework')->with('updated', 'Homework successfully');
    }

    public function HomeworkDelete($id)
    {
        $homework = HomeworkModel::getSingle($id);
        if ($homework != null) {
            $homework->is_delete = 1;
            $homework->save();
            return redirect('admin/homework/homework')->with('deleted', 'Delete successfully');
        } else {
            return redirect('admin/homework/homework')->with('error', 'Not Found');
        }
    }

    public function HomeworkRestore($id)
    {
        $homework = HomeworkModel::getSingle($id);
        if (!empty($homework) && $homework->is_delete == 1) {
            $homework->is_delete = 0;
            $homework->save();
            return redirect('admin/homework/homework/trash_bin')->with('restore', 'Restore Homework successfully');
        } else {
            return redirect('admin//homework/homework/trash_bin')->with('error', 'Not Found');
        }
    }

    public function HomeworkTrashBin(Request $request)
    {
        $data['getRecord'] = HomeworkModel::getRecord(1);
        $data['getClass'] = ClassModel::getClass();

        if (!empty($request->class_id)) {
            $data['getSubject'] = ClassSubjectModel::MySubject($request->class_id);
        }
        $data['header_title'] = 'Homework Trash Bin';

        if (session('error')) {
            Toastr::error('No Information Found  ', 'Error');
        } else if (session('restore')) {
            Toastr::success('Restore Homework successfully', 'Message');
        } else {
            if (HomeworkModel::getRecord(1)->count() > 0) {
                Toastr::info(' Search successful. Here are the results.', 'Message');
            } else {
                Toastr::error('Search failed. Check the entered information again.', 'Error');
            }
        }

        return view('admin.homework.list', $data);
    }

    public function HomeworkSubmitted($homework_id)
    {
        $homework = HomeworkModel::getSingle($homework_id);
        if (!empty($homework)) {
            $data['homework_id'] = $homework_id;
            $data['getRecord'] = HomeworkSubmitModel::getRecord($homework_id);
            $data['header_title'] = 'Submitted Homework';
            Toastr::info(' Search successful. Here are the results.', 'Message');
            return view('admin.homework.submitted', $data);
        } else {
            return redirect('admin/homework/homework')->with('error', 'Not Found');
        }
    }

    // Teacher side
    public function HomeworkTeacher(Request $request)
    {
        $class_ids = array();
        $getClass = AssignClassTeacherModel::getMyClassSubjectGroup(Auth::user()->id);

        foreach ($getClass as $class) {
            $class_ids[] = $class->class_id;
        }

        $data['getRecord'] = HomeworkModel::getRecordTeacher($class_ids);
        $data['getClass'] = $getClass;

        if (!empty($request->class_id)) {
            $data['getSubject'] = ClassSubjectModel::MySubject($request->class_id);
        }
        $data['header_title'] = 'Homework';

        if (session('error')) {
            Toastr::error('No Information Found  ', 'Error');
        } else if (session('success')) {
            Toastr::success('Homework created successfully  ', 'Message');
        } else if (session('updated')) {
            Toastr::success('Homework updated successfully', 'Message');
        } else if (session('deleted')) {
            Toastr::warning('Homework delete successfully ', 'Warning');
        } else {
            if (HomeworkModel::getRecord()->count() > 0) {
                Toastr::info(' Search successful. Here are the results.', 'Message');
            } else {
                Toastr::error('Search failed. Check the entered information again.', 'Error');
            }
        }
        return view('teacher.homework.list', $data);
    }

    public function HomeworkAddTeacher(Request $request)
    {
        $data['header_title'] = 'Homework Add';
        $data['getClass'] = AssignClassTeacherModel::getMyClassSubjectGroup(Auth::user()->id);

        if (!empty($request->class_id)) {
            $data['getSubject'] = ClassSubjectModel::MySubject($request->class_id);
        }

        return view('teacher.homework.add', $data);
    }

    public function HomeworkInsertTeacher(HomeworkRequest $request)
    {
        $homework = new HomeworkModel;
        $homework->class_id = trim($request->class_id);
        $homework->subject_id = trim($request->subject_id);
        $homework->homework_date = trim($request->homework_date);
        $homework->submission_date = trim($request->submission_date);
        $homework->description = trim($request->description);
        $homework->created_by = Auth::user()->id;

        if (!empty($request->file('document_file'))) {
            $ext = $request->file('document_file')->getClientOriginalExtension();
            $file = $request->file('document_file');
            $timestamp = now()->format('YmdHis'); // Lấy ngày giờ hiện tại dưới dạng YmdHis (năm tháng ngày giờ phút giây)
            $randomStr = Str::random(3); // Tạo chuỗi ngẫu nhiên gồm 3 ký tự
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = strtolower($originalName . $timestamp . $randomStr . '.' . $ext);
            $file->move('upload/homework/', $filename);

            $homework->document_file = $filename;
        }
        $homework->save();

        return redirect('teacher/homework/homework')->with('success', 'Homework successfully');
    }

    public function HomeworkEditTeacher(Request $request, $id)
    {

        $getRecord = HomeworkModel::getSingle($id);
        if (!empty($getRecord)) {
            $data['getRecord'] = $getRecord;
            $data['getSubject'] = ClassSubjectModel::MySubject($getRecord->class_id);
            $data['getClass'] = AssignClassTeacherModel::getMyClassSubjectGroup(Auth::user()->id);
            $data['header_title'] = 'Homework Edit';
            if (!empty($request->class_id)) {
                $data['getSubject'] = ClassSubjectModel::MySubject($request->class_id);
            }

            return view('teacher.homework.edit', $data);

        } else {
            return redirect('teacher/homework/homework')->with('error', 'Not Found');
        }
    }

    public function HomeworkUpdateTeacher(HomeworkRequest $request, $id)
    {
        $homework = HomeworkModel::getSingle($id);

        $homework->class_id = trim($request->class_id);
        $homework->subject_id = trim($request->subject_id);
        $homework->homework_date = trim($request->homework_date);
        $homework->submission_date = trim($request->submission_date);
        $homework->description = trim($request->description);
        $homework->created_by = Auth::user()->id;

        if (!empty($request->file('document_file'))) {
            $ext = $request->file('document_file')->getClientOriginalExtension();
            $file = $request->file('document_file');
            $timestamp = now()->format('YmdHis'); // Lấy ngày giờ hiện tại dưới dạng YmdHis (năm tháng ngày giờ phút giây)
            $randomStr = Str::random(3); // Tạo chuỗi ngẫu nhiên gồm 3 ký tự
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = strtolower($originalName . $timestamp . $randomStr . '.' . $ext);
            $file->move('upload/homework/', $filename);

            $homework->document_file = $filename;
        }
        $homework->save();

        return redirect('teacher/homework/homework')->with('updated', 'Homework successfully');
    }

    public function HomeworkSubmittedTeacher($homework_id)
    {
        $homework = HomeworkModel::getSingle($homework_id);
        if (!empty($homework)) {
            $data['homework_id'] = $homework_id;
            $data['getRecord'] = HomeworkSubmitModel::getRecord($homework_id);
            $data['header_title'] = 'Submitted Homework';
            Toastr::info(' Search successful. Here are the results.', 'Message');
            return view('teacher.homework.submitted', $data);
        } else {
            return redirect('teacher/homework/homework')->with('error', 'Not Found');
        }
    }

    // student side work
    public function HomeworkStudent()
    {
        $data['getRecord'] = HomeworkModel::getRecordStudent(Auth::user()->class_id, Auth::user()->id);
        $data['getSubject'] = ClassSubjectModel::MySubject(Auth::user()->class_id);
        $data['header_title'] = 'My Homework';

        if (session('success')) {
            Toastr::success('Homework Submit created successfully  ', 'Message');
        } else if (session('error')) {
            Toastr::error('It is too late to turn in homework.', 'Error');
        } else {
            if (HomeworkModel::getRecordStudent(Auth::user()->class_id, Auth::user()->id)->count() > 0) {
                Toastr::info(' Search successful. Here are the results.', 'Message');
            } else {
                Toastr::error('Search failed. Check the entered information again.', 'Error');
            }
        }

        return view('student.homework.list', $data);
    }

    public function SubmitHomework($homework_id)
    {
        $data['getRecord'] = HomeworkModel::getSingle($homework_id);
        $data['header_title'] = 'Submit My Homework';
        return view('student.homework.submit', $data);
    }

    public function SubmitHomeWorkInsert(SubmitHomeworkRequest $request, $homework_id)
    {
        $dateNow = date('Y-m-d', strtotime(Carbon::now()));
        $submission_date = HomeworkModel::getSingle($homework_id)->submission_date;
        if ($dateNow >= $submission_date) {
            return redirect('student/my_homework')->with('error', 'It is too late to turn in homework.');
        }
        $homework = new HomeworkSubmitModel;
        $homework->homework_id = $homework_id;
        $homework->student_id = Auth::user()->id;
        $homework->description = trim($request->description);

        if (!empty($request->file('document_file'))) {
            $ext = $request->file('document_file')->getClientOriginalExtension();
            $file = $request->file('document_file');
            $timestamp = now()->format('YmdHis'); // Lấy ngày giờ hiện tại dưới dạng YmdHis (năm tháng ngày giờ phút giây)
            $randomStr = Str::random(3); // Tạo chuỗi ngẫu nhiên gồm 3 ký tự
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = strtolower($originalName . $timestamp . $randomStr . '.' . $ext);
            $file->move('upload/homework_submit/', $filename);

            $homework->document_file = $filename;
        }

        $homework->save();

        return redirect('student/my_homework')->with('success', 'Homework Submit successfully');
    }

    public function HomeworkSubmittedStudent(Request $request)
    {
        $data['getRecord'] = HomeworkSubmitModel::getRecordStudent(Auth::user()->id);
        $data['getSubject'] = ClassSubjectModel::MySubject(Auth::user()->class_id);
        $data['header_title'] = 'My Homework Submitted';

        if (HomeworkSubmitModel::getRecordStudent(Auth::user()->id)->count() > 0) {
            Toastr::info(' Search successful. Here are the results.', 'Message');
        } else {
            Toastr::error('Search failed. Check the entered information again.', 'Error');
        }
        return view('student.homework.submitted_list', $data);
    }

    // parent side work
    public function HomeworkStudentParent($student_id)
    {
        $data['header_title'] = 'Student Homework';
        $getStudent = User::getSingle($student_id);
        if (!empty($getStudent->class_id) && !empty($getStudent->id)) {
            $data['getRecord'] = HomeworkModel::getRecordStudent($getStudent->class_id, $getStudent->id);
            $data['getSubject'] = ClassSubjectModel::MySubject($getStudent->class_id);
            $data['getStudent'] = $getStudent;
            if (HomeworkModel::getRecordStudent($getStudent->class_id, $getStudent->id)->count() > 0) {
                Toastr::info(' Search successful. Here are the results.', 'Message');
            } else {
                Toastr::error('Search failed. Check the entered information again.', 'Error');
            }
            return view('parent.homework.list', $data);
        } else {
            return redirect('parent/my_student')->with('error', 'Error URL');
        }
    }

    public function SubmittedHomeworkStudentParent($student_id)
    {
        $getStudent = User::getSingle($student_id);
        if (!empty($getStudent->class_id) && !empty($getStudent->id)) {
            $data['getRecord'] = HomeworkSubmitModel::getRecordStudent($getStudent->id);
            $data['getSubject'] = ClassSubjectModel::MySubject($getStudent->class_id);
            $data['header_title'] = 'Student Submitted Homework';
            $data['getStudent'] = $getStudent;
            if (HomeworkSubmitModel::getRecordStudent($getStudent->id)->count() > 0) {
                Toastr::info(' Search successful. Here are the results.', 'Message');
            } else {
                Toastr::error('Search failed. Check the entered information again.', 'Error');
            }
            return view('parent.homework.submitted_list', $data);
        } else {
            return redirect('parent/my_student')->with('error', 'Error URL');
        }
    }
}
