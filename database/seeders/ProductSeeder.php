<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample products with real brands and categories
        $brands = Brand::all();
        $categories = Category::all();
        $vendors = Vendor::all();

        // Sample local products
        $localProducts = [
            'Amul Butter' => 'Dairy Products',
            'Tata Salt' => 'Food & Beverages',
            'Bajaj Pulsar' => 'Motorcycles',
            'Hero Splendor' => 'Motorcycles',
            'Maruti Swift' => 'Cars',
            'HCL Laptop' => 'Laptops',
            'Wipro Soap' => 'Personal Care',
            'Reliance Jio Phone' => 'Smartphones',
        ];

        foreach ($localProducts as $productName => $categoryName) {
            $category = $categories->where('name', $categoryName)->first();
            $brand = $brands->where('origin_country', 'India')->random();
            $vendor = $vendors->random();

            Product::create([
                'name' => $productName,
                'description' => fake()->paragraph(),
                'product_type' => 'local',
                'brand_id' => $brand->id,
                'category_id' => $category ? $category->id : $categories->random()->id,
                'vendor_id' => $vendor->id,
                'image_url' => fake()->imageUrl(640, 480, 'products'),
            ]);
        }

        // Sample foreign products
        $foreignProducts = [
            'iPhone 15' => 'Smartphones',
            'Samsung Galaxy' => 'Smartphones',
            'Nike Air Max' => 'Footwear',
            'Adidas Ultraboost' => 'Footwear',
            'Toyota Camry' => 'Cars',
            'Honda Civic' => 'Cars',
            'Sony Bravia TV' => 'TVs',
            'LG Refrigerator' => 'Kitchen Appliances',
        ];

        foreach ($foreignProducts as $productName => $categoryName) {
            $category = $categories->where('name', $categoryName)->first();
            $brand = $brands->where('origin_country', '!=', 'India')->random();
            $vendor = $vendors->random();

            Product::create([
                'name' => $productName,
                'description' => fake()->paragraph(),
                'product_type' => 'foreign',
                'brand_id' => $brand->id,
                'category_id' => $category ? $category->id : $categories->random()->id,
                'vendor_id' => $vendor->id,
                'image_url' => fake()->imageUrl(640, 480, 'products'),
            ]);
        }

        // Create additional random products
        Product::factory(50)->create();
    }
}
