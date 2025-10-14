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
                    ->options([
                        'Lila' => 'Lila - Tantra, Thai Massage, Entspannung',
                        'Maya' => 'Maya - Erotik Massage, Öl Massage, VIP Service',
                        'Nira' => 'Nira - Paar Massage, Wellness, Entspannung',
                        'Kira' => 'Kira - Tantra, Meditation, Spirituell',
                        'Siri' => 'Siri - Hot Stone, Deep Tissue, Reflexologie',
                        'Ploy' => 'Ploy - Erotik Massage, Körperbehandlung, Intimität',
                        'Anya' => 'Anya - VIP Service, Luxus Behandlung, Diskretion',
                        'Nin' => 'Nin - Aromatherapie, Entspannung, Wellness',
                    ])
                    ->required()
                    ->searchable(),
                Select::make('service')
                    ->label('Service')
                    ->options([
                        'Erotik Massage' => 'Erotik Massage - 60-90 Min - ab 150€',
                        'Tantra Massage' => 'Tantra Massage - 90-120 Min - ab 200€',
                        'VIP Service' => 'VIP Service - 120-180 Min - ab 300€',
                        'Paar Erlebnis' => 'Paar Erlebnis - 90-150 Min - ab 350€',
                        'Body-to-Body' => 'Body-to-Body - 60-90 Min - ab 180€',
                        'Girlfriend Experience' => 'Girlfriend Experience - 120-240 Min - ab 400€',
                        'Thai Massage' => 'Thai Massage - 60-90 Min - ab 120€',
                        'Öl Massage' => 'Öl Massage - 60-90 Min - ab 140€',
                    ])
                    ->required()
                    ->searchable(),
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
