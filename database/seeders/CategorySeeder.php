<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $c1 = "Electronic's Accessories";
        // $c2 = "Men's Fashion";
        // $c3 = "Women's Fashion";
        // $c4 = "Kid and Toys";
        // $c5 = "Networking Devices";
        $categories = ["Men's Fashion", "Women's Fashion", "Computer", "Mobile", "Electronic's Accessories", "Kid and Toys", "Networking Devices"];

        for ($i = 0; $i < count($categories); $i++) {
            Category::factory()->create([
                "name" => $categories[$i],
                "slug" => str()->slug($categories[$i])
            ]);
        }
    }
}
