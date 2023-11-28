<x-app-layout>
    <x-slot name="header">{{ __('order.show.title', ['id' => $order->id]) }}</x-slot>

    <div class='py-8'>
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <form action="{{ route('orders.update', $order) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="p-4 mb-4 bg-white rounded-md">
                    <div class="border rounded-md border-blue-500 w-full p-2 mb-4 mt-2">
                        {{ __('constant.orderStatus.' . $order->orderItems[0]->status) }}
                        <input type="hidden" name="payment_method" value="{{ $order->orderItems[0]->payment_method }}">
                    </div>
                    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 bg-white shadow-sm sm:rounded-lg p-6">
                        <input id="contact-input" type="hidden" name="contact_id" value="{{ $order->contact_id }}">
                        <div class="relative select h-28 w-full mt-1" name="contact" value="{{ $order->contact_id }}">
                            <ul class="absolute z-10 cursor-pointer rounded-md">
                                <li class="relative p-2 pr-4 after down-arrow trigger">
                                    <ul class="list-inside
                                    list-disc">
                                        <li>
                                            <strong>{{ __('contact.Name') }}</strong>:
                                            {{ $order->contact->name }}
                                        </li>
                                        <li>
                                            <strong>{{ __('contact.Address') }}</strong>:
                                            {{ $order->contact->location->detail }}
                                        </li>
                                        <li>
                                            <strong>{{ __('contact.Phone number') }}</strong>:
                                            {{ $order->contact->phone_number }}
                                        </li>
                                    </ul>
                                </li>
                                <div class="bg-white shadow-md">
                                    @foreach ($user->contacts as $contact)
                                        <li class="option hidden cursor-pointer hover:bg-slate-300 p-2"
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
                    </div>
                </div>
                <div class="p-4 mb-4 bg-white rounded-md">
                    @foreach ($order->orderItems as $orderItem)
                        <div class="flex mb-4 w-full">
                            <div class="w-1/6 mr-4">
                                @if (strpos($orderItem->product->photo, 'https://via.placeholder.com/') === 0)
                                    <img class="object-cover" src="{{ $orderItem->product->photo }}"
                                        alt="{{ $orderItem->product->name }}">
                                @else
                                    <img class="object-cover" src="{{ asset($orderItem->product->photo) }}"
                                        alt="{{ $orderItem->product->name }}">
                                @endif
                            </div>
                            <div class="grow">
                                <strong class="text-xl">{{ $orderItem->product->name }} </strong>
                                <div class="flex justify-between mt-4 items-end">
                                    <div class="text-opacity-80 text-sm">{{ __('order.Quantity') }}:
                                        {{ $orderItem->quantity }}
                                    </div>
                                    <div class="text-black text-xl mr-4">
                                        {{ formatCurrency($orderItem->product->price) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="flex flex-col justify-end items-end p-4 mb-4 bg-white rounded-md">
                    <div class="flex justify-between w-1/3 items-end mb-2">
                        <span class="block text-gray-500">{{ __('order.Payment Method') }}</span>
                        <span
                            class="block text-lg">{{ __('constant.paymentMethod.' . $order->orderItems[0]->payment_method) }}</span>
                    </div>
                    <div class="flex items-end">
                        <span
                            class="mr-2">{{ __('order.Total', ['totalQuantity' => $order->orderItems->sum('quantity')]) }}:
                        </span>
                        <span class="block text-2xl text-red-500">
                            {{ formatCurrency($order->orderItems->sum('totalPrice')) }}
                        </span>
                    </div>
                    <div class="flex items-end mt-4">
                        <button type="submit" class="button primary">{{ __('Save changes') }}</button>
                        <a class="ml-4 button  @if (
                            $order->orderItems[0]->status !== App\Enums\OrderStatus::WAITING &&
                                $order->orderItems[0]->status !== App\Enums\OrderStatus::PACKAGING) disabled @else bg-slate-300 border text-black hover:bg-slate-400 @endif"
                            href="{{ route('orders.show', $order->id) }}">
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
