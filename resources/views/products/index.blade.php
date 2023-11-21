<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('product.index.title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="w-full">
                <div class="mx-auto mb-4 w-1/2">
                    <form action="{{ route('products.search') }}" method="GET">
                        <input type="text" class="form-control"
                            placeholder="{{ __('product.index.find') }}" name="search"
                            value="{{ app('request')->input('search') }}">
                        <select data-filter="make" name="category"
                            class="filter-make form-control filter"">
                            <option value="0" @if ( app('request')->input('category') == 0) selected @endif>{{ __('product.index.category') }}</option>
                            <option value="1" @if ( app('request')->input('category') == 1) selected @endif>{{ __('product.index.food') }}</option>
                            <option value="2" @if ( app('request')->input('category') == 2) selected @endif>{{ __('product.index.drink') }}</option>
                        </select>
                        <button class="w-1/6 rounded bg-blue-500 p-2 text-white"
                            type="submit">Tìm</button>
                    </form>
                </div>

                <div class="grid grid-cols-4 gap-4">
                    @foreach ($products as $index => $product)
                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf

                            <div
                                class="flex h-full w-full flex-col justify-between bg-white shadow-lg">
                                <a href="{{ route('products.show', ['product' => $product->id]) }}">
                                    <div class="flex justify-center">
                                        <div class="h-full w-full overflow-hidden rounded">
                                            @if (strpos($product->photo, 'https://via.placeholder.com/') === 0)
                                                <img class="h-56 w-full" src="{{ $product->photo }}"
                                                    alt="Card image">
                                            @else
                                                <img class="h-56 w-full"
                                                    src="{{ asset($product->photo) }}"
                                                    alt="Card image">
                                            @endif
                                            <div class="px-6 py-4">
                                                <input type="hidden" name="id"
                                                    value="{{ $product->id }}" />
                                                <div class="flex items-center justify-between">
                                                    <div class="mb-4 text-xl font-bold">
                                                        @php
                                                            $limitedName = Str::limit($product->name, 12);
                                                        @endphp
                                                        {{ $limitedName }}
                                                    </div>
                                                    <div
                                                        class="mb-4 text-sm font-bold text-gray-400">
                                                        {{ __('product.index.sold') }}{{ $product->number_of_purchase }}
                                                    </div>
                                                </div>
                                                <div class="text-base text-gray-700">
                                                    @php
                                                        $limitedDescription = Str::limit($product->description, 100);
                                                    @endphp
                                                    {{ $limitedDescription }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <div class="flex justify-between">
                                    <div class="mb-4 px-6 text-xl font-bold text-red-600">
                                        {{ formatCurrency($product->price, Session::get('locale')) }}</div>
                                    <button class="mb-4 px-6" type="submit">
                                        <i class="fa fa-cart-plus"></i>
                                    </button>
                                </div>

                            </div>
                        </form>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $products->appends(isset($request) ? $request->input() : null)->links('pagination::tailwind') }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

