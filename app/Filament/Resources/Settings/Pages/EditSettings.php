<?php

namespace App\Filament\Resources\Settings\Pages;

use App\Filament\Resources\Settings\SettingsResource;
use App\Models\SimpleSettingsModel;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Cache;

class EditSettings extends EditRecord
{
    protected static string $resource = SettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('reset')
                ->label('Reset to Defaults')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Reset Settings')
                ->modalDescription('Are you sure you want to reset all settings to their default values? This action cannot be undone.')
                ->action(function () {
                    // Reset settings to defaults
                    \Illuminate\Support\Facades\DB::table('settings')->whereIn('key', [
                        'site_name', 'footer_text', 'maintenance_mode', 'age_confirmation'
                    ])->delete();

                    // Create default settings
                    \Illuminate\Support\Facades\DB::table('settings')->insert([
                        [
                            'key' => 'site_name',
                            'title' => 'Site Name',
                            'value' => 'My Site',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ],
                        [
                            'key' => 'footer_text',
                            'title' => 'Footer Text',
                            'value' => null,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ],
                        [
                            'key' => 'maintenance_mode',
                            'title' => 'Maintenance Mode',
                            'value' => false,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ],
                        [
                            'key' => 'age_confirmation',
                            'title' => 'Age Confirmation',
                            'value' => false,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ],
                    ]);

                    Cache::forget('site_settings');
                    // Ensure frontend picks up latest settings immediately
                    Cache::forget('public_site_settings');

                    Notification::make()
                        ->title('Settings Reset')
                        ->body('All settings have been reset to their default values.')
                        ->success()
                        ->send();

                    return redirect()->back();
                }),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Clear any cached settings
        Cache::forget('site_settings');
        // Ensure frontend picks up latest settings immediately
        Cache::forget('public_site_settings');

        return $data;
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->title('Settings Updated')
            ->body('The site settings have been successfully updated.')
            ->success();
    }
}
