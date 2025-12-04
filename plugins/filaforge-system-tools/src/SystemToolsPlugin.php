<?php

namespace Filaforge\SystemTools;

use Filaforge\SystemTools\Pages\SystemTools;
use Filament\Contracts\Plugin as PluginContract;
use Filament\Panel;

class SystemToolsPlugin implements PluginContract
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'system-tools';
    }

    public function register(Panel $panel): void
    {
        $panel->pages([
            SystemTools::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
