<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\NoticeBoardListRequest;
use App\Http\Requests\NoticeBoardRequest;
use App\Http\Requests\SendMailRequest;
use App\Mail\SendEmailUserMail;
use App\Models\NoticeBoardMessageModel;
use App\Models\NoticeBoardModel;
use App\Models\User;
use Auth;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Mail;

class CommunicateController extends Controller
{
    public function SendEmail()
    {
        if (session('error')) {
            Toastr::error('Error  ', 'Error');
        } else if (session('success')) {
            Toastr::success('Mail successfully send  ', 'Message');
        }
        else
        {
            Toastr::info('Please complete all information.', 'Message');
        }
        $data['header_title'] = 'Send Email';
        return view('admin.communicate.send_email', $data);
    }

    public function SendEmailUser(SendMailRequest $request)
    {
        if (!empty($request->user_id)) {
            $user = User::getSingle($request->user_id);
            $user->send_message = $request->message;
            $user->send_subject = $request->subject;

            Mail::to($user->email)->send(new SendEmailUserMail($user));
        }

        if (!empty($request->message_to)) {
            foreach ($request->message_to as $user_type) {
                $getUser = User::getUserType($user_type);
                foreach ($getUser as $user) {
                    $user->send_message = $request->message;
                    $user->send_subject = $request->subject;

                    Mail::to($user->email)->send(new SendEmailUserMail($user));
                }
            }
        }

        return redirect()->back()->with('success', 'Mail successfully send');
    }
    public function SearchUser(Request $request)
    {
        $json = array();
        if (!empty($request->search)) {
            $getUser = User::SearchUser($request->search);
            foreach ($getUser as $value) {
                $type = '';
                if ($value->user_type == 1) {
                    $type = 'Admin';
                } else if ($value->user_type == 2) {
                    $type = 'Teacher';
                } else if ($value->user_type == 3) {
                    $type = 'Student';
                } else if ($value->user_type == 4) {
                    $type = 'Parent';
                }

                $name = $value->name . ' ' . $value->last_name . ' - ' . $type;
                $json[] = ['id' => $value->id, 'text' => $name];
            }
        }

        echo json_encode($json);
    }

    // Admin CRUD Notice Board
    public function NoticeBoard(NoticeBoardListRequest $request)
    {
        $data['header_title'] = 'Notice Board List';

        if (session('error')) {
            Toastr::error('No Information Found  ', 'Error');
        } else if (session('success')) {
            Toastr::success('Communicate added successfully  ', 'Message');
        } else if (session('updated')) {
            Toastr::success('Communicate updated successfully', 'Message');
        } else if (session('deleted')) {
            Toastr::warning('Communicate delete successfully ', 'Warning');
        } else {
            if (NoticeBoardModel::getRecord()->count() > 0) {
                Toastr::info(' Search successful. Here are the results.', 'Message');
            } else {
                Toastr::error('Search failed. Check the entered information again.', 'Error');
            }
        }

        if (!empty($request->paginate)) {
            $getRecord = NoticeBoardModel::getRecord()->orderBy('notice_board.id', 'desc')->paginate($request->paginate);
        } else {
            $getRecord = NoticeBoardModel::getRecord()->orderBy('notice_board.id', 'desc')->paginate(10);
        }
        $data['getRecord'] = $getRecord;
        return view('admin.communicate.noticeboard.list', $data);

    }

    public function AddNoticeBoard(Request $request)
    {
        $data['header_title'] = 'Add New Notice Board';
        Toastr::info('Please complete all information.', 'Message');
        if (session('success')) {
            Toastr::success('Notice Board created successfully ', 'Message');
        }
        return view('admin.communicate.noticeboard.add', $data);
    }

    public function InsertNoticeBoard(NoticeBoardRequest $request)
    {
        $noticeBoard = new NoticeBoardModel;
        $noticeBoard->title = $request->title;
        $noticeBoard->notice_date = $request->notice_date;
        $noticeBoard->publish_date = $request->publish_date;
        $noticeBoard->message = $request->message;
        $noticeBoard->created_by = Auth()->user()->id;
        $noticeBoard->save();

        foreach ($request->message_to as $message_to) {
            $message = new NoticeBoardMessageModel;
            $message->notice_board_id = $noticeBoard->id;
            $message->message_to = $message_to;
            $message->save();
        }

        return redirect('admin/communicate/notice_board/add')->with('success', 'Notice Board successfully created');
    }

    public function EditNoticeBoard($id)
    {
        $data['getRecord'] = NoticeBoardModel::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['header_title'] = 'Edit Notice Board';
            Toastr::info('Please fully update the information.', 'Message');

            return view('admin.communicate.noticeboard.edit', $data);
        } else {
            return redirect('admin/communicate/notice_board')->with('error', 'Not Found');
        }
    }

    public function UpdateNoticeBoard(NoticeBoardRequest $request, $id)
    {
        $noticeBoard = NoticeBoardModel::getSingle($id);

        $noticeBoard->title = $request->title;
        $noticeBoard->notice_date = $request->notice_date;
        $noticeBoard->publish_date = $request->publish_date;
        $noticeBoard->message = $request->message;
        $noticeBoard->created_by = Auth()->user()->id;
        $noticeBoard->save();

        NoticeBoardMessageModel::DeleteRecord($id);
        if (!empty($request->message_to)) {
            foreach ($request->message_to as $message_to) {
                $message = new NoticeBoardMessageModel;
                $message->notice_board_id = $noticeBoard->id;
                $message->message_to = $message_to;
                $message->save();
            }
        }

        return redirect('admin/communicate/notice_board/list')->with('updated', 'Notice Board successfully updated');
    }

    public function deleteNoticeBoard($id)
    {
        $noticeBoard = NoticeBoardModel::getSingle($id);
        if ($noticeBoard != null) {
            $noticeBoardMessage = NoticeBoardMessageModel::DeleteRecord($id);
            $noticeBoard->delete();
            return redirect('admin/communicate/notice_board')->with('deleted', 'Admin Delete successfully');
        } else {
            return redirect('admin/communicate/notice_board')->with('error', 'Not Found');
        }
    }

    // users side work
    public function MyNoticeBoardUser(Request $request)
    {
        $data['getRecord'] = NoticeBoardModel::getRecordUser(Auth::user()->user_type);
        $data['header_title'] = 'My Notice Board';


        return view('student.my_notice_board', $data);
    }

    public function MyStudentNoticeBoardParent(Request $request)
    {
        $data['getRecord'] = NoticeBoardModel::getRecordUser(3);
        $data['header_title'] = 'My Student Notice Board';

        if (NoticeBoardModel::getRecordUser(3)->count() > 0) {
            Toastr::info(' Search successful. Here are the results.', 'Message');
        } else {
            Toastr::error('Search failed. Check the entered information again.', 'Error');
        }

        return view('parent.my_student_notice_board', $data);
    }

}
