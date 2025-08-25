<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gujarat = State::where('name', 'Gujarat')->first();

        if (! $gujarat) {
            $this->command->error('Gujarat not found in states table. Please run StateSeeder first.');

            return;
        }

        $gujaratCities = [
            'Ahmedabad', 'Mehsana', 'Surat', 'Rajkot', 'Vadodara',
            'Bhavnagar', 'Jamnagar', 'Junagadh', 'Gandhinagar', 'Valsad', 'Navsari',
        ];

        foreach ($gujaratCities as $cityName) {
            City::firstOrCreate(
                [
                    'state_id' => $gujarat->id,
                    'name' => $cityName,
                ],
                [
                    'state_id' => $gujarat->id,
                    'name' => $cityName,
                ]
            );
        }
    }
}
