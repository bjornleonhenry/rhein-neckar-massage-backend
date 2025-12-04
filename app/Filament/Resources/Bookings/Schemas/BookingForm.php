<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('girl')
                    ->label('Masseurin')
                    ->options(function () {
                        return \App\Models\Profile::where('active', true)
                            ->orderBy('name')
                            ->pluck('name', 'name')
                            ->toArray();
                    })
                    ->required()
                    ->searchable()
                    ->getSearchResultsUsing(function (string $search) {
                        return \App\Models\Profile::where('active', true)
                            ->where('name', 'like', "%{$search}%")
                            ->orderBy('name')
                            ->pluck('name', 'name')
                            ->toArray();
                    }),
                Select::make('service')
                    ->label('Service')
                    ->options(function () {
                        return \App\Models\Angebot::where('is_active', true)
                            ->orderBy('title')
                            ->get()
                            ->mapWithKeys(function ($angebot) {
                                return [
                                    $angebot->title => $angebot->title . ' - ' . $angebot->duration_minutes . ' Min - ' . number_format($angebot->price, 2) . '€'
                                ];
                            })
                            ->toArray();
                    })
                    ->required()
                    ->searchable()
                    ->getSearchResultsUsing(function (string $search) {
                        return \App\Models\Angebot::where('is_active', true)
                            ->where('title', 'like', "%{$search}%")
                            ->orderBy('title')
                            ->get()
                            ->mapWithKeys(function ($angebot) {
                                return [
                                    $angebot->title => $angebot->title . ' - ' . $angebot->duration_minutes . ' Min - ' . number_format($angebot->price, 2) . '€'
                                ];
                            })
                            ->toArray();
                    }),
                DatePicker::make('date')
                    ->label('Datum')
                    ->required()
                    ->minDate(now()),
                TimePicker::make('time')
                    ->label('Uhrzeit')
                    ->required()
                    ->seconds(false),
                TextInput::make('name')
                    ->label('Kundenname')
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->label('Telefon')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('E-Mail')
                    ->email()
                    ->maxLength(255),
                Textarea::make('message')
                    ->label('Nachricht')
                    ->columnSpanFull(),
                Textarea::make('special_requests')
                    ->label('Besondere Wünsche')
                    ->columnSpanFull(),
                TextInput::make('duration')
                    ->label('Dauer')
                    ->maxLength(255),
                TextInput::make('price')
                    ->label('Preis (€)')
                    ->numeric()
                    ->prefix('€'),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Ausstehend',
                        'confirmed' => 'Bestätigt',
                        'cancelled' => 'Storniert',
                        'completed' => 'Abgeschlossen',
                    ])
                    ->default('pending')
                    ->required(),
                Toggle::make('is_read')
                    ->label('Gelesen')
                    ->default(false),
            ]);
    }
}
