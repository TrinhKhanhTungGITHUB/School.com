<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class SubjectModel extends Model
{
    use HasFactory;

    protected $table = 'subject';

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getTotalSubject()
    {
        $return = SubjectModel::select('subject.*', 'users.name as created_by_name')
            ->join('users', 'users.id', 'subject.created_by')
            ->where('subject.is_delete', '=', '0')
            ->where('subject.status', '=', '0')
            ->count();
        return $return;
    }

    static public function getRecord($is_delete)
    {
        $return = SubjectModel::select('subject.*', 'users.name as created_by_name')
            ->join('users', 'users.id', 'subject.created_by')
            ->where('subject.is_delete', '=', $is_delete);
        if (!empty(Request::get('name'))) {
            $return = $return->where('subject.name', 'like', '%' . Request::get('name') . '%');
        }

        if (!empty(Request::get('name_sort'))) {
            $return = $return->orderBy('subject.name', Request::get('name_sort'));
        }

        if (!empty(Request::get('type'))) {
            $return = $return->where('subject.type', '=', Request::get('type'));
        }

        if (!empty(Request::get('subject_type_sort'))) {
            $return = $return->orderBy('subject.type', Request::get('subject_type_sort'));
        }

        if (!empty(Request::get('status'))) {
            $status = (Request::get('status') == 100) ? 0 : 1;
            $return = $return->where('subject.status', '=', $status);
        }
        if (!empty(Request::get('date'))) {
            $return = $return->whereDate('subject.created_at', '=', Request::get('date'));
        }

        if (!empty(Request::get('date_sort'))) {
            $return = $return->orderBy('subject.created_at', Request::get('date_sort'));
        }
        return $return;
    }

    static public function getSubject()
    {
        $return = SubjectModel::select('subject.*')
            ->join('users', 'users.id', 'subject.created_by')
            ->where('subject.is_delete', '=', '0')
            ->where('subject.status', '=', '0')
            ->orderBy('subject.id', 'asc')
            ->get();

        return $return;
    }

}
