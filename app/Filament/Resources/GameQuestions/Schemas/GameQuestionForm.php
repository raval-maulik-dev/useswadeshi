<?php

namespace App\Filament\Resources\GameQuestions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GameQuestionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('game_id')
                    ->relationship('game', 'name')
                    ->required(),
                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required(),
                TextInput::make('question_text'),
                Select::make('correct_answer')
                    ->options(['local' => 'Local', 'foreign' => 'Foreign'])
                    ->required(),
            ]);
    }
}
