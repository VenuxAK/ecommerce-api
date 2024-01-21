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
            "id" => $this->id,
            "name" => $this->name,
            "slug" => $this->slug,
            "description" => $this->description,
            "types" => $this->productTypes->map(function ($type) {
                return [
                    "name" => $type->name,
                    "slug" => $type->slug,
                    "products" => $type->products->map(function ($product) use ($type) {
                        return [
                            "id" => $product->id,
                            "name" => $product->name,
                            "slug" => $product->slug,
                            "price" => $product->price,
                            "product_type" => $product->name,
                            "product_type_id" => $type->id,
                            "thumbnail" => url("/storage") . "/" . $product->images[0]->image_path,
                        ];
                    })
                ];
            })
        ];
    }
}
