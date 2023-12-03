<x-app-layout>
    <x-slot name="header">{{ __('contact.create.title') }}</x-slot>
    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 bg-white shadow-sm sm:rounded-lg p-6">
            <form action="{{ route('contacts.store') }}" method="post">
                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <div id='create-contact-form'>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
