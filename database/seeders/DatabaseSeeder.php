<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed users first (so we have organization reference)
        $this->call([
            UserSeeder::class,
            InspectionTypeSeeder::class,
            ComponentSeeder::class,
        ]);
    }
}
