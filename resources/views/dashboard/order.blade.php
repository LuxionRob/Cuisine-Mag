<x-dashboard-layout>
    <header class="bg-white shadow">
        <div class="max-w-7xl font-semibold tracking-wider mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ __('order.index.title') }} </div>
    </header>
    <div class='py-8'>
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg w-full">
            <div class="border-b border-gray-200 bg-white p-6 ">

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
                                    {{ __('order.Amount') }}
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
                                @if ($order->orderItems->pluck('status')->first() !== App\Enums\OrderStatus::CANCELED)
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
                                                {{ __('constant.paymentMethod.' . $order->orderItems->pluck('payment_method')->first()) }}
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
                <div class="mt-4">
                    {{ $orders->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
