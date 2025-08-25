<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample games
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
        ];

        foreach ($games as $game) {
            Game::create($game);
        }

        // Create additional random games
        Game::factory(5)->create();
    }
}
