<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\AssignSubject\AssignSubjectRequest;
use App\Http\Requests\Admin\AssignSubject\AssignSubjectSingleRequest;
use App\Http\Requests\Admin\ClassSubjectListRequest;
use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\SubjectModel;
use Auth;
use Brian2694\Toastr\Facades\Toastr;

class ClassSubjectController extends Controller
{
    /// Done
    public function list(ClassSubjectListRequest $request)
    {
        if (\Request::segment(3) == 'list') {

            $data['header_title'] = 'Assign Subject List';
            if (session('error')) {
                Toastr::error('No Information Found  ', 'Error');
            } else if (session('error_Enter')) {
                Toastr::error('You entered missing information', 'Message');
            } else if (session('updated')) {
                Toastr::success('Assign subject updated successfully', 'Message');
            } else if (session('deleted')) {
                Toastr::warning('Assign subject delete successfully ', 'Warning');
            } else if (session('updated_single_1')) {
                Toastr::success('Status successfully updated ', 'Message');
            } else if (session('updated_single_2')) {
                Toastr::success('Subject successfully assign to class', 'Message');
            } else {
                if (ClassSubjectModel::getRecord(0)->count() > 0) {
                    Toastr::info(' Search successful. Here are the results.', 'Message');
                } else {
                    Toastr::error('Search failed. Check the entered information again.', 'Error');
                }
            }

            if (!empty($request->paginate)) {
                $getRecord = ClassSubjectModel::getRecord(0)->orderBy('class_subject.id', 'desc')->paginate($request->paginate);
            } else {
                $getRecord = ClassSubjectModel::getRecord(0)->orderBy('class_subject.id', 'desc')->paginate(10);
            }
            $data['getRecord'] = $getRecord;
            return view('admin.assign_subject.list', $data);
        }
        else if(\Request::segment(3) =='trash_bin')
        {
            $data['header_title'] = 'Trash Bin Assign Subject List';

            if (session('error')) {
                Toastr::error('No Information Found  ', 'Error');
            } else if (session('restore')) {
                Toastr::success('Restore Assign Subject successfully', 'Message');
            } else if (session('deleted')) {
                Toastr::warning('Assign Subject delete successfully ', 'Warning');
            } else {
                if (ClassSubjectModel::getRecord(1)->count() > 0) {
                    Toastr::info(' Search successful. Here are the results.', 'Message');
                } else {
                    Toastr::error('Search failed. Trash Bin empty.', 'Error');
                }
            }

            if (!empty($request->paginate)) {
                $getRecord = ClassSubjectModel::getRecord(1)->orderBy('class_subject.id', 'desc')->paginate($request->paginate);
            } else {
                $getRecord = ClassSubjectModel::getRecord(1)->orderBy('class_subject.id', 'desc')->paginate(10);
            }

            $data['getRecord'] = $getRecord;
            return view('admin.assign_subject.list', $data);
        }
    }
    public function add()
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getSubject'] = SubjectModel::getSubject();
        $data['header_title'] = 'Add New Assign Subject';
        Toastr::info('Please complete all information.', 'Message');
        if (session('success')) {
            Toastr::success('Assign subject created successfully ', 'Message');
        } else if (session('success_update')) {
            Toastr::warning('Assign subject update status successfully ', 'Message');
        }

