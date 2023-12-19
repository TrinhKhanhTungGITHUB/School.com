<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\Auth\ForgotRequest;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Http\Requests\Admin\Auth\RestPasswordRequest;
use App\Mail\ForgotPasswordMail;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Mail;

class AuthController extends Controller
{
    public function login()
    {
        //    dd(Hash::make(123456));
        if( !empty(Auth::check()))
        {
            if( Auth::user()->user_type == 1)
            {
                return redirect('admin/dashboard');
            }
            else if( Auth::user()->user_type == 2)
            {
                return redirect('teacher/dashboard');
            }
            else if( Auth::user()->user_type == 3)
            {
                return redirect('student/dashboard');
            }
            else if( Auth::user()->user_type == 4)
            {
                return redirect('parent/dashboard');
            }
        }

        if (session('error')){
            Toastr::error('Please enter correct email and password or your account is deleted.', 'Error');
        }
        else if(session('success_forgot'))
        {
            Toastr::success('Please check your email and reset your password', 'Message');
        }
        else if(session('success_reset'))
        {
            Toastr::success('Password Reset Successful', 'Message');
        }
        else if(session('success_logout'))
        {
            Toastr::success('Logout Success' , 'Message');
        }
        else
        {
            Toastr::info('Please complete all information.', 'Message');
        }

        return view('auth.login');
    }

    public function AuthLogin(LoginRequest $request)
    {
        $remember =  !empty($request->remember) ? true : false;
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_delete' => 0, 'status'=>0], $remember)) {
            // Kiểm tra loại người dùng và chuyển hướng tương ứng
            if (Auth::user()->user_type == 1) {
                return redirect('admin/dashboard')->with('success_login','Successful login.');;
            } else if (Auth::user()->user_type == 2) {
                return redirect('teacher/dashboard')->with('success_login','Successful login.');;
            } else if (Auth::user()->user_type == 3) {
                return redirect('student/dashboard')->with('success_login','Successful login.');;
            } else if (Auth::user()->user_type == 4) {
                return redirect('parent/dashboard')->with('success_login','Successful login.');;
            }
        } else {
            return redirect()->back()->with('error', 'Please enter correct email and password or your account is deleted.');
        }

    }

    public function ForgotPassword()
    {
        if(session('error_forgot'))
        {
            Toastr::error('Email not found in the system', 'Message');
        }
        else if(session('error_form_reset'))
        {
            Toastr::error('Session Error.', 'Error ');
        }
        else{
            Toastr::info('Please complete all information.', 'Message');
        }
        return view('auth.forgot');
    }

    public function PostForGotPassword(ForgotRequest $request)
    {
        $user = User::getEmailSingle($request->email);
        if(!empty($user))
        {
            $user->remember_token = Str::random(30);
            $user->save();

            Mail::to($user->email)->send(new ForgotPasswordMail($user));
            return redirect(url(''))->with('success_forgot','Please check your email and reset your password');
        }
        else
        {
            return redirect()->back()->with('error_forgot','Email not found in the system');
        }
    }

    public function reset($remember_token)
    {
        $user = User::getTokenSingle($remember_token);
        if(!empty($user))
        {
            $data['user'] = $user;
            if(session('error_reset'))
            {
                Toastr::error('Password and confirm password does not match', 'Message');
                return view('auth.reset', $data);
            }
            else{
                Toastr::info('Please complete all information.', 'Message');
                return view('auth.reset', $data);
            }
        }
        else
        {
            return redirect(url('forgot-password'))->with('error_form_reset','Session Error.');
        }
    }

    public function PostReset($token, RestPasswordRequest $request)
    {
        if($request->password == $request->confirm_password)
        {
            $user = User::getTokenSingle(($token));
            $user->password = Hash::make($request->password);
            $user->remember_token = Str::random(30);
            $user->save();

            return redirect(url(''))->with('success_reset','Password Reset Successful');
        }
        else
        {
            return redirect()->back()->with('error_reset','Password and confirm password does not match');
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect(url(''))->with('success_logout','Logout Success');
    }

}
