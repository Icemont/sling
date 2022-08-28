<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sling') }}</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <!-- Scripts -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --tblr-font-sans-serif: 'Inter',-apple-system,BlinkMacSystemFont,San Francisco,Segoe UI,Roboto,Helvetica Neue,sans-serif !important;
        }
    </style>
</head>
<body>
<div class="font-sans text-gray-900 antialiased">
    {{ $slot }}
</div>
<script src="{{ asset('assets/js/tabler.js') }}"></script>
</body>
</html>
