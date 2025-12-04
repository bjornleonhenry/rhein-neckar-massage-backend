<?php

namespace Filaforge\HelloWidget\Providers;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class HelloWidgetServiceProvider extends PackageServiceProvider
{
    public static string $name = 'hello-widget';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasViews()
            ->hasTranslations()
            ->hasMigrations()
            ->hasAssets();

        FilamentAsset::register([
            Css::make('hello-widget', __DIR__ . '/../../resources/css/hello-widget.css'),
        ], 'filaforge/hello-widget');
    }
}
