<x-app-layout>
    <x-slot name="header">{{ __('order.index.title') }}</x-slot>

    <div class='py-8'>
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg w-full">
                @if ($orders->count() > 0)
                    <table class="w-full table-auto">
                        <thead>
                            <tr>
                                <th class="w-1/12 px-4 py-2">
                                    {{ __('order.id') }}
                                </th>
                                <th class="w-1/12 px-4 py-2">
                                    {{ __('order.Quantity') }}
                                </th>
                                <th class="w-1/12 px-4 py-2">
                                    {{ __('order.Price') }}
                                </th>
                                <th class="w-1/12 px-4 py-2">
                                    {{ __('order.Payment Method') }}
                                </th>
                                <th class="w-1/12 px-4 py-2">
                                    {{ __('Create At') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                @if ($order->orderItems[0]->status !== \App\Enums\OrderStatus::CANCELED)
                                    <a href="{{ route('orders.show', $order->id) }}">
                                        <tr>
                                            <td class="border text-center px-4 py-2">
                                                <a href="{{ route('orders.show', $order->id) }}">
                                                    {{ $order->id }}
                                                </a>
                                            </td>
                                            <td class="border text-center px-4 py-2">
                                                {{ $order->orderItems->sum('quantity') }}
                                            </td>
                                            <td class="border text-center px-4 py-2">
                                                {{ formatCurrency($order->orderItems->sum('totalPrice')) }}
                                            </td>
                                            <td class="border text-center px-4 py-2">
                                                {{ __('constant.paymentMethod.' . $order->orderItems[0]->payment_method) }}
                                            </td>
                                            <td class="border text-center px-4 py-2">
                                                {{ $order->created_at }}
                                            </td>
                                        </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <x-no-item>
                        {{ __('order.empty') }}
                    </x-no-item>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
