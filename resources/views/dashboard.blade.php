<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                @if (Auth::user()->role === App\Enums\UserRole::ROLE_ADMIN)
                    <div class="grid grid-cols-3 gap-5">
                        <div class="col-span-2 h-64 bg-white shadow-md rounded-md">
                            <a href="{{ route('admin.orders.index') }}"
                                class="w-full h-fit border-2 border-gray-500 p-2 pl-4 rounded-md flex justify-between hover:bg-slate-100 group">
                                <span class="group-hover:underline">{{ __('Orders') }}</span>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        class="group-hover:opacity-80">
                                        <path
                                            d="M11.293 4.707 17.586 11H4v2h13.586l-6.293 6.293 1.414 1.414L21.414 12l-8.707-8.707-1.414 1.414z" />
                                    </svg>
                                </div>
                            </a>
                        </div>
                        <div class="col-span-1 h-64 bg-white shadow-md rounded-md">
                            <a href="{{ route('users.index') }}"
                                class="w-full h-fit border-2 border-gray-500 p-2 pl-4 rounded-md flex justify-between hover:bg-slate-100 group">
                                <span class="group-hover:underline">{{ __('Users') }}</span>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        class="group-hover:opacity-80">
                                        <path
                                            d="M11.293 4.707 17.586 11H4v2h13.586l-6.293 6.293 1.414 1.414L21.414 12l-8.707-8.707-1.414 1.414z" />
                                    </svg>
                                </div>
                            </a>
                        </div>
                        <div class="col-span-3 h-64 bg-white shadow-md rounded-md">
                            <a href="{{ route('user.products', ['user' => Auth::user()->id]) }}"
                                class="w-full h-fit border-2 border-gray-500 p-2 pl-4 rounded-md flex justify-between hover:bg-slate-100 group">
                                <span class="group-hover:underline">{{ __('Products') }}</span>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        class="group-hover:opacity-80">
                                        <path
                                            d="M11.293 4.707 17.586 11H4v2h13.586l-6.293 6.293 1.414 1.414L21.414 12l-8.707-8.707-1.414 1.414z" />
                                    </svg>
                                </div>
                            </a>
                        </div>
                    </div>
                @elseif (Auth::user()->role === App\Enums\UserRole::ROLE_SALESMAN)
                    <div class="grid grid-cols-3 gap-5">
                        <div class="col-span-2 h-64 bg-white shadow-md rounded-">
                            <a href="{{ route('salesman.orders.index') }}"
                                class="w-full h-fit border-2 border-gray-500 p-2 pl-4 rounded-md flex justify-between hover:bg-slate-100 group">
                                <span class="group-hover:underline">{{ __('Orders') }}</span>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        class="group-hover:opacity-80">
                                        <path
                                            d="M11.293 4.707 17.586 11H4v2h13.586l-6.293 6.293 1.414 1.414L21.414 12l-8.707-8.707-1.414 1.414z" />
                                    </svg>
                                </div>
                            </a>
                        </div>
                        <div class="col-span-1 h-64 bg-white shadow-md rounded-md">
                            <a href="{{ route('user.products', ['user' => Auth::user()->id]) }}"
                                class="w-full h-fit border-2 border-gray-500 p-2 pl-4 rounded-md flex justify-between hover:bg-slate-100 group">
                                <span class="group-hover:underline">{{ __('Products') }}</span>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        class="group-hover:opacity-80">
                                        <path
                                            d="M11.293 4.707 17.586 11H4v2h13.586l-6.293 6.293 1.414 1.414L21.414 12l-8.707-8.707-1.414 1.414z" />
                                    </svg>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
