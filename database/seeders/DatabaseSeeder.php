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
            GameQuestionSeeder::class,
            GameOptionSeeder::class,
            GameResultSeeder::class,
            ProductAlternativeSeeder::class,
            ArticleSeeder::class,
        ]);
    }
}
