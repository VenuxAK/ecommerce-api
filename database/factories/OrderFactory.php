<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(1, 5), // Assuming users have IDs from 1 to 5
            'order_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'total_amount' => fake()->randomFloat(2, 10, 500),
            'status' => fake()->randomElement(['pending', 'shipped', 'delivered', 'cancelled']),
        ];
    }
}
