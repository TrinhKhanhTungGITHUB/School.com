<?php

namespace App\Http\Requests\Admin\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required','string','max:255'
            ],
            'last_name' =>[
                'required','string','max:255'
            ],
            'gender' =>[
                'required',
                'in:Male,Female,Other',
            ],
            'date_of_birth' =>[
                'required','date'
            ],
            'admission_date' =>[
                'required','date'
            ],
            'mobile_number' =>[
                'nullable','regex:/^[0-9]{10}$/',
            ],
            'marital_status' =>[
                'nullable',
                'string', 'max:50',
            ],
            'profile_pic' =>[
                'nullable',
                'mimes:jpg,png,jpeg',
                'max:2048',
            ],
            'address' => [
                'required',
                'string', 'max:100',
            ],
            'permanent_address' => 'nullable',
            'qualification' => 'nullable',
            'work_experience' => 'nullable',
            'note' => 'nullable',
            'status' =>[
                'required',
                'integer',
                'in:0,1',
            ],
            'email' =>[
                'required','email','unique:users'
            ],
            'password' =>[
                'required','min:6'
            ],

        ];
    }
}
