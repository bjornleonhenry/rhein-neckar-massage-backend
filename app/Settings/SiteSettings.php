<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SiteSettings extends Settings
{
    // Provide sensible defaults so the settings loader won't fail when no
    // persisted settings exist yet.
    public string $site_name = 'My Site';

    public ?string $footer_text = null;

    public bool $maintenance_mode = false;

    public bool $age_confirmation = false;

    public static function group(): string
    {
        return 'site';
    }
}
