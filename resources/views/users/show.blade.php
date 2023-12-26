<x-app-layout>
    <x-slot name="header">
        {{ __('user.show.title') }}
    </x-slot>
    <div class="p-6 w-full">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 bg-white shadow-sm sm:rounded-lg">
            <div class="border-b border-gray-200 w-full flex justify-start">
                <div class=" bg-white p-6 ">
                    <p class="group relative ">
                        <strong>{{ __('user.username') }}:</strong>
                        {{ $user->username }}
                        <span
                            class="absolute -bottom-12 hidden rounded bg-slate-400 p-2 before:absolute before:-top-1 before:right-2 before:block before:h-4 before:w-4 before:rotate-45 before:bg-slate-400 group-hover:block">
                            {{ __('Create At') }}
                            {{ $user->created_at }}
                        </span>
                    </p>
                    <p class=""><strong>{{ __('user.fullname') }}:</strong>
                        {{ $user->fullName }}
                    </p>
                    <p class=""><strong>Email:</strong>
                        {{ $user->email }}
                    </p>
                </div>
                <div class="p-6 ">
                    <div class="flex items-center">

                        <x-dropdown align="left" width="64">
                            <x-slot name="trigger">
                                <button
                                    class="flex items-center text-sm font-medium text-gray-500 transition duration-150 ease-in-out hover:border-gray-300 hover:text-gray-700 focus:border-gray-300 focus:text-gray-700 focus:outline-none">
                                    <div class="ml-1">
                                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>{{ __('Contacts') }}</div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                @foreach ($user->contacts as $contact)
                                    <x-dropdown-link :href="route('contacts.show', $contact->id)" class="w-64">
                                        <div><strong>{{ __('contact.Name') }}</strong>: {{ $contact->name }}</div>
                                        <div><strong>{{ __('contact.Phone number') }}</strong>:
                                            {{ $contact->phone_number }}</div>
                                        <div><strong>{{ __('contact.Address') }}</strong>:
                                            {{ $contact->location->detail }}
                                        </div>
                                    </x-dropdown-link>
                                    @unless ($loop->last)
                                        <div class="border-b-2 w-3/4 h-[1px] mx-auto"></div>
                                    @endunless
                                @endforeach
                            </x-slot>
                        </x-dropdown>

                        <div class="ml-2 hover:opacity-60 active:opacity-80"><a href="{{ route('contacts.create') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20"
                                    viewBox="0 0 50 50">
                                    <path
                                        d="M 25 2 C 12.309295 2 2 12.309295 2 25 C 2 37.690705 12.309295 48 25 48 C 37.690705 48 48 37.690705 48 25 C 48 12.309295 37.690705 2 25 2 z M 25 4 C 36.609824 4 46 13.390176 46 25 C 46 36.609824 36.609824 46 25 46 C 13.390176 46 4 36.609824 4 25 C 4 13.390176 13.390176 4 25 4 z M 24 13 L 24 24 L 13 24 L 13 26 L 24 26 L 24 37 L 26 37 L 26 26 L 37 26 L 37 24 L 26 24 L 26 13 L 24 13 z">
                                    </path>
                                </svg></a></div>
                    </div>
                </div>
            </div>
            <div class="mt-4 flex justify-end pb-4">
                <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="mr-2 button edit">
                    {{ __('Edit') }}
                </a>
                <form method="POST" action="{{ route('users.destroy', $user->id) }}"class="button delete">
                    @csrf
                    @method('DELETE')
                    <button type="submit" data-confirm="{{ __('Confirm Delete') }}">{{ __('Delete') }}</button>
                </form>
            </div>
        </div>
        @auth(Auth::user()->role !== App\Enums\UserRole::ROLE_ADMIN)
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 bg-white shadow-sm sm:rounded-lg mt-8 pt-4">
                <h3 class="text-center font-semibold text-xl">{{ __('order.index.title') }}</h3>
                @if (count($orders))
                    @foreach ($orders as $order)
                        @if ($order->orderItems->count() > 0)
                            <div class="mb-2 bg-white rounded p-4 flex flex-col items-center">
                                <div
                                    class="border rounded-md w-full p-2 mb-4 mt-2 @if ($order->orderItems[0]->status === App\Enums\OrderStatus::CANCELED) border-red-500 bg-red-100 @else border-blue-500 @endif">
                                    {{ __('constant.orderStatus.' . $order->orderItems[0]->status) }}
                                </div>
                                @foreach ($order->orderItems as $orderItem)
                                    @if ($loop->iteration < 2)
                                        <div class="flex mb-2 w-full">
                                            <div class="w-1/6 mr-4">
                                                <img class="object-cover" src="{{ $orderItem->product->photo }}"
                                                    alt="{{ $orderItem->product->name }}">
                                            </div>
                                            <div class="grow">
                                                <strong class="text-xl">{{ $orderItem->product->name }}</strong>
                                                <div class="flex justify-between mt-4 items-end">
                                                    <div class="text-opacity-80 text-sm">{{ __('order.Quantity') }}:
                                                        {{ $orderItem->quantity }}
                                                    </div>
                                                    <div class="text-black text-xl mr-4">
                                                        {{ formatCurrency($orderItem->product->price) }}
                                                    </div>
                                                </div>
                                                @if ($orderItem->product->number_in_stock == -1)
                                                    <div class="text-opacity-80 text-sm text-red-600">
                                                        {{ __('order.cancel.message') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <a class="inline-flex justify-center py-2 hover:bg-slate-100 opacity-70 w-full text-center"
                                    href="{{ route('orders.show', $order->id) }}">
                                    <span class="h-2 w-2 block bg-slate-500 rounded-full mr-1"></span>
                                    <span class="h-2 w-2 block bg-slate-500 rounded-full mr-1"></span>
                                    <span class="h-2 w-2 block bg-slate-500 rounded-full"></span>
                                </a>
                                <div class="w-full border-slate-500 h-0 border mt-4"></div>
                                <div class="flex justify-end w-full items-end mt-4">
                                    <span
                                        class="mr-2">{{ __('order.Total', ['totalQuantity' => $order->orderItems->sum('quantity')]) }}:</span>
                                    <span class="block text-2xl text-red-500">
                                        {{ formatCurrency($order->orderItems->sum('totalPrice')) }}</span>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    <x-no-item>
                        {{ __('order.empty') }}
                    </x-no-item>
                @endif
            </div>
        @endauth

    </div>
</x-app-layout>
