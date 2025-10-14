<?php

namespace App\Filament\Resources\Gaestebuches\Pages;

use App\Filament\Resources\Gaestebuches\GaestebuchResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewGaestebuch extends ViewRecord
{
    protected static string $resource = GaestebuchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
