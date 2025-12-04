<?php

namespace Filaforge\DatabaseViewer;

use Filaforge\DatabaseViewer\Pages\DatabaseViewer;
use Filament\Contracts\Plugin as PluginContract;
use Filament\Panel;

class DatabaseViewerPlugin implements PluginContract
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'database-viewer';
    }

    public function register(Panel $panel): void
    {
        $panel->pages([
            DatabaseViewer::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
