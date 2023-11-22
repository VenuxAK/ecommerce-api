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
        $query->when($filter["latest"] ?? false, function ($query, $limit) {
            $query->orderBy("created_at", "desc")->limit($limit);
        });
        $query->when($filter["recommanded"] ?? false, function ($query, $recommanded) {
            $query->inRandomOrder()->limit($recommanded);
        });
        $query->when($filter["related"] ?? false, function ($query, $related) {
            $query->where("product_type_id", $related);
        });
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
        $query->when($filter["price"] ?? false, function ($query, $price) {
            if ($price == "low") {
                $query->orderBy("price", "asc");
            } elseif ($price == "high") {
                $query->orderBy("price", "desc");
            }
        });
        $query->when($filter["limit"] ?? false, function ($query, $limit) {
            $query->limit($limit);
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
