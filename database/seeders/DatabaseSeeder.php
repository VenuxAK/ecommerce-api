<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
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
        // ProductType::truncate();
        // Product::truncate();
        // Order::truncate();
        // OrderItem::truncate();
        // User::truncate();
        $this->call([
            /** First Run */
            // CategorySeeder::class,
            // ProductTypeSeeder::class,
            // ProductSeeder::class,

            /** Second Run */
            // User::factory(5)->create()

            /** Third Run */
            // OrderItemSeeder::class,
            // OrderSeeder::class,
        ]);
    }
}
