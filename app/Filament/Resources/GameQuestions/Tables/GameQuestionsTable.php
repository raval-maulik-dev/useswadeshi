<?php

namespace App\Filament\Resources\GameQuestions\Tables;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class GameQuestionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('game.name')
                    ->label('Game')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('question')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('options')
                    ->label('Options')
                    ->limit(30)
                    ->toggleable(),
                TextColumn::make('correct_answer')
                    ->label('Correct Answer')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('game_id')
                    ->label('Game')
                    ->relationship('game', 'name'),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}
