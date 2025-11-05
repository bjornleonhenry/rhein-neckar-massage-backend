<?php

namespace App\Filament\Resources\Angebots\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AngebotForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('€'),
                TextInput::make('duration_minutes')
                    ->required()
                    ->numeric(),
                TextInput::make('category')
                    ->required(),
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('angebots')
                    ->visibility('public'),
                Textarea::make('services')
                    ->columnSpanFull(),
                Repeater::make('options')
                    ->relationship('options')
                    ->schema([
                        TextInput::make('title')
                            ->placeholder('z.B. 60 Min, 90 Min')
                            ->columnSpan(1),
                        TextInput::make('angebot_price')
                            ->label('Price')
                            ->required()
                            ->numeric()
                            ->prefix('€')
                            ->columnSpan(1),
                        TextInput::make('angebot_time')
                            ->label('Duration (minutes)')
                            ->required()
                            ->numeric()
                            ->suffix('Min')
                            ->columnSpan(1),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->columnSpan(1),
                    ])
                    ->columns(4)
                    ->defaultItems(1)
                    ->addActionLabel('Add Price Option')
                    ->collapsible()
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->required()
                    ->default(true),
            ]);
    }
}
