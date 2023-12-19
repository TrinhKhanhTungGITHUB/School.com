<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class StudentAttendanceModel extends Model
{
    use HasFactory;

    protected $table = "student_attendance";

    public static function CheckAlreadyAttendance($student_id, $class_id, $attendance_date, $subject_id)
    {
        return StudentAttendanceModel::where('student_id', '=', $student_id)->where('class_id', '=', $class_id)
            ->where('attendance_date', '=', $attendance_date)
            ->where('subject_id', '=', $subject_id)
            ->first();
    }

    public static function getRecord($remove_pagination = 0)
    {
        $return = StudentAttendanceModel::select(
            'student_attendance.*',
            'class.name as class_name',
            'student.name as student_name',
            'student.last_name as student_last_name',
            'created_by.name as created_name',
            'subject.name as subject_name'
        )
            ->join('class', 'class.id', '=', 'student_attendance.class_id')
            ->join('users as student', 'student.id', '=', 'student_attendance.student_id')
            ->join('users as created_by', 'created_by.id', '=', 'student_attendance.created_by')
            ->join('subject', 'subject.id', '=', 'student_attendance.subject_id');

        if (!empty(Request::get('student_id'))) {
            $return = $return->where('student_attendance.student_id', '=', Request::get('student_id'));
        }

        if (!empty(Request::get('student_name'))) {
            $return = $return->where('student.name', 'like', '%' . Request::get('student_name') . '%');
        }

        if (!empty(Request::get('student_last_name'))) {
            $return = $return->where('student.last_name', 'like', '%' . Request::get('student_last_name') . '%');
        }

        if (!empty(Request::get('class_id'))) {
            $return = $return->where('student_attendance.class_id', '=', Request::get('class_id'));
        }

        if (!empty(Request::get('subject_id'))) {
            $return = $return->where('student_attendance.subject_id', '=', Request::get('subject_id'));
        }

        if (!empty(Request::get('start_attendance_date'))) {
            $return = $return->where('student_attendance.attendance_date', '>=', Request::get('start_attendance_date'));
        }

        if (!empty(Request::get('end_attendance_date'))) {
            $return = $return->where('student_attendance.attendance_date', '<=', Request::get('end_attendance_date'));
        }

        if (!empty(Request::get('attendance_type'))) {
            $return = $return->where('student_attendance.attendance_type', '=', Request::get('attendance_type'));
        }
        $return = $return->orderBy('student_attendance.attendance_date', 'asc');

        if (!empty($remove_pagination)) {
            $return = $return->get();
        } else {
            $return = $return->paginate(10);
        }
        return $return;
    }

    public static function getRecordTeacher($class_ids)
    {
        if (!empty($class_ids)) {
            $return = StudentAttendanceModel::select(
                'student_attendance.*',
                'class.name as class_name',
                'student.name as student_name',
                'student.last_name as student_last_name',
                'created_by.name as created_name',
                'subject.name as subject_name'
            )
                ->join('class', 'class.id', '=', 'student_attendance.class_id')
                ->join('users as student', 'student.id', '=', 'student_attendance.student_id')
                ->join('users as created_by', 'created_by.id', '=', 'student_attendance.created_by')
                ->join('subject', 'subject.id', '=', 'student_attendance.subject_id')
                ->whereIn('student_attendance.class_id', $class_ids);

            if (!empty(Request::get('student_id'))) {
                $return = $return->where('student_attendance.student_id', '=', Request::get('student_id'));
            }

            if (!empty(Request::get('student_name'))) {
                $return = $return->where('student.name', 'like', '%' . Request::get('student_name') . '%');
            }

            if (!empty(Request::get('student_last_name'))) {
                $return = $return->where('student.last_name', 'like', '%' . Request::get('student_last_name') . '%');
            }

            if (!empty(Request::get('class_id'))) {
                $return = $return->where('student_attendance.class_id', '=', Request::get('class_id'));
            }

            if (!empty(Request::get('subject_id'))) {
                $return = $return->where('student_attendance.subject_id', '=', Request::get('subject_id'));
            }

            if (!empty(Request::get('start_attendance_date'))) {
                $return = $return->where('student_attendance.attendance_date', '>=', Request::get('start_attendance_date'));
            }

            if (!empty(Request::get('end_attendance_date'))) {
                $return = $return->where('student_attendance.attendance_date', '<=', Request::get('end_attendance_date'));
            }

            if (!empty(Request::get('attendance_type'))) {
                $return = $return->where('student_attendance.attendance_type', '=', Request::get('attendance_type'));
            }

            $return = $return->orderBy('student_attendance.attendance_date', 'asc')
            ->paginate(10);
            return $return;
        } else {
            return "";
        }
    }

    public static function getRecordStudent($student_id)
    {
        $return = StudentAttendanceModel::select(
            'student_attendance.*',
            'class.name as class_name',
            'subject.name as subject_name'
        )
            ->join('class', 'class.id', '=', 'student_attendance.class_id')
            // ->join('users as student', 'student.id', '=', 'student_attendance.student_id')
            ->join('subject', 'subject.id', '=', 'student_attendance.subject_id')
            ->where('student_attendance.student_id', '=', $student_id);

        if (!empty(Request::get('class_id'))) {
            $return = $return->where('student_attendance.class_id', '=', Request::get('class_id'));
        }

        if (!empty(Request::get('subject_id'))) {
            $return = $return->where('student_attendance.subject_id', '=', Request::get('subject_id'));
        }

        if (!empty(Request::get('start_attendance_date'))) {
            $return = $return->where('student_attendance.attendance_date', '>=', Request::get('start_attendance_date'));
        }

        if (!empty(Request::get('end_attendance_date'))) {
            $return = $return->where('student_attendance.attendance_date', '<=', Request::get('end_attendance_date'));
        }

        if (!empty(Request::get('attendance_type'))) {
            $return = $return->where('student_attendance.attendance_type', '=', Request::get('attendance_type'));
        }

        $return = $return->orderBy('student_attendance.id', 'desc')
            ->paginate(10);
        return $return;
    }

    public static function getRecordStudentCount($student_id)
    {
        $return = StudentAttendanceModel::select(
            'student_attendance.id'
        )
            ->join('class', 'class.id', '=', 'student_attendance.class_id')
            // ->join('users as student', 'student.id', '=', 'student_attendance.student_id')
            ->join('subject', 'subject.id', '=', 'student_attendance.subject_id')
            ->where('student_attendance.student_id', '=', $student_id);

        $return = $return->orderBy('student_attendance.id', 'desc')
            ->count();
        return $return;
    }

    public static function getRecordStudentParentCount($student_ids)
    {
        $return = StudentAttendanceModel::select(
            'student_attendance.id'
        )
            ->join('class', 'class.id', '=', 'student_attendance.class_id')
            // ->join('users as student', 'student.id', '=', 'student_attendance.student_id')
            ->join('subject', 'subject.id', '=', 'student_attendance.subject_id')
            ->whereIn('student_attendance.student_id', $student_ids);

        $return = $return->orderBy('student_attendance.id', 'desc')
            ->count();
        return $return;
    }

    public static function getRecordParent($student_id)
    {
        $return = StudentAttendanceModel::select(
            'student_attendance.*',
            'class.name as class_name',
            'subject.name as subject_name'
        )
            ->join('class', 'class.id', '=', 'student_attendance.class_id')
            // ->join('users as student', 'student.id', '=', 'student_attendance.student_id')
            ->join('subject', 'subject.id', '=', 'student_attendance.subject_id')
            ->where('student_attendance.student_id', '=', $student_id);

        if (!empty(Request::get('class_id'))) {
            $return = $return->where('student_attendance.class_id', '=', Request::get('class_id'));
        }

        if (!empty(Request::get('subject_id'))) {
            $return = $return->where('student_attendance.subject_id', '=', Request::get('subject_id'));
        }

        if (!empty(Request::get('start_attendance_date'))) {
            $return = $return->where('student_attendance.attendance_date', '>=', Request::get('start_attendance_date'));
        }

        if (!empty(Request::get('end_attendance_date'))) {
            $return = $return->where('student_attendance.attendance_date', '<=', Request::get('end_attendance_date'));
        }

        if (!empty(Request::get('attendance_type'))) {
            $return = $return->where('student_attendance.attendance_type', '=', Request::get('attendance_type'));
        }

        $return = $return->orderBy('student_attendance.id', 'desc')
            ->paginate(10);
        return $return;
    }

    public static function getClassStudent($student_id)
    {
        return StudentAttendanceModel::select('student_attendance.*', 'class.name as class_name', 'subject.name as subject_name')
            ->join('class', 'class.id', '=', 'student_attendance.class_id')
            // ->join('users as student', 'student.id', '=', 'student_attendance.student_id')
            ->join('subject', 'subject.id', '=', 'student_attendance.subject_id')
            ->where('student_attendance.student_id', '=', $student_id)
            ->groupBy('student_attendance.class_id')
            ->get();
    }
}
