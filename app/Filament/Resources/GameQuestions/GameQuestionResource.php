<?php

namespace App\Filament\Resources\GameQuestions;

use App\Filament\Resources\GameQuestions\Pages\CreateGameQuestion;
use App\Filament\Resources\GameQuestions\Pages\EditGameQuestion;
use App\Filament\Resources\GameQuestions\Pages\ListGameQuestions;
use App\Filament\Resources\GameQuestions\Schemas\GameQuestionForm;
use App\Filament\Resources\GameQuestions\Tables\GameQuestionsTable;
use App\Models\GameQuestion;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GameQuestionResource extends Resource
{
    protected static ?string $model = GameQuestion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static \UnitEnum|string|null $navigationGroup = 'Gaming';

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

    public static function getHeaderActions(): array
    {
        return [
            Action::make('preview_question')
                ->label('Preview Question')
                ->icon(Heroicon::OutlinedEye)
                ->modalHeading('Question Preview')
                ->modalContent(fn (GameQuestion $record) => view('filament.forms.components.question-preview', [
                    'question' => $record->question,
                    'type' => $record->type,
                    'options' => $record->options->map(function ($option) {
                        return [
                            'option_text' => $option->option_text,
                            'option_type' => $option->optionable_type ? class_basename($option->optionable_type) : 'text',
                            'optionable_id' => $option->optionable_id,
                            'is_correct' => $option->is_correct,
                        ];
                    })->toArray(),
                ]))
                ->modalWidth('lg')
                ->visible(fn (GameQuestion $record) => $record->exists),
        ];
    }
}
