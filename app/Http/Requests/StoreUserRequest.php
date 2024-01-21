<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
            "name" => ["required", "string", "min:3", "max:150"],
            "username" => ["required", "string", "min:3", "max:150", Rule::unique('users', 'username')],
            "email" => ["required", "email", "string", "max:150", Rule::unique('users', 'email')],
            "password" => ["required", "string", "min:6", "max:255"],
            "address" => $this->address ? ["string", "max:500"] : [""],
            "phone_no" => $this->phone_no ? ['regex:/^([0-9\s\+\(\)]*)$/', 'min:10', 'max:15', Rule::unique('users', 'phone_no')] : [''],
        ];
    }

    public function messages(): array
    {
        return [
            "email.unique" => "Your email address has already been used.",
            "phone_no.unique" => "Your phone number has already been used.",
            "phone_no.numeric" => "The phone number field must be numbers",
            "phone_no.min" => "The phone number field must be at least 10 digits.",
            "phone_no.max" => "The phone number field must not be greater than 15 digits.",
            "phone_no.regex" => "The phone number field format is invalid."
        ];
    }
}
