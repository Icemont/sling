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
</head>
<body class="theme-light">
@include('layouts.navigation')
<div class="page">
    <div class="page-wrapper">
        <div class="container-xl">
            <!-- Page title -->
            <div class="page-header d-print-none">
                <div class="row align-items-center">
                    <div class="col">
                        {{ $header }}
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl">
                {{ $slot }}
            </div>
        </div>
        <footer class="footer footer-transparent d-print-none">
            <div class="container-xl">
                <div class="row text-center align-items-center flex-row-reverse">
                    <div class="col-lg-auto ms-lg-auto">
                        <ul class="list-inline list-inline-dots mb-0">
                            <li class="list-inline-item"><a href="https://icemont.dev/" target="_blank"
                                                            class="link-secondary">Developer</a></li>
                            <li class="list-inline-item"><a href="https://github.com/icemont/sling" target="_blank"
                                                            class="link-secondary" rel="noopener">Source code</a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                        <ul class="list-inline list-inline-dots mb-0">
                            <li class="list-inline-item">
                                Sling v{{ App\Http\Kernel::VERSION }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script src="{{ asset('assets/js/tabler.js') }}"></script>
</body>
</html>
