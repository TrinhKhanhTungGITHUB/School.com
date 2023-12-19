<?php

namespace App\Http\Controllers;

use App\Exports\ExportParent;
use App\Http\Requests\Admin\Parent\ParentEditRequest;
use App\Http\Requests\Admin\Parent\ParentRequest;
use App\Http\Requests\Admin\ParentListRequest;
use App\Models\User;
use Auth;
use Brian2694\Toastr\Facades\Toastr;
use Hash;
use Illuminate\Http\Request;
use Str;
use Maatwebsite\Excel\Facades\Excel;

class ParentController extends Controller
{
    public function export_excel(Request $request)
    {
        return Excel::download(new ExportParent, 'Parent_' . date('d-m-Y H:i:s') . '.xlsx');
    }
    // Admin side
    public function list(ParentListRequest $request)
    {
        if (\Request::segment(3) == "list") {
            $data['header_title'] = 'Parent List';
            Toastr::clear();
            if (session('error')) {
                Toastr::error('No Information Found ', 'Error');
            } else if (session('updated_changed')) {
                Toastr::warning('Change of password and update successfully', 'Message');
            } else if (session('updated')) {
                Toastr::success('Parent updated successfully', 'Message');
            } else if (session('deleted')) {
                Toastr::warning('Parent delete successfully ', 'Warning');
            } else if (session('error_URL_assign_parent')) {
                Toastr::error('Error URL Parent', 'Message');
                session()->forget('error_URL_assign_parent');
            } else {
                if (User::getParent(0)->count() > 0) {
                    Toastr::info(' Search successful. Here are the results.', 'Message');
                } else {
                    Toastr::error('Search failed. Check the entered information again.', 'Error');
                }
            }
            session()->forget('error_URL_assign_parent');
            Toastr::clear();

            if (!empty($request->paginate)) {
                $getRecord = User::getParent(0)->orderBy('id', 'desc')->paginate($request->paginate);
            } else {
                $getRecord = User::getParent(0)->orderBy('id', 'desc')->paginate(10);
            }
            $data['getRecord'] = $getRecord;

            return view('admin.parent.list', $data);
        } else if (\Request::segment(3) == "trash_bin") {
            $data['header_title'] = 'Trash Bin Parent List';

            if (session('error')) {
                Toastr::error('No Information Found  ', 'Error');
            } else if (session('restore')) {
                Toastr::success('Restore Parent successfully', 'Message');
            } else if (session('deleted')) {
                Toastr::warning('Parent delete successfully ', 'Warning');
            } else {
                if (User::getParent(1)->count() > 0) {
                    Toastr::info(' Search successful. Here are the results.', 'Message');
                } else {
                    Toastr::error('Search failed. Trash Bin empty.', 'Error');
                }
            }
            if (!empty($request->paginate)) {
                $getRecord = User::getParent(1)->orderBy('id', 'desc')->paginate($request->paginate);
            } else {
                $getRecord = User::getParent(1)->orderBy('id', 'desc')->paginate(10);
            }
            $data['getRecord'] = $getRecord;
            return view('admin.parent.list', $data);
        }
    }

    public function add()
    {
        $data['header_title'] = 'Add New Parent';

        Toastr::info('Please complete all information.', 'Message');
        if (session('success')) {
            Toastr::success('Parent created successfully ', 'Message');
        }

        return view('admin.parent.add', $data);
    }

    public function insert(ParentRequest $request)
    {
        $parent = new User;

        if (!empty($request->mobile_number)) {
            $parent->mobile_number = trim($request->mobile_number);
        }

        if (!empty($request->address)) {
            $parent->address = trim($request->address);
        }

        if (!empty($request->occupation)) {
            $parent->occupation = trim($request->occupation);
        }

        $parent->name = trim($request->name);
        $parent->last_name = trim($request->last_name);
        $parent->gender = trim($request->gender);

        if (!empty($request->file('profile_pic'))) {
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $timestamp = now()->format('YmdHis'); // Lấy ngày giờ hiện tại dưới dạng YmdHis (năm tháng ngày giờ phút giây)
            $randomStr = Str::random(3); // Tạo chuỗi ngẫu nhiên gồm 3 ký tự
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = strtolower($originalName . $timestamp . $randomStr . '.' . $ext);
            $file->move('upload/profile/parent/', $filename);

            $parent->profile_pic = $filename;
        }

        $parent->mobile_number = trim($request->mobile_number);
        $parent->status = trim($request->status);

        $parent->email = trim($request->email);
        $parent->password = Hash::make($request->password);
        $parent->user_type = 4;
        $parent->save();

        return redirect('admin/parent/add')->with('success', 'Parent created successfully');
    }

