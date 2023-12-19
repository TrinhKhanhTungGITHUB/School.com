<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class MyStudentListRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable',
            'last_name' => 'nullable',
            'gender' => 'nullable|in:Male,Female,Other',
            'date_of_birth' => 'date|nullable',
            'class' => 'nullable',
            'email' => 'nullable',
            'name_sort' => 'nullable|in:asc,desc',
            'last_name_sort' => 'nullable|in:asc,desc',
            'date_of_birth_sort' => 'nullable|in:asc,desc',
            'admission_number_sort' => 'nullable|in:asc,desc',
            'email_sort' => 'nullable|in:asc,desc',
            'admission_date_sort' => 'nullable|in:asc,desc',
            'paginate' => 'nullable|integer|min:1',
        ];
    }
}
