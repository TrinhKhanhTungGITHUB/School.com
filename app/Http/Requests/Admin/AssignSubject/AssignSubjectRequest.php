<?php

namespace App\Http\Requests\Admin\AssignSubject;

use Illuminate\Foundation\Http\FormRequest;

class AssignSubjectRequest extends FormRequest
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
            'class_id' => ['required' , 'integer'],
            'subject_id' => ['required' , 'array'],
            'subject_id.*' => ['required' , 'integer'],
            'status' => [
                'required',
                'integer',
                'in:0,1',
            ],
        ];
    }
}