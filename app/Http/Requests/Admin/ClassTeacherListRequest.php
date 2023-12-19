<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ClassTeacherListRequest extends FormRequest
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
            'class_name' => 'nullable',
            'teacher_name' => 'nullable',
            'teacher_last_name' => 'nullable',
            'created_by' => 'nullable',
            'status' => 'nullable|in:1,100',
            'date' => 'date|nullable',
            'class_name_sort' => 'nullable|in:asc,desc',
            'teacher_name_sort' => 'nullable|in:asc,desc',
            'teacher_last_name_sort' => 'nullable|in:asc,desc',
            'created_by_sort' => 'nullable|in:asc,desc',
            'email_sort' => 'nullable|in:asc,desc',
            'date_sort' => 'nullable|in:asc,desc',
            'paginate' => 'nullable|integer|min:1',
        ];
    }
}
