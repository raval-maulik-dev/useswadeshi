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
        // Seed in order to maintain foreign key relationships
        $this->call([
            UserSeeder::class,
            CountrySeeder::class,
            StateSeeder::class,
            CitySeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
            VendorSeeder::class,
            ProductSeeder::class,
            GameSeeder::class,
            PledgeSeeder::class,
            // Use the comprehensive GamesMasterSeeder instead of individual game seeders
            \Database\Seeders\Games\GamesMasterSeeder::class,
            GameResultSeeder::class,
            ProductAlternativeSeeder::class,
            ArticleSeeder::class,
        ]);
    }
}
