<?php

namespace App\Rules;

use Closure;
use Facades\App\Services\ExternalApiService;
use Illuminate\Contracts\Validation\ValidationRule;

class TimezoneRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $data = ExternalApiService::getData('timezone');
        if (!in_array($value, $data)) {
            $fail('Timezone is incorrect');
        }
    }
}
