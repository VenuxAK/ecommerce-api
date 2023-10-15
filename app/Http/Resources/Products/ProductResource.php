<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            "name" => $this->name,
            "slug" => $this->slug,
            "description" => $this->description,
            "price" => $this->price,
            "stock_quantity" => $this->stock_quantity,
            "product_type" => $this->productType ? $this->productType->name : NULL,
            "category" => $this->productType->category->name,
            "images" => $this->images->map(function ($img) {
                return url("/storage") . "/" . $img->image_path;
            })
        ];
    }
}
