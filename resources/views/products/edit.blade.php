<x-app-layout>
    <x-slot name="header">
        {{ __('Edit Product') }}
    </x-slot>
    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-200 bg-white p-6">
                    <form action="{{ route('products.update', [ 'product' => $product->id ]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="id" value="{{ $product->id }}" />
                        <div class="mb-4">
                            <label for="name"
                                   class="block text-sm font-medium text-gray-700">{{ __('product.edit.name') }}</label>
                            <input type="text" name="name" id="name" value="{{ $product->name }}"
                                   class="form-input mt-1 block w-full rounded-md">
                        </div>
                        <div class="mb-4 h-auto">
                            <label for="description"
                                   class="block text-sm font-medium text-gray-700">{{ __('product.edit.description') }}</label>
                            <input type="text" name="description" id="description" value="{{ $product->description }}"
                                   class="form-input mt-1 block w-full h-auto rounded-md">
                        </div>
                        <div class="flex space-x-4">
                            <div class="mb-4">
                                <label for="price" class="block text-sm font-medium text-gray-700">{{ __('product.edit.price') }}</label>
                                <input type="text" name="price" id="price" value="{{ $product->price }}"
                                       class="form-input mt-1 block w-1/2 rounded-md">
                            </div>
                            <div class="mb-4">
                                <label for="number_in_stock" class="block text-sm font-medium text-gray-700">{{ __('product.edit.numberStock') }}</label>
                                <input type="text" name="number_in_stock" id="number_in_stock" value="{{ $product->number_in_stock }}"
                                       class="form-input mt-1 block w-1/2 rounded-md">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="photo" class="block text-sm font-medium text-gray-700">{{ __('product.edit.photo') }}</label>
                            <input type="file" class="form-control" id="photo" name="photo">
                            @if (strpos($product->photo, 'https://via.placeholder.com/') === 0)
                                <img class="w-40 h-40" src="{{ $product->photo}}" alt="Card image">
                            @else
                                <img class="w-40 h-40" src="{{ asset($product->photo) }}" alt="Card image">
                            @endif
                        </div>
                        <div>
                            <button type="submit" class="button edit">
                                {{ __('Update') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
