<?php

use Filaforge\SystemMonitor\Http\Controllers\MetricsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])
    ->get('/filaforge-system-monitor/metrics', [MetricsController::class, 'index'])
    ->name('filaforge-system-monitor.metrics');
