<x-app-layout>
    <x-slot name='header'>{{ __('order.create.title') }}</x-slot>
    <div class='py-8'>
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <form action="{{ route('orders.store') }}" method="post">
                @csrf
                <div class="flex w-full">
                    <div class="bg-white p-4 rounded-md mb-4 grow">
                        <table class=w-full>
                            <thead>
                                <tr>
                                    <th class="py-2">{{ __('cart.Product') }}</th>
                                    <th class="py-2">{{ __('cart.Price') }}</th>
                                    <th class="py-2">{{ __('cart.Quantity') }}</th>
                                    <th class="py-2">{{ __('cart.Total') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Loop through cart items -->
                                @foreach ($user->cartItems as $item)
                                    <tr>
                                        <td class="py-2 text-center">{{ $item['product']['name'] }}
                                        </td>
                                        <td class="py-2 text-center">
                                            {{ formatCurrency($item['product']['price']) }}</td>
                                        <td class="py-2 text-center">
                                            <span>{{ $item['quantity'] }}</span>
                                        </td>
                                        <td class="py-2 text-center">
                                            {{ formatCurrency($item['total_price']) }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="w-2/3 mx-auto h-0 border-2 border-t-slate-500"></tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="py-2 text-center font-bold text-red-500 text-xl">
                                        {{ formatCurrency($user->cartItems->sum('total_price')) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="ml-8 rounded-md mb-4 w-1/3 flex-nowrap">
                        <div class="py-4 px-8 bg-white">
                            @if ($user->contacts->count() > 0)
                                <h3 class="font-extrabold">{{ __('Contacts') }} </h3>
                                <input id="contact-input" type="hidden" name="contact_id"
                                    value="{{ $user->contacts[0]->id }}">
                                <div class="relative select h-28 w-full mt-1">
                                    <ul class="absolute z-10 cursor-pointer rounded-md">
                                        <li class="relative trigger p-2 pr-4 after down-arrow">
                                            <ul class="list-outside list-disc">
                                                <li>
                                                    <strong>{{ __('contact.Name') }}</strong>:
                                                    {{ $user->contacts[0]->name }}
                                                </li>
                                                <li>
                                                    <strong>{{ __('contact.Address') }}</strong>:
                                                    {{ $user->contacts[0]->location->detail }}
                                                </li>
                                                <li>
                                                    <strong>{{ __('contact.Phone number') }}</strong>:
                                                    {{ $user->contacts[0]->phone_number }}
                                                </li>
                                            </ul>
                                        </li>
                                        <div class="bg-white shadow-md">
                                            @foreach ($user->contacts as $contact)
                                                <li class="option hidden cursor-pointer hover:bg-slate-300 p-2 shadow-sm rounded"
                                                    value="{{ $contact->id }}">
                                                    <ul class="list-inside list-disc">
                                                        <li>
                                                            <strong>{{ __('contact.Name') }}</strong>:
                                                            {{ $contact->name }}
                                                        </li>
                                                        <li>
                                                            <strong>{{ __('contact.Address') }}</strong>:
                                                            {{ $contact->location->detail }}
                                                        </li>
                                                        <li>
                                                            <strong>{{ __('contact.Phone number') }}</strong>:
                                                            {{ $contact->phone_number }}
                                                        </li>
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </div>
                                    </ul>
                                </div>
                                <div class="w-2/3 h-0 mx-auto border border-slate-500 mb-4"></div>
                            @else
                                <div class="flex items-center">
                                    <h3 class="font-extrabold inline">{{ __('Contacts') }}</h3>
                                    <span class="ml-2 hover:opacity-60 active:opacity-80">
                                        <a href="{{ route('contacts.create') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20"
                                                height="20" viewBox="0 0 50 50">
                                                <path
                                                    d="M 25 2 C 12.309295 2 2 12.309295 2 25 C 2 37.690705 12.309295 48 25 48 C 37.690705 48 48 37.690705 48 25 C 48 12.309295 37.690705 2 25 2 z M 25 4 C 36.609824 4 46 13.390176 46 25 C 46 36.609824 36.609824 46 25 46 C 13.390176 46 4 36.609824 4 25 C 4 13.390176 13.390176 4 25 4 z M 24 13 L 24 24 L 13 24 L 13 26 L 24 26 L 24 37 L 26 37 L 26 26 L 37 26 L 37 24 L 26 24 L 26 13 L 24 13 z">
                                                </path>
                                            </svg>
                                        </a>
                                    </span>
                                </div>
                            @endif
                            <label for="payment_method" class="font-extrabold block">{{ __('Payment Method') }}</label>
                            <select name="payment_method" id="payment_method"
                                class="w-full rounded-md broder-slate-500 mt-1">
                                @foreach ($paymentMethods as $method)
                                    <option value="{{ $method }}">
                                        {{ __('constant.paymentMethod.' . $method) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class=" w-full flex justify-end">
                    <button type="submit" class="button primary">
                        {{ __('order.create.button') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
