<?php

namespace App\Filament\Resources\Mieterins\Pages;

use App\Filament\Resources\Mieterins\MieterinResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMieterin extends EditRecord
{
    protected static string $resource = MieterinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
