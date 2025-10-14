<?php

namespace App\Filament\Resources\Settings\Pages;

use App\Filament\Resources\Settings\SettingsResource;
use App\Models\SimpleSettingsModel;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Table;

class ListSettings extends ListRecords
{
    protected static string $resource = SettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('manage_settings')
                ->label('Manage Settings')
                ->icon('heroicon-o-cog-6-tooth')
                ->url(fn () => $this->getResource()::getUrl('index'))
                ->visible(true),
        ];
    }

    public function table(Table $table): Table
    {
        return parent::table($table)
            ->defaultSort('updated_at', 'desc');
    }
}
