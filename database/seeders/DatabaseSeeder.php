<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Category::truncate();
        // Product::truncate();
        // Order::truncate();
        // OrderItem::truncate();
        $this->call([
            // CategorySeeder::class,
            // ProductSeeder::class,
            // OrderSeeder::class,
            // OrderItemSeeder::class,
        ]);
    }
}
