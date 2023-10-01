<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
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
        $this->only(['name', 'description', 'price', 'stock_quantity', 'category_id']);

        return [
            "name" => [
                "required", "string", "min:3", "max:255", Rule::unique('products', 'name')
            ],
            "description" => [
                "required"
            ],
            "price" => [
                "required", "numeric"
            ],
            "stock_quantity" => [
                "required", "numeric"
            ],
            "category_id" => [
                "required", "numeric", Rule::exists('categories', 'id')
            ]
        ];
    }

    public function messages()
    {
        return [
            "name.unique" => "The selected name has already used.",
            "category_id.exists" => "The selected category doesn't exist."
        ];
    }
}
