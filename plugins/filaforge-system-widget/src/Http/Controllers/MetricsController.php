<?php

namespace Filaforge\FilamentSystemMonitor\Http\Controllers;

use Filaforge\FilamentSystemMonitor\Services\SystemMetricsProvider;
use Illuminate\Routing\Controller;

class MetricsController extends Controller
{
    public function index(SystemMetricsProvider $provider)
    {
        return response()->json($provider->collect());
    }
}
