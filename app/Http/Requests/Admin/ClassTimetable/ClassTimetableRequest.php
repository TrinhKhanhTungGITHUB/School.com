<?php

namespace App\Http\Requests\Admin\ClassTimetable;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClassTimetableRequest extends FormRequest
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
           'timetable' => 'required|array',
            'timetable.*' => [
                'array',
                'required',
                'distinct',
            ],
            'timetable.*.week_id' => 'required|integer',
            'timetable.*.start_time' => 'nullable|date_format:H:i',
            'timetable.*.end_time' => [
                'nullable',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    $startAttribute = str_replace('end_time', 'start_time', $attribute);
                    $startTime = $this->input($startAttribute);

                    // if ($startTime && strtotime($value) <= strtotime($startTime)) {
                    //     $fail("The $attribute must be greater than start_time.");
                    // }
                },
            ],
            // 'timetable.*.room_number' => 'nullable|string',
        ];
    }
}
