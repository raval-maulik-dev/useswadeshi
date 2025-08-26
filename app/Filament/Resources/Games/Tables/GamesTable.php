<?php

namespace App\Filament\Resources\Games\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class GamesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('total_questions')
                    ->label('Questions')
                    ->formatStateUsing(fn ($state) => $state ? $state : 'All')
                    ->badge()
                    ->color('info'),

                TextColumn::make('per_question_time')
                    ->label('Time Limit')
                    ->formatStateUsing(fn ($state) => $state ? $state.'s' : '∞')
                    ->badge()
                    ->color('warning'),

                TextColumn::make('max_attempts')
                    ->label('Max Attempts')
                    ->formatStateUsing(fn ($state) => $state ? $state : '∞')
                    ->badge()
                    ->color('success'),

                ToggleColumn::make('is_active')
                    ->label('Active')
                    ->sortable(),

                ToggleColumn::make('allow_replay')
                    ->label('Replay')
                    ->sortable(),

                TextColumn::make('gameQuestions_count')
                    ->label('Total Questions')
                    ->counts('gameQuestions')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('gameResults_count')
                    ->label('Attempts')
                    ->counts('gameResults')
                    ->badge()
                    ->color('secondary'),

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
                TernaryFilter::make('is_active')
                    ->label('Active Games')
                    ->placeholder('All Games')
                    ->trueLabel('Active Only')
                    ->falseLabel('Inactive Only'),

                TernaryFilter::make('allow_replay')
                    ->label('Replay Allowed')
                    ->placeholder('All Games')
                    ->trueLabel('Replay Allowed')
                    ->falseLabel('No Replay'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
