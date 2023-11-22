<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ["name", "slug", "description", "thumbnail"];

    protected function scopeFilter($query, $filter)
    {
        /**
         *  http://localhost:8000/api/v1/categories?products=10
         *  categories
         */
        $query->when($filter["products"] ?? false, function ($query, $products) {
            // $query->
        });
    }

    public function productTypes()
    {
        return $this->hasMany(ProductType::class);
    }
}
