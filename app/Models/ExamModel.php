<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class ExamModel extends Model
{
    use HasFactory;

    protected $table = 'exam';

    static public function getRecord($is_delete)
    {
        $return = self::select('exam.*', 'users.name as created_name')
            ->join('users', 'users.id', '=', 'exam.created_by')
            ->where('users.is_delete', '=', 0)
            ->where('users.status', '=', 0)
            ->where('exam.is_delete', '=',$is_delete );
        if (!empty(Request::get('name'))) {
            $return = $return->where('exam.name', 'like', '%' . Request::get('name') . '%');
        }

        if (!empty(Request::get('name_sort'))) {
            $return = $return->orderBy('exam.name', Request::get('name_sort'));
        }

        if (!empty(Request::get('status'))) {
            $status = (Request::get('status') == 100) ? 0 : 1;
            $return = $return->where('exam.status', '=', $status);
        }

        if (!empty(Request::get('date'))) {
            $return = $return->whereDate('exam.created_at', '=', Request::get('date'));
        }

        if (!empty(Request::get('date_sort'))) {
            $return = $return->orderBy('exam.created_at', Request::get('date_sort'));
        }
        return $return;
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getExam()
    {
        $return = self::select('exam.*')
            ->join('users', 'users.id', '=', 'exam.created_by')
            ->where('exam.is_delete', '=', 0)
            ->where('exam.status', '=', 0)
            ->where('users.is_delete', '=', 0)
            ->where('users.status', '=', 0)
            ->orderBy('exam.name', 'asc')
            ->get();
        return $return;
    }

    static public function getTotalExam()
    {
        $return = self::select('exam.*')
            ->join('users', 'users.id', '=', 'exam.created_by')
            ->where('exam.is_delete', '=', 0)
            ->count();
            return $return;
    }
}
