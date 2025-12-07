<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use App\Filament\Pages\Dashboard;
use App\Filament\Pages\Notifications;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Navigation\NavigationGroup;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Widgets\ThemeToggle;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Blade;
use Marjose123\FilamentWebhookServer\WebhookPlugin;
use Awcodes\QuickCreate\QuickCreatePlugin;
use Swis\Filament\Backgrounds\FilamentBackgroundsPlugin;
use Swis\Filament\Backgrounds\ImageProviders\MyImages;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;
use Livewire\Livewire;
use Filaforge\DatabaseQuery\DatabaseQueryPlugin;
use Filaforge\DeepseekChat\Providers\DeepseekChatPanelPlugin;
use Filaforge\TerminalConsole\TerminalConsolePlugin;
use Xentixar\FilamentPushNotifications\PushNotification;
use BinaryBuilds\CommandRunner\CommandRunnerPlugin;
use Muazzam\SlickScrollbar\SlickScrollbarPlugin;
use ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin;
use ShuvroRoy\FilamentSpatieLaravelHealth\FilamentSpatieLaravelHealthPlugin;
use WatheqAlshowaiter\FilamentStickyTableHeader\StickyTableHeaderPlugin;
use Resma\FilamentAwinTheme\FilamentAwinTheme;



class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
                Notifications::class,
                \App\Filament\Pages\ApiExplorerPage::class,
                \App\Filament\Pages\DatabaseViewer::class,
            ])    
                        ->brandLogo(fn () => view('filament.app.logo'))
            ->brandName('fireflow')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->widgets([
                AccountWidget::class,
                ThemeToggle::class,
                \App\Filament\Widgets\CalendarWidget::class,
            ])
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Content')
                    ->collapsed(),
                NavigationGroup::make()
                    ->label('System')
                    ->collapsed(),
                NavigationGroup::make()
                    ->label('Settings')
                    ->collapsed(),
                NavigationGroup::make()
                    ->label('Developer')
                    ->collapsed(),
            ])
            ->databaseNotifications()
            ->globalSearch()
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->spa()
            ->colors([
                'primary' => Color::Blue,
            ])
            ->plugins([
                // ... other plugins
            //    PushNotification::make(),
                CommandRunnerPlugin::make()->canDeleteCommandHistory(fn ($user) => $user?->isAdmin() ?? false),
                SlickScrollbarPlugin::make(),
                FilamentSpatieLaravelBackupPlugin::make(),
                FilamentSpatieLaravelHealthPlugin::make(),
                StickyTableHeaderPlugin::make(),
            ])
            ->plugins([
                FilamentBackgroundsPlugin::make()
                    ->showAttribution(false)
                    ->imageProvider(
                        MyImages::make()
                            ->directory('images/splash')
                    ),
                FilamentFullCalendarPlugin::make(),
            ])
         ->plugins([
                DatabaseQueryPlugin::make(),
                TerminalConsolePlugin::make(),
                DeepseekChatPanelPlugin::make(),
            ])
            ->plugins([
                QuickCreatePlugin::make()
                    ->excludes([
                        \App\Filament\Resources\UserResource::class,
                    ]),
            ])
        //    ->plugin(\Filaforge\TerminalConsole\TerminalConsolePlugin::make())
        //     ->plugin(\Filaforge\DatabaseTools\DatabaseToolsPlugin::make())
            ->plugin(\ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin::make())
                   ->plugins([
            FilamentAwinTheme::make(),
                   ])
            ->plugins([
              WebhookPlugin::make()
                    ->icon('heroicon-o-bolt') // Set the icon for the plugin
                    ->enableApiRoutes() // Enable the API routes
                    ->includeModels([]) // Include the models you want to be able to receive webhooks for that is not automatically included
                    ->excludedModels([]) // Exclude the models you don't want to be able to receive webhooks for
                    ->keepLogs() // Keep the logs of the webhooks
                    ->sort(1) // Set the sort order of the webhooks plugin in the navigation
                    ->polling(30) // Set the polling interval in seconds for the webhook plugin
                    // Optionally set custom pages using existing Livewire components.
                    // ->customPageUsing(webhookPage: Webhooks::class, webhookHistoryPage: WebhookHistory::class)
                    ->enablePlugin()
                    ->navigationGroup('Settings'),
                    
        ]);
    }

    public function boot(): void
    {
        // Remove blue focus outlines from topbar buttons (bell and avatar)
        Filament::registerRenderHook(
            'panels::styles',
            fn (): string => '
<style>
/* Remove focus rings from topbar buttons */
.fi-topbar .fi-icon-btn:focus,
.fi-topbar .fi-user-menu-trigger:focus,
.fi-topbar .fi-notifications-trigger:focus {
    outline: none !important;
    box-shadow: none !important;
}

/* Hide scrollbar on sidebar navigation */
.fi-sidebar-nav {
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE and Edge */
}

.fi-sidebar-nav::-webkit-scrollbar {
    display: none; /* Chrome, Safari, and Opera */
}
</style>
            ',
        );

        // Ensure Livewire can resolve the calendar widget component name used by Filament
        if (class_exists(\App\Filament\Widgets\CalendarWidget::class)) {
            Livewire::component('app.filament.widgets.calendar-widget', \App\Filament\Widgets\CalendarWidget::class);
        }

        // Add Alpine.js $persist polyfill for compatibility with Livewire v3.6.4
        Filament::registerRenderHook(
            'panels::scripts.before',
            fn (): string => '
<script>
// Alpine.js $persist polyfill for Livewire v3.6.4 compatibility
document.addEventListener("alpine:init", () => {
    if (typeof window.Alpine.$persist === "undefined") {
        window.Alpine.$persist = function(initialValue) {
            return function(el, { effect, evaluateLater }) {
                let key = el.getAttribute("x-data-persist");
                if (!key) {
                    key = "alpine-persist-" + Math.random().toString(36).substr(2, 9);
                    el.setAttribute("x-data-persist", key);
                }
                
                let stored = localStorage.getItem(key);
                let value = stored ? JSON.parse(stored) : initialValue;
                
                effect(() => {
                    localStorage.setItem(key, JSON.stringify(value));
                });
                
                return value;
            };
        };
    }
});
</script>
            ',
        );
    }


}
