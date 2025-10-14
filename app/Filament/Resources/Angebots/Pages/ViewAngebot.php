<?php

namespace App\Filament\Resources\Angebots\Pages;

use App\Filament\Resources\Angebots\AngebotResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAngebot extends ViewRecord
{
    protected static string $resource = AngebotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