        return view('admin.assign_subject.add', $data);
    }

    public function insert(AssignSubjectRequest $request)
    {
        $check = 0;
        if (!empty($request->subject_id)) {
            foreach ($request->subject_id as $subject_id) { // Kiểm tra trong 1 lớp có nhiều môn. Nếu lớp đó đã tồn tại môn đó thì chỉ cập nhật trạng thái môn đó của lớp đó.
                $getAlreadyFirst = ClassSubjectModel::getAlreadyFirst($request->class_id, $subject_id);
                if (!empty($getAlreadyFirst)) {
                    $check = 1;
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->save();
                } else // Nếu không có thì tạo mới lớp học và môn học
                {
                    $classSubject = new ClassSubjectModel;
                    $classSubject->class_id = $request->class_id;
                    $classSubject->subject_id = $subject_id;
                    $classSubject->status = $request->status;
                    $classSubject->created_by = Auth::user()->id;

                    $classSubject->save();
                }
            }
            if ($check == 0) {
                return redirect('admin/assign_subject/add')->with('success', 'Assign subject created successfully');
            } else {
                return redirect('admin/assign_subject/add')->with('success_update', 'Assign subject created successfully');
            }
        } else {
            redirect()->back()->with('error_Enter', 'You entered missing information');
        }

    }
    public function edit($id)
    {
        $data['getRecord'] = ClassSubjectModel::getSingle($id);

        if (!empty($data['getRecord'])) {
            $data['getAssignSubjectID'] = ClassSubjectModel::getAssignSubjectID($data['getRecord']->class_id);
            $data['getClass'] = ClassModel::getClass();
            $data['getSubject'] = SubjectModel::getSubject();
            $data['header_title'] = 'Edit Assign Subject';

            Toastr::info('Please fully update all assign subject the information.', 'Message');

            return view('admin.assign_subject.edit', $data);
        } else {
            return redirect('admin/assign_subject/list')->with('error', 'Not Found');
        }
    }

    public function update(AssignSubjectRequest $request, $id)
    {
        // Xóa lớp đó luôn. Tạo lớp mới
        ClassSubjectModel::deleteSubject($request->class_id);

        foreach ($request->subject_id as $subject_id) { // Kiểm tra trong 1 lớp có nhiều môn. Nếu lớp đó đã tồn tại môn đó thì chỉ cập nhật trạng thái môn đó của lớp đó.
            $getAlreadyFirst = ClassSubjectModel::getAlreadyFirst($request->class_id, $subject_id);
            if (!empty($getAlreadyFirst)) {
                $getAlreadyFirst->status = $request->status;
                $getAlreadyFirst->save();
            } else // Nếu không có thì tạo mới lớp học và môn học
            {
                $classSubject = new ClassSubjectModel;
                $classSubject->class_id = $request->class_id;
                $classSubject->subject_id = $subject_id;
                $classSubject->status = $request->status;
                $classSubject->created_by = Auth::user()->id;

                $classSubject->save();
            }
        }
        return redirect('admin/assign_subject/list')->with('updated', 'Assign subject update successfully');
    }

    public function edit_single($id)
    {
        $data['getRecord'] = ClassSubjectModel::getSingle($id);

        if (!empty($data['getRecord'])) {
            $data['getClass'] = ClassModel::getClass();
            $data['getSubject'] = SubjectModel::getSubject();
            $data['header_title'] = 'Edit Assign Subject Single';

            Toastr::info('Please fully update assign subject the information.', 'Message');

            return view('admin.assign_subject.edit_single', $data);
        } else {
            return redirect('admin/assign_subject/list')->with('error', 'Not Found');
        }
    }

    public function update_single(AssignSubjectSingleRequest $request, $id)
    {
        $getAlreadyFirst = ClassSubjectModel::getAlreadyFirst($request->class_id, $request->subject_id);
        if (!empty($getAlreadyFirst)) {
            $getAlreadyFirst->status = $request->status;
            $getAlreadyFirst->save();

            return redirect('admin/assign_subject/list')->with('updated_single_1', 'Status update successfully');
        } else // Nếu không có thì tạo mới lớp học và môn học
        {
            $classSubject = ClassSubjectModel::getSingle($id);
            $classSubject->class_id = $request->class_id;
            $classSubject->subject_id = $request->subject_id;
            $classSubject->status = $request->status;
            $classSubject->save();

            return redirect('admin/assign_subject/list')->with('updated_single_2', 'Subject successfully assign to class');
        }
    }
    public function delete($id)
    {
        $class = ClassSubjectModel::getSingle($id);
        if ($class != null) {
            $class->is_delete = 1;
            $class->save();
            return redirect('admin/assign_subject/list')->with('deleted', 'Subject Delete successfully');
        } else {
            return redirect('admin/assign_subject/list')->with('error', 'Not Found');
        }
    }

    public function restore($id)
    {
        $assignSubject = ClassSubjectModel::getSingle($id);
        if (!empty($assignSubject) && $assignSubject->is_delete == 1) {
            $assignSubject->is_delete = 0;
            $assignSubject->save();
            return redirect('admin/assign_subject/trash_bin')->with('restore', 'Restore assign subject successfully');
        } else {
            return redirect('admin/assign_subject/trash_bin')->with('error', 'Not Found');
        }
    }

    // public function remove($id)
    // {
    //     $assignSubject = ClassSubjectModel::getSingle($id);
    //     if (!empty($assignSubject) && $assignSubject->is_delete == 1) {
    //         $assignSubject->delete();
    //         return redirect('admin/assign_subject/trash_bin')->with('deleted', 'Deleted assign subject successfully');
    //     } else {
    //         return redirect('admin/assign_subject/trash_bin')->with('error', 'Not Found');
    //     }
    // }
}
