<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class UmamiService
{
    protected ?string $websiteId;
    protected ?string $hostUrl;
    protected bool $enabled;
    
    public function __construct()
    {
        $this->websiteId = env('VITE_UMAMI_WEBSITE_ID');
        $this->hostUrl = env('VITE_UMAMI_HOST_URL');
        $this->enabled = env('VITE_ENABLE_UMAMI_DEV', false);
    }
    
    public function isEnabled(): bool
    {
        return $this->enabled && !empty($this->websiteId) && !empty($this->hostUrl);
    }
    
    public function getStats(array $params = []): array
    {
        // For now, always return mock data since we don't have real Umami API
        return $this->getMockStats();
        
        if (!$this->isEnabled()) {
            return $this->getMockStats();
        }
        
        try {
            $response = Http::timeout(10)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->getAuthToken(),
                    'Content-Type' => 'application/json',
                ])
                ->get($this->hostUrl . '/api/websites/' . $this->websiteId . '/stats', $params);
                
            if ($response->successful()) {
                return $response->json();
            }
            
            return $this->getMockStats();
        } catch (\Exception $e) {
            return ['error' => 'Failed to fetch stats: ' . $e->getMessage()];
        }
    }
    
    public function getMetrics(string $type, array $params = []): array
    {
        // For now, always return mock data since we don't have real Umami API
        return $this->getMockMetrics($type);
        
        if (!$this->isEnabled()) {
            return $this->getMockMetrics($type);
        }
        
        try {
            $response = Http::timeout(10)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->getAuthToken(),
                    'Content-Type' => 'application/json',
                ])
                ->get($this->hostUrl . '/api/websites/' . $this->websiteId . '/metrics', array_merge($params, ['type' => $type]));
                
            if ($response->successful()) {
                return $response->json();
            }
            
            return $this->getMockMetrics($type);
        } catch (\Exception $e) {
            return ['error' => 'Failed to fetch metrics: ' . $e->getMessage()];
        }
    }
    
    protected function getAuthToken(): string
    {
        // In a real implementation, you would authenticate with Umami
        // This might involve username/password or API key
        return env('UMAMI_API_TOKEN', 'mock-token');
    }
    
    protected function getMockStats(): array
    {
        return [
            'visitors' => [
                'today' => rand(100, 500),
                'yesterday' => rand(80, 400),
                'this_month' => rand(2000, 8000),
                'last_month' => rand(1800, 7500),
            ],
            'pageviews' => [
                'today' => rand(500, 2000),
                'yesterday' => rand(400, 1800),
                'this_month' => rand(10000, 40000),
                'last_month' => rand(9000, 38000),
            ],
            'bounce_rate' => rand(30, 70) . '%',
            'avg_session_duration' => rand(120, 600) . 's',
        ];
    }
    
    protected function getMockMetrics(string $type): array
    {
        return match($type) {
            'url' => [
                ['x' => '/', 'y' => rand(100, 500)],
                ['x' => '/angebote', 'y' => rand(50, 200)],
                ['x' => '/galerie', 'y' => rand(30, 150)],
                ['x' => '/kontakt', 'y' => rand(20, 100)],
                ['x' => '/ueber-uns', 'y' => rand(15, 80)],
            ],
            'referrer' => [
                ['x' => 'Direct', 'y' => rand(100, 300)],
                ['x' => 'google.com', 'y' => rand(50, 150)],
                ['x' => 'facebook.com', 'y' => rand(20, 80)],
                ['x' => 'instagram.com', 'y' => rand(15, 60)],
                ['x' => 'Other', 'y' => rand(30, 100)],
            ],
            'browser' => [
                ['x' => 'Chrome', 'y' => rand(200, 400)],
                ['x' => 'Safari', 'y' => rand(100, 200)],
                ['x' => 'Firefox', 'y' => rand(50, 100)],
                ['x' => 'Edge', 'y' => rand(30, 80)],
                ['x' => 'Other', 'y' => rand(20, 60)],
            ],
            'device' => [
                ['x' => 'Desktop', 'y' => rand(200, 400)],
                ['x' => 'Mobile', 'y' => rand(150, 300)],
                ['x' => 'Tablet', 'y' => rand(30, 80)],
            ],
            'country' => [
                ['x' => 'Germany', 'y' => rand(300, 500)],
                ['x' => 'Austria', 'y' => rand(50, 100)],
                ['x' => 'Switzerland', 'y' => rand(30, 80)],
                ['x' => 'Netherlands', 'y' => rand(20, 60)],
                ['x' => 'Other', 'y' => rand(40, 100)],
            ],
            default => [],
        };
    }
}