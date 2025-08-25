<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductAlternative;
use Illuminate\Database\Seeder;

class ProductAlternativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create alternatives for existing products
        $foreignProducts = Product::where('is_swadeshi', false)->get();
        $localProducts = Product::where('is_swadeshi', true)->get();

        // Create alternatives for each foreign product
        foreach ($foreignProducts as $foreignProduct) {
            // Find a local alternative in the same category
            $localAlternative = $localProducts->where('category_id', $foreignProduct->category_id)->first();

            if ($localAlternative) {
                ProductAlternative::create([
                    'product_id' => $foreignProduct->id,
                    'name' => "Local alternative to {$foreignProduct->name}",
                    'description' => "A swadeshi alternative to {$foreignProduct->name}",
                    'price' => $localAlternative->price * 0.9, // Slightly cheaper alternative
                    'image' => null,
                ]);
            }
        }

        // Create additional alternatives using existing products
        $additionalForeignProducts = Product::where('is_swadeshi', false)->take(10)->get();
        $additionalLocalProducts = Product::where('is_swadeshi', true)->take(10)->get();

        foreach ($additionalForeignProducts as $foreignProduct) {
            $localAlternative = $additionalLocalProducts->random();

            ProductAlternative::create([
                'product_id' => $foreignProduct->id,
                'name' => "Local alternative to {$foreignProduct->name}",
                'description' => "A swadeshi alternative to {$foreignProduct->name}",
                'price' => $localAlternative->price * 0.9, // Slightly cheaper alternative
                'image' => null,
            ]);
        }
    }
}
