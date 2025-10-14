<?php

namespace App\Filament\Resources\Gaestebuches\Pages;

use App\Filament\Resources\Gaestebuches\GaestebuchResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGaestebuches extends ListRecords
{
    protected static string $resource = GaestebuchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
