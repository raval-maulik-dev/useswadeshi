<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Indian brands
        $indianBrands = [
            'Amul',
            'Tata',
            'Reliance',
            'Mahindra',
            'Bajaj',
            'Hero',
            'Maruti',
            'HCL',
            'Infosys',
            'Wipro',
        ];

        foreach ($indianBrands as $brandName) {
            Brand::create([
                'name' => $brandName,
                'origin_country' => 'India',
            ]);
        }

        // Create foreign brands
        $foreignBrands = [
            'Apple' => 'USA',
            'Samsung' => 'South Korea',
            'Nike' => 'USA',
            'Adidas' => 'Germany',
            'Toyota' => 'Japan',
            'Honda' => 'Japan',
            'BMW' => 'Germany',
            'Mercedes' => 'Germany',
            'Sony' => 'Japan',
            'LG' => 'South Korea',
        ];

        foreach ($foreignBrands as $brandName => $country) {
            Brand::create([
                'name' => $brandName,
                'origin_country' => $country,
            ]);
        }

        // Create additional random brands
        Brand::factory(20)->create();
    }
}
