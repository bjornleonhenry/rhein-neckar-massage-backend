<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;

class BookingInfolist
{
    public static function configure(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Buchungsdetails')
                    ->schema([
                        TextEntry::make('girl')
                            ->label('Masseurin'),
                        TextEntry::make('service')
                            ->label('Service'),
                        TextEntry::make('date')
                            ->label('Datum')
                            ->date('d.m.Y'),
                        TextEntry::make('time')
                            ->label('Uhrzeit')
                            ->time('H:i'),
                        TextEntry::make('duration')
                            ->label('Dauer'),
                        TextEntry::make('price')
                            ->label('Preis')
                            ->money('EUR'),
                    ])
                    ->columns(2),
                Section::make('Kundendaten')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Name'),
                        TextEntry::make('phone')
                            ->label('Telefon'),
                        TextEntry::make('email')
                            ->label('E-Mail'),
                    ])
                    ->columns(2),
                Section::make('Zusätzliche Informationen')
                    ->schema([
                        TextEntry::make('message')
                            ->label('Nachricht')
                            ->columnSpanFull()
                            ->prose(),
                        TextEntry::make('special_requests')
                            ->label('Besondere Wünsche')
                            ->columnSpanFull()
                            ->prose(),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => match($state) {
                                'pending' => 'Ausstehend',
                                'confirmed' => 'Bestätigt',
                                'cancelled' => 'Storniert',
                                'completed' => 'Abgeschlossen',
                                default => $state,
                            })
                            ->color(fn (string $state): string => match($state) {
                                'pending' => 'warning',
                                'confirmed' => 'success',
                                'cancelled' => 'danger',
                                'completed' => 'info',
                                default => 'gray',
                            }),
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
