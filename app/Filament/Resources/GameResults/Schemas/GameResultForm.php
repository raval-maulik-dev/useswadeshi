<?php

namespace App\Filament\Resources\GameResults\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GameResultForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('game_id')
                    ->relationship('game', 'name')
                    ->required(),
                TextInput::make('score')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('total_questions')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('result_summary'),
            ]);
    }
}
