<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateTimetableFields implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
          // Kiểm tra nếu có ít nhất một trong 3 trường dữ liệu, thì cả ba trường đều phải có dữ liệu
          if (
            ($value['start_time'] !== null || $value['end_time'] !== null || $value['room_number'] !== null) &&
            ($value['start_time'] === null || $value['end_time'] === null || $value['room_number'] === null)
        ) {
            return false;
        }

        return true;
    }
}
