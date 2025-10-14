<?php

namespace App\Filament\Resources\Ambients\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AmbientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('type')
                    ->required(),
                TextInput::make('location')
                    ->required(),
                TextInput::make('capacity')
                    ->required()
                    ->numeric(),
                Textarea::make('features')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('amenities')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->image(),
                TextInput::make('rating')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('size'),
            ]);
    }
}
