@props(['active'])

@php
    $classes = $active ? 'flex items-center py-1 px-4 mb-1 bg-gray-300' : 'flex items-center py-1 px-4 mb-1 hover:bg-gray-100';
@endphp


<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
