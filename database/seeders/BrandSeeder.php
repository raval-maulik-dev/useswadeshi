<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Country;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $india = Country::where('code', 'IN')->first();
        $foreignCountries = Country::whereNot('code', 'IN')->get();

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
                'description' => 'Leading Indian brand in their respective industry',
                'country_id' => $india?->id,
            ]);
        }

        // Create foreign brands
        $foreignBrands = [
            'Apple' => 'US',
            'Samsung' => 'KR',
            'Nike' => 'US',
            'Adidas' => 'DE',
            'Toyota' => 'JP',
            'Honda' => 'JP',
            'BMW' => 'DE',
            'Mercedes' => 'DE',
            'Sony' => 'JP',
            'LG' => 'KR',
        ];

        foreach ($foreignBrands as $brandName => $countryCode) {
            $country = $foreignCountries->where('code', $countryCode)->first();
            Brand::create([
                'name' => $brandName,
                'description' => "International brand from {$countryCode}",
                'country_id' => $country?->id,
            ]);
        }

        // Create additional random brands
        Brand::factory(20)->create();
    }
}
