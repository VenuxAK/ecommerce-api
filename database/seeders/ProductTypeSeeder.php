<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Men's Fashion
        $men_fashion  = ["Pants", "Sneakers", "Shoes", "Bags", "Shirts", "Hoddies and Sweatshirts"];
        foreach ($men_fashion as $men) {
            ProductType::factory()->create([
                "name" => $men,
                "slug" => str()->slug($men),
                "category_id" => 1
            ]);
        }

        // Women's Fashion
        $women_fashion = ["Rompers Dress", "Bodysuits Skirt", "Pants and Capris Jeans"];
        foreach ($women_fashion as $women) {
            ProductType::factory()->create([
                "name" => $women,
                "slug" => str()->slug($women),
                "category_id" => 2
            ]);
        }

        // Computer
        $computer = ["Headphones", "PC", "Laptop"];
        foreach ($computer as $item) {
            ProductType::factory()->create([
                "name" => $item,
                "slug" => str()->slug($item),
                "category_id" => 3
            ]);
        }

        // Mobile
        $mobiles = ["iPhone", "Samsung", "Xiao Mi"];
        foreach ($mobiles as $item) {
            ProductType::factory()->create([
                "name" => $item,
                "slug" => str()->slug($item),
                "category_id" => 4
            ]);
        }
    }
}
