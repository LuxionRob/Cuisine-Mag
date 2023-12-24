<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script>
            var locale = '{{ App::getLocale() }}'
        </script>
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>

    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')
            <div class="flex">
                <div class="bg-white w-1/6 px-4 py-4">
                    <h2 class="text-lg font-bold px-4 mb-4">{{ __('dashboard.header') }}</h2>
                    <div>
                        <a class="flex items-center py-1 px-4 mb-1 hover:bg-gray-200 bg-gray-200">
                            <i class="fa-solid fa-chart-line w-1/6"></i>
                            <h5 class="flex-1">{{ __('dashboard.dashboard') }}</h5>
                        </a>
                        <a class="flex items-center py-1 px-4 mb-1 hover:bg-gray-200">
                            <i class="fa-solid fa-burger w-1/6"></i>
                            <h5 class="flex-1">{{ __('dashboard.product') }}</h5>
                        </a>
                        <a class="flex items-center py-1 px-4 mb-1 hover:bg-gray-200">
                            <i class="fa-solid fa-user w-1/6"></i>
                            <h5 class="flex-1">{{ __('dashboard.user') }}</h5>
                        </a>
                        <a class="flex items-center py-1 px-4 mb-1 hover:bg-gray-200">
                            <i class="fa-solid fa-file-lines w-1/6"></i>
                            <h5 class="flex-1">{{ __('dashboard.invoice') }}</h5>
                        </a>
                    </div>
                </div>
                <div class=" flex-1">content</div>
            </div>
        </div>
    </body>
</html>