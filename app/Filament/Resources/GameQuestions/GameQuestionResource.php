<?php

namespace App\Filament\Resources\GameQuestions;

use App\Filament\Resources\GameQuestions\Pages\CreateGameQuestion;
use App\Filament\Resources\GameQuestions\Pages\EditGameQuestion;
use App\Filament\Resources\GameQuestions\Pages\ListGameQuestions;
use App\Filament\Resources\GameQuestions\Schemas\GameQuestionForm;
use App\Filament\Resources\GameQuestions\Tables\GameQuestionsTable;
use App\Models\GameQuestion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GameQuestionResource extends Resource
{
    protected static ?string $model = GameQuestion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return GameQuestionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GameQuestionsTable::configure($table);
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
            'index' => ListGameQuestions::route('/'),
            'create' => CreateGameQuestion::route('/create'),
            'edit' => EditGameQuestion::route('/{record}/edit'),
        ];
    }
}
