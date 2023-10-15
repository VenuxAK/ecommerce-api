<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductType;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Category::truncate();
        // ProductImage::truncate();
        // ProductType::truncate();
        // Product::truncate();
        // Order::truncate();
        // OrderItem::truncate();
        // User::truncate();
        // ProductImage::truncate();
        $this->call([
            /** First create your own 10 category with thumbnail */

            /** First Run */
            // CategorySeeder::class,
            // ProductTypeSeeder::class,
            // ProductSeeder::class,
            // ProductImageSeeder::class,

            /** Second Run */
            // User::factory(5)->create(),

            /** Third Run */
            // OrderItemSeeder::class,
            // OrderSeeder::class,
        ]);
    }
}
