<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;

    protected $fillable = ["name", "slug", "category_id"];
    protected $with = ["category"];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
