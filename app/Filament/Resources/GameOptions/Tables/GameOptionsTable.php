<?php

namespace App\Filament\Resources\GameOptions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class GameOptionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question.question')
                    ->label('Question')
                    ->limit(50)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('display_text')
                    ->label('Option')
                    ->limit(30)
                    ->searchable(),

                TextColumn::make('optionable_type')
                    ->label('Type')
                    ->formatStateUsing(function ($state) {
                        if (! $state) {
                            return 'Text';
                        }

                        return class_basename($state);
                    })
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'Product' => 'success',
                        'Brand' => 'warning',
                        default => 'gray',
                    }),

                IconColumn::make('is_correct')
                    ->label('Correct')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('is_correct')
                    ->label('Correct Answer')
                    ->options([
                        '1' => 'Correct',
                        '0' => 'Incorrect',
                    ]),

                SelectFilter::make('optionable_type')
                    ->label('Option Type')
                    ->options([
                        null => 'Text',
                        'App\Models\Product' => 'Product',
                        'App\Models\Brand' => 'Brand',
                    ]),

                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
