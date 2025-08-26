<?php

namespace App\Filament\Resources\GameQuestions\Schemas;

use App\Models\Brand;
use App\Models\Game;
use App\Models\Product;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class GameQuestionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // Question Details
                Select::make('game_id')
                    ->label('Game')
                    ->options(Game::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                Textarea::make('question')
                    ->label('Question')
                    ->required()
                    ->columnSpanFull(),

                Select::make('type')
                    ->label('Question Type')
                    ->options([
                        'mcq' => 'Multiple Choice (Single Answer)',
                        'multi_select' => 'Multiple Choice (Multiple Answers)',
                        'true_false' => 'True/False',
                    ])
                    ->default('mcq')
                    ->required()
                    ->reactive(),

                Select::make('difficulty')
                    ->label('Difficulty')
                    ->options([
                        'easy' => 'Easy',
                        'medium' => 'Medium',
                        'hard' => 'Hard',
                    ]),

                TextInput::make('points')
                    ->label('Points')
                    ->numeric()
                    ->default(10)
                    ->minValue(1)
                    ->maxValue(100)
                    ->required(),

                // Options Management
                Repeater::make('options')
                    ->label('Options')
                    ->schema([
                        Select::make('option_type')
                            ->label('Type')
                            ->options([
                                'text' => 'Text',
                                'product' => 'Product',
                                'brand' => 'Brand',
                            ])
                            ->default('text')
                            ->reactive()
                            ->afterStateUpdated(function (Set $set) {
                                $set('optionable_id', null);
                                $set('optionable_type', null);
                                $set('option_text', null);
                            }),

                        TextInput::make('option_text')
                            ->label('Text')
                            ->placeholder('Enter option text')
                            ->visible(fn (Get $get) => $get('option_type') === 'text'),

                        Select::make('optionable_id')
                            ->label('Product')
                            ->options(Product::all()->pluck('name', 'id'))
                            ->searchable()
                            ->visible(fn (Get $get) => $get('option_type') === 'product')
                            ->reactive()
                            ->afterStateUpdated(function (Set $set) {
                                $set('optionable_type', Product::class);
                            }),

                        Select::make('optionable_id')
                            ->label('Brand')
                            ->options(Brand::all()->pluck('name', 'id'))
                            ->searchable()
                            ->visible(fn (Get $get) => $get('option_type') === 'brand')
                            ->reactive()
                            ->afterStateUpdated(function (Set $set) {
                                $set('optionable_type', Brand::class);
                            }),

                        Checkbox::make('is_correct')
                            ->label('Correct'),

                        TextInput::make('sort_order')
                            ->label('Order')
                            ->numeric()
                            ->placeholder('1, 2, 3...'),
                    ])
                    ->defaultItems(4)
                    ->minItems(2)
                    ->maxItems(6)
                    ->reorderable()
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => $state['option_text'] ?? 'Option')
                    ->columnSpanFull(),
            ]);
    }
}
