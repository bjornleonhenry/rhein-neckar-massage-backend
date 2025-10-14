<?php

namespace App\Filament\Pages;

use App\Settings\SiteSettings;
use BackedEnum;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageFooter extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    // Do not register this settings page in the Filament navigation menu.
    protected static bool $shouldRegisterNavigation = false;

    protected static string $settings = SiteSettings::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }
}
