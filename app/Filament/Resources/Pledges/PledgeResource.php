<?php

namespace App\Filament\Resources\Pledges;

use App\Filament\Resources\Pledges\Pages\CreatePledge;
use App\Filament\Resources\Pledges\Pages\EditPledge;
use App\Filament\Resources\Pledges\Pages\ListPledges;
use App\Filament\Resources\Pledges\Schemas\PledgeForm;
use App\Filament\Resources\Pledges\Tables\PledgesTable;
use App\Models\Pledge;
use BackedEnum;
use Filament\Resources\Resource;
use UnitEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PledgeResource extends Resource
{
    protected static ?string $model = Pledge::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-hand-raised';

    protected static ?string $navigationLabel = 'Pledges';

    protected static ?string $modelLabel = 'Pledge';

    protected static ?string $pluralModelLabel = 'Pledges';

    protected static UnitEnum|string|null $navigationGroup = 'User Engagement';

    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return PledgeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PledgesTable::configure($table);
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
            'index' => ListPledges::route('/'),
            'create' => CreatePledge::route('/create'),
            'edit' => EditPledge::route('/{record}/edit'),
        ];
    }
}
