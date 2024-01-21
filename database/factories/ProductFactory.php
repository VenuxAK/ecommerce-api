<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->sentence(3);
        return [
            'name' => $name,
            'slug' => str()->slug($name),
            'description' => fake()->paragraph(2),
            'price' => fake()->randomFloat(2, 10, 100, 500, 1000),
            'stock_quantity' => fake()->numberBetween(5, 50),
            'product_type_id' => fake()->numberBetween(1, 20),
        ];
    }
}
