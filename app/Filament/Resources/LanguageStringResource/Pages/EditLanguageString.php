<?php

namespace App\Filament\Resources\LanguageStringResource\Pages;

use App\Filament\Resources\LanguageStringResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditLanguageString extends EditRecord
{
    protected static string $resource = LanguageStringResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        /** @var Model $record */
        $record = $this->record;

        $data = $this->form->getState();

        // Persist English translation
        if (array_key_exists('english_translation', $data)) {
            $enValue = $data['english_translation'];
            $en = $record->translations()->firstOrNew(['lang' => 'en']);
            $en->value = $enValue;
            $en->is_active = true;
            $record->translations()->save($en);
        }

        // Persist German translation
        if (array_key_exists('german_translation', $data)) {
            $deValue = $data['german_translation'];
            $de = $record->translations()->firstOrNew(['lang' => 'de']);
            $de->value = $deValue;
            $de->is_active = true;
            $record->translations()->save($de);
        }
    }
}
