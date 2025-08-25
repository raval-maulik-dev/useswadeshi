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
            ['name' => 'India', 'code' => 'IN'],
            ['name' => 'United States', 'code' => 'US'],
            ['name' => 'United Kingdom', 'code' => 'GB'],
            ['name' => 'Canada', 'code' => 'CA'],
            ['name' => 'Australia', 'code' => 'AU'],
            ['name' => 'Germany', 'code' => 'DE'],
            ['name' => 'France', 'code' => 'FR'],
            ['name' => 'Japan', 'code' => 'JP'],
            ['name' => 'China', 'code' => 'CN'],
            ['name' => 'Brazil', 'code' => 'BR'],
            ['name' => 'South Korea', 'code' => 'KR'],
            ['name' => 'Italy', 'code' => 'IT'],
            ['name' => 'Spain', 'code' => 'ES'],
            ['name' => 'Netherlands', 'code' => 'NL'],
            ['name' => 'Switzerland', 'code' => 'CH'],
            ['name' => 'Sweden', 'code' => 'SE'],
            ['name' => 'Norway', 'code' => 'NO'],
            ['name' => 'Denmark', 'code' => 'DK'],
            ['name' => 'Finland', 'code' => 'FI'],
            ['name' => 'Belgium', 'code' => 'BE'],
            ['name' => 'Austria', 'code' => 'AT'],
            ['name' => 'Poland', 'code' => 'PL'],
            ['name' => 'Czech Republic', 'code' => 'CZ'],
            ['name' => 'Hungary', 'code' => 'HU'],
            ['name' => 'Romania', 'code' => 'RO'],
            ['name' => 'Bulgaria', 'code' => 'BG'],
            ['name' => 'Croatia', 'code' => 'HR'],
            ['name' => 'Slovenia', 'code' => 'SI'],
            ['name' => 'Slovakia', 'code' => 'SK'],
            ['name' => 'Lithuania', 'code' => 'LT'],
            ['name' => 'Latvia', 'code' => 'LV'],
            ['name' => 'Estonia', 'code' => 'EE'],
            ['name' => 'Luxembourg', 'code' => 'LU'],
            ['name' => 'Malta', 'code' => 'MT'],
            ['name' => 'Cyprus', 'code' => 'CY'],
            ['name' => 'Greece', 'code' => 'GR'],
            ['name' => 'Portugal', 'code' => 'PT'],
            ['name' => 'Ireland', 'code' => 'IE'],
            ['name' => 'Iceland', 'code' => 'IS'],
        ];

        foreach ($countries as $country) {
            Country::firstOrCreate(
                ['code' => $country['code']],
                $country
            );
        }
    }
}
