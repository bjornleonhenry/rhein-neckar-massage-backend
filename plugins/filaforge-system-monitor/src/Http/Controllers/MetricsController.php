<?php

namespace Filaforge\SystemMonitor\Http\Controllers;

use Filaforge\SystemMonitor\Services\SystemMetricsProvider;
use Illuminate\Routing\Controller;

class MetricsController extends Controller
{
    public function index(SystemMetricsProvider $provider)
    {
        return response()->json($provider->collect());
    }
}
