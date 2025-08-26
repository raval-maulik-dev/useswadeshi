<?php

namespace App\Filament\Resources\GameOptions;

use App\Filament\Resources\GameOptions\Pages\CreateGameOption;
use App\Filament\Resources\GameOptions\Pages\EditGameOption;
use App\Filament\Resources\GameOptions\Pages\ListGameOptions;
use App\Filament\Resources\GameOptions\Pages\ViewGameOption;
use App\Filament\Resources\GameOptions\Schemas\GameOptionForm;
use App\Filament\Resources\GameOptions\Tables\GameOptionsTable;
use App\Models\GameOption;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GameOptionResource extends Resource
{
    protected static ?string $model = GameOption::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedListBullet;

    protected static \UnitEnum|string|null $navigationGroup = 'Gaming';

    public static function form(Schema $schema): Schema
    {
        return GameOptionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GameOptionsTable::configure($table);
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
            'index' => ListGameOptions::route('/'),
            'create' => CreateGameOption::route('/create'),
            'view' => ViewGameOption::route('/{record}'),
            'edit' => EditGameOption::route('/{record}/edit'),
        ];
    }
}
