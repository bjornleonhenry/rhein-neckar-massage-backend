<?php

namespace App\Filament\Resources\Gaestebuches\Pages;

use App\Filament\Resources\Gaestebuches\GaestebuchResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditGaestebuch extends EditRecord
{
    protected static string $resource = GaestebuchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
