<?php

namespace App\Filament\Resources\Mieterins\Pages;

use App\Filament\Resources\Mieterins\MieterinResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMieterins extends ListRecords
{
    protected static string $resource = MieterinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
