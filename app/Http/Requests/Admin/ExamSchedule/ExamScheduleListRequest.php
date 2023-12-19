<?php

namespace App\Http\Requests\Admin\ExamSchedule;

use Illuminate\Foundation\Http\FormRequest;

class ExamScheduleListRequest extends FormRequest
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
            'exam_id' => 'nullable|integer',
            'class_id' => 'nullable|integer',
        ];
    }
}
