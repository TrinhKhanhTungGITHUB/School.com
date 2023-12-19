<?php

namespace App\Http\Controllers;


use App\Http\Requests\Admin\Admin\AddUserRequest;
use App\Http\Requests\Admin\Admin\UpdateUserRequest;
use App\Http\Requests\Admin\AdminListRequest;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class AdminController extends Controller
{
    public function list(AdminListRequest $request)
    {
        if (\Request::segment(3) == "list") {
            $data['header_title'] = 'Admin List';
            if (session('error')) {
                Toastr::error('No Information Found  ', 'Error');
            } else if (session('updated_changed')) {
                Toastr::warning('Change of password and update successfully', 'Message');
            } else if (session('updated')) {
                Toastr::success('Admin updated successfully', 'Message');
            } else if (session('deleted')) {
                Toastr::warning('Admin delete successfully ', 'Warning');
            } else {
                if (User::getAdmin(0)->count() > 0) {
                    Toastr::info(' Search successful. Here are the results.', 'Message');
                } else {
                    Toastr::error('Search failed. Check the entered information again.', 'Error');
                }
            }

            if (!empty($request->paginate)) {
                $getRecord = User::getAdmin(0)->orderBy('id', 'desc')->paginate($request->paginate);
            } else {
                $getRecord = User::getAdmin(0)->orderBy('id', 'desc')->paginate(10);
            }
            $data['getRecord'] = $getRecord;
            return view('admin.admin.list', $data);
        } else if (\Request::segment(3) == 'trash_bin') {
            $data['header_title'] = 'Trash Bin Admin List';

            if (session('error')) {
                Toastr::error('No Information Found  ', 'Error');
            } else if (session('restore')) {
                Toastr::success('Restore Admin successfully', 'Message');
            } else if (session('deleted')) {
                Toastr::warning('Admin delete successfully ', 'Warning');
            } else {
                if (User::getAdmin(1)->count() > 0) {
                    Toastr::info('Search successful. Here are the results.', 'Message');
                } else {
                    Toastr::error('Search failed. Trash Bin empty.', 'Error');
                }
            }

            if (!empty($request->paginate)) {
                $getRecord = User::getAdmin(1)->orderBy('id', 'desc')->paginate($request->paginate);
            } else {
                $getRecord = User::getAdmin(1)->orderBy('id', 'desc')->paginate(10);
            }

            $data['getRecord'] = $getRecord;

            return view('admin.admin.list', $data);
        }

    }
    public function add()
    {
        $data['header_title'] = 'Add New Admin';

        Toastr::info('Please complete all information.', 'Message');
        if (session('success')) {
            Toastr::success('Admin created successfully ', 'Message');
        }

        return view('admin.admin.add', $data);
    }

    public function insert(AddUserRequest $request)
    {
        $user = new User;
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->password = Hash::make($request->password);
        $user->user_type = 1;

        if (!empty($request->file('profile_pic'))) {
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $timestamp = now()->format('YmdHis'); // Lấy ngày giờ hiện tại dưới dạng YmdHis (năm tháng ngày giờ phút giây)
            $randomStr = Str::random(3); // Tạo chuỗi ngẫu nhiên gồm 3 ký tự
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = strtolower($originalName . $timestamp . $randomStr . '.' . $ext);
            $file->move('upload/profile/admin/', $filename);

            $user->profile_pic = $filename;
        }
        $user->save();

        return redirect('admin/admin/add')->with('success', 'Admin created successfully');
    }

    public function edit($id)
    {
        $data['getRecord'] = User::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['header_title'] = 'Edit Admin';
            Toastr::info('Please fully update the information.', 'Message');

            return view('admin.admin.edit', $data);
        } else {
            return redirect('admin/admin/list')->with('error', 'Not Found');
        }
    }

    public function update(UpdateUserRequest $request, $id)
    {
        request()->validate([
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $user = User::getSingle($id);
        $user->name = trim($request->name);
        $user->email = trim($request->email);

        if (!empty($request->file('profile_pic'))) {
            if (!empty($user->getProfile())) {
                unlink('upload/profile/admin/' . $user->profile_pic);
            }

            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $timestamp = now()->format('YmdHis'); // Lấy ngày giờ hiện tại dưới dạng YmdHis (năm tháng ngày giờ phút giây)
            $randomStr = Str::random(3); // Tạo chuỗi ngẫu nhiên gồm 3 ký tự
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = strtolower($originalName . $timestamp . $randomStr . '.' . $ext);
            $file->move('upload/profile/admin/', $filename);

            $user->profile_pic = $filename;
        }

        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect('admin/admin/list')->with('updated_changed', 'Admin update successfully');
        } else {
            $user->save();
            return redirect('admin/admin/list')->with('updated', 'Admin update successfully');
        }
    }

    public function delete($id)
    {
        $user = User::getSingle($id);
        if ($user != null) {
            $user->is_delete = 1;
            $user->save();
            return redirect('admin/admin/list')->with('deleted', 'Admin Delete successfully');
        } else {
            return redirect('admin/admin/list')->with('error', 'Not Found');
        }
    }

    public function restore($id)
    {
        $user = User::getSingle($id);
        if (!empty($user) && $user->is_delete == 1 && $user->user_type == 1) {
            $user->is_delete = 0;
            $user->save();
            return redirect('admin/admin/trash_bin')->with('restore', 'Restore Admin successfully');
        } else {
            return redirect('admin/admin/trash_bin')->with('error', 'Not Found');
        }
    }

    // public function remove($id)
    // {
    //     $user = User::getSingle($id);
    //     if (!empty($user) && $user->is_delete == 1 && $user->user_type == 1) {
    //         $user->delete();
    //         return redirect('admin/admin/trash_bin')->with('deleted', 'Deleted Admin successfully');
    //     } else {
    //         return redirect('admin/admin/trash_bin')->with('error', 'Not Found');
    //     }
    // }

}
