<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            /** First create your own 10 category with thumbnail */

            /** First Run */
            // CategorySeeder::class,
            // ProductTypeSeeder::class,

            /** Second Run */
            // RoleSeeder::class,
            // User::factory(5)->create(),

            /** Third Run */
            // OrderItemSeeder::class,
            // OrderSeeder::class,
        ]);
    }
}
