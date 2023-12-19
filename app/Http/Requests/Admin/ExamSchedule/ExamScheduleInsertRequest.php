<?php

namespace App\Http\Requests\Admin\ExamSchedule;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExamScheduleInsertRequest extends FormRequest
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
            // 'exam_id' => 'required|integer',
            // 'class_id' => 'required|integer',
            // 'schedule.*' => [
            //     'nullable',
            //     'array',
            // ],
            // 'schedule.*.subject_id' => 'required|integer',
            // 'schedule.*.exam_date' => 'required|date',
            // 'schedule.*.start_time' => 'required|date_format:H:i',
            // 'schedule.*.end_time' => 'required|date_format:H:i',
            // 'schedule.*.room_number' => 'required|string',
            // 'schedule.*.full_marks' => 'required|integer',
            // 'schedule.*.passing_marks' => 'required|integer',

        ];
    }
}
