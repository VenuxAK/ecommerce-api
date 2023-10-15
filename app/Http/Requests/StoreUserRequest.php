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
            "email" => ["required", "email", "string", "max:150", Rule::unique('users', 'email')],
            "password" => ["required", "min:6", "max:255"]
        ];
    }

    public function messages(): array
    {
        return [
            "email.unique" => "Your email address has already been used."
        ];
    }
}
