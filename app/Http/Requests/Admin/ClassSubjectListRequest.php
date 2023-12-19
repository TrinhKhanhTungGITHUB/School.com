<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ClassSubjectListRequest extends FormRequest
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
            'subject_name' => 'nullable',
            'date' => 'date|nullable',
            'class_name_sort' => 'nullable|in:asc,desc',
            'subject_name_sort' => 'nullable|in:asc,desc',
            'date_sort' => 'nullable|in:asc,desc',
            'paginate' => 'nullable|integer|min:1',
        ];
    }
}
