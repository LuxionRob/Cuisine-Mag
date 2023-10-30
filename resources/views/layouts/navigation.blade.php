<nav x-data="{ open: false }" class="border-b border-gray-100 bg-white">
    <!-- Primary Navigation Menu -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex grow">
                <!-- Logo -->
                <div class="flex shrink-0 items-center">
                    <a href="/">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex grow">
                    @auth
                        @if (Auth::user()->role === 'ADMIN' || Auth::user()->role === 'SALESMAN')
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                        @endif
                    @endauth
                    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                        {{ __('Products') }}
                    </x-nav-link>
                    @auth
                        <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                            {{ __('Orders') }}
                        </x-nav-link>
                    @endauth
                    <div class="grow"></div>
                    @include('components/language-switcher')
                    @auth
                        <div class="ml-auto flex items-center">
                            <a href="{{ route('cart.index') }}" class="hover:fill-orange-400 h-fit w-full scale-75">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" id="cart">
                                    <path
                                        d="M0 4h5l1 4h24l-2 14H6L3.5 6H0zm10 20a3 3 0 0 0 0 6 3 3 0 0 0 0-6m14 0a3 3 0 0 0 0 6 3 3 0 0 0 0-6">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    @endauth
                </div>
            </div>

            @auth
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center text-sm font-medium text-gray-500 transition duration-150 ease-in-out hover:border-gray-300 hover:text-gray-700 focus:border-gray-300 focus:text-gray-700 focus:outline-none">
                                <div>{{ Auth::user()->username }}</div>

                                <div class="ml-1">
                                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('users.show', Auth::id())">
                                Profile
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @else
                <div class="flex items-center">
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline dark:text-gray-500">Log in</a>
                    <a href="{{ route('register') }}"
                        class="ml-4 text-sm text-gray-700 underline dark:text-gray-500">Register</a>
                </div>
            @endauth
        </div>
    </div>
</nav>
