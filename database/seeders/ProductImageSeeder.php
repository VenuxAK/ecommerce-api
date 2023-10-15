<?php

namespace Database\Seeders;

use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // end point
        // $endpoint = "https://random.imagecdn.app/500/";
        // for ($i = 0; $i < 50; $i++) {
        //     for ($x = 0; $x < 4; $x++) {
        //         $img = $endpoint . random_int(1, 500);
        //         $path = Storage::put("products", $img, ["disks" => "eStore_images"]);
        //         ProductImage::factory()->create([
        //             "product_id" => $i + 1,
        //             "image_path" => $path
        //         ]);
        //     }
        // }
    }
}
