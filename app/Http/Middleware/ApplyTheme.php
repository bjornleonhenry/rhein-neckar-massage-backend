<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class ApplyTheme
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Get the current theme from cookie or default to light
        $theme = Cookie::get('theme', 'light');

        // Ensure theme is valid
        if (!in_array($theme, ['light', 'dark'])) {
            $theme = 'light';
        }

        // If this is an HTML response and we're in dark mode, add the dark class
        if ($response instanceof \Illuminate\Http\Response &&
            $response->headers->get('Content-Type') === 'text/html; charset=UTF-8' &&
            $theme === 'dark') {

            $content = $response->getContent();

            // Add dark class to html element if it doesn't already have it
            if (strpos($content, '<html') !== false && strpos($content, 'class="dark"') === false) {
                $content = preg_replace(
                    '/<html([^>]*)>/',
                    '<html$1 class="dark">',
                    $content
                );
                $response->setContent($content);
            }
        }

        return $response;
    }
}
