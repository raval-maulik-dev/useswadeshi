<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = [
            [
                'name' => 'Swadeshi Challenge',
                'description' => 'Test your knowledge about Indian products vs foreign products',
                'total_questions' => 10,
            ],
            [
                'name' => 'Brand Recognition',
                'description' => 'Identify whether brands are Indian or foreign',
                'total_questions' => 10,
            ],
            [
                'name' => 'Usage Impact Calculator',
                'description' => 'Calculate the impact of switching from foreign to local products',
                'total_questions' => 10,
            ],
            [
                'name' => 'Product Origins',
                'description' => 'Learn about the origins of various products',
                'is_active' => false,
            ],
            [
                'name' => 'Local vs Global',
                'description' => 'Compare local and global products',
                'is_active' => false,
            ],
            [
                'name' => 'Swadeshi Quiz Marathon',
                'description' => 'Answer a series of timed questions about local businesses and culture',
                'is_active' => false,
            ],

            [
                'name' => 'Festival Special Quiz',
                'description' => 'A limited-time quiz based on Indian festivals and local traditions',
                'is_active' => false,
            ],
            [
                'name' => 'Guess the Local Brand',
                'description' => 'Identify logos and slogans of local brands',
                'is_active' => false,
            ],
            [
                'name' => 'Local Hero Spotlight',
                'description' => 'Learn about inspiring Indian entrepreneurs and their brands',
                'is_active' => false,
            ],
            [
                'name' => 'Eco-Friendly Choices',
                'description' => 'Select eco-friendly local alternatives to common foreign products',
            ],
            [
                'name' => 'Supply Chain Explorer',
                'description' => 'Trace the journey of a product from raw material to consumer and identify local vs foreign dependencies',
                'is_active' => false,
            ],
            [
                'name' => 'Local Treasure Hunt (Digital)',
                'description' => 'Unlock clues about famous Indian products and brands',
                'is_active' => false,
            ],
            [
                'name' => 'Sustainable Switch',
                'description' => 'Choose eco-friendly local alternatives and earn points',
                'is_active' => false,
            ],
            [
                'name' => 'Make in India Memory Match',
                'description' => 'Match Indian brands with their products in a memory card game',
                'is_active' => false,
            ],
            [
                'name' => 'Local Startups Quiz',
                'description' => 'Identify upcoming Indian startups and their innovations',
                'is_active' => false,
            ],
            [
                'name' => 'Price Comparison Challenge',
                'description' => 'Guess whether local or foreign products are more affordable',
                'is_active' => false,
            ],
            [
                'name' => 'Swadeshi Crossword',
                'description' => 'Solve a crossword featuring Indian brands and entrepreneurs',
                'is_active' => false,
            ],
            [
                'name' => 'Impact Meter',
                'description' => 'See the impact of your purchases by choosing local over foreign',
                'is_active' => false,
            ],
            [
                'name' => 'Guess the Origin',
                'description' => 'Identify the country of origin for famous brands',
                'is_active' => false,
            ],
            [
                'name' => 'Local Legends Trivia',
                'description' => 'Test your knowledge about historic Indian brands and founders',
                'is_active' => false,
            ],
        ];

        foreach ($games as $game) {
            Game::firstOrCreate(['name' => $game['name']], $game);
        }
    }
}
