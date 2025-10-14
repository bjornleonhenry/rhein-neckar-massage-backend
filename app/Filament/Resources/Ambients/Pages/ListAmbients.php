<?php

namespace App\Filament\Resources\Ambients\Pages;

use App\Filament\Resources\Ambients\AmbientResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAmbients extends ListRecords
{
    protected static string $resource = AmbientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