    public function edit($id)
    {
        $data['getRecord'] = User::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['header_title'] = 'Edit Parent';
            Toastr::info('Please fully update the information.', 'Message');

            return view('admin.parent.edit', $data);
        } else {
            return redirect('admin/student/list')->with('error', 'Not Found');
        }
    }

    public function update(ParentEditRequest $request, $id)
    {
        request()->validate([
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $parent = User::getSingle($id);

        if (!empty($request->occupation)) {
            $parent->occupation = trim($request->occupation);
        }

        if (!empty($request->address)) {
            $parent->address = trim($request->address);
        }

        $parent->name = trim($request->name);
        $parent->last_name = trim($request->last_name);
        $parent->gender = trim($request->gender);


        if (!empty($request->file('profile_pic'))) {
            if (!empty($parent->getProfile())) {
                unlink('upload/profile/parent/' . $parent->profile_pic);
            }

            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $timestamp = now()->format('YmdHis'); // Lấy ngày giờ hiện tại dưới dạng YmdHis (năm tháng ngày giờ phút giây)
            $randomStr = Str::random(3); // Tạo chuỗi ngẫu nhiên gồm 3 ký tự
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = strtolower($originalName . $timestamp . $randomStr . '.' . $ext);
            $file->move('upload/profile/parent/', $filename);

            $parent->profile_pic = $filename;
        }

        $parent->mobile_number = trim($request->mobile_number);
        $parent->status = trim($request->status);

        $parent->email = trim($request->email);
        $parent->user_type = 4;

        if (!empty($request->password)) {
            $parent->password = Hash::make($request->password);
            $parent->save();
            return redirect('admin/parent/list')->with('updated_changed', 'parent update successfully');
        } else {
            $parent->save();
            return redirect('admin/parent/list')->with('updated', 'parent update successfully');
        }

    }

    public function delete($id)
    {
        $parent = User::getSingle($id);

        if ($parent != null) {
            $parent->is_delete = 1;
            $parent->save();
            return redirect('admin/parent/list')->with('deleted', 'Parent Delete successfully');
        } else {
            return redirect('admin/parent/list')->with('error', 'Not Found');
        }
    }

    public function restore($id)
    {
        $parent = User::getSingle($id);
        if (!empty($parent) && $parent->is_delete == 1 && $parent->user_type == 4) {
            $parent->is_delete = 0;
            $parent->save();
            return redirect('admin/parent/trash_bin')->with('restore', 'Restore parent successfully');
        } else {
            return redirect('admin/parent/trash_bin')->with('error', 'Not Found');
        }
    }

    // public function remove($id)
    // {
    //     $parent = User::getSingle($id);
    //     $student = User::getStudentToParent($id);
    //     if (!empty($parent) && $parent->is_delete == 1 && $parent->user_type == 4) {
    //         if (!empty($student)) {
    //             $student->parent_id = null;
    //             $student->save();
    //             $parent->delete();
    //             return redirect('admin/parent/trash_bin')->with('deleted', 'Deleted parent successfully');
    //         } else {
    //             $parent->delete();
    //             return redirect('admin/parent/trash_bin')->with('deleted', 'Deleted parent successfully');
    //         }
    //     } else {
    //         return redirect('admin/parent/trash_bin')->with('error', 'Not Found');
    //     }
    // }

    // ----------------------   Done -----------------------//
    public function myStudent($id)
    {
        $data['getParent'] = User::getSingle($id);
        $data['parent_id'] = $id;
        $data['getSearchStudent'] = User::getSearchStudent();
        $data['getRecord'] = User::getMyStudent($id);

        $data['header_title'] = 'Parent Student List';

        if (session('error_URL_assign_student')) {
            Toastr::error('Error URL Student', 'Message');
        } else if (session('success_assign')) {
            Toastr::success('Assign student parent successfully', 'Message');
        } else if (session('success_assign_delete')) {
            Toastr::warning('Assign student parent delete successfully', 'Message');
        } else if (session('error_exceeding')) {
            Toastr::error('This parent has more than 2 students.', 'Error');
        }
        else if(User::getMyStudent($id)->count() ==0 )
        {
            Toastr::warning('This parent does not have any students yet', 'Message');
        }
        else {
            Toastr::info(' Search successful. Here are the results.', 'Message');
        }

        return view('admin.parent.my_student', $data);
    }

    public function AssignStudentParent($student_id, $parent_id)
    {
        $student = User::getSingle($student_id);
        $parent = User::getSingle($parent_id);
        if ($parent == NULL || $parent->user_type != 4) {
            return redirect('admin/parent/list')->with('error_URL_assign_parent', 'Error URL');
        } else if ($student == NULL || $student->user_type != 3) {
            return redirect('admin/parent/my-student/' . $parent_id)->with('error_URL_assign_student', 'Error URL');
        } else if (User::getMyStudent($parent_id)->count() >= 2) {
            return redirect()->back()->with('error_exceeding', 'Error ! This parent has more than 3 students.');
        } else {
            $student->parent_id = $parent_id;
            $student->save();
            return redirect()->back()->with('success_assign', 'Parent Successfully Assign ');
        }
    }

    public function AssignStudentParentDelete($student_id)
    {
        $student = User::getSingle($student_id);
        $student->parent_id = null;
        $student->save();
        return redirect()->back()->with('success_assign_delete', 'Parent Successfully Assign Delete');
    }

    // parent side

    public function myStudentParent()
    {
        $id = Auth::user()->id;

        $data['getParent'] = User::getSingle($id);
        $data['getRecord'] = User::getMyStudent($id);

        $data['header_title'] = 'My Student';
        if (session('error')) {
            Toastr::error('No Found Information', 'Message');
        } else if (User::getMyStudent($id)->count() > 0) {
            Toastr::info('This is a list of your children.', 'Message');
        } else {
            Toastr::error('You are not a parent of any student yet.', 'Error');
        }

        return view('parent.my_student', $data);
    }
}
