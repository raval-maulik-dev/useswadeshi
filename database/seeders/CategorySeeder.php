<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create parent categories
        $parentCategories = [
            'Electronics',
            'Automotive',
            'Food & Beverages',
            'Fashion',
            'Home & Garden',
            'Sports',
            'Books',
            'Health & Beauty',
        ];

        $parentIds = [];
        foreach ($parentCategories as $categoryName) {
            $category = Category::create([
                'name' => $categoryName,
                'parent_id' => null,
            ]);
            $parentIds[] = $category->id;
        }

        // Create sub-categories
        $subCategories = [
            'Electronics' => ['Smartphones', 'Laptops', 'TVs', 'Audio Devices'],
            'Automotive' => ['Cars', 'Motorcycles', 'Auto Parts', 'Accessories'],
            'Food & Beverages' => ['Dairy Products', 'Snacks', 'Beverages', 'Organic Food'],
            'Fashion' => ['Clothing', 'Footwear', 'Accessories', 'Jewelry'],
            'Home & Garden' => ['Furniture', 'Kitchen Appliances', 'Garden Tools', 'Decor'],
            'Sports' => ['Fitness Equipment', 'Outdoor Sports', 'Indoor Games', 'Sports Wear'],
            'Books' => ['Fiction', 'Non-Fiction', 'Educational', 'Children Books'],
            'Health & Beauty' => ['Personal Care', 'Cosmetics', 'Health Supplements', 'Medical Devices'],
        ];

        foreach ($subCategories as $parentName => $subCats) {
            $parentCategory = Category::where('name', $parentName)->first();
            if ($parentCategory) {
                foreach ($subCats as $subCatName) {
                    Category::create([
                        'name' => $subCatName,
                        'parent_id' => $parentCategory->id,
                    ]);
                }
            }
        }

        // Create additional random categories
        Category::factory(15)->create();
    }
}
