<?php

namespace App\Filament\Resources\Gaestebuches\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class GaestebuchInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('date')
                    ->date(),
                TextEntry::make('rating')
                    ->numeric(),
                TextEntry::make('service'),
                IconEntry::make('verified')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
