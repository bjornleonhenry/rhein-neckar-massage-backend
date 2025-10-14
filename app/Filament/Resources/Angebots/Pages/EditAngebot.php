<?php

namespace App\Filament\Resources\Angebots\Pages;

use App\Filament\Resources\Angebots\AngebotResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAngebot extends EditRecord
{
    protected static string $resource = AngebotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
