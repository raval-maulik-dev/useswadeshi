<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Vendor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Enter product name'),
                Textarea::make('description')
                    ->rows(3)
                    ->placeholder('Enter product description'),
                Select::make('product_type')
                    ->options([
                        'local' => 'Local',
                        'foreign' => 'Foreign',
                    ])
                    ->required()
                    ->searchable()
                    ->placeholder('Select product type'),
                Select::make('brand_id')
                    ->label('Brand')
                    ->relationship('brand', 'name')
                    ->searchable()
                    ->placeholder('Select brand'),
                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->placeholder('Select category')->options(
                        \App\Models\Category::query()
                            ->limit(5) // preload when nothing is typed
                            ->pluck('name', 'id')
                            ->toArray()
                    ),
                Select::make('vendor_id')
                    ->label('Vendor')
                    ->relationship('vendor', 'business_name')
                    ->searchable()
                    ->placeholder('Select vendor'),
                TextInput::make('image_url')
                    ->label('Image URL')
                    ->url()
                    ->placeholder('Enter image URL'),
            ]);
    }
}
