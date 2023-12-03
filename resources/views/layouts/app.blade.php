<!DOCTYPE html>
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

        <!-- Page Heading -->
        <header class="bg-white shadow">
            <div class="max-w-7xl font-semibold tracking-wider mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>

        <main>
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 mt-4 -mb-8">
                @if (Session::has('fail'))
                    <div class="bg-red-500 text-slate-100 p-4 rounded-lg shadow-md mb-4 mx-auto">
                        {{ Session::get('fail') }}
                    </div>
                @endif
                @if (Session::has('success'))
                    <div class="bg-green-500 text-slate-100 p-4 rounded-lg shadow-md mb-4 mx-auto">
                        {{ Session::get('success') }}
                    </div>
                @endif
                @error('*')
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <span class="block sm:inline">{{ __($message) }}</span>
                    </div>
                @enderror
            </div>
            {{ $slot }}
        </main>
    </div>
</body>

</html>
