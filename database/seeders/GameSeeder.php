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
            ],
            [
                'name' => 'Brand Recognition',
                'description' => 'Identify whether brands are Indian or foreign',
            ],
            [
                'name' => 'Product Origins',
                'description' => 'Learn about the origins of various products',
            ],
            [
                'name' => 'Local vs Global',
                'description' => 'Compare local and global products',
            ],
            [
                'name' => 'Swadeshi Quiz Marathon',
                'description' => 'Answer a series of timed questions about local businesses and culture',
            ],
            [
                'name' => 'Usage Impact Calculator',
                'description' => 'Calculate the impact of switching from foreign to local products',
            ],
            [
                'name' => 'Festival Special Quiz',
                'description' => 'A limited-time quiz based on Indian festivals and local traditions',
            ],
            [
                'name' => 'Guess the Local Brand',
                'description' => 'Identify logos and slogans of local brands',
            ],
            [
                'name' => 'Local Hero Spotlight',
                'description' => 'Learn about inspiring Indian entrepreneurs and their brands',
            ],
            [
                'name' => 'Eco-Friendly Choices',
                'description' => 'Select eco-friendly local alternatives to common foreign products',
            ],
            [
                'name' => 'Supply Chain Explorer',
                'description' => 'Trace the journey of a product from raw material to consumer and identify local vs foreign dependencies',
            ],
            [
                'name' => 'Local Treasure Hunt (Digital)',
                'description' => 'Unlock clues about famous Indian products and brands',
            ],
            [
                'name' => 'Sustainable Switch',
                'description' => 'Choose eco-friendly local alternatives and earn points',
            ],
            [
                'name' => 'Make in India Memory Match',
                'description' => 'Match Indian brands with their products in a memory card game',
            ],
            [
                'name' => 'Local Startups Quiz',
                'description' => 'Identify upcoming Indian startups and their innovations',
            ],
            [
                'name' => 'Price Comparison Challenge',
                'description' => 'Guess whether local or foreign products are more affordable',
            ],
            [
                'name' => 'Swadeshi Crossword',
                'description' => 'Solve a crossword featuring Indian brands and entrepreneurs',
            ],
            [
                'name' => 'Impact Meter',
                'description' => 'See the impact of your purchases by choosing local over foreign',
            ],
            [
                'name' => 'Guess the Origin',
                'description' => 'Identify the country of origin for famous brands',
            ],
            [
                'name' => 'Local Legends Trivia',
                'description' => 'Test your knowledge about historic Indian brands and founders',
            ],
        ];

        foreach ($games as $game) {
            Game::firstOrCreate(['name' => $game['name']], $game);
        }
    }
}
