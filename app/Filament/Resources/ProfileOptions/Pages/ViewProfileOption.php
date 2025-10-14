<?php

namespace App\Filament\Resources\ProfileOptions\Pages;

use App\Filament\Resources\ProfileOptions\ProfileOptionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProfileOption extends ViewRecord
{
    protected static string $resource = ProfileOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
