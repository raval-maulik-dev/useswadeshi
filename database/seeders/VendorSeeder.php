<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create vendors for existing users with vendor role
        $vendorUsers = User::where('role', 'vendor')->get();

        foreach ($vendorUsers as $user) {
            Vendor::create([
                'name' => 'Swadeshi Vendor Store',
                'description' => 'Authentic Indian products vendor',
                'logo' => null,
                'website' => 'https://swadeshivendor.com',
                'contact_email' => $user->email,
                'contact_phone' => $user->phone,
            ]);
        }

        // Create realistic Indian vendors
        $indianVendors = [
            [
                'name' => 'Swadeshi Mart',
                'description' => 'Premium Indian products marketplace',
                'website' => 'https://swadeshimart.com',
                'contact_email' => 'info@swadeshimart.com',
                'contact_phone' => '+91-9876543210',
            ],
            [
                'name' => 'Desi Dukaan',
                'description' => 'Traditional Indian goods and handicrafts',
                'website' => 'https://desidukaan.in',
                'contact_email' => 'hello@desidukaan.in',
                'contact_phone' => '+91-9876543211',
            ],
            [
                'name' => 'Bharat Bazaar',
                'description' => 'One-stop shop for Indian products',
                'website' => 'https://bharatbazaar.co.in',
                'contact_email' => 'contact@bharatbazaar.co.in',
                'contact_phone' => '+91-9876543212',
            ],
            [
                'name' => 'Local Pride Store',
                'description' => 'Supporting local artisans and craftsmen',
                'website' => 'https://localpride.in',
                'contact_email' => 'support@localpride.in',
                'contact_phone' => '+91-9876543213',
            ],
            [
                'name' => 'Indian Heritage Shop',
                'description' => 'Preserving Indian cultural heritage through products',
                'website' => 'https://indianheritage.shop',
                'contact_email' => 'info@indianheritage.shop',
                'contact_phone' => '+91-9876543214',
            ],
            [
                'name' => 'Swadeshi Corner',
                'description' => 'Curated collection of Indian brands',
                'website' => 'https://swadeshicorner.com',
                'contact_email' => 'hello@swadeshicorner.com',
                'contact_phone' => '+91-9876543215',
            ],
            [
                'name' => 'Desi Essentials',
                'description' => 'Daily essentials made in India',
                'website' => 'https://desiessentials.in',
                'contact_email' => 'contact@desiessentials.in',
                'contact_phone' => '+91-9876543216',
            ],
            [
                'name' => 'Bharat Products Hub',
                'description' => 'Hub for authentic Indian products',
                'website' => 'https://bharatproductshub.com',
                'contact_email' => 'info@bharatproductshub.com',
                'contact_phone' => '+91-9876543217',
            ],
            [
                'name' => 'Local Artisan Market',
                'description' => 'Direct from artisans to customers',
                'website' => 'https://localartisanmarket.in',
                'contact_email' => 'hello@localartisanmarket.in',
                'contact_phone' => '+91-9876543218',
            ],
            [
                'name' => 'Swadeshi Lifestyle',
                'description' => 'Lifestyle products with Indian values',
                'website' => 'https://swadeshilifestyle.com',
                'contact_email' => 'contact@swadeshilifestyle.com',
                'contact_phone' => '+91-9876543219',
            ],
        ];

        foreach ($indianVendors as $vendorData) {
            Vendor::create([
                'name' => $vendorData['name'],
                'description' => $vendorData['description'],
                'logo' => null, // Will be handled by frontend
                'website' => $vendorData['website'],
                'contact_email' => $vendorData['contact_email'],
                'contact_phone' => $vendorData['contact_phone'],
            ]);
        }
    }
}
