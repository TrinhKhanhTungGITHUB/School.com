<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'class';

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getRecord($is_delete)
    {
        $return = ClassModel::select('class.*', 'users.name as created_by_name')
            ->join('users', 'users.id', 'class.created_by')
            ->where('class.is_delete', '=', $is_delete);
        if (!empty(Request::get('name'))) {
            $return = $return->where('class.name', 'like', '%' . Request::get('name') . '%');
        }

        if (!empty(Request::get('name_sort'))) {
            $return = $return->orderBy('name', Request::get('name_sort'));
        }

        if (!empty(Request::get('amount'))) {
            $return = $return->where('class.amount', '=', Request::get('amount'));
        }

        if (!empty(Request::get('amount_sort'))) {
            $return = $return->orderBy('amount', Request::get('amount_sort'));
        }

        if (!empty(Request::get('date'))) {
            $return = $return->whereDate('class.created_at', '=', Request::get('date'));
        }

        if (!empty(Request::get('date_sort'))) {
            $return = $return->orderBy('created_at', Request::get('date_sort'));
        }

        if (!empty(Request::get('status'))) {
            $status = (Request::get('status') == 100) ? 0 : 1;
            $return = $return->where('class.status', '=', $status);
        }

        return $return;
    }

    static function getClass($is_total = 0)
    {
        $return = ClassModel::select('class.*')
            ->join('users', 'users.id', 'class.created_by')
            ->where('class.is_delete', '=', 0)
            ->where('class.status', '=', 0)
            ->orderBy('class.name', 'asc');
        if ($is_total != 0) {
            return $return->count();
        }
        return $return->get();
    }

    static public function getClassName($class_id)
    {
        return self::select('class.name')
            ->where('class.id','=',$class_id)
            ->first();
    }
}
