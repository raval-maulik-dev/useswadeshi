<?php

namespace App\Filament\Resources\GameResults\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GameResultForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),
                Select::make('game_id')
                    ->relationship('game', 'name')
                    ->searchable()
                    ->required(),
                TextInput::make('score')
                    ->required()
                    ->numeric()
                    ->minValue(0),
                TextInput::make('total_questions')
                    ->required()
                    ->numeric()
                    ->minValue(1),
                Textarea::make('answers')
                    ->label('Answers (JSON format)')
                    ->placeholder('{"correct_answers": 5, "incorrect_answers": 3, "percentage": 62.5, "time_taken": 120}')
                    ->columnSpanFull(),
            ]);
    }
}
