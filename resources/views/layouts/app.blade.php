<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $ogTitle ?? config('app.name', 'Laravel') }}">
    <meta property="og:description" content="{{ $ogDescription ?? 'Welcome to our website' }}">
    <meta property="og:image" content="{{ $ogImage ?? asset('assets/og-image.jpg') }}">
    <meta property="og:site_name" content="{{ config('app.name', 'Laravel') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $ogTitle ?? config('app.name', 'Laravel') }}">
    <meta property="twitter:description" content="{{ $ogDescription ?? 'Welcome to our website' }}">
    <meta property="twitter:image" content="{{ $ogImage ?? asset('assets/og-image.jpg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    @yield('content')

    @stack('scripts')
</body>
</html>