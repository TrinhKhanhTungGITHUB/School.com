<?php

namespace App\Http\Requests\Admin\Student;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'admission_number' =>[
                'required','numeric'
            ],
            'rol_number' =>[
                'nullable','numeric'
            ],
            'class_id' =>[
                'required','integer'
            ],
            'gender' =>[
                'required',
                'in:Male,Female,Other',
            ],
            'date_of_birth' =>[
                'required','date'
            ],
            'profile_pic' =>[
                'nullable',
                'mimes:jpg,png,jpeg',
                'max:2048',
            ],
            'caste' =>[
                'nullable','max:50'
            ],
            'religion' =>[
                'nullable','max:50'
            ],
            'mobile_number' =>[
                'nullable','regex:/^[0-9]{10}$/',
            ],
            'admission_date' =>[
                'required','date'
            ],
            'blood_group' =>[
                'nullable',
                'string','max:10'
            ],
            'height' =>[
                'nullable',
                'integer',
                'between:0,300',
            ],
            'weight' =>[
                'nullable',
                'integer',
                'between:0,300',
            ],
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
