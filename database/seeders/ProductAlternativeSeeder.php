<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductAlternative;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductAlternativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create alternatives for existing products
        $foreignProducts = Product::where('product_type', 'foreign')->get();
        $localProducts = Product::where('product_type', 'local')->get();

        // Create alternatives for each foreign product
        foreach ($foreignProducts as $foreignProduct) {
            // Find a local alternative in the same category
            $localAlternative = $localProducts->where('category_id', $foreignProduct->category_id)->first();
            
            if ($localAlternative) {
                ProductAlternative::create([
                    'foreign_product_id' => $foreignProduct->id,
                    'local_product_id' => $localAlternative->id,
                    'note' => "Local alternative to {$foreignProduct->name}",
                ]);
            }
        }

        // Create additional random alternatives
        ProductAlternative::factory(20)->create();
    }
}
