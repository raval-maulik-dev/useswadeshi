<?php

namespace App\Filament\Resources\GameQuestions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GameQuestionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('game_id')
                    ->relationship('game', 'name')
                    ->searchable()
                    ->required(),
                Textarea::make('question')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('options')
                    ->label('Options (JSON format: ["Option 1", "Option 2"])')
                    ->placeholder('["Yes", "No"]')
                    ->required(),
                Select::make('correct_answer')
                    ->options(['Yes' => 'Yes', 'No' => 'No'])
                    ->required(),
            ]);
    }
}
