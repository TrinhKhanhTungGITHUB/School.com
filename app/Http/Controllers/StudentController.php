<?php

namespace App\Http\Controllers;

use App\Exports\ExportStudent;
use App\Http\Requests\Admin\Student\StudentEditRequest;
use App\Http\Requests\Admin\Student\StudentRequest;
use App\Http\Requests\Admin\StudentListRequest;
use App\Http\Requests\Teacher\MyStudentListRequest;
use App\Models\ClassModel;
use App\Models\User;
use Auth;
use Brian2694\Toastr\Facades\Toastr;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function export_excel(Request $request)
    {
        return Excel::download(new ExportStudent, 'Student_' . date('d-m-Y H:i:s') . '.xlsx');
    }
    public function list(StudentListRequest $request)
    {
        if (\Request::segment(3) == "list") {
            $data['getClass'] = ClassModel::getClass();
            $data['header_title'] = 'Student List';

            if (session('error')) {
                Toastr::error('No Information Found  ', 'Error');
            } else if (session('updated_changed')) {
                Toastr::warning('Change of password and update successfully', 'Message');
            } else if (session('updated')) {
                Toastr::success('Student updated successfully', 'Message');
            } else if (session('deleted')) {
                Toastr::warning('Student delete successfully ', 'Warning');
            } else {
                if (User::getStudent(0)->count() > 0) {
                    Toastr::info(' Search successful. Here are the results.', 'Message');
                } else {
                    Toastr::error('Search failed. Check the entered information again.', 'Error');
                }
            }

            if (!empty($request->paginate)) {
                $getRecord = User::getStudent(0)->orderBy('id', 'desc')->paginate($request->paginate);
            } else {
                $getRecord = User::getStudent(0)->orderBy('id', 'desc')->paginate(10);
            }

            $data['getRecord'] = $getRecord;
            return view('admin.student.list', $data);
        } else if (\Request::segment(3) == 'trash_bin') {
            $data['getClass'] = ClassModel::getClass();
            $data['header_title'] = 'Trash Bin Student List';

            if (session('error')) {
                Toastr::error('No Information Found  ', 'Error');
            } else if (session('restore')) {
                Toastr::success('Restore Student successfully', 'Message');
            } else if (session('deleted')) {
                Toastr::warning('Student delete successfully ', 'Warning');
            } else {
                if (User::getStudent(1)->count() > 0) {
                    Toastr::info(' Search successful. Here are the results.', 'Message');
                } else {
                    Toastr::error('Search failed. Trash Bin empty.', 'Error');
                }
            }

            if (!empty($request->paginate)) {
                $getRecord = User::getStudent(1)->orderBy('id', 'desc')->paginate($request->paginate);
            } else {
                $getRecord = User::getStudent(1)->orderBy('id', 'desc')->paginate(10);
            }

            $data['getRecord'] = $getRecord;
            return view('admin.student.list', $data);
        }
    }

    public function show($id)
    {
        $data['id'] = $id;
        $data['getClass'] = ClassModel::getClass();
        $data['getRecord'] = User::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['header_title'] = 'Edit Student';
            Toastr::info('Information about User.', 'Message');

            return view('admin.student.view', $data);
        } else {
            return redirect('admin/student/list')->with('error', 'Not Found');
        }
    }

    public function add()
    {
        $data['header_title'] = 'Add New Student';
        $data['getClass'] = ClassModel::getClass();

        Toastr::info('Please complete all information.', 'Message');
        if (session('success')) {
            Toastr::success('Student created successfully ', 'Message');
        }

        return view('admin.student.add', $data);
    }

    public function insert(StudentRequest $request)
    {
        $student = new User;
        if (!empty($request->roll_number)) {
            $student->roll_number = trim($request->roll_number);
        }

        if (!empty($request->caste)) {
            $student->caste = trim($request->caste);
        }

        if (!empty($request->religion)) {
            $student->religion = trim($request->religion);
        }

        if (!empty($request->mobile_number)) {
            $student->mobile_number = trim($request->mobile_number);
        }

        if (!empty($request->blood_group)) {
            $student->blood_group = trim($request->blood_group);
        }

        if (!empty($request->height)) {
            $student->height = trim($request->height);
        }

        if (!empty($request->weight)) {
            $student->weight = trim($request->weight);
        }

        $student->name = trim($request->name);
        $student->last_name = trim($request->last_name);
        $student->admission_number = trim($request->admission_number);

        $student->class_id = trim($request->class_id);
        $student->gender = trim($request->gender);

        if (!empty($request->date_of_birth)) {
            $student->date_of_birth = trim($request->date_of_birth);
        }

        if (!empty($request->file('profile_pic'))) {
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $timestamp = now()->format('YmdHis'); // Lấy ngày giờ hiện tại dưới dạng YmdHis (năm tháng ngày giờ phút giây)
            $randomStr = Str::random(3); // Tạo chuỗi ngẫu nhiên gồm 3 ký tự
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = strtolower($originalName . $timestamp . $randomStr . '.' . $ext);
            $file->move('upload/profile/student/', $filename);

            $student->profile_pic = $filename;
        }


        if (!empty($request->admission_date)) {
            $student->admission_date = trim($request->admission_date);
        }


        $student->status = trim($request->status);

        $student->email = trim($request->email);
        $student->password = Hash::make($request->password);
        $student->user_type = 3;
        $student->save();

        return redirect('admin/student/add')->with('success', 'Student created successfully');
    }

    public function edit($id)
    {
        $data['id'] = $id;
        $data['getClass'] = ClassModel::getClass();
        $data['getRecord'] = User::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['header_title'] = 'Edit Student';
            Toastr::info('Please fully update the information.', 'Message');

            return view('admin.student.edit', $data);
        } else {
            return redirect('admin/student/list')->with('error', 'Not Found');
        }
    }

    public function update(StudentEditRequest $request, $id)
    {
        request()->validate([
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $student = User::getSingle($id);

        if (!empty($request->roll_number)) {
            $student->roll_number = trim($request->roll_number);
        }

        if (!empty($request->caste)) {
            $student->caste = trim($request->caste);
        }

        if (!empty($request->religion)) {
            $student->religion = trim($request->religion);
        }

        if (!empty($request->mobile_number)) {
            $student->mobile_number = trim($request->mobile_number);
        }

        if (!empty($request->blood_group)) {
            $student->blood_group = trim($request->blood_group);
        }

        if (!empty($request->height)) {
            $student->height = trim($request->height);
        }

        if (!empty($request->weight)) {
            $student->weight = trim($request->weight);
        }
        $student->name = trim($request->name);
        $student->last_name = trim($request->last_name);
        $student->admission_number = trim($request->admission_number);
        $student->roll_number = trim($request->roll_number);
        $student->class_id = trim($request->class_id);
        $student->gender = trim($request->gender);

        if (!empty($request->date_of_birth)) {
            $student->date_of_birth = trim($request->date_of_birth);
        }

        if (!empty($request->file('profile_pic'))) {
            if (!empty($student->getProfile())) {
                unlink('upload/profile/student/' . $student->profile_pic);
            }

            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $timestamp = now()->format('YmdHis'); // Lấy ngày giờ hiện tại dưới dạng YmdHis (năm tháng ngày giờ phút giây)
            $randomStr = Str::random(3); // Tạo chuỗi ngẫu nhiên gồm 3 ký tự
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = strtolower($originalName . $timestamp . $randomStr . '.' . $ext);
            $file->move('upload/profile/student/', $filename);

            $student->profile_pic = $filename;
        }

        if (!empty($request->admission_date)) {
            $student->admission_date = trim($request->admission_date);
        }

        $student->status = trim($request->status);

        $student->email = trim($request->email);

        if (!empty($request->password)) {
            $student->password = Hash::make($request->password);
            $student->save();
            return redirect('admin/student/list')->with('updated_changed', 'Student update successfully');
        } else {
            $student->save();
            return redirect('admin/student/list')->with('updated', 'Student update successfully');
        }

    }

    public function delete($id)
    {
        $student = User::getSingle($id);

        if ($student != null) {
            $student->is_delete = 1;
            $student->save();
            return redirect('admin/student/list')->with('deleted', 'Student Delete successfully');
        } else {
            return redirect('admin/student/list')->with('error', 'Not Found');
        }
    }

    public function restore($id)
    {
        $student = User::getSingle($id);
        if (!empty($student) && $student->is_delete == 1 && $student->user_type == 3) {
            $student->is_delete = 0;
            $student->save();
            return redirect('admin/student/trash_bin')->with('restore', 'Restore student successfully');
        } else {
            return redirect('admin/student/trash_bin')->with('error', 'Not Found');
        }
    }

    // public function remove($id)
    // {
    //     $student = User::getSingle($id);
    //     if (!empty($student) && $student->is_delete == 1 && $student->user_type == 3) {
    //         $student->delete();
    //         return redirect('admin/student/trash_bin')->with('deleted', 'Deleted student successfully');
    //     } else {
    //         return redirect('admin/student/trash_bin')->with('error', 'Not Found');
    //     }
    // }


    // teacher side work

    public function MyStudent(MyStudentListRequest $request)
    {
        $data['getRecord'] = User::getTeacherStudent(Auth::user()->id);
        $data['header_title'] = 'My Student List';
        $data['getClass'] = ClassModel::getClass();


        if (User::getTeacherStudent(Auth::user()->id)->count() > 0) {
            Toastr::info('There are your students.', 'Message');
        } else {
            Toastr::error('You do not have any students yet.', 'Error');
        }

        if (!empty($request->paginate)) {
            $getRecord = User::getTeacherStudent(Auth::user()->id)->orderBy('id', 'desc')->paginate($request->paginate);
        } else {
            $getRecord = User::getTeacherStudent(Auth::user()->id)->orderBy('id', 'desc')->paginate(10);
        }

        $data['getRecord'] = $getRecord;
        return view('teacher.my_student', $data);
    }
}
