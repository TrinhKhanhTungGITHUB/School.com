<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\Admin\UpdateAdminAccountRequest;
use App\Http\Requests\Admin\Parent\UpdateParentAccountRequest;
use App\Http\Requests\Admin\SettingsRequest;
use App\Http\Requests\Admin\Student\UpdateStudentAccountRequest;
use App\Http\Requests\Admin\Teacher\UpdateTeacherAccountRequest;
use App\Http\Requests\Profile\ChangePasswordRequest;
use App\Models\ClassModel;
use App\Models\SettingModel;
use App\Models\User;
use Auth;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Str;

class UserController extends Controller
{
    public function Setting()
    {
        $data['header_title'] = "Setting";
        $data['getRecord'] = SettingModel::getSingle();
        if(session('success'))
            Toastr::success('Setting successfully Updated','Message');
        else
        {
            Toastr::info('Please fill in all information','Message');
        }
        return view('admin.setting', $data);
    }

    public function UpdateSetting(SettingsRequest $request)
    {
        $setting = SettingModel::getSingle();
        $setting->paypal_email = trim($request->paypal_email);

        $setting->stripe_key = trim($request->stripe_key);
        $setting->stripe_secret = trim($request->stripe_secret);

        $setting->school_name = trim($request->school_name);
        $setting->exam_description = trim($request->exam_description);

        if (!empty($request->file('logo'))) {
            if (!empty($setting->getLogo())) {
                unlink('upload/setting/' . $setting->logo);
            }

            $ext = $request->file('logo')->getClientOriginalExtension();
            $file = $request->file('logo');
            $timestamp = now()->format('YmdHis'); // Lấy ngày giờ hiện tại dưới dạng YmdHis (năm tháng ngày giờ phút giây)
            $randomStr = Str::random(3); // Tạo chuỗi ngẫu nhiên gồm 3 ký tự
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = strtolower($originalName . $timestamp . $randomStr . '.' . $ext);
            $file->move('upload/setting/', $filename);

            $setting->logo = $filename;
        }

        if (!empty($request->file('favicon_icon'))) {
            if (!empty($setting->getFavicon())) {
                unlink('upload/setting/' . $setting->favicon_icon);
            }

            $ext = $request->file('favicon_icon')->getClientOriginalExtension();
            $file = $request->file('favicon_icon');
            $timestamp = now()->format('YmdHis'); // Lấy ngày giờ hiện tại dưới dạng YmdHis (năm tháng ngày giờ phút giây)
            $randomStr = Str::random(3); // Tạo chuỗi ngẫu nhiên gồm 3 ký tự
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $favicon_icon = strtolower($originalName . $timestamp . $randomStr . '.' . $ext);
            $file->move('upload/setting/', $favicon_icon);

            $setting->favicon_icon = $favicon_icon;
        }

        $setting->save();

        return redirect()->back()->with('success','Setting successfully Updated');
    }

    public function change_password()
    {
        $data['header_title'] = 'Change Password';
        if (session('error')){
            Toastr::info('Please complete all information.', 'Message');
            Toastr::error('Old password is not correct ', 'Error');
        }
        else if (session('success')){
            Toastr::success('Password successfully updated ', 'Message');
        }
        else{
            Toastr::info('Please complete all information.', 'Message');
        }

        return view('profile.change_password', $data);
    }
    public function MyAccount()
    {
        $data['header_title'] = 'My Account';
        $data['getRecord'] = User::getSingle(Auth::user()->id);

        if(Auth::user()->user_type == 2)
        {
            if (session('updated')){
                Toastr::success(' Account updated successfully ', 'Message');
            }
            else{
                Toastr::info('Information about Teacher.', 'Message');
            }

            return view('teacher.my-account', $data);
        }
        else if(Auth::user()->user_type == 3)
        {
            // Thông báo
            if (session('updated')){
                Toastr::success(' Account updated successfully ', 'Message');
            }
            else{
                Toastr::info('Information about Student.', 'Message');
            }

            return view('student.my-account', $data);
        }
        else if(Auth::user()->user_type == 4)
        {
            // Thông báo
            if (session('updated')){
                Toastr::success(' Account updated successfully ', 'Message');
            }
            else{
                Toastr::info('Information about Parent.', 'Message');
            }

            return view('parent.my-account', $data);
        }
        else{
            if (session('updated')){
                Toastr::success(' Account updated successfully ', 'Message');
            }
            else{
                Toastr::info('Information about Admin.', 'Message');
            }

            return view('admin.my-account', $data);
        }
    }

    public function UpdateMyAccountTeacher(UpdateTeacherAccountRequest $request)
    {
        $id = Auth::user()->id;
        request()->validate([
            'email' => 'required|email|unique:users,email,'. $id,
        ]);

       $teacher = User::getSingle($id);

        $teacher->name = trim($request->name);
        $teacher->last_name = trim($request->last_name);
        $teacher->gender = trim($request->gender);
        $teacher->date_of_birth = trim($request->date_of_birth);

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

        if (!empty($request-> qualification)) {
            $teacher-> qualification = trim($request-> qualification);
        }

        if (!empty($request->work_experience)) {
            $teacher->work_experience = trim($request->work_experience);
        }

        if (!empty($request->note)) {
            $teacher->note = trim($request->note);
        }

        $teacher->email = trim($request->email);

        $teacher->save();

        return redirect()->back()->with('updated', 'Teacher update successfully');
    }

    public function UpdateMyAccountStudent(UpdateStudentAccountRequest $request)
    {
        $id = Auth::user()->id;
        request()->validate([
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $student = User::getSingle($id);

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

        $student->email = trim($request->email);
        $student->save();
        return redirect()->back()->with('updated', 'Student update successfully');

    }

    public function UpdateMyAccountParent(UpdateParentAccountRequest $request)
    {
        $id = Auth::user()->id;

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

        $parent->email = trim($request->email);
        $parent->user_type = 4;

        $parent->save();
        return redirect()->back()->with('updated', 'parent update successfully');

    }

    public function UpdateMyAccountAdmin(UpdateAdminAccountRequest $request)
    {
        $id = Auth::user()->id;
        request()->validate([
            'email' => 'required|email|unique:users,email,'.$id,
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

        $user->save();
        return redirect()->back()->with('updated', 'Admin update successfully');

    }


    public function update_change_password(ChangePasswordRequest $request)
    {
        $user = User::getSingle(Auth::user()->id);
        if(Hash::check($request->old_password, $user->password))
        {
            $user->password = Hash::make($request->new_password);
            $user->save();

            return redirect()->back()->with('success', 'Password successfully updated');
        }
        else
        {
            return redirect()->back()->with('error',"Old password is not correct");
        }
    }
}
