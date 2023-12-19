<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Request;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getAdmin($is_delete)
    {
        $return = self::select('users.*')
            ->where('user_type', '=', 1)
            ->where('is_delete', '=', $is_delete);
        if (!empty(Request::get('name'))) {
            $return = $return->where('name', 'like', '%' . Request::get('name') . '%');
        }
        if (!empty(Request::get('name_sort'))) {
            $return = $return->orderBy('name', Request::get('name_sort'));
        }
        if (!empty(Request::get('email'))) {
            $return = $return->where('email', 'like', '%' . Request::get('email') . '%');
        }
        if (!empty(Request::get('email_sort'))) {
            $return = $return->orderBy('email', Request::get('email_sort'));
        }
        if (!empty(Request::get('date'))) {
            $return = $return->whereDate('created_at', '=', Request::get('date'));
        }
        if (!empty(Request::get('date_sort'))) {
            $return = $return->orderBy('created_at', Request::get('date_sort'));
        }

        return $return;
    }

    static public function getTeacher($is_delete,$remove_pagination =0)
    {
        $return = self::select('users.*')
            ->where('users.user_type', '=', 2)
            ->where('users.is_delete', '=', $is_delete);

        if (!empty(Request::get('name'))) {
            $return = $return->where('users.name', 'like', '%' . Request::get('name') . '%');
        }

        if (!empty(Request::get('name_sort'))) {
            $return = $return->orderBy('users.name', Request::get('name_sort'));
        }

        if (!empty(Request::get('last_name'))) {
            $return = $return->where('users.last_name', 'like', '%' . Request::get('last_name') . '%');
        }

        if (!empty(Request::get('last_name_sort'))) {
            $return = $return->orderBy('users.last_name', Request::get('last_name_sort'));
        }

        if (!empty(Request::get('email'))) {
            $return = $return->where('users.email', 'like', '%' . Request::get('email') . '%');
        }

        if (!empty(Request::get('email_sort'))) {
            $return = $return->orderBy('email', Request::get('email_sort'));
        }

        if (!empty(Request::get('gender'))) {
            $return = $return->where('users.gender', 'like', '%' . Request::get('gender') . '%');
        }

        if (!empty(Request::get('mobile'))) {
            $return = $return->where('users.mobile_number', 'like', '%' . Request::get('mobile') . '%');
        }

        if (!empty(Request::get('marital_status'))) {
            $return = $return->where('users.marital_status', 'like', '%' . Request::get('marital_status') . '%');
        }

        if (!empty(Request::get('address'))) {
            $return = $return->where('users.address', 'like', '%' . Request::get('address') . '%');
        }

        if (!empty(Request::get('status'))) {
            $status = (Request::get('status') == 100) ? 0 : 1;
            $return = $return->where('users.status', '=', $status);
        }

        if (!empty(Request::get('admission_date'))) {
            $return = $return->where('users.admission_date', 'like', '%' . Request::get('admission_date') . '%');
        }

        if (!empty(Request::get('date_of_join_sort'))) {
            $return = $return->orderBy('users.admission_date', Request::get('date_of_join_sort'));
        }

        if (!empty(Request::get('created_date'))) {
            $return = $return->whereDate('users.created_at', '=', Request::get('created_date'));
        }

        if (!empty(Request::get('created_date_sort'))) {
            $return = $return->orderBy('users.created_at', Request::get('created_date_sort'));
        }

        if (!empty($remove_pagination)) {
            $return = $return->get();
        }
        return $return;
    }

    static public function getStudent($is_delete, $remove_pagination = 0)
    {
        $return = self::select('users.*', 'class.name as class_name', 'parent.name as parent_name', 'parent.last_name as parent_last_name')
            ->join('users as parent', 'parent.id', '=', 'users.parent_id', 'left')
            ->join('class', 'class.id', '=', 'users.class_id', 'left')
            ->where('users.user_type', '=', 3)
            ->where('users.is_delete', '=', $is_delete);
        if (!empty(Request::get('name'))) {
            $return = $return->where('users.name', 'like', '%' . Request::get('name') . '%');
        }

        if (!empty(Request::get('name_sort'))) {
            $return = $return->orderBy('users.name', Request::get('name_sort'));
        }

        if (!empty(Request::get('last_name'))) {
            $return = $return->where('users.last_name', 'like', '%' . Request::get('last_name') . '%');
        }

        if (!empty(Request::get('last_name_sort'))) {
            $return = $return->orderBy('users.last_name', Request::get('last_name_sort'));
        }

        if (!empty(Request::get('gender'))) {
            $return = $return->where('users.gender', 'like', '%' . Request::get('gender') . '%');
        }

        if (!empty(Request::get('date_of_birth'))) {
            $return = $return->where('users.date_of_birth', 'like', '%' . Request::get('date_of_birth') . '%');
        }

        if (!empty(Request::get('date_of_birth_sort'))) {
            $return = $return->orderBy('users.date_of_birth', Request::get('date_of_birth_sort'));
        }

        if (!empty(Request::get('class'))) {
            $return = $return->where('users.class_id', 'like', '%' . Request::get('class') . '%');
        }

        if (!empty(Request::get('admission_number'))) {
            $return = $return->where('users.admission_number', 'like', '%' . Request::get('admission_number') . '%');
        }

        if (!empty(Request::get('admission_number_sort'))) {
            $return = $return->orderBy('users.admission_number', Request::get('admission_number_sort'));
        }

        if (!empty(Request::get('roll_number'))) {
            $return = $return->where('users.roll_number', 'like', '%' . Request::get('roll_number') . '%');
        }

        if (!empty(Request::get('email'))) {
            $return = $return->where('users.email', 'like', '%' . Request::get('email') . '%');
        }

        if (!empty(Request::get('email_sort'))) {
            $return = $return->orderBy('users.email', Request::get('email_sort'));
        }


        if (!empty(Request::get('mobile'))) {
            $return = $return->where('users.mobile_number', 'like', '%' . Request::get('mobile') . '%');
        }

        if (!empty(Request::get('admission_date'))) {
            $return = $return->where('users.admission_date', 'like', '%' . Request::get('admission_date') . '%');
        }

        if (!empty(Request::get('admission_date_sort'))) {
            $return = $return->orderBy('users.admission_date', Request::get('admission_date_sort'));
        }

        if (!empty(Request::get('height'))) {
            $return = $return->where('users.height', 'like', '%' . Request::get('height') . '%');
        }

        if (!empty(Request::get('weight'))) {
            $return = $return->where('users.weight', 'like', '%' . Request::get('weight') . '%');
        }

        if (!empty(Request::get('caste'))) {
            $return = $return->where('users.caste', 'like', '%' . Request::get('caste') . '%');
        }

        if (!empty(Request::get('religion'))) {
            $return = $return->where('users.religion', 'like', '%' . Request::get('religion') . '%');
        }

        if (!empty(Request::get('blood_group'))) {
            $return = $return->where('users.blood_group', 'like', '%' . Request::get('blood_group') . '%');
        }

        if (!empty(Request::get('created_date'))) {
            $return = $return->whereDate('users.created_at', '=', Request::get('created_date'));
        }

        if (!empty(Request::get('status'))) {
            $status = (Request::get('status') == 100) ? 0 : 1;
            $return = $return->where('users.status', '=', $status);
        }
        $return = $return->orderBy('users.id', 'desc');

        if (!empty($remove_pagination)) {
            $return = $return->get();
        }
        return $return;
    }

    static public function getParent($is_delete, $remove_pagination =0)
    {
        $return = self::select('users.*')
            ->where('user_type', '=', 4)
            ->where('is_delete', '=', $is_delete);
        if (!empty(Request::get('name'))) {
            $return = $return->where('name', 'like', '%' . Request::get('name') . '%');
        }

        if (!empty(Request::get('name_sort'))) {
            $return = $return->orderBy('name', Request::get('name_sort'));
        }

        if (!empty(Request::get('last_name'))) {
            $return = $return->where('last_name', 'like', '%' . Request::get('last_name') . '%');
        }

        if (!empty(Request::get('last_name_sort'))) {
            $return = $return->orderBy('last_name', Request::get('last_name_sort'));
        }

        if (!empty(Request::get('gender'))) {
            $return = $return->where('gender', 'like', '%' . Request::get('gender') . '%');
        }

        if (!empty(Request::get('phone'))) {
            $return = $return->where('mobile_number', 'like', '%' . Request::get('phone') . '%');
        }

        if (!empty(Request::get('occupation'))) {
            $return = $return->where('occupation', 'like', '%' . Request::get('occupation') . '%');
        }

        if (!empty(Request::get('occupation_sort'))) {
            $return = $return->orderBy('occupation', Request::get('occupation_sort'));
        }

        if (!empty(Request::get('address'))) {
            $return = $return->where('address', 'like', '%' . Request::get('address') . '%');
        }

        if (!empty(Request::get('address_sort'))) {
            $return = $return->orderBy('address', Request::get('address_sort'));
        }

        if (!empty(Request::get('email'))) {
            $return = $return->where('email', 'like', '%' . Request::get('email') . '%');
        }

        if (!empty(Request::get('email_sort'))) {
            $return = $return->orderBy('email', Request::get('email_sort'));
        }

        if (!empty(Request::get('status'))) {
            $status = (Request::get('status') == 100) ? 0 : 1;
            $return = $return->where('users.status', '=', $status);
        }

        if (!empty(Request::get('created_at'))) {
            $return = $return->whereDate('created_at', '=', Request::get('created_at'));
        }

        if (!empty(Request::get('date_sort'))) {
            $return = $return->orderBy('created_at', Request::get('date_sort'));
        }

        if (!empty($remove_pagination)) {
            $return = $return->get();
        }
        return $return;
    }

    // Attendance Admin
    static public function getStudentClassSubject($class_id, $subject_id, $paginate=0)
    {
         $return = self::select('users.id', 'users.name', 'users.last_name', 'class.name as class_name', 'subject.name as subject_name')
            ->join('class_subject', 'class_subject.class_id', '=', 'users.class_id')
            ->join('subject', 'subject.id', '=', 'class_subject.subject_id')
            ->join('class', 'class.id', '=', 'users.class_id')
            ->where('users.user_type', '=', 3)
            ->where('users.is_delete', '=', 0)
            ->where('class_subject.is_delete', '=', 0)
            ->where('class_subject.status', '=', 0)
            ->where('subject.is_delete', '=', 0)
            ->where('subject.status', '=', 0)
            ->where('users.class_id', '=', $class_id)
            ->where('subject.id', '=', $subject_id)
            ->orderBy('users.id', 'desc');
        if($paginate == 1)
        {
            return $return->paginate(10);
        }
         else
         {
            return $return->get();
         }
    }

    static public function getAttendance($student_id, $class_id, $attendance_date, $subject_id)
    {
        return StudentAttendanceModel::CheckAlreadyAttendance($student_id, $class_id, $attendance_date, $subject_id);
    }

    //
    static public function getTeacherStudent($teacher_id, $is_count = 0)
    {
        $return = self::select($is_count == 1 ? 'users.id' : 'users.*', 'class.name as class_name')
            ->join('class', 'class.id', '=', 'users.class_id')
            ->join('assign_class_teacher', 'assign_class_teacher.class_id', '=', 'class.id')
            ->where('assign_class_teacher.teacher_id', '=', $teacher_id)
            ->where('users.user_type', '=', 3)
            ->where('users.is_delete', '=', 0)
            ->where('users.status', '=', 0)
            ->where('assign_class_teacher.is_delete', '=', 0)
            ->where('assign_class_teacher.status', '=', 0)
            ->where('class.is_delete', '=', 0)
            ->where('class.status', '=', 0);
            if (!empty(Request::get('name'))) {
                $return = $return->where('users.name', 'like', '%' . Request::get('name') . '%');
            }

            if (!empty(Request::get('name_sort'))) {
                $return = $return->orderBy('users.name', Request::get('name_sort'));
            }

            if (!empty(Request::get('last_name'))) {
                $return = $return->where('users.last_name', 'like', '%' . Request::get('last_name') . '%');
            }

            if (!empty(Request::get('last_name_sort'))) {
                $return = $return->orderBy('users.last_name', Request::get('last_name_sort'));
            }

            if (!empty(Request::get('gender'))) {
                $return = $return->where('users.gender', 'like', '%' . Request::get('gender') . '%');
            }

            if (!empty(Request::get('date_of_birth'))) {
                $return = $return->where('users.date_of_birth', 'like', '%' . Request::get('date_of_birth') . '%');
            }

            if (!empty(Request::get('date_of_birth_sort'))) {
                $return = $return->orderBy('users.date_of_birth', Request::get('date_of_birth_sort'));
            }

            if (!empty(Request::get('class'))) {
                $return = $return->where('users.class_id', 'like', '%' . Request::get('class') . '%');
            }

            if (!empty(Request::get('admission_number_sort'))) {
                $return = $return->orderBy('users.admission_number', Request::get('admission_number_sort'));
            }

            if (!empty(Request::get('email'))) {
                $return = $return->where('users.email', 'like', '%' . Request::get('email') . '%');
            }

            if (!empty(Request::get('email_sort'))) {
                $return = $return->orderBy('users.email', Request::get('email_sort'));
            }


            if (!empty(Request::get('admission_date'))) {
                $return = $return->where('users.admission_date', 'like', '%' . Request::get('admission_date') . '%');
            }

            if (!empty(Request::get('admission_date_sort'))) {
                $return = $return->orderBy('users.admission_date', Request::get('admission_date_sort'));
            }

            $return = $return->orderBy('users.id', 'desc');
        if ($is_count == 1) {
            return $return->count();
        }

        return $return->groupBy('users.id');
    }

    static public function getStudentToParent($parent_id)
    {
        return self::select('users.*', 'parent.name as parent_name', 'parent.last_name as parent_last_name')
            ->join('users as parent', 'parent.id', '=', 'users.parent_id', 'left')
            ->where('users.user_type', '=', 3)
            ->where('users.parent_id', '=', $parent_id)
            ->where('users.is_delete', '=', 0)
            ->first();
    }

    static public function getTeacherClass()
    {
        $return = self::select('users.*')
            ->where('users.user_type', '=', 2)
            ->where('users.is_delete', '=', 0)
            ->where('users.status', '=', 0);
        $return = $return->orderBy('users.id', 'desc')
            ->get();
        return $return;
    }

    static public function getClassSingle($class_id)
    {
        return ClassModel::where('id', '=', $class_id)->first();
    }

    static public function getSearchStudent()
    {
        if (!empty(Request::get('id')) || !empty(Request::get('name')) || !empty(Request::get('last_name')) || !empty(Request::get('email'))) {
            $return = self::select('users.*', 'class.name as class_name', 'parent.name as parent_name')
                ->join('users as parent', 'parent.id', '=', 'users.parent_id', 'left')
                ->join('class', 'class.id', '=', 'users.class_id', 'left')
                ->where('users.user_type', '=', 3)
                ->where('users.is_delete', '=', 0);

            if (!empty(Request::get('id'))) {
                $return = $return->where('users.id', '=', Request::get('id'));
            }

            if (!empty(Request::get('name'))) {
                $return = $return->where('users.name', 'like', '%' . Request::get('name') . '%');
            }

            if (!empty(Request::get('last_name'))) {
                $return = $return->where('users.last_name', 'like', '%' . Request::get('last_name') . '%');
            }

            if (!empty(Request::get('email'))) {
                $return = $return->where('users.email', 'like', '%' . Request::get('email') . '%');
            }

            $return = $return->orderBy('users.id', 'desc')
                ->limit(50)
                ->paginate(5);

            return $return;
        }
    }


    static public function getMyStudent($parent_id, $is_count =0)
    {
        $return = self::select('users.*', 'class.name as class_name', 'parent.name as parent_name')
            ->join('users as parent', 'parent.id', '=', 'users.parent_id', 'left')
            ->join('class', 'class.id', '=', 'users.class_id', 'left')
            ->where('users.user_type', '=', 3)
            ->where('users.parent_id', '=', $parent_id)
            ->where('users.is_delete', '=', 0)
            ->orderBy('users.id', 'desc')
            ->get();
        return $return;
    }

    static public function getMyStudentCount($parent_id)
    {
        $return = self::select('users.id')
            ->join('users as parent', 'parent.id', '=', 'users.parent_id', 'left')
            ->join('class', 'class.id', '=', 'users.class_id', 'left')
            ->where('users.user_type', '=', 3)
            ->where('users.parent_id', '=', $parent_id)
            ->where('users.is_delete', '=', 0)
            ->orderBy('users.id', 'desc')
            ->count();
        return $return;
    }

    static public function getMyStudentIds($parent_id)
    {
        $return = self::select('users.id')
            ->join('users as parent', 'parent.id', '=', 'users.parent_id')
            ->join('class', 'class.id', '=', 'users.class_id', 'left')
            ->where('users.user_type', '=', 3)
            ->where('users.parent_id', '=', $parent_id)
            ->where('users.is_delete', '=', 0)
            ->orderBy('users.id', 'desc')
            ->get();
        $student_ids = array();
        foreach ($return as $value) {
            $student_ids[] = $value->id;
        }
        return $student_ids;
    }

    static public function getMyStudentClassIds($parent_id)
    {
        $return = self::select('users.class_id')
            ->join('users as parent', 'parent.id', '=', 'users.parent_id')
            ->join('class', 'class.id', '=', 'users.class_id')
            ->where('users.user_type', '=', 3)
            ->where('users.parent_id', '=', $parent_id)
            ->where('users.is_delete', '=', 0)
            ->orderBy('users.id', 'desc')
            ->get();
        $class_ids = array();
        foreach ($return as $value) {
            $class_ids[] = $value->class_id;
        }
        return $class_ids;
    }

    static public function getPaidAmount($student_id, $class_id)
    {
        return StudentAddFeesModel::getPaidAmount($student_id, $class_id);
    }
    static public function getEmailSingle($email)
    {
        return User::where('email', '=', $email)->first();
    }

    // Dashboard
    static public function getTotalUser($user_type)
    {
        return self::select('users.id')
            ->where('user_type', '=', $user_type)
            ->where('is_delete', '=', 0)
            ->count();
    }

    static public function getSingleClass($id)
    {
        return self::select('users.*', 'class.amount', 'class.name as class_name')
            ->join('class', 'class.id', '=', 'users.class_id')
            ->where('users.id', '=', $id)
            ->where('class.is_delete', '=', 0)
            ->where('class.status', '=', 0)
            ->where('users.status', '=', 0)
            ->first();
    }

    static public function SearchUser($search)
    {
        $return = self::select('users.*')
            ->where(function ($query) use ($search) {
                $query->where('users.name', 'like', '%' . $search . '%')
                    ->orWhere('users.last_name', 'like', '%' . $search . '%');
            })
            ->limit(10)
            ->get();

        return $return;
    }

    // Send Email
    static public function getUserType($user_type)
    {
        return self::select('users.*')
            ->where('user_type', '=', $user_type)
            ->where('is_delete', '=', 0)
            ->where('status', '=', 0)
            ->get();
    }

    static public function getCollectFeesStudent()
    {
        $return = self::select('users.*', 'class.name as class_name', 'class.amount')
            ->join('class', 'class.id', '=', 'users.class_id')
            ->where('users.user_type', '=', 3)
            ->where('users.is_delete', '=', 0);

        if (!empty(Request::get('class_id'))) {
            $return = $return->where('users.class_id', '=', Request::get('class_id'));
        }

        if (!empty(Request::get('student_id'))) {
            $return = $return->where('users.id', '=', Request::get('student_id'));
        }

        if (!empty(Request::get('first_name'))) {
            $return = $return->where('users.name', 'like', '%' . Request::get('first_name') . '%');
        }

        if (!empty(Request::get('last_name'))) {
            $return = $return->where('users.last_name', 'like', '%' . Request::get('last_name') . '%');
        }
        $return = $return->orderBy('users.name', 'asc')
            ->paginate(10);

        return $return;
    }

    static public function getStudentClass($class_id)
    {
        return self::select('users.id', 'users.name', 'users.last_name')
            ->where('users.user_type', '=', 3)
            ->where('users.is_delete', '=', 0)
            ->where('users.class_id', '=', $class_id)
            ->orderBy('users.id', 'desc')
            ->get();
    }
    static public function getTokenSingle($remember_token)
    {
        return User::where('remember_token', '=', $remember_token)->first();
    }

    public function getProfile()
    {
        if (!empty($this->profile_pic)) {
            if ($this->user_type == 2 && file_exists('upload/profile/teacher/' . $this->profile_pic)) {
                return url('upload/profile/teacher/' . $this->profile_pic);
            } else if ($this->user_type == 1 && file_exists('upload/profile/admin/' . $this->profile_pic)) {
                return url('upload/profile/admin/' . $this->profile_pic);
            } else if ($this->user_type == 3 && file_exists('upload/profile/student/' . $this->profile_pic)) {
                return url('upload/profile/student/' . $this->profile_pic);
            } else if ($this->user_type == 4 && file_exists('upload/profile/parent/' . $this->profile_pic)) {
                return url('upload/profile/parent/' . $this->profile_pic);
            } else {
                return url('upload/profile/' . $this->profile_pic);
            }
        } else {
            return "";
        }
    }
}
