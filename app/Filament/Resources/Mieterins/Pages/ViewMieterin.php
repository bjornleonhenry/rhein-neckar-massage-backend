<?php

namespace App\Filament\Resources\Mieterins\Pages;

use App\Filament\Resources\Mieterins\MieterinResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMieterin extends ViewRecord
{
    protected static string $resource = MieterinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
