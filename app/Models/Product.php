<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ["name", "slug", "description", "product_type_id", "price", "stock_quantity"];


    public function scopeFilter($query, $filter)
    {
        $query->when($filter["search"] ?? false, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where("name", "LIKE", "%" . $search . "%")
                    ->orWhere("description", "LIKE", "%" . $search . "%");
            });
        });
        $query->when($filter["min_price"] ?? false, function ($query, $min_price) {
            $query->where("price", ">=", $min_price);
        });
        $query->when($filter["max_price"] ?? false, function ($query, $max_price) {
            $query->where("price", "<=", $max_price);
        });
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, "product_id");
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    // public function category()
    // {
    //     return $this->belongsTo(Category::class);
    // }

    public function orderItem()
    {
        return $this->hasOne(OrderItem::class);
    }
}
