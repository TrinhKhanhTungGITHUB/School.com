<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ClassListRequest extends FormRequest
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
            'name' => [
                'nullable',
                'string',
                'max:30'
            ],
            'status' => [
                'nullable',
                'integer',
                'in:0,1',
            ],
            'amount' => [
                'nullable',
                'integer',
                'gt:0',
                'lt:999999',
            ],
            'name_sort' => 'nullable|in:asc,desc',
            'amount_sort' => 'nullable|in:asc,desc',
            'date_sort' => 'nullable|in:asc,desc',
            'paginate' => 'nullable|integer|min:1',
        ];
    }
}
