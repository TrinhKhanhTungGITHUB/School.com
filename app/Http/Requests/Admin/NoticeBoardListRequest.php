<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class NoticeBoardListRequest extends FormRequest
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
            'title' => 'nullable',
            'name' => 'nullable',
            'status' => 'nullable|in:1,100',
            'notice_date_from' => 'date|nullable',
            'notice_date_to' => 'date|nullable',
            'publish_date_to' => 'date|nullable',
            'publish_date_from' => 'date|nullable',
            'message_to' =>'nullable|integer',
            'title_sort' => 'nullable|in:asc,desc',
            'notice_date_sort' => 'nullable|in:asc,desc',
            'publish_date_sort' => 'nullable|in:asc,desc',
            'paginate' => 'nullable|integer|min:1',
        ];
    }
}
