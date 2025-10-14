<?php

namespace App\Filament\Resources\Messages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('E-Mail')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('phone')
                    ->label('Telefon')
                    ->searchable(),
                TextColumn::make('service')
                    ->label('Service')
                    ->searchable(),
                TextColumn::make('date')
                    ->label('Datum')
                    ->date('d.m.Y')
                    ->sortable(),
                TextColumn::make('time')
                    ->label('Zeit')
                    ->time('H:i')
                    ->sortable(),
                IconColumn::make('is_read')
                    ->label('Gelesen')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Erstellt am')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
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
