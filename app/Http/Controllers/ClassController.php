<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\ClassListRequest;
use App\Http\Requests\Admin\CU_ClassRequest;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Auth;
use Brian2694\Toastr\Facades\Toastr;

class ClassController extends Controller
{
    // Done
    public function list(ClassListRequest $request)
    {
        if (\Request::segment(3) == "list") {
            $data['header_title'] = 'Class List';
            if (session('error')) {
                Toastr::error('No Information Found', 'Error');

            } else if (session('updated')) {
                Toastr::success('Class updated successfully', 'Message');
            } else if (session('deleted')) {
                Toastr::warning('Class delete successfully ', 'Warning');
            } else {
                if (ClassModel::getRecord(0)->count() > 0) {
                    Toastr::info(' Search successful. Here are the results.', 'Message');
                } else {
                    Toastr::error('Search failed. Check the entered information again.', 'Error');
                }
            }

            if (!empty($request->paginate)) {
                $getRecord = ClassModel::getRecord(0)->orderBy('id', 'desc')->paginate($request->paginate);
            } else {
                $getRecord = ClassModel::getRecord(0)->orderBy('id', 'desc')->paginate(10);
            }
            $data['getRecord'] = $getRecord;
            return view('admin.class.list', $data);
        } else if (\Request::segment(3) == "trash_bin") {
            $data['header_title'] = 'Trash Bin Class List';

            if (session('error')) {
                Toastr::error('No Information Found  ', 'Error');
            } else if (session('restore')) {
                Toastr::success('Restore Class successfully', 'Message');
            } else if (session('deleted')) {
                Toastr::warning('Class delete successfully ', 'Warning');
            } else {
                if (ClassModel::getRecord(1)->count() > 0) {
                    Toastr::info(' Search successful. Here are the results.', 'Message');
                } else {
                    Toastr::error('Search failed. Trash Bin empty.', 'Error');
                }
            }

            if (!empty($request->paginate)) {
                $getRecord = ClassModel::getRecord(1)->orderBy('id', 'desc')->paginate($request->paginate);
            } else {
                $getRecord = ClassModel::getRecord(1)->orderBy('id', 'desc')->paginate(10);
            }

            $data['getRecord'] = $getRecord;

            return view('admin.class.list', $data);
        }
    }

    public function add()
    {
        $data['header_title'] = 'Add New Class';

        Toastr::info('Please complete all information.', 'Message');
        if (session('success')) {
            Toastr::success('Class created successfully ', 'Message');
        }

        return view('admin.class.add', $data);
    }

    public function insert(CU_ClassRequest $request)
    {
        $class = new ClassModel;
        $class->name = $request->name;
        $class->amount = $request->amount;
        $class->status = $request->status;
        $class->created_by = Auth::user()->id;
        $class->save();

        return redirect('admin/class/add')->with('success', 'Class created successfully');
    }

    public function edit($id)
    {
        $data['getRecord'] = ClassModel::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['header_title'] = 'Edit Class';
            if (session('error_Enter_Amount')) {
                Toastr::error('Amount can only increase. Please re-enter amount', 'Error');
            } else {
                Toastr::info('Please fully update the information.', 'Message');
            }
            return view('admin.class.edit', $data);
        } else {
            return redirect('admin/class/list')->with('error', 'Not Found');
        }
    }

    public function update(CU_ClassRequest $request, $id)
    {
        if ($request->amount >= $request->amount_old) {
            $class = ClassModel::getSingle($id);
            $class->name = trim($request->name);
            $class->amount = $request->amount;
            $class->status = trim($request->status);
            $class->save();
            return redirect('admin/class/list')->with('updated', 'Class update successfully');
        } else {
            return redirect()->back()->with('error_Enter_Amount', 'Amount can only increase. Please re-enter amount');
        }
    }


    public function delete($id)
    {
        $class = ClassModel::getSingle($id);
        if ($class != null) {
            $class->is_delete = 1;
            $class->save();
            return redirect('admin/class/list')->with('deleted', 'Class Delete successfully');
        } else {
            return redirect('admin/class/list')->with('error', 'Not Found');
        }
    }

    public function restore($id)
    {
        $class = ClassModel::getSingle($id);
        if (!empty($class) && $class->is_delete == 1) {
            $class->is_delete = 0;
            $class->save();
            return redirect('admin/class/trash_bin')->with('restore', 'Restore Class successfully');
        } else {
            return redirect('admin/class/trash_bin')->with('error', 'Not Found');
        }
    }

    // public function remove($id)
    // {
    //     $class = ClassModel::getSingle($id);
    //     if (!empty($class) && $class->is_delete == 1) {
    //         $class->delete();
    //         return redirect('admin/class/trash_bin')->with('deleted', 'Deleted class successfully');
    //     } else {
    //         return redirect('admin/class/trash_bin')->with('error', 'Not Found');
    //     }
    // }
}
