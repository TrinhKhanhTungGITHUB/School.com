<?php

namespace App\Http\Controllers;

use App\Exports\ExportTeacher;
use App\Http\Requests\Admin\Teacher\TeacherRequest;
use App\Http\Requests\Admin\Teacher\TeacherUpdateRequest;
use App\Http\Requests\Admin\TeacherListRequest;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class TeacherController extends Controller
{
    public function export_excel(Request $request)
    {
        return Excel::download(new ExportTeacher, 'Teacher_' . date('d-m-Y H:i:s') . '.xlsx');
    }
    // Done
    public function list(TeacherListRequest $request)
    {
        if(\Request::segment(3) == "list")
        {
            $data['header_title'] = 'Teacher List';

            if (session('error')) {
                Toastr::error('No Information Found  ', 'Error');
            } else if (session('updated_changed')) {
                Toastr::warning('Change of password and update successfully', 'Message');
            } else if (session('updated')) {
                Toastr::success('Teacher updated successfully', 'Message');
            } else if (session('deleted')) {
                Toastr::warning('Teacher delete successfully ', 'Warning');
            } else {
                if (User::getTeacher(0)->count() > 0) {
                    Toastr::info('Search successful. Here are the results.', 'Message');
                } else {
                    Toastr::error('Search failed. Check the entered information again.', 'Error');
                }
            }

            if (!empty($request->paginate)) {
                $getRecord = User::getTeacher(0)->orderBy('id', 'desc')->paginate($request->paginate);
            }
            else{
                $getRecord = User::getTeacher(0)->orderBy('id', 'desc')->paginate(10);
            }

            $data['getRecord'] = $getRecord;
            return view('admin.teacher.list', $data);
        }
        else if(\Request::segment(3) == 'trash_bin')
        {
            $data['header_title'] = 'Trash Bin Teacher List';

            if (session('error')) {
                Toastr::error('No Information Found  ', 'Error');
            } else if (session('restore')) {
                Toastr::success('Restore Teacher succes fully', 'Message');
            } else if (session('deleted')) {
                Toastr::warning('Teacher delete successfully', 'Warning');
            } else {
                if (User::getTeacher(1)->count() > 0) {
                    Toastr::info('Search successful.Here are the results.', 'Message');
                } else {
                    Toastr::error('Search failed.Trash Bin empty.', 'Error');
                }
            }

            if (!empty($request->paginate)) {
                $getRecord = User::getTeacher(1)->orderBy('id', 'desc')->paginate($request->paginate);
            }
            else{
                $getRecord = User::getTeacher(1)->orderBy('id', 'desc')->paginate(10);
            }

            $data['getRecord'] = $getRecord;
            return view('admin.teacher.list', $data);
        }

    }

    public function add()
    {
        $data['header_title'] = 'Add New Teacher';

        Toastr::info('Please complete all information.', 'Message');
        if (session('success')) {
            Toastr::success('Teacher created successfully', 'Message');
        }

        return view('admin.teacher.add', $data);
    }

    public function insert(TeacherRequest $request)
    {
        $teacher = new User;
        $teacher->name = trim($request->name);
        $teacher->last_name = trim($request->last_name);
        $teacher->gender = trim($request->gender);

        $teacher->date_of_birth = trim($request->date_of_birth);

        $teacher->admission_date = trim($request->admission_date);

        if (!empty($request->file('profile_pic'))) {
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $timestamp = now()->format('YmdHis'); // Lấy ngày giờ hiện tại dưới dạng YmdHis (năm tháng ngày giờ phút giây)
            $randomStr = Str::random(3); // Tạo chuỗi ngẫu nhiên gồm 3 ký tự
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = strtolower($originalName . $timestamp . $randomStr . '.' . $ext);
            $file->move('upload/profile/teacher', $filename);

            $teacher->profile_pic = $filename;
        }

        if (!empty($request->marital_status)) {
            $teacher->marital_status = trim($request->marital_status);
        }

        if (!empty($request->address)) {
            $teacher->address = trim($request->address);
        }

        if (!empty($request->mobile_number)) {
            $teacher->mobile_number = trim($request->mobile_number);
        }

        if (!empty($request->permanent_address)) {
            $teacher->permanent_address = trim($request->permanent_address);
        }

        if (!empty($request->qualification)) {
            $teacher->qualification = trim($request->qualification);
        }

        if (!empty($request->work_experience)) {
            $teacher->work_experience = trim($request->work_experience);
        }

        if (!empty($request->note)) {
            $teacher->note = trim($request->note);
        }

        $teacher->status = trim($request->status);
        $teacher->email = trim($request->email);
        $teacher->password = Hash::make($request->password);
        $teacher->user_type = 2;
        $teacher->save();

        return redirect('admin/teacher/add')->with('success', 'Teacher created successfully');
    }

    public function edit($id)
    {
        $data['getRecord'] = User::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['header_title'] = 'Edit Teacher';
            Toastr::info('Please fully update the information.', 'Message');

            return view('admin.teacher.edit', $data);
        } else {
            return redirect('admin/teacher/list')->with('error', 'Not Found');
        }
    }

    public function update(TeacherUpdateRequest $request, $id)
    {

        request()->validate([
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $teacher = User::getSingle($id);

        $teacher->name = trim($request->name);
        $teacher->last_name = trim($request->last_name);
        $teacher->gender = trim($request->gender);
        $teacher->date_of_birth = trim($request->date_of_birth);
        $teacher->admission_date = trim($request->admission_date);

        if (!empty($request->file('profile_pic'))) {
            if (!empty($teacher->getProfile())) {
                unlink('upload/profile/teacher/' . $teacher->profile_pic);
            }

            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $timestamp = now()->format('YmdHis'); // Lấy ngày giờ hiện tại dưới dạng YmdHis (năm tháng ngày giờ phút giây)
            $randomStr = Str::random(3); // Tạo chuỗi ngẫu nhiên gồm 3 ký tự
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = strtolower($originalName . $timestamp . $randomStr . '.' . $ext);
            $file->move('upload/profile/teacher/', $filename);

            $teacher->profile_pic = $filename;
        }

        if (!empty($request->marital_status)) {
            $teacher->marital_status = trim($request->marital_status);
        }

        if (!empty($request->address)) {
            $teacher->address = trim($request->address);
        }

        if (!empty($request->mobile_number)) {
            $teacher->mobile_number = trim($request->mobile_number);
        }

        if (!empty($request->permanent_address)) {
            $teacher->permanent_address = trim($request->permanent_address);
        }

        if (!empty($request->qualification)) {
            $teacher->qualification = trim($request->qualification);
        }

        if (!empty($request->work_experience)) {
            $teacher->work_experience = trim($request->work_experience);
        }

        if (!empty($request->note)) {
            $teacher->note = trim($request->note);
        }

        $teacher->status = trim($request->status);
        $teacher->email = trim($request->email);

        if (!empty($request->password)) {
            $teacher->password = Hash::make($request->password);
            $teacher->save();
            return redirect('admin/teacher/list')->with('updated_changed', 'Teacher update successfully');
        } else {
            $teacher->save();
            return redirect('admin/teacher/list')->with('updated', 'Teacher update successfully');
        }
    }


    public function delete($id)
    {
        $teacher = User::getSingle($id);
        if ($teacher != null) {
            $teacher->is_delete = 1;
            $teacher->save();
            return redirect('admin/teacher/list')->with('deleted', 'Teacher Delete successfully');
        } else {
            return redirect('admin/teacher/list')->with('error', 'Not Found');
        }

    }

    public function restore($id)
    {
        $teacher = User::getSingle($id);
        if (!empty($teacher) && $teacher->is_delete == 1 && $teacher->user_type == 2) {
            $teacher->is_delete = 0;
            $teacher->save();
            return redirect('admin/teacher/trash_bin')->with('restore', 'Restore teacher successfully');
        } else {
            return redirect('admin/teacher/trash_bin')->with('error', 'Not Found');
        }
    }


    // public function remove($id)
    // {
    //     $teacher = User::getSingle($id);
    //     if (!empty($teacher) && $teacher->is_delete == 1 && $teacher->user_type == 2) {
    //         $teacher->delete();
    //         return redirect('admin/teacher/trash_bin')->with('deleted', 'Deleted teacher successfully');
    //     } else {
    //         return redirect('admin/teacher/trash_bin')->with('error', 'Not Found');
    //     }
    // }

}
