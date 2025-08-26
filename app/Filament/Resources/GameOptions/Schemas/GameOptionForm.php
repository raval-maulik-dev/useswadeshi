<?php

namespace App\Filament\Resources\GameOptions\Schemas;

use App\Models\Brand;
use App\Models\GameQuestion;
use App\Models\Product;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class GameOptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('question_id')
                    ->label('Question')
                    ->options(GameQuestion::all()->pluck('question', 'id'))
                    ->searchable()
                    ->required(),

                TextInput::make('option_text')
                    ->label('Option Text')
                    ->placeholder('Enter option text (leave blank if using a model)'),

                TextInput::make('sort_order')
                    ->label('Sort Order')
                    ->numeric()
                    ->placeholder('1, 2, 3...'),

                Select::make('option_type')
                    ->label('Option Type')
                    ->options([
                        'text' => 'Text Only',
                        'product' => 'Product',
                        'brand' => 'Brand',
                    ])
                    ->default('text')
                    ->reactive()
                    ->afterStateUpdated(function (Set $set) {
                        $set('optionable_id', null);
                        $set('optionable_type', null);
                    }),

                Checkbox::make('is_correct')
                    ->label('Is Correct Answer'),

                Select::make('optionable_id')
                    ->label('Select Product')
                    ->options(function (Get $get) {
                        if ($get('option_type') === 'product') {
                            return Product::all()->pluck('name', 'id');
                        }

                        return [];
                    })
                    ->searchable()
                    ->visible(fn (Get $get) => $get('option_type') === 'product')
                    ->reactive()
                    ->afterStateUpdated(function (Set $set) {
                        $set('optionable_type', Product::class);
                    }),

                Select::make('optionable_id')
                    ->label('Select Brand')
                    ->options(function (Get $get) {
                        if ($get('option_type') === 'brand') {
                            return Brand::all()->pluck('name', 'id');
                        }

                        return [];
                    })
                    ->searchable()
                    ->visible(fn (Get $get) => $get('option_type') === 'brand')
                    ->reactive()
                    ->afterStateUpdated(function (Set $set) {
                        $set('optionable_type', Brand::class);
                    }),
            ]);
    }
}
