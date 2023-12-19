<?php

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceSubmitRequest extends FormRequest
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
            "student_id" => ["required","integer"],
            "attendance_type" => ["required","integer", "in:1,2,3,4"],
            "class_id" => ["required", "integer"],
            "attendance_date" => ["required","date"],
        ];
    }
}
