<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSubjectTimetableModel extends Model
{
    use HasFactory;

    protected $table = 'class_subject_timetable';

    protected $fillable = [
        'class_id',
        'subject_id',
        'week_id', // Thêm trường này vào mảng fillable
        'start_time',
        'end_time',
        'room_number',
    ];

    static public function getRecordClassSubject($class_id,$subject_id,$week_id)
    {
        return self::where('class_id', '=',$class_id)
                    ->where('subject_id','=', $subject_id)
                    ->where('week_id','=', $week_id)
                    ->first();
    }

    static public function getDeleteRecord($class_id,$subject_id,$week_id)
    {
        return self::where('class_id', '=',$class_id)
                    ->where('subject_id','=', $subject_id)
                    ->where('week_id','=', $week_id)
                    ->delete();
    }


    static public function getDayClassSubjectTime($class_id,$subject_id)
    {
        return self::select('class_subject_timetable.week_id')
                    ->where('class_id', '=',$class_id)
                    ->where('subject_id','=', $subject_id)
                    ->get();
    }
}
