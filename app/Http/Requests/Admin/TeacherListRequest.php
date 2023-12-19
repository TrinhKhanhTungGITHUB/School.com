<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TeacherListRequest extends FormRequest
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
            'email' => 'nullable',
            'gender' => 'nullable|in:Male,Female,Other',
            'mobile' => 'nullable',
            'marital_status' => 'nullable',
            'curent_address' => 'nullable',
            'date_of_joining' => 'date|nullable',
            'status' => 'nullable|in:1,100',
            'created_date' => 'date|nullable',
            'name_sort' => 'nullable|in:asc,desc',
            'last_name_sort' => 'nullable|in:asc,desc',
            'email_sort' => 'nullable|in:asc,desc',
            'date_of_join_sort' => 'nullable|in:asc,desc',
            'created_date_sort' => 'nullable|in:asc,desc',
            'paginate' => 'nullable|integer|min:1',
        ];
    }
}
