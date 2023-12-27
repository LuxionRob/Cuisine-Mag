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
                    <x-sidebar-link :active="request()->routeIs('dashboard.index')" :href="route('dashboard.index')">
                        <i class="fa-solid fa-chart-line w-1/6"></i>
                        <h5 class="flex-1">{{ __('dashboard.dashboard') }}</h5>
                    </x-sidebar-link>
                    <x-sidebar-link :active="request()->routeIs('dashboard.products')" :href="route('dashboard.products')">
                        <i class="fa-solid fa-burger w-1/6"></i>
                        <h5 class="flex-1">{{ __('dashboard.product') }}</h5>
                    </x-sidebar-link>
                    <x-sidebar-link :active="request()->routeIs('dashboard.users')" :href="route('dashboard.users')">
                        <i class="fa-solid fa-user w-1/6"></i>
                        <h5 class="flex-1">{{ __('dashboard.user') }}</h5>
                    </x-sidebar-link>
                    <x-sidebar-link :active="request()->routeIs('dashboard.orders')" :href="route('dashboard.orders')">
                        <i class="fa-solid fa-file-lines w-1/6"></i>
                        <h5 class="flex-1">{{ __('dashboard.invoice') }}</h5>
                    </x-sidebar-link>
                </div>
            </div>
            <main class="flex-1 h-[626px] p-8 relative">
                <div class="max-w-full font-semibold tracking-wider">
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
    </div>
</body>

</html>
