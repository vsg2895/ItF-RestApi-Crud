<?php

namespace App\Http\Requests\PhoneBook;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Response;

class UpdatePhoneBookRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'phone_number' => ['required', 'regex:/^(\+\d{1,3}[- ]?)?\d{12}$/'],
            'country_code' => ['required', 'string'],
            'timezone_name' => ['required'],
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        Response::exception($validator->errors(), 'Validation errors');
    }
}
