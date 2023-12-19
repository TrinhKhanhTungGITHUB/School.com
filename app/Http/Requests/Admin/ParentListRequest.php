<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ParentListRequest extends FormRequest
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
            'email' => 'nullable',
            'gender' => 'nullable|in:Male,Female,Other',
            'phone' => 'nullable',
            'occupation' => 'nullable',
            'address' => 'nullable',
            'status' => 'nullable|in:100,1',
            'created_at' => 'nullable|date',
            'name_sort' => 'nullable|in:asc,desc',
            'last_name_sort' => 'nullable|in:asc,desc',
            'email_sort' => 'nullable|in:asc,desc',
            'date_sort' => 'nullable|in:asc,desc',
            'paginate' => 'nullable|integer|min:1',
        ];
    }
}
