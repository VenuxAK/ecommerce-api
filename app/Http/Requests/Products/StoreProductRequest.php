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
        $this->only(['name', 'description', 'price', 'stock_quantity', 'category_id', 'images']);

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
            "product_type_id" => [
                "required", "numeric", Rule::exists('product_types', 'id')
            ],
            "images" => [
                "required"
            ]
        ];
    }

    public function messages()
    {
        return [
            "name.unique" => "The selected name has already been used.",
            "product_type_id.exists" => "The selected product type doesn't exist."
        ];
    }
}
