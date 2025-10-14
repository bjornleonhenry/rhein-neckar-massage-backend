<?php

namespace App\Filament\Resources\Angebots\Pages;

use App\Filament\Resources\Angebots\AngebotResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAngebots extends ListRecords
{
    protected static string $resource = AngebotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
