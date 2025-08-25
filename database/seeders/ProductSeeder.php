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
        // Create sample products with real brands and categories
        $brands = Brand::all();
        $categories = Category::all();
        $vendors = Vendor::all();

        // Create Indian products (first 10 brands)
        for ($i = 0; $i < 20; $i++) {
            $category = $categories->random();
            $brand = $brands->take(10)->random();
            $vendor = $vendors->random();

            Product::create([
                'name' => fake()->words(3, true),
                'description' => fake()->paragraph(),
                'price' => fake()->randomFloat(2, 10, 1000),
                'image' => fake()->imageUrl(400, 300, 'products'),
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'vendor_id' => $vendor->id,
                'is_swadeshi' => true,
            ]);
        }

        // Create foreign products (remaining brands)
        for ($i = 0; $i < 10; $i++) {
            $category = $categories->random();
            $brand = $brands->skip(10)->random();
            $vendor = $vendors->random();

            Product::create([
                'name' => fake()->words(3, true),
                'description' => fake()->paragraph(),
                'price' => fake()->randomFloat(2, 10, 1000),
                'image' => fake()->imageUrl(400, 300, 'products'),
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'vendor_id' => $vendor->id,
                'is_swadeshi' => false,
            ]);
        }

        // Create additional random products
        Product::factory(50)->create();
    }
}
