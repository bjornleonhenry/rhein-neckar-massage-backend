<?php

namespace Filaforge\ApiExplorer\Pages;

use BackedEnum;
use Exception;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Config;
use UnitEnum;

class ApiExplorerPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-globe-alt';

    protected string $view = 'api-explorer::pages.api-explorer';

    protected static ?string $title = 'API Explorer';

    protected static ?string $navigationLabel = 'API Explorer';

    protected static string | UnitEnum | null $navigationGroup = 'Settings';

    public ?array $data = [];

    public string $response = '';

    public int $statusCode = 0;

    public float $responseTime = 0;

    public array $requestHistory = [];

    public function mount(): void
    {
        $this->form->fill([
            'method' => 'GET',
            'url' => '',
            'headers' => '',
            'body' => '',
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('method')
                    ->label('HTTP Method')
                    ->options([
                        'GET' => 'GET',
                        'POST' => 'POST',
                        'PUT' => 'PUT',
                        'DELETE' => 'DELETE',
                        'PATCH' => 'PATCH',
                        'HEAD' => 'HEAD',
                        'OPTIONS' => 'OPTIONS',
                    ])
                    ->required()
                    ->default('GET'),

                TextInput::make('url')
                    ->label('URL')
                    ->placeholder('https://api.example.com/endpoint')
                    ->required()
                    ->url(),

                Textarea::make('headers')
                    ->label('Headers (JSON format)')
                    ->placeholder('{"Content-Type": "application/json", "Authorization": "Bearer token"}')
                    ->rows(3),

                Textarea::make('body')
                    ->label('Request Body')
                    ->placeholder('{"key": "value"}')
                    ->rows(5),
            ])
            ->statePath('data');
    }

    public function sendRequest(): void
    {
        $data = $this->form->getState();

        if (! $data['url']) {
            Notification::make()
                ->title('URL is required')
                ->danger()
                ->send();

            return;
        }

        // No blocking - allow all requests
        // if (config('api-explorer.block_localhost', true) && str_contains($data['url'], 'localhost')) {
        //     Notification::make()
        //         ->title('Localhost requests are blocked for security')
        //         ->danger()
        //         ->send();
        //     return;
        // }

        try {
            // Use shorter timeout for localhost to prevent hanging
            $isLocalhost = str_contains($data['url'], 'localhost') || str_contains($data['url'], '127.0.0.1');
            $timeout = $isLocalhost ? 10 : 30;

            $client = new Client([
                'timeout' => $timeout,
                'connect_timeout' => 5,
                'verify' => false,
            ]);

            $headers = [];
            if (! empty($data['headers'])) {
                $headers = $this->parseHeaders($data['headers']);
            }

            // Add default headers to prevent blocking
            $headers = array_merge($headers, [
                'User-Agent' => 'API-Explorer/1.0',
                'Accept' => 'application/json, text/plain, */*',
                'Accept-Language' => 'en-US,en;q=0.9',
            ]);

            $options = [
                'headers' => $headers,
                'allow_redirects' => true,
                'http_errors' => false,
            ];

            if (! empty($data['body']) && in_array($data['method'], ['POST', 'PUT', 'PATCH'])) {
                $options['body'] = $data['body'];
            }

            $startTime = microtime(true);
            $response = $client->request($data['method'], $data['url'], $options);
            $endTime = microtime(true);

            $this->statusCode = $response->getStatusCode();
            $this->responseTime = round(($endTime - $startTime) * 1000, 2);

            // Handle HTML responses (like 403 error pages)
            $body = $response->getBody()->getContents();
            if (str_starts_with(strtolower($body), '<!doctype') || str_starts_with(strtolower($body), '<html')) {
                $this->response = "HTTP {$this->statusCode} Error\n\nReceived HTML response instead of JSON. This could be due to:\n- CORS restrictions\n- Firewall/Security blocking\n- Rate limiting\n- Invalid endpoint\n\nFirst few characters of response:\n" . substr($body, 0, 200);
            } else {
                $this->response = $this->formatResponse($response);
            }

            // Add to history
            $this->requestHistory[] = [
                'method' => $data['method'],
                'url' => $data['url'],
                'status' => $this->statusCode,
                'time' => $this->responseTime,
                'timestamp' => now()->format('H:i:s'),
            ];

            Notification::make()
                ->title('Request completed')
                ->success()
                ->send();

        } catch (RequestException $e) {
            $this->statusCode = $e->hasResponse() ? $e->getResponse()->getStatusCode() : 0;
            $this->response = $e->getMessage();
            $this->responseTime = 0;

            Notification::make()
                ->title('Request failed')
                ->body($e->getMessage())
                ->danger()
                ->send();
        } catch (Exception $e) {
            $this->response = 'Error: ' . $e->getMessage();
            $this->statusCode = 0;
            $this->responseTime = 0;

            // Special handling for localhost timeouts
            if (str_contains($e->getMessage(), 'Operation timed out') && str_contains($data['url'], 'localhost')) {
                $this->response = "Localhost Request Timeout\n\nThe request to localhost timed out. This could be due to:\n- Laravel development server not running\n- Endpoint taking too long to respond\n- Database query issues\n\nTry:\n1. Check if 'php artisan serve' is running\n2. Test the endpoint directly: curl " . $data['url'] . "\n3. Check Laravel logs for errors";
            }

            Notification::make()
                ->title('Request failed')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    private function parseHeaders(string $headersString): array
    {
        try {
            return json_decode($headersString, true) ?: [];
        } catch (Exception $e) {
            return [];
        }
    }

    private function formatResponse($response): string
    {
        $body = $response->getBody()->getContents();

        // Try to format JSON
        $decoded = json_decode($body, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }

        return $body;
    }

    public function clearResponse(): void
    {
        $this->response = '';
        $this->statusCode = 0;
        $this->responseTime = 0;
    }

    public function clearHistory(): void
    {
        $this->requestHistory = [];
    }

    public function loadSampleRequest(): void
    {
        $this->form->fill([
            'method' => 'GET',
            'url' => 'https://jsonplaceholder.typicode.com/posts/1',
            'headers' => '{"Content-Type": "application/json"}',
            'body' => '',
        ]);
    }
}
