<?php

namespace App\Filament\Resources\Messages\Schemas;

use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MessageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Kontaktdaten')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Name'),
                        TextEntry::make('email')
                            ->label('E-Mail'),
                        TextEntry::make('phone')
                            ->label('Telefon'),
                    ])
                    ->columns(3),
                Section::make('Termindetails')
                    ->schema([
                        TextEntry::make('service')
                            ->label('Service'),
                        TextEntry::make('date')
                            ->label('Datum')
                            ->date('d.m.Y'),
                        TextEntry::make('time')
                            ->label('Zeit')
                            ->time('H:i'),
                    ])
                    ->columns(3),
                Section::make('Nachricht')
                    ->schema([
                        TextEntry::make('message')
                            ->label('Nachricht')
                            ->columnSpanFull()
                            ->prose(),
                        TextEntry::make('is_read')
                            ->label('Gelesen')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => $state ? 'Ja' : 'Nein')
                            ->color(fn (string $state): string => $state ? 'success' : 'warning'),
                    ]),
                Section::make('Zeitstempel')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Erstellt am')
                            ->dateTime('d.m.Y H:i'),
                        TextEntry::make('updated_at')
                            ->label('Aktualisiert am')
                            ->dateTime('d.m.Y H:i'),
                    ])
                    ->columns(2),
            ]);
    }
}
