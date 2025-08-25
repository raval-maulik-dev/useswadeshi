<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            ['name' => 'India', 'iso_code' => 'IND'],
            ['name' => 'United States', 'iso_code' => 'USA'],
            ['name' => 'United Kingdom', 'iso_code' => 'GBR'],
            ['name' => 'Canada', 'iso_code' => 'CAN'],
            ['name' => 'Australia', 'iso_code' => 'AUS'],
            ['name' => 'Germany', 'iso_code' => 'DEU'],
            ['name' => 'France', 'iso_code' => 'FRA'],
            ['name' => 'Japan', 'iso_code' => 'JPN'],
            ['name' => 'China', 'iso_code' => 'CHN'],
            ['name' => 'Brazil', 'iso_code' => 'BRA'],
        ];

        foreach ($countries as $country) {
            Country::firstOrCreate(
                ['iso_code' => $country['iso_code']],
                $country
            );
        }
    }
}
