<?php

namespace App\Http\Resources\Categories;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "name" => $this->name,
            "slug" => $this->slug,
            "description" => $this->description,
            "products" => $this->products->map(function ($product) {
                return [
                    "name" => $product->name,
                    "slug" => $product->slug,
                    "description" => $product->description,
                    "price" => $product->price,
                    "stock_quantity" => $product->stock_quantity,
                ];
            })
            // "products" => array_map(function ($product) {
            //     return [
            //         "name" => $product->name,
            //         "slug" => $product->slug,
            //         "description" => $product->description,
            //         "price" => $product->price,
            //         "stock_quantity" => $product->stock_quantity,
            //     ];
            // }, $this->products)
        ];
    }
}
