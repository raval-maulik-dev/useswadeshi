<?php

namespace App\Filament\Resources\ProductAlternatives;

use App\Filament\Resources\ProductAlternatives\Pages\CreateProductAlternative;
use App\Filament\Resources\ProductAlternatives\Pages\EditProductAlternative;
use App\Filament\Resources\ProductAlternatives\Pages\ListProductAlternatives;
use App\Filament\Resources\ProductAlternatives\Schemas\ProductAlternativeForm;
use App\Filament\Resources\ProductAlternatives\Tables\ProductAlternativesTable;
use App\Models\ProductAlternative;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProductAlternativeResource extends Resource
{
    protected static ?string $model = ProductAlternative::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static \UnitEnum|string|null $navigationGroup = 'Product Management';

    public static function form(Schema $schema): Schema
    {
        return ProductAlternativeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductAlternativesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProductAlternatives::route('/'),
            'create' => CreateProductAlternative::route('/create'),
            'edit' => EditProductAlternative::route('/{record}/edit'),
        ];
    }
}
