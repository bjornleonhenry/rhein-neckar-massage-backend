<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie', 'storage/*'],

    'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],

    // Allowed origins. Keep the local env fallback and add known production domains.
    // When requests include credentials the origin must be explicit (not '*').
    'allowed_origins' => [
        env('FRONTEND_URL', 'http://localhost:5555'),
        'https://rhein-neckar-massage.de',
        'https://atelier-heidelberg.de',
        'https://atelierheidelberg.de',  
        'http://rhein-neckar-massage.de',
        'http://atelier-heidelberg.de',
        'http://atelierheidelberg.de',  
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => ['*'],

    'max_age' => 86400,

    // Must be true when the frontend sends requests with credentials.
    'supports_credentials' => true,

];
