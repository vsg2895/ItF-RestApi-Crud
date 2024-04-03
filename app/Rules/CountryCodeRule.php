<?php

namespace App\Rules;

use Facades\App\Services\ExternalApiService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CountryCodeRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $data = ExternalApiService::getData('country_codes');
        if (!array_key_exists($value, $data)) {
            $fail('Country code is incorrect');
        }
    }
}
