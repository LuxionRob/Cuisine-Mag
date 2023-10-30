<x-app-layout>
    <x-slot name="header">
        {{ __('Create Product') }}
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-200 bg-white p-6">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="name"
                                class="block text-sm font-medium text-gray-700">{{ __('product.edit.name') }}</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="form-input mt-1 block w-full rounded-md">
                        </div>
                        <div class="mb-4 h-auto">
                            <label for="description"
                                class="block text-sm font-medium text-gray-700">{{ __('product.edit.description') }}</label>
                            <input type="text" name="description" id="description" value="{{ old('description') }}"
                                class="form-input mt-1 block w-full h-auto rounded-md">
                        </div>
                        <div class="flex space-x-4">
                            <div class="mb-4">
                                <label for="price" class="block text-sm font-medium text-gray-700">{{ __('product.edit.price') }}</label>
                                <input type="text" name="price" id="price" value="{{ old('price') }}"
                                    class="form-input mt-1 block w-1/2 rounded-md">
                            </div>
                            <div class="mb-4">
                                <label for="number_in_stock" class="block text-sm font-medium text-gray-700">{{ __('product.edit.numberStock') }}</label>
                                <input type="text" name="number_in_stock" id="number_in_stock" value="{{ old('number_in_stock') }}"
                                    class="form-input mt-1 block w-1/2 rounded-md">
                            </div>
                            <div>
                                <label for="number_in_stock" class="block text-sm font-medium text-gray-700">{{ __('product.edit.category') }}</label>
                                <select data-filter="make" name="category" class="filter-make filter form-control rounded">
                                    <option value="1">{{ __('product.index.food') }}</option>
                                    <option value="2">{{ __('product.index.drink') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="photo" class="block text-sm font-medium text-gray-700">{{ __('product.edit.photo') }}</label>
                            <input type="file" class="form-control" id="photo" name="photo" value="{{ old('photo') }}">
                        </div>
                        <div>
                            <button type="submit" class="button create">
                                {{ __('Create') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
