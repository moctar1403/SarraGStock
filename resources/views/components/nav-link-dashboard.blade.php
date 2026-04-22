@props(['route', 'active' => false])

@php
    $classes = ($active ?? false)
                ? 'bg-cyan-700 hover:bg-cyan-800 rounded-md px-3 py-1 text-white text-sm font-medium transition mx-1 inline-flex items-center'
                : 'bg-cyan-500 hover:bg-cyan-600 rounded-md px-3 py-1 text-white text-sm font-medium transition mx-1 inline-flex items-center';
@endphp

<a href="{{ $route }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>