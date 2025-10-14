<?php

namespace App\Filament\Resources\Ambients\Pages;

use App\Filament\Resources\Ambients\AmbientResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAmbient extends EditRecord
{
    protected static string $resource = AmbientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
