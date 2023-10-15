<?php

namespace App\Http\Requests\ProductTypes;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductTypeRequest extends FormRequest
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
            "name" => [
                "required", "string", "min:3", "max:255", Rule::unique('product_types', 'name')
            ],
            "category_id" => [
                "required", "numeric", Rule::exists('categories', 'id')
            ]
        ];
    }

    public function messages()
    {
        return [
            "name.unique" => "The selected name has already exists.",
            "category_id.required" => "The category field is required.",
            "category_id.exists" => "The selected category doesn't exists."
        ];
    }
}
