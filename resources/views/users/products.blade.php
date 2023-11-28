<x-app-layout>
    <x-slot name="header">
        {{ __('user.products.Product inventory') }}
    </x-slot>
    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-200 bg-white p-6 ">
                    <div class="flex items-center justify-end">
                        <a href="{{ route('products.create') }} " class="mr-2 button primary">
                            {{ __('user.products.button') }}
                        </a>
                    </div>
                    <div class="mt-4">
                        {{ $products->links('pagination::tailwind') }}
                    </div>
                    <table class="w-full table-fixed ">
                        <thead>
                            <tr>
                                <th class="w-1/12 px-4 py-2">
                                    {{ __('user.index.table.id') }}</th>
                                <th class="px-4 py-2">
                                    {{ __('user.products.table.name') }}
                                </th>
                                <th class="w-1/12 px-4 py-2">{{ __('user.products.table.price') }}</th>
                                <th class="w-1/6 px-4 py-2">
                                    {{ __('user.products.table.numberStock') }}</th>
                                <th class="w-1/6 px-4 py-2">{{ __('user.products.table.images') }}</th>
                                <th class="w-1/4 px-4 py-2">
                                    {{ __('user.index.table.actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $index => $product)
                                <tr>
                                    <td class="border px-4 py-2">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        {{ $product->name }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        {{ $product->price }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        {{ $product->number_in_stock }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        @if (strpos($product->photo, 'https://via.placeholder.com/') === 0)
                                            <img class="w-40 h-40" src="{{ $product->photo }}" alt="Card image">
                                        @else
                                            <img class="w-40 h-40" src="{{ asset($product->photo) }}" alt="Card image">
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('products.show', ['product' => $product->id]) }}"
                                            class="button primary">
                                            {{ __('View') }}
                                        </a>
                                        <a href="{{ route('products.edit', ['product' => $product->id]) }}"
                                            class="button edit">
                                            {{ __('Edit') }}
                                        </a>
                                        <form method="POST"
                                            action="{{ route('products.destroy', ['product' => $product->id]) }}"
                                            class="button delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                data-confirm="{{ __('Confirm Delete') }}">{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $products->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
