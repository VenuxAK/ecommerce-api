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
            "product_type_id" => $this->productType ? $this->productType->id : NULL,
            "category" => $this->productType->category->name,
            "thumbnail" => url("/storage") . "/" . $this->images[0]->image_path,
            "images" => $this->images->map(function ($img) {
                return url("/storage") . "/" . $img->image_path;
            })
        ];
    }
}
