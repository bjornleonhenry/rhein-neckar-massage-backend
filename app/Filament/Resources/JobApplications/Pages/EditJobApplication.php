<?php

namespace App\Filament\Resources\JobApplications\Pages;

use App\Filament\Resources\JobApplications\JobApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJobApplication extends EditRecord
{
    protected static string $resource = JobApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
