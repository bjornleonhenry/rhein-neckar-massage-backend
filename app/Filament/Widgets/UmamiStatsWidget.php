<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Services\UmamiService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class UmamiStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        $umamiService = new UmamiService();
        
        if (!$umamiService->isEnabled()) {
            return [];
        }
        
        $stats = Cache::remember('umami_widget_stats', 3600, function () use ($umamiService) {
            return $umamiService->getStats();
        });
        
        if (isset($stats['error'])) {
            return [];
        }
        
        return [
            Stat::make('Visitors Today', $stats['visitors']['today'] ?? 0)
                ->description($stats['visitors']['yesterday'] ?? 0 . ' yesterday')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
                
            Stat::make('Pageviews Today', $stats['pageviews']['today'] ?? 0)
                ->description($stats['pageviews']['yesterday'] ?? 0 . ' yesterday')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
                
            Stat::make('Bounce Rate', $stats['bounce_rate'] ?? '0%')
                ->description('Average bounce rate')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('warning'),
        ];
    }
    
    public static function canView(): bool
    {
        // Allow any authenticated user (you can restrict this further if needed)
        return Auth::check();
    }
}