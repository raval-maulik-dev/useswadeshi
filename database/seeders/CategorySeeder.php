<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 🎯 Core focus categories (easy to connect with audience)
        $parentCategories = [
            'Fashion & Apparel',
            'Food & Beverages',
            'Personal Care & Wellness',
            'Home & Lifestyle',
            'Stationery & Toys',
        ];

        $parentIds = [];
        foreach ($parentCategories as $categoryName) {
            $category = Category::create([
                'name' => $categoryName,
                'parent_id' => null,
            ]);
            $parentIds[$categoryName] = $category->id;
        }

        // Sub-categories aligned with local-first movement
        $subCategories = [
            'Fashion & Apparel' => [
                'Women’s Ethnic Wear',
                'Men’s Ethnic Wear',
                'Handloom & Fabrics',
                'Footwear',
                'Jewelry & Accessories',
            ],
            'Food & Beverages' => [
                'Snacks & Namkeen',
                'Dairy Products',
                'Spices & Condiments',
                'Beverages (Tea, Coffee, Herbal)',
                'Organic & Healthy Foods',
            ],
            'Personal Care & Wellness' => [
                'Herbal Skincare',
                'Hair Care (Oils, Shampoos)',
                'Ayurvedic Products',
                'Cosmetics (Made in India)',
                'Fitness & Yoga Essentials',
            ],
            'Home & Lifestyle' => [
                'Handicrafts & Decor',
                'Kitchenware (Steel, Copper, Clay)',
                'Home Linens',
                'Cleaning Supplies (Local)',
            ],
            'Stationery & Toys' => [
                'Notebooks & Art Supplies',
                'Educational Toys',
                'Wooden & Handmade Toys',
                'Kids’ Books (Local Language)',
            ],
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
    }
}
