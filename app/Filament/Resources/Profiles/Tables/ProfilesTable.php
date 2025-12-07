<?php

namespace App\Filament\Resources\Profiles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ProfilesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                ToggleColumn::make('active')
                    ->label('Active')
                    ->sortable(),
                ImageColumn::make('main_image')
                    ->label('Main Image')
                    ->getStateUsing(function ($record) {
                        // Use the model's accessor method which handles URL generation correctly
                        return $record->main_image_url;
                    })
                    ->defaultImageUrl('https://via.placeholder.com/40x40?text=No+Image')
                    ->circular()
                    ->size(40),
                TextColumn::make('age')
                    ->numeric()
                    ->sortable()
                    ->suffix(' Jahre'),
                TextColumn::make('origin')
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('body_type')
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('weight')
                    ->numeric()
                    ->sortable()
                    ->suffix(' kg')
                    ->placeholder('—'),
                TextColumn::make('height')
                    ->numeric()
                    ->sortable()
                    ->suffix(' cm')
                    ->placeholder('—'),
                TextColumn::make('bust_size')
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('created_at')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                \Filament\Tables\Filters\TernaryFilter::make('active')
                    ->label('Status')
                    ->placeholder('All profiles')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
