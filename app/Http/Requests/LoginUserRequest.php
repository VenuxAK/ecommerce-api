<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginUserRequest extends FormRequest
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
            "email" => ["required", "email", "string", "max:150", Rule::exists('users', 'email')],
            "password" => ["required", "max:255", "string"]
        ];
    }

    public function messages(): array
    {
        return [
            "email.exists" => "Your email address has not registered yet."
        ];
    }
}
