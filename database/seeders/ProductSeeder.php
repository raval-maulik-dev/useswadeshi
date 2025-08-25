<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendors = Vendor::all();

        // Get categories with their subcategories
        $categories = Category::with('children')->whereNull('parent_id')->get();

        // Get brands by category
        $fashionBrands = Brand::whereIn('name', ['Fabindia', 'Biba', 'W for Woman', 'Manyavar', 'Raymond', 'Bata', 'Khadi', 'Taneira', 'Nike', 'Adidas', 'Zara', 'H&M', 'Uniqlo', 'Gucci', 'Louis Vuitton'])->get();
        $foodBrands = Brand::whereIn('name', ['Amul', 'Britannia', 'Parle', 'Haldirams', 'Dabur', 'Tata Tea', 'Mother Dairy', 'Nestle India', 'Coca-Cola', 'PepsiCo', 'Kraft Heinz', 'Unilever', 'Danone', 'Ferrero'])->get();
        $personalCareBrands = Brand::whereIn('name', ['Himalaya', 'Patanjali', 'Biotique', 'Forest Essentials', 'Kama Ayurveda', 'Nykaa', 'Lakme', 'Emami', 'L\'Oreal', 'Procter & Gamble', 'Johnson & Johnson', 'Estee Lauder', 'Shiseido'])->get();
        $homeBrands = Brand::whereIn('name', ['Godrej', 'Asian Paints', 'Berger Paints', 'Havells', 'Crompton', 'Bajaj Electricals', 'Prestige', 'Butterfly', 'IKEA', 'Philips', 'Samsung', 'LG', 'Bosch', 'Whirlpool'])->get();
        $stationeryBrands = Brand::whereIn('name', ['Cello', 'Reynolds', 'Camlin', 'Natraj', 'Apsara', 'Funskool', 'Hamleys India', 'Chumbak', 'LEGO', 'Mattel', 'Hasbro', 'Faber-Castell', 'Staedtler', 'Pilot'])->get();

        // Fashion & Apparel Products
        $this->seedFashionProducts($categories->where('name', 'Fashion & Apparel')->first(), $fashionBrands, $vendors);

        // Food & Beverages Products
        $this->seedFoodProducts($categories->where('name', 'Food & Beverages')->first(), $foodBrands, $vendors);

        // Personal Care & Wellness Products
        $this->seedPersonalCareProducts($categories->where('name', 'Personal Care & Wellness')->first(), $personalCareBrands, $vendors);

        // Home & Lifestyle Products
        $this->seedHomeProducts($categories->where('name', 'Home & Lifestyle')->first(), $homeBrands, $vendors);

        // Stationery & Toys Products
        $this->seedStationeryProducts($categories->where('name', 'Stationery & Toys')->first(), $stationeryBrands, $vendors);
    }

    private function seedFashionProducts($category, $brands, $vendors): void
    {
        $subcategories = $category->children;

        // Women's Ethnic Wear
        $womensEthnic = $subcategories->where('name', 'Women\'s Ethnic Wear')->first();
        $this->createProducts($womensEthnic, $brands, $vendors, [
            ['name' => 'Silk Saree', 'price' => 2500, 'description' => 'Traditional silk saree with intricate designs'],
            ['name' => 'Cotton Kurti', 'price' => 800, 'description' => 'Comfortable cotton kurti for daily wear'],
            ['name' => 'Designer Anarkali', 'price' => 3500, 'description' => 'Elegant designer anarkali suit'],
            ['name' => 'Handloom Dress', 'price' => 1200, 'description' => 'Handwoven cotton dress'],
            ['name' => 'Embroidered Lehenga', 'price' => 4500, 'description' => 'Beautiful embroidered lehenga choli'],
        ], ['Fabindia', 'Biba', 'W for Woman', 'Taneira', 'Khadi']);

        // Men's Ethnic Wear
        $mensEthnic = $subcategories->where('name', 'Men\'s Ethnic Wear')->first();
        $this->createProducts($mensEthnic, $brands, $vendors, [
            ['name' => 'Cotton Kurta', 'price' => 1200, 'description' => 'Comfortable cotton kurta for men'],
            ['name' => 'Silk Sherwani', 'price' => 8000, 'description' => 'Traditional silk sherwani for special occasions'],
            ['name' => 'Dhoti Set', 'price' => 600, 'description' => 'Traditional dhoti with kurta'],
            ['name' => 'Designer Bandhgala', 'price' => 4000, 'description' => 'Modern designer bandhgala suit'],
            ['name' => 'Jodhpuri Suit', 'price' => 5500, 'description' => 'Classic Jodhpuri suit for formal events'],
        ], ['Manyavar', 'Raymond', 'Fabindia']);

        // Footwear
        $footwear = $subcategories->where('name', 'Footwear')->first();
        $this->createProducts($footwear, $brands, $vendors, [
            ['name' => 'Leather Sandals', 'price' => 1500, 'description' => 'Comfortable leather sandals'],
            ['name' => 'Sports Shoes', 'price' => 2500, 'description' => 'High-quality sports shoes'],
            ['name' => 'Formal Shoes', 'price' => 2000, 'description' => 'Classic formal leather shoes'],
            ['name' => 'Casual Sneakers', 'price' => 1800, 'description' => 'Stylish casual sneakers'],
            ['name' => 'Traditional Mojaris', 'price' => 800, 'description' => 'Handcrafted traditional mojaris'],
        ], ['Bata', 'Nike', 'Adidas']);
    }

    private function seedFoodProducts($category, $brands, $vendors): void
    {
        $subcategories = $category->children;

        // Snacks & Namkeen
        $snacks = $subcategories->where('name', 'Snacks & Namkeen')->first();
        $this->createProducts($snacks, $brands, $vendors, [
            ['name' => 'Mixed Namkeen', 'price' => 120, 'description' => 'Traditional mixed namkeen'],
            ['name' => 'Kurkure Chips', 'price' => 20, 'description' => 'Crunchy kurkure chips'],
            ['name' => 'Haldirams Mixture', 'price' => 80, 'description' => 'Classic Haldirams mixture'],
            ['name' => 'Baked Nachos', 'price' => 150, 'description' => 'Healthy baked nachos'],
            ['name' => 'Roasted Peanuts', 'price' => 60, 'description' => 'Fresh roasted peanuts'],
        ], ['Haldirams', 'Parle', 'Britannia']);

        // Dairy Products
        $dairy = $subcategories->where('name', 'Dairy Products')->first();
        $this->createProducts($dairy, $brands, $vendors, [
            ['name' => 'Amul Milk', 'price' => 60, 'description' => 'Pure cow milk'],
            ['name' => 'Ghee', 'price' => 500, 'description' => 'Pure desi ghee'],
            ['name' => 'Curd', 'price' => 40, 'description' => 'Fresh homemade curd'],
            ['name' => 'Butter', 'price' => 120, 'description' => 'Fresh butter'],
            ['name' => 'Paneer', 'price' => 200, 'description' => 'Fresh cottage cheese'],
        ], ['Amul', 'Mother Dairy', 'Nestle India']);

        // Beverages
        $beverages = $subcategories->where('name', 'Beverages (Tea, Coffee, Herbal)')->first();
        $this->createProducts($beverages, $brands, $vendors, [
            ['name' => 'Tata Tea Premium', 'price' => 150, 'description' => 'Premium quality tea'],
            ['name' => 'Green Tea', 'price' => 200, 'description' => 'Organic green tea'],
            ['name' => 'Coffee Beans', 'price' => 300, 'description' => 'Fresh coffee beans'],
            ['name' => 'Herbal Tea', 'price' => 180, 'description' => 'Ayurvedic herbal tea'],
            ['name' => 'Masala Chai', 'price' => 100, 'description' => 'Traditional masala chai'],
        ], ['Tata Tea', 'Dabur', 'Coca-Cola', 'PepsiCo']);
    }

    private function seedPersonalCareProducts($category, $brands, $vendors): void
    {
        $subcategories = $category->children;

        // Herbal Skincare
        $skincare = $subcategories->where('name', 'Herbal Skincare')->first();
        $this->createProducts($skincare, $brands, $vendors, [
            ['name' => 'Aloe Vera Gel', 'price' => 250, 'description' => 'Pure aloe vera gel for skin'],
            ['name' => 'Neem Face Wash', 'price' => 180, 'description' => 'Natural neem face wash'],
            ['name' => 'Turmeric Cream', 'price' => 300, 'description' => 'Ayurvedic turmeric cream'],
            ['name' => 'Sandalwood Soap', 'price' => 120, 'description' => 'Natural sandalwood soap'],
            ['name' => 'Coconut Oil', 'price' => 200, 'description' => 'Pure coconut oil for skin'],
        ], ['Himalaya', 'Patanjali', 'Biotique', 'Forest Essentials']);

        // Hair Care
        $haircare = $subcategories->where('name', 'Hair Care (Oils, Shampoos)')->first();
        $this->createProducts($haircare, $brands, $vendors, [
            ['name' => 'Amla Hair Oil', 'price' => 150, 'description' => 'Traditional amla hair oil'],
            ['name' => 'Coconut Hair Oil', 'price' => 180, 'description' => 'Pure coconut hair oil'],
            ['name' => 'Herbal Shampoo', 'price' => 200, 'description' => 'Natural herbal shampoo'],
            ['name' => 'Brahmi Oil', 'price' => 220, 'description' => 'Brahmi hair oil for growth'],
            ['name' => 'Neem Shampoo', 'price' => 160, 'description' => 'Neem-based anti-dandruff shampoo'],
        ], ['Himalaya', 'Dabur', 'Patanjali', 'Kama Ayurveda']);
    }

    private function seedHomeProducts($category, $brands, $vendors): void
    {
        $subcategories = $category->children;

        // Handicrafts & Decor
        $handicrafts = $subcategories->where('name', 'Handicrafts & Decor')->first();
        $this->createProducts($handicrafts, $brands, $vendors, [
            ['name' => 'Handcrafted Vase', 'price' => 800, 'description' => 'Beautiful handcrafted ceramic vase'],
            ['name' => 'Wooden Wall Art', 'price' => 1200, 'description' => 'Traditional wooden wall art'],
            ['name' => 'Brass Diya Set', 'price' => 400, 'description' => 'Traditional brass diya set'],
            ['name' => 'Handwoven Rug', 'price' => 2500, 'description' => 'Handwoven cotton rug'],
            ['name' => 'Clay Pot Set', 'price' => 300, 'description' => 'Traditional clay pot set'],
        ], ['Godrej', 'Asian Paints', 'Berger Paints']);

        // Kitchenware
        $kitchenware = $subcategories->where('name', 'Kitchenware (Steel, Copper, Clay)')->first();
        $this->createProducts($kitchenware, $brands, $vendors, [
            ['name' => 'Stainless Steel Cookware Set', 'price' => 1500, 'description' => 'Complete stainless steel cookware set'],
            ['name' => 'Copper Water Bottle', 'price' => 800, 'description' => 'Traditional copper water bottle'],
            ['name' => 'Clay Cooking Pot', 'price' => 400, 'description' => 'Traditional clay cooking pot'],
            ['name' => 'Steel Tiffin Box', 'price' => 600, 'description' => 'Stainless steel tiffin box'],
            ['name' => 'Copper Vessel Set', 'price' => 1200, 'description' => 'Traditional copper vessel set'],
        ], ['Prestige', 'Butterfly', 'Godrej']);
    }

    private function seedStationeryProducts($category, $brands, $vendors): void
    {
        $subcategories = $category->children;

        // Notebooks & Art Supplies
        $stationery = $subcategories->where('name', 'Notebooks & Art Supplies')->first();
        $this->createProducts($stationery, $brands, $vendors, [
            ['name' => 'Classmate Notebook', 'price' => 50, 'description' => 'High-quality school notebook'],
            ['name' => 'Camlin Paint Set', 'price' => 200, 'description' => 'Complete paint set for artists'],
            ['name' => 'Reynolds Pen Set', 'price' => 150, 'description' => 'Smooth writing pen set'],
            ['name' => 'Natraj Pencil Pack', 'price' => 30, 'description' => 'Pack of 10 HB pencils'],
            ['name' => 'Apsara Eraser', 'price' => 20, 'description' => 'High-quality eraser'],
        ], ['Cello', 'Reynolds', 'Camlin', 'Natraj', 'Apsara']);

        // Educational Toys
        $toys = $subcategories->where('name', 'Educational Toys')->first();
        $this->createProducts($toys, $brands, $vendors, [
            ['name' => 'Building Blocks Set', 'price' => 800, 'description' => 'Educational building blocks'],
            ['name' => 'Puzzle Set', 'price' => 400, 'description' => 'Brain development puzzle set'],
            ['name' => 'Science Kit', 'price' => 1200, 'description' => 'Educational science experiment kit'],
            ['name' => 'Math Learning Game', 'price' => 300, 'description' => 'Fun math learning game'],
            ['name' => 'Alphabet Learning Set', 'price' => 250, 'description' => 'Alphabet learning toys'],
        ], ['Funskool', 'Hamleys India', 'LEGO', 'Mattel']);
    }

    private function createProducts($category, $brands, $vendors, $products, $preferredBrands): void
    {
        // Skip if category is null
        if (! $category) {
            return;
        }

        foreach ($products as $productData) {
            // Prefer Indian brands for swadeshi products
            $isSwadeshi = rand(1, 3) <= 2; // 2/3 chance of being swadeshi
            $availableBrands = $isSwadeshi ?
                $brands->whereIn('name', $preferredBrands) :
                $brands->whereNotIn('name', $preferredBrands);

            if ($availableBrands->isEmpty()) {
                $availableBrands = $brands;
            }

            $brand = $availableBrands->random();
            $vendor = $vendors->random();

            Product::create([
                'name' => $productData['name'],
                'description' => $productData['description'],
                'price' => $productData['price'],
                'image' => null, // Will be handled by frontend
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'vendor_id' => $vendor->id,
                'is_swadeshi' => $isSwadeshi,
            ]);
        }
    }
}
