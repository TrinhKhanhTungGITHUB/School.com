<?php

namespace App\Http\Requests\Admin\Parent;

use Illuminate\Foundation\Http\FormRequest;

class ParentRequest extends FormRequest
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
            'occupation' =>[
                'nullable','string','max:255'
            ],
            'address' =>[
                'required','string','max:255'
            ],
            'gender' =>[
                'required',
                'in:Male,Female,Other',
            ],
            'profile_pic' =>[
                'nullable',
                'mimes:jpg,png,jpeg',
                'max:2048',
            ],
            'mobile_number' =>[
                'required','regex:/^[0-9]{10}$/',
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
