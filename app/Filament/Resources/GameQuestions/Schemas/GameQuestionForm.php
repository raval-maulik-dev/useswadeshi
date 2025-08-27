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
                    ->required()
                    ->live(),

                Textarea::make('question')
                    ->label('Question')
                    ->required()
                    ->columnSpanFull()
                    ->rows(3),

                Select::make('type')
                    ->label('Question Type')
                    ->options([
                        'mcq' => 'Multiple Choice (Single Answer)',
                        'multi_select' => 'Multiple Choice (Multiple Answers)',
                        'true_false' => 'True/False',
                    ])
                    ->default('mcq')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        // Reset options when question type changes
                        $set('options', []);
                    }),

                Select::make('difficulty')
                    ->label('Difficulty')
                    ->options([
                        'easy' => 'Easy',
                        'medium' => 'Medium',
                        'hard' => 'Hard',
                    ])
                    ->default('medium'),

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
                            ->label('Option Type')
                            ->options([
                                'text' => 'Text Option',
                                'product' => 'Product Option',
                                'brand' => 'Brand Option',
                            ])
                            ->default('text')
                            ->live()
                            ->required()
                            ->afterStateUpdated(function (Set $set) {
                                // Clear related fields when option type changes
                                $set('optionable_id', null);
                                $set('optionable_type', null);
                                $set('option_text', null);
                            }),

                        TextInput::make('option_text')
                            ->label('Option Text')
                            ->placeholder('Enter option text')
                            ->required(fn (Get $get) => $get('option_type') === 'text')
                            ->visible(fn (Get $get) => $get('option_type') === 'text')
                            ->maxLength(255),

                        Select::make('optionable_id')
                            ->label(fn (Get $get) => match ($get('option_type')) {
                                'product' => 'Select Product',
                                'brand' => 'Select Brand',
                                default => 'Select Item',
                            })
                            ->options(function (Get $get) {
                                return match ($get('option_type')) {
                                    'product' => Product::query()
                                        ->orderBy('name')
                                        ->pluck('name', 'id'),
                                    'brand' => Brand::query()
                                        ->orderBy('name')
                                        ->pluck('name', 'id'),
                                    default => collect(),
                                };
                            })
                            ->searchable()
                            ->required(fn (Get $get) => in_array($get('option_type'), ['product', 'brand']))
                            ->visible(fn (Get $get) => in_array($get('option_type'), ['product', 'brand']))
                            ->live()
                            ->afterStateUpdated(function (Set $set, $state, Get $get) {
                                // Set the optionable_type when an item is selected
                                $type = $get('option_type');
                                $set('optionable_type', match ($type) {
                                    'product' => Product::class,
                                    'brand' => Brand::class,
                                    default => null,
                                });
                            }),

                        Checkbox::make('is_correct')
                            ->label('Correct Answer')
                            ->helperText('Check this if this option is correct'),

                        TextInput::make('sort_order')
                            ->label('Display Order')
                            ->numeric()
                            ->placeholder('1, 2, 3...')
                            ->minValue(1)
                            ->helperText('Optional: Set the order this option appears'),

                        // Hidden field to store optionable_type
                        TextInput::make('optionable_type')
                            ->hidden(),
                    ])
                    ->defaultItems(4)
                    ->minItems(2)
                    ->maxItems(6)
                    ->reorderable()
                    ->collapsible()
                    ->collapsed()
                    ->itemLabel(fn (array $state): ?string => match (true) {
                        ! empty($state['option_text']) => $state['option_text'],
                        ! empty($state['optionable_id']) => 'Selected Item',
                        default => 'Option'
                    })
                    ->columnSpanFull()
                    ->afterStateHydrated(function (Set $set, $state) {
                        // Ensure proper state hydration for existing data
                        if (is_array($state)) {
                            foreach ($state as $index => $option) {
                                if (isset($option['optionable_type']) && ! empty($option['optionable_type'])) {
                                    // Set the correct option type based on the optionable_type
                                    $optionType = strtolower(class_basename($option['optionable_type']));
                                    $set("options.{$index}.option_type", $optionType);
                                }
                            }
                        }
                    }),
            ]);
    }
}
