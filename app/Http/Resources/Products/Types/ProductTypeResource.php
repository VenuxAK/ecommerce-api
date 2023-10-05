<?php

namespace App\Http\Resources\Products\Types;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "type" => $this->name,
            "products" => $this->products->map(function ($product) {
                return [
                    "id" => $product->id,
                    "name" => $product->name,
                    "slug" => $product->slug,
                    "description" => $product->description,
                    "price" => $product->price,
                    "stock_quantity" => $product->stock_quantity
                ];
            })
        ];
    }
}
