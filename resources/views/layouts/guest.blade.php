<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sling') }}</title>
    <link rel="icon" type="image/png" href="/assets/icons/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/assets/icons/favicon.svg" />
    <link rel="shortcut icon" href="/assets/icons/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/icons/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Sling" />
    <link rel="manifest" href="/assets/icons/site.webmanifest" />
    @vite(['resources/css/app.css'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --tblr-font-sans-serif: 'Inter',-apple-system,BlinkMacSystemFont,San Francisco,Segoe UI,Roboto,Helvetica Neue,sans-serif !important;
        }
    </style>
</head>
<body{!! Auth::user()?->dark_theme ? ' data-bs-theme="dark"' : '' !!}>
<div class="font-sans text-gray-900 antialiased">
    {{ $slot }}
</div>
@vite(['resources/js/app.js', 'resources/js/tabler.js'])

</body>
</html>
