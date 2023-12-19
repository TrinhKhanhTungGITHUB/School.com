<?php

namespace App\Http\Controllers;


use App\Http\Requests\Admin\SubjectListRequest;
use App\Http\Requests\Admin\SubjectRequest;
use App\Models\ClassSubjectModel;
use App\Models\SubjectModel;
use App\Models\User;
use Auth;
use Brian2694\Toastr\Facades\Toastr;


class SubjectController extends Controller
{
    // Admin side
    public function list(SubjectListRequest $request)
    {
        if (\Request::segment(3) == "list") {

            $data['header_title'] = 'Subject List';
            if (session('error')) {
                Toastr::error('No Information Found', 'Error');
            } else if (session('updated')) {
                Toastr::success('Subject updated successfully', 'Message');
            } else if (session('deleted')) {
                Toastr::warning('Subject delete successfully ', 'Warning');
            } else {
                if (SubjectModel::getRecord(0)->count() > 0) {
                    Toastr::info(' Search successful. Here are the results.', 'Message');
                } else {
                    Toastr::error('Search failed. Check the entered information again.', 'Error');
                }
            }

            if (!empty($request->paginate)) {
                $getRecord = SubjectModel::getRecord(0)->orderBy('id', 'desc')->paginate($request->paginate);
            } else {
                $getRecord = SubjectModel::getRecord(0)->orderBy('id', 'desc')->paginate(10);
            }
            $data['getRecord'] = $getRecord;

            return view('admin.subject.list', $data);
        }
        else if (\Request::segment(3) == "trash_bin") {
            $data['header_title'] = 'Trash Bin Subject List';

            if (session('error')) {
                Toastr::error('No Information Found  ', 'Error');
            } else if (session('restore')) {
                Toastr::success('Restore Subject successfully', 'Message');
            } else if (session('deleted')) {
                Toastr::warning('Subject delete successfully ', 'Warning');
            } else {
                if (SubjectModel::getRecord(1)->count() > 0) {
                    Toastr::info(' Search successful. Here are the results.', 'Message');
                } else {
                    Toastr::error('Search failed. Trash Bin empty.', 'Error');
                }
            }

            if (!empty($request->paginate)) {
                $getRecord = SubjectModel::getRecord(1)->orderBy('id', 'desc')->paginate($request->paginate);
            } else {
                $getRecord = SubjectModel::getRecord(1)->orderBy('id', 'desc')->paginate(10);
            }
            $data['getRecord'] = $getRecord;

            return view('admin.subject.list', $data);
        }

    }

    public function add()
    {
        $data['header_title'] = 'Add New Subject';
        Toastr::info('Please complete all information.', 'Message');
        if (session('success')) {
            Toastr::success('Subject created successfully ', 'Message');
        }

        return view('admin.subject.add', $data);
    }

    public function insert(SubjectRequest $request)
    {
        $subject = new SubjectModel;
        $subject->name = trim($request->name);
        $subject->type = trim($request->type);
        $subject->status = trim($request->status);
        $subject->created_by = Auth::user()->id;
        $subject->save();
        Toastr::success('Subject created successfully', 'Message');

        return redirect('admin/subject/add')->with('success', 'Subject created successfully');
    }

    public function edit($id)
    {
        $data['getRecord'] = SubjectModel::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['header_title'] = 'Edit Subject';
            Toastr::info('Please fully update the information.', 'Message');

            return view('admin.subject.edit', $data);
        } else {
            return redirect('admin/subject/list')->with('error', 'Not Found');
        }
    }

    public function update(SubjectRequest $request, $id)
    {
        $class = SubjectModel::getSingle($id);
        $class->name = trim($request->name);
        $class->type = trim($request->type);
        $class->status = trim($request->status);
        $class->save();

        return redirect('admin/subject/list')->with('updated', 'Subject update successfully');
    }

    public function delete($id)
    {
        $subject = SubjectModel::getSingle($id);

        if ($subject != null) {
            $subject->is_delete = 1;
            $subject->save();
            return redirect('admin/subject/list')->with('deleted', 'Subject Delete successfully');
        } else {
            return redirect('admin/subject/list')->with('error', 'Not Found');
        }
    }

    public function restore($id)
    {
        $class = SubjectModel::getSingle($id);
        if (!empty($class) && $class->is_delete == 1) {
            $class->is_delete = 0;
            $class->save();
            return redirect('admin/subject/trash_bin')->with('restore', 'Restore subject successfully');
        } else {
            return redirect('admin/subject/trash_bin')->with('error', 'Not Found');
        }
    }

    // public function remove($id)
    // {
    //     $subject = SubjectModel::getSingle($id);
    //     if (!empty($subject) && $subject->is_delete == 1) {
    //         $subject->delete();
    //         return redirect('admin/subject/trash_bin')->with('deleted', 'Deleted subject successfully');
    //     } else {
    //         return redirect('admin/subject/trash_bin')->with('error', 'Not Found');
    //     }
    // }


// -----------------------------------  Done  ----------------------------//
    // student side

    public function MySubject()
    {
        $data['header_title'] = 'My Subject';
        $data['getRecord'] = ClassSubjectModel::MySubject(Auth::user()->class_id);

        Toastr::success('Information about my subject.', 'Message');

        return view('student.my_subject', $data);
    }

    // parent side
    public function ParentStudentSubject($student_id)
    {
        $data['header_title'] = 'Student Subject';
        $student = User::getSingle($student_id);
        if(empty($student) || $student_id != 3)
        {
            Toastr::error('No results were found.', 'Message');
        }
        else
        {
            $data['getUser'] = $student;
            $data['getRecord'] = ClassSubjectModel::MySubject($student->class_id);

            Toastr::success('Information about my subject.', 'Message');
        }
        return view('parent.my_student_subject', $data);
    }

}
