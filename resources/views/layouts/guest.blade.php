<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="auth-body">
        <div class="auth-shell">
            <header class="auth-topbar">
                <a class="auth-brand" href="/" aria-label="+Saber">
                    <span class="auth-brand-mark" aria-hidden="true">
                        <svg viewBox="0 0 32 32" fill="none">
                            <path d="M4 7.5c4.8-2.7 9.2-1.3 12 1.4v17.1c-2.8-2.7-7.2-4.1-12-1.4V7.5Z" fill="currentColor" />
                            <path d="M28 7.5c-4.8-2.7-9.2-1.3-12 1.4v17.1c2.8-2.7 7.2-4.1 12-1.4V7.5Z" fill="currentColor" opacity=".72" />
                        </svg>
                    </span>
                    <span>+Saber</span>
                </a>
            </header>

            <div class="auth-page">
                {{ $slot }}
            </div>
        </div>

        @livewireScripts
    </body>
</html>
