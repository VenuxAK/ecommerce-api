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
            "id" => $this->id,
            "type" => $this->name,
            "category" => $this->category->name,
            "slug" => $this->slug,
            "products" => $this->products->map(function ($product) {
                return [
                    "id" => $product->id,
                    "name" => $product->name,
                    "slug" => $product->slug,
                    "description" => $product->description,
                    "price" => $product->price,
                    "stock_quantity" => $product->stock_quantity,
                    "product_type" => $this->name,
                    "product_type_id" => $this->id,
                    "thumbnail" => url("/storage") . "/" . $product->images[0]->image_path
                ];
            })
        ];
    }
}
