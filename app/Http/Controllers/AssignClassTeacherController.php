<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\AssignClassTeacher\AssignClassTeacherRequest;
use App\Http\Requests\Admin\ClassTeacherListRequest;
use App\Models\AssignClassTeacherModel;
use App\Models\ClassModel;
use App\Models\User;
use Auth;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Models\ClassSubjectModel;

class AssignClassTeacherController extends Controller
{
    public function list(ClassTeacherListRequest $request)
    {
        if (\Request::segment(3) == "list") {
            $data['header_title'] = 'Assign Class Teacher';
            if (session('error')) {
                Toastr::error('You have not chosen a teacher for that class', 'Error');
            } else if (session('error_class')) {
                Toastr::error('You have not selected a class yet', 'Error');
            } else if (session('updated')) {
                Toastr::success('Assign class teacher updated successfully', 'Message');
            } else if (session('deleted')) {
                Toastr::warning('Assign class teacher delete successfully ', 'Warning');
            } else if (session('updated_single_1')) {
                Toastr::success('Status successfully updated ', 'Message');
            } else if (session('updated_single_2')) {
                Toastr::success('Teacher successfully assign to class', 'Message');
            } else {
                if (AssignClassTeacherModel::getRecord(0)->count() > 0) {
                    Toastr::info(' Search successful. Here are the results.', 'Message');
                } else {
                    Toastr::error('Search failed. Check the entered information again.', 'Error');
                }
            }

            if (!empty($request->paginate)) {
                $getRecord = AssignClassTeacherModel::getRecord(0)->orderBy('assign_class_teacher.id', 'desc')->paginate($request->paginate);
            } else {
                $getRecord = AssignClassTeacherModel::getRecord(0)->orderBy('assign_class_teacher.id', 'desc')->paginate(10);
            }

            $data['getRecord'] = $getRecord;
            return view('admin.assign_class_teacher.list', $data);
        } else if (\Request::segment(3) == "trash_bin") {

            $data['header_title'] = 'Assign Class Teacher Trash Bin';
            if (session('error')) {
                Toastr::error('No Information Found  ', 'Error');
            } else if (session('restore')) {
                Toastr::success('Restore Assign Class Teacher successfully', 'Message');
            } else if (session('deleted')) {
                Toastr::warning('Assign Class Teacher delete successfully ', 'Warning');
            } else {
                if (AssignClassTeacherModel::getRecord(1)->count() > 0) {
                    Toastr::info('Search successful. Here are the results.', 'Message');
                } else {
                    Toastr::error('Search failed. Trash Bin empty.', 'Error');
                }
            }

            if (!empty($request->paginate)) {
                $getRecord = AssignClassTeacherModel::getRecord(1)->orderBy('assign_class_teacher.id', 'desc')->paginate($request->paginate);
            } else {
                $getRecord = AssignClassTeacherModel::getRecord(1)->orderBy('assign_class_teacher.id', 'desc')->paginate(10);
            }

            $data['getRecord'] = $getRecord;

            return view('admin.assign_class_teacher.list', $data);
        }

    }

    public function add()
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getTeacher'] = User::getTeacherClass();

        $data['header_title'] = 'Add Assign Class Teacher';
        Toastr::info('Please complete all information.', 'Message');
        if (session('success')) {
            Toastr::success('Assign class teacher created successfully ', 'Message');
        } else if (session('success_update')) {
            Toastr::success('Assign class teacher update status successfully ', 'Message');
        }

