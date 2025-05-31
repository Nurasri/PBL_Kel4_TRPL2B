@props([
    'type' => 'button',
    'variant' => 'green',
    'size' => 'md'
])

@php
$classes = [
    'green' => 'btn-green',
    'gray' => 'btn-gray',
    'red' => 'px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red',
];

$class = $classes[$variant] ?? $classes['green'];
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</button>
