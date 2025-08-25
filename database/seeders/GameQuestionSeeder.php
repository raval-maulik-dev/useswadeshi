<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\GameQuestion;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create questions for existing games and products
        $games = Game::all();
        $products = Product::all();

        foreach ($games as $game) {
            // Create 5-10 questions per game
            $questionCount = rand(5, 10);
            $randomProducts = $products->random($questionCount);

            foreach ($randomProducts as $product) {
                GameQuestion::create([
                    'game_id' => $game->id,
                    'product_id' => $product->id,
                    'question_text' => "Is {$product->name} a local or foreign product?",
                    'correct_answer' => $product->product_type,
                ]);
            }
        }

        // Create additional random questions
        GameQuestion::factory(30)->create();
    }
}
