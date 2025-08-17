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
        // User::factory(10)->create();

        $this->call([
            LocationSeeder::class,
            AttentionSeeder::class, // <-- Verifica que esta línea exista
            ReasonSeeder::class,
            LineInfoSeeder::class, // <-- Añade esta línea
            SubscriptionPlanSeeder::class,
            RoleAndUserSeeder::class, // <-- Añade esta línea
        ]);
    }
}
