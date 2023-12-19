<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarksGradeModel extends Model
{
    use HasFactory;

    protected $table = 'marks_grade';

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getRecord()
    {
        return MarksGradeModel::select('marks_grade.*','users.name as created_name')
                                ->join('users','users.id','=','marks_grade.created_by')
                                ->orderBy('marks_grade.percent_to','desc')
                                ->paginate(10);
    }

    static public function getGrade($percentage)
    {
        $return = MarksGradeModel::select('marks_grade.*')
                -> where('percent_from','<=',$percentage)
                -> where('percent_to','>=',$percentage)
                ->first();
        return !empty($return->name) ? $return->name : '';
    }
}
