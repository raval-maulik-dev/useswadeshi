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
        // Get countries
        $india = Country::where('code', 'IN')->first();
        $usa = Country::where('code', 'US')->first();
        $uk = Country::where('code', 'GB')->first();
        $germany = Country::where('code', 'DE')->first();
        $japan = Country::where('code', 'JP')->first();
        $southKorea = Country::where('code', 'KR')->first();
        $france = Country::where('code', 'FR')->first();
        $italy = Country::where('code', 'IT')->first();
        $switzerland = Country::where('code', 'CH')->first();
        $netherlands = Country::where('code', 'NL')->first();
        $spain = Country::where('code', 'ES')->first();
        $sweden = Country::where('code', 'SE')->first();
        $denmark = Country::where('code', 'DK')->first();

        // Fashion & Apparel Brands
        $fashionBrands = [
            // Indian Brands
            ['name' => 'Fabindia', 'country_id' => $india->id, 'description' => 'Traditional Indian clothing and home furnishings'],
            ['name' => 'Biba', 'country_id' => $india->id, 'description' => 'Contemporary ethnic wear for women'],
            ['name' => 'W for Woman', 'country_id' => $india->id, 'description' => 'Fashion brand for modern Indian women'],
            ['name' => 'Manyavar', 'country_id' => $india->id, 'description' => 'Traditional Indian menswear'],
            ['name' => 'Raymond', 'country_id' => $india->id, 'description' => 'Premium clothing and textiles'],
            ['name' => 'Bata', 'country_id' => $india->id, 'description' => 'Footwear and accessories'],
            ['name' => 'Khadi', 'country_id' => $india->id, 'description' => 'Handspun and handwoven fabric'],
            ['name' => 'Taneira', 'country_id' => $india->id, 'description' => 'Tata Group ethnic wear brand'],

            // Foreign Brands
            ['name' => 'Nike', 'country_id' => $usa->id, 'description' => 'Global sports and athletic wear'],
            ['name' => 'Adidas', 'country_id' => $germany->id, 'description' => 'Sports and lifestyle footwear'],
            ['name' => 'Zara', 'country_id' => $spain->id, 'description' => 'Fast fashion clothing retailer'],
            ['name' => 'H&M', 'country_id' => $sweden->id, 'description' => 'Fast fashion clothing and accessories'],
            ['name' => 'Uniqlo', 'country_id' => $japan->id, 'description' => 'Casual wear and basics'],
            ['name' => 'Gucci', 'country_id' => $italy->id, 'description' => 'Luxury fashion and accessories'],
            ['name' => 'Louis Vuitton', 'country_id' => $france->id, 'description' => 'Luxury fashion and leather goods'],
        ];

        // Food & Beverages Brands
        $foodBrands = [
            // Indian Brands
            ['name' => 'Amul', 'country_id' => $india->id, 'description' => 'Dairy products and milk'],
            ['name' => 'Britannia', 'country_id' => $india->id, 'description' => 'Biscuits and bakery products'],
            ['name' => 'Parle', 'country_id' => $india->id, 'description' => 'Biscuits, confectionery and beverages'],
            ['name' => 'Haldirams', 'country_id' => $india->id, 'description' => 'Snacks and namkeen'],
            ['name' => 'Dabur', 'country_id' => $india->id, 'description' => 'Ayurvedic and natural products'],
            ['name' => 'Tata Tea', 'country_id' => $india->id, 'description' => 'Tea and beverages'],
            ['name' => 'Mother Dairy', 'country_id' => $india->id, 'description' => 'Dairy products'],
            ['name' => 'Nestle India', 'country_id' => $india->id, 'description' => 'Food and beverage products'],
            ['name' => 'Fortune', 'country_id' => $india->id, 'description' => 'Edible oils and foods (Adani Wilmar)'],
            ['name' => 'Saffola', 'country_id' => $india->id, 'description' => 'Edible oils and oats (Marico)'],
            ['name' => 'Paper Boat', 'country_id' => $india->id, 'description' => 'Traditional Indian beverages'],
            ['name' => 'Tata Salt', 'country_id' => $india->id, 'description' => 'Iodized salt'],
            ['name' => 'Aashirvaad', 'country_id' => $india->id, 'description' => 'Atta, spices and staples (ITC)'],
            ['name' => 'India Gate', 'country_id' => $india->id, 'description' => 'Basmati rice brand'],
            ['name' => 'Yogabar', 'country_id' => $india->id, 'description' => 'Healthy foods and snacks'],
            ['name' => 'Parry’s Sugar', 'country_id' => $india->id, 'description' => 'Refined sugar'],
            ['name' => 'iD Fresh', 'country_id' => $india->id, 'description' => 'Ready-to-cook batter and foods'],
            ['name' => 'Tata Sampann', 'country_id' => $india->id, 'description' => 'Pulses and spices'],
            ['name' => '24 Mantra Organic', 'country_id' => $india->id, 'description' => 'Organic staples and foods'],
            ['name' => 'Pachranga', 'country_id' => $india->id, 'description' => 'Traditional Indian pickles'],
            ['name' => 'Mother’s Recipe', 'country_id' => $india->id, 'description' => 'Pickles and ready mixes'],
            ['name' => 'Lijjat', 'country_id' => $india->id, 'description' => 'Papad brand cooperative'],
            ['name' => 'Bikaji', 'country_id' => $india->id, 'description' => 'Snacks and namkeen'],
            ['name' => 'Balaji Wafers', 'country_id' => $india->id, 'description' => 'Chips and snacks'],
            ['name' => 'Bisleri', 'country_id' => $india->id, 'description' => 'Packaged drinking water'],
            ['name' => 'Hamdard', 'country_id' => $india->id, 'description' => 'RoohAfza and Unani products'],

            // Foreign Brands
            ['name' => 'Coca-Cola', 'country_id' => $usa->id, 'description' => 'Soft drinks and beverages'],
            ['name' => 'PepsiCo', 'country_id' => $usa->id, 'description' => 'Beverages and snacks'],
            ['name' => 'Kraft Heinz', 'country_id' => $usa->id, 'description' => 'Processed food products'],
            ['name' => 'Unilever', 'country_id' => $uk->id, 'description' => 'Food, home care and personal care'],
            ['name' => 'Danone', 'country_id' => $france->id, 'description' => 'Dairy products and beverages'],
            ['name' => 'Ferrero', 'country_id' => $italy->id, 'description' => 'Chocolate and confectionery'],
        ];

        // Personal Care & Wellness Brands
        $personalCareBrands = [
            // Indian Brands
            ['name' => 'Himalaya', 'country_id' => $india->id, 'description' => 'Herbal personal care products'],
            ['name' => 'Patanjali', 'country_id' => $india->id, 'description' => 'Ayurvedic and natural products'],
            ['name' => 'Biotique', 'country_id' => $india->id, 'description' => 'Herbal beauty and wellness'],
            ['name' => 'Forest Essentials', 'country_id' => $india->id, 'description' => 'Luxury Ayurvedic skincare'],
            ['name' => 'Kama Ayurveda', 'country_id' => $india->id, 'description' => 'Traditional Ayurvedic products'],
            ['name' => 'Nykaa', 'country_id' => $india->id, 'description' => 'Beauty and personal care'],
            ['name' => 'Lakme', 'country_id' => $india->id, 'description' => 'Cosmetics and beauty products'],
            ['name' => 'Emami', 'country_id' => $india->id, 'description' => 'Personal care and healthcare'],
            ['name' => 'Vicco', 'country_id' => $india->id, 'description' => 'Ayurvedic oral and skincare'],
            ['name' => 'Boroline', 'country_id' => $india->id, 'description' => 'Skincare antiseptic cream'],
            ['name' => 'Santoor', 'country_id' => $india->id, 'description' => 'Soap brand by Wipro'],
            ['name' => 'Nirma', 'country_id' => $india->id, 'description' => 'Detergent and home care'],
            ['name' => 'Ghadi', 'country_id' => $india->id, 'description' => 'Detergent brand'],
            ['name' => 'Goodknight', 'country_id' => $india->id, 'description' => 'Mosquito repellents (Godrej)'],
            ['name' => 'Maxo', 'country_id' => $india->id, 'description' => 'Mosquito repellents (Jyothy Labs)'],
            ['name' => 'Park Avenue', 'country_id' => $india->id, 'description' => 'Fragrances and grooming (Raymond)'],
            ['name' => 'Bombay Shaving Company', 'country_id' => $india->id, 'description' => 'Men’s grooming'],
            ['name' => 'Ustraa', 'country_id' => $india->id, 'description' => 'Men’s grooming'],
            ['name' => 'Fogg', 'country_id' => $india->id, 'description' => 'Fragrance brand (Vini Cosmetics)'],
            ['name' => 'Godrej Expert', 'country_id' => $india->id, 'description' => 'Hair color brand'],
            ['name' => 'Nua', 'country_id' => $india->id, 'description' => 'Sanitary pads'],
            ['name' => 'Paree', 'country_id' => $india->id, 'description' => 'Sanitary pads'],

            // Foreign Brands
            ['name' => 'L\'Oreal', 'country_id' => $france->id, 'description' => 'Cosmetics and beauty products'],
            ['name' => 'Procter & Gamble', 'country_id' => $usa->id, 'description' => 'Personal care and household products'],
            ['name' => 'Johnson & Johnson', 'country_id' => $usa->id, 'description' => 'Personal care and healthcare'],
            ['name' => 'Unilever', 'country_id' => $uk->id, 'description' => 'Personal care and home care'],
            ['name' => 'Estee Lauder', 'country_id' => $usa->id, 'description' => 'Luxury cosmetics and skincare'],
            ['name' => 'Shiseido', 'country_id' => $japan->id, 'description' => 'Japanese cosmetics and skincare'],
        ];

        // Home & Lifestyle Brands
        $homeBrands = [
            // Indian Brands
            ['name' => 'Godrej', 'country_id' => $india->id, 'description' => 'Home appliances and furniture'],
            ['name' => 'Asian Paints', 'country_id' => $india->id, 'description' => 'Paints and home decor'],
            ['name' => 'Berger Paints', 'country_id' => $india->id, 'description' => 'Paints and coatings'],
            ['name' => 'Havells', 'country_id' => $india->id, 'description' => 'Electrical equipment and appliances'],
            ['name' => 'Crompton', 'country_id' => $india->id, 'description' => 'Electrical appliances and fans'],
            ['name' => 'Bajaj Electricals', 'country_id' => $india->id, 'description' => 'Home appliances and lighting'],
            ['name' => 'Prestige', 'country_id' => $india->id, 'description' => 'Kitchen appliances and cookware'],
            ['name' => 'Butterfly', 'country_id' => $india->id, 'description' => 'Kitchen appliances and mixer grinders'],
            ['name' => 'Hawkins', 'country_id' => $india->id, 'description' => 'Pressure cookers and cookware'],
            ['name' => 'Milton', 'country_id' => $india->id, 'description' => 'Flasks and kitchen storage'],
            ['name' => 'Borosil', 'country_id' => $india->id, 'description' => 'Glassware and kitchen appliances'],
            ['name' => 'Nilkamal', 'country_id' => $india->id, 'description' => 'Plastic furniture and storage'],
            ['name' => 'Cello', 'country_id' => $india->id, 'description' => 'Household products and storage'],
            ['name' => 'Pigeon', 'country_id' => $india->id, 'description' => 'Kitchen appliances (Stovekraft)'],
            ['name' => 'Agaro', 'country_id' => $india->id, 'description' => 'Home appliances and tools'],
            ['name' => 'Usha', 'country_id' => $india->id, 'description' => 'Fans and home appliances'],
            ['name' => 'Symphony', 'country_id' => $india->id, 'description' => 'Air coolers'],
            ['name' => 'Eveready', 'country_id' => $india->id, 'description' => 'Batteries and lighting'],
            ['name' => 'Syska', 'country_id' => $india->id, 'description' => 'LED lighting and accessories'],
            ['name' => 'Gainda', 'country_id' => $india->id, 'description' => 'Phenyl and cleaners'],
            ['name' => 'Cycle Pure', 'country_id' => $india->id, 'description' => 'Agarbatti and home fragrance'],
            ['name' => 'Mangaldeep', 'country_id' => $india->id, 'description' => 'Agarbatti brand (ITC)'],
            ['name' => 'Zed Black', 'country_id' => $india->id, 'description' => 'Incense and dhoop'],
            ['name' => 'Indian Art Villa', 'country_id' => $india->id, 'description' => 'Copper utensils and bottles'],

            // Foreign Brands
            ['name' => 'IKEA', 'country_id' => $sweden->id, 'description' => 'Furniture and home accessories'],
            ['name' => 'Philips', 'country_id' => $netherlands->id, 'description' => 'Electronics and home appliances'],
            ['name' => 'Samsung', 'country_id' => $southKorea->id, 'description' => 'Electronics and home appliances'],
            ['name' => 'LG', 'country_id' => $southKorea->id, 'description' => 'Electronics and home appliances'],
            ['name' => 'Bosch', 'country_id' => $germany->id, 'description' => 'Home appliances and power tools'],
            ['name' => 'Whirlpool', 'country_id' => $usa->id, 'description' => 'Home appliances and laundry'],
        ];

        // Stationery & Toys Brands
        $stationeryBrands = [
            // Indian Brands
            ['name' => 'Cello', 'country_id' => $india->id, 'description' => 'Writing instruments and stationery'],
            ['name' => 'Reynolds', 'country_id' => $india->id, 'description' => 'Pens and writing instruments'],
            ['name' => 'Camlin', 'country_id' => $india->id, 'description' => 'Art supplies and stationery'],
            ['name' => 'Natraj', 'country_id' => $india->id, 'description' => 'Pencils and art supplies'],
            ['name' => 'Apsara', 'country_id' => $india->id, 'description' => 'Pencils and writing instruments'],
            ['name' => 'Linc', 'country_id' => $india->id, 'description' => 'Writing instruments brand'],
            ['name' => 'Funskool', 'country_id' => $india->id, 'description' => 'Educational toys and games'],
            ['name' => 'Hamleys India', 'country_id' => $india->id, 'description' => 'Toys and games retailer'],
            ['name' => 'Chumbak', 'country_id' => $india->id, 'description' => 'Lifestyle and gift products'],

            // Foreign Brands
            ['name' => 'LEGO', 'country_id' => $denmark->id, 'description' => 'Construction toys and building blocks'],
            ['name' => 'Mattel', 'country_id' => $usa->id, 'description' => 'Toys and games manufacturer'],
            ['name' => 'Hasbro', 'country_id' => $usa->id, 'description' => 'Toys and board games'],
            ['name' => 'Faber-Castell', 'country_id' => $germany->id, 'description' => 'Art supplies and stationery'],
            ['name' => 'Staedtler', 'country_id' => $germany->id, 'description' => 'Writing instruments and art supplies'],
            ['name' => 'Pilot', 'country_id' => $japan->id, 'description' => 'Writing instruments and pens'],
        ];

        // Combine all brands
        $allBrands = array_merge($fashionBrands, $foodBrands, $personalCareBrands, $homeBrands, $stationeryBrands);

        foreach ($allBrands as $brand) {
            Brand::firstOrCreate(
                ['name' => $brand['name']],
                $brand
            );
        }
    }
}
