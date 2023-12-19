<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeworkRequest extends FormRequest
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
            'class_id' => ['required','integer'],
            'subject_id' => ['required','integer'],
            'homework_date' => ['required','date'],
            'submission_date' => ['required','date','after_or_equal:homework_date'],
            'description' => ['required','string'],
            'document_file' => ['nullable', 'file'],
        ];
    }
}
