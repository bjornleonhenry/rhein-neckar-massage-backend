<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get allowed origins from config
        $allowedOrigins = config('cors.allowed_origins');
        $origin = $request->header('Origin');

        // Handle preflight OPTIONS request
        if ($request->isMethod('OPTIONS')) {
            return response('', 200)
                ->header('Access-Control-Allow-Origin', $this->getAllowedOrigin($origin, $allowedOrigins))
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, Authorization, Accept, Origin, X-CSRF-TOKEN')
                ->header('Access-Control-Allow-Credentials', 'true')
                ->header('Access-Control-Max-Age', '86400');
        }

        $response = $next($request);

        // Add CORS headers to response
        $response->headers->set('Access-Control-Allow-Origin', $this->getAllowedOrigin($origin, $allowedOrigins));
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, Authorization, Accept, Origin, X-CSRF-TOKEN');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        $response->headers->set('Access-Control-Expose-Headers', 'Content-Length, Content-Type');

        return $response;
    }

    /**
     * Get the allowed origin based on request origin
     */
    private function getAllowedOrigin(?string $origin, array|string $allowedOrigins): string
    {
        // Convert to array for consistent handling
        $origins = is_array($allowedOrigins) ? $allowedOrigins : [$allowedOrigins];

        // If wildcard is allowed, return the request origin or wildcard
        if (in_array('*', $origins, true)) {
            return $origin ?? '*';
        }

        // If request origin is in allowed list, return it
        if ($origin && in_array($origin, $origins, true)) {
            return $origin;
        }

        // Default to first allowed origin
        return $origins[0] ?? '*';
    }
}
