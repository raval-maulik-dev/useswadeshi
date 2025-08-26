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
                    ->label('Question')
                    ->limit(50)
                    ->searchable(),

                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'mcq' => 'success',
                        'multi_select' => 'warning',
                        'true_false' => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('difficulty')
                    ->label('Difficulty')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'easy' => 'success',
                        'medium' => 'warning',
                        'hard' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('points')
                    ->label('Points')
                    ->sortable(),

                TextColumn::make('options_count')
                    ->label('Options')
                    ->counts('options')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('game_id')
                    ->label('Game')
                    ->relationship('game', 'name'),

                SelectFilter::make('type')
                    ->label('Question Type')
                    ->options([
                        'mcq' => 'Multiple Choice',
                        'multi_select' => 'Multi Select',
                        'true_false' => 'True/False',
                    ]),

                SelectFilter::make('difficulty')
                    ->label('Difficulty')
                    ->options([
                        'easy' => 'Easy',
                        'medium' => 'Medium',
                        'hard' => 'Hard',
                    ]),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}