        return view('admin.assign_class_teacher.add', $data);
    }

    public function insert(AssignClassTeacherRequest $request)
    {
        if (!empty($request->class_id)) {
            if (!empty($request->teacher_id)) {
                $check = 0;
                foreach ($request->teacher_id as $teacher_id) { // Kiểm tra trong 1 lớp có nhiều giáo viên. Nếu lớp đó đã tồn tại giáo viên đó thì chỉ cập nhật trạng thái giáo viên đó của lớp đó.
                    $getAlreadyFirst = AssignClassTeacherModel::getAlreadyFirst($request->class_id, $teacher_id);
                    if (!empty($getAlreadyFirst)) {
                        $check = 1;
                        $getAlreadyFirst->status = $request->status;
                        $getAlreadyFirst->save();
                    } else // Nếu không có thì tạo mới giáo viên và lớp học
                    {
                        $classSubject = new AssignClassTeacherModel;
                        $classSubject->class_id = $request->class_id;
                        $classSubject->teacher_id = $teacher_id;
                        $classSubject->status = $request->status;
                        $classSubject->created_by = Auth::user()->id;

                        $classSubject->save();
                    }
                }

                if ($check == 0) {
                    return redirect('admin/assign_class_teacher/add')->with('success', 'Assign class to teacher created successfully');
                } else {
                    return redirect('admin/assign_class_teacher/add')->with('success_update', 'Assign class to teacher created successfully');
                }
            } else {
                return redirect()->back()->with('error', 'You have not selected a teacher yet');
            }
        } else {
            return redirect()->back()->with('error_class', 'You have not selected a class yet');
        }
    }

    public function edit($id)
    {
        $data['getRecord'] = AssignClassTeacherModel::getSingle($id);

        if (!empty($data['getRecord'])) {
            $data['getAssignTeacherID'] = AssignClassTeacherModel::getAssignTeacherID($data['getRecord']->class_id);
            $data['getClass'] = ClassModel::getClass();
            $data['getTeacher'] = User::getTeacherClass();
            $data['header_title'] = 'Edit Assign Class Teacher';

            Toastr::info('Please fully update all assign class teacher the information.', 'Message');

            return view('admin.assign_class_teacher.edit', $data);
        } else {
            return redirect('admin/assign_class_teacher/list')->with('error', 'Not Found');
        }
    }

    public function update(AssignClassTeacherRequest $request, $id)
    {
        AssignClassTeacherModel::deleteTeacher($request->class_id);
        if (!empty($request->teacher_id)) {
            $check = 0;
            foreach ($request->teacher_id as $teacher_id) { // Kiểm tra trong 1 lớp có nhiều giáo viên. Nếu lớp đó đã tồn tại giáo viên đó thì chỉ cập nhật trạng thái giáo viên đó của lớp đó.
                $getAlreadyFirst = AssignClassTeacherModel::getAlreadyFirst($request->class_id, $teacher_id);
                if (!empty($getAlreadyFirst)) {
                    $check = 1;
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->save();
                } else // Nếu không có thì tạo mới giáo viên và lớp học
                {
                    $classTeacher = new AssignClassTeacherModel;
                    $classTeacher->class_id = $request->class_id;
                    $classTeacher->teacher_id = $teacher_id;
                    $classTeacher->status = $request->status;
                    $classTeacher->created_by = Auth::user()->id;

                    $classTeacher->save();
                }
            }
            if ($check == 0) {
                return redirect('admin/assign_class_teacher/add')->with('success', 'Assign class to teacher updated successfully');
            } else {
                return redirect('admin/assign_class_teacher/add')->with('success_update', 'Assign class to teacher updated successfully');
            }
        } else {
            return redirect()->back()->with('error', 'Not Found');
        }
    }

    public function edit_single($id)
    {
        $data['getRecord'] = AssignClassTeacherModel::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['getClass'] = ClassModel::getClass();
            $data['getTeacher'] = User::getTeacherClass();
            $data['header_title'] = 'Edit Assign Class Teacher Single';

            Toastr::info('Please fully update assign subject the information.', 'Message');

            return view('admin.assign_class_teacher.edit_single', $data);
        } else {
            return redirect('admin/assign_subject/list')->with('error', 'Not Found');
        }
    }

    public function update_single(AssignClassTeacherRequest $request, $id)
    {
        $getAlreadyFirst = AssignClassTeacherModel::getAlreadyFirst($request->class_id, $request->teacher_id);
        if (!empty($getAlreadyFirst)) {
            $getAlreadyFirst->status = $request->status;
            $getAlreadyFirst->save();

            return redirect('admin/assign_class_teacher/list')->with('updated_single_1', 'Status update successfully');
        } else // Nếu không có thì tạo mới lớp học và giáo viên
        {
            $classTeacher = AssignClassTeacherModel::getSingle($id);
            $classTeacher->class_id = $request->class_id;
            $classTeacher->teacher_id = $request->teacher_id;
            $classTeacher->status = $request->status;
            $classTeacher->save();

            return redirect('admin/assign_class_teacher/list')->with('updated_single_2', 'Teacher successfully assign to class');
        }
    }


    public function delete($id)
    {
        $class = AssignClassTeacherModel::getSingle($id);
        if ($class != null) {
            $class->is_delete = 1;
            $class->save();
            return redirect('admin/assign_class_teacher/list')->with('deleted', 'Assign Class teacher Delete successfully');
        } else {
            return redirect('admin/assign_class_teacher/list')->with('error', 'Not Found');
        }
    }

    public function restore($id)
    {
        $class = AssignClassTeacherModel::getSingle($id);
        if (!empty($class) && $class->is_delete == 1) {
            $class->is_delete = 0;
            $class->save();
            return redirect('admin/assign_class_teacher/trash_bin')->with('restore', 'Assign Class Teacher Restore successfully');
        } else {
            return redirect('admin/assign_class_teacher/trash_bin')->with('error', 'Not Found');
        }
    }

//--------------------   Done   ------------------------------- //
    // teacher side work
    public function MyClassSubject(Request $request)
    {
        $user_id = Auth::user()->id;

        $getClass = AssignClassTeacherModel::getMyClassSubjectGroup($user_id);
        $data['header_title'] = 'My Class & Subject';

        if ($getClass->count() === 0) {
            Toastr::warning('You do not have any classes yet.', 'Message');
            return view('teacher.my_class_subject', $data);
        }

        $data['getClass'] = $getClass;

        if (empty($request->class_id)) {
            Toastr::info('Please enter complete search information.', 'Message');
            return view('teacher.my_class_subject', $data);
        }

        $getSubject = ClassSubjectModel::mySubject($request->class_id);

        if ($getSubject->count() === 0) {
            Toastr::warning('This class has no subjects yet.', 'Message');
            return view('teacher.my_class_subject', $data);
        }

        $data['getSubject'] = $getSubject;

        if (AssignClassTeacherModel::getMyClassSubject($user_id)->count() === 0) {
            Toastr::error('Search failed. Check the entered information again.', 'Error');
            return view('teacher.my_class_subject', $data);
        }

        $paginate = !empty($request->paginate) ? $request->paginate : 10;
        $getRecord = AssignClassTeacherModel::getMyClassSubject($user_id)->orderBy('id', 'desc')->paginate($paginate);
        $data['getRecord'] = $getRecord;

        Toastr::info('Search successful. Here are the results.', 'Message');
        return view('teacher.my_class_subject', $data);

    }
}
