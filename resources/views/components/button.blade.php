@props(['variant' => 'primary', 'size' => 'md', 'type' => 'button', 'href' => null])

@php
$baseClasses = 'inline-flex items-center font-medium rounded-lg transition-colors duration-150 focus:outline-none focus:shadow-outline';

$variants = [
    'primary' => 'text-white bg-green-600 border border-transparent hover:bg-green-700 focus:shadow-outline-green active:bg-green-600',
    'secondary' => 'text-gray-700 bg-gray-200 border border-gray-300 hover:bg-gray-300 focus:shadow-outline-gray active:bg-gray-200 dark:text-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:hover:bg-gray-600',
    'danger' => 'text-white bg-red-600 border border-transparent hover:bg-red-700 focus:shadow-outline-red active:bg-red-600',
    'warning' => 'text-white bg-yellow-600 border border-transparent hover:bg-yellow-700 focus:shadow-outline-yellow active:bg-yellow-600',
    'info' => 'text-white bg-blue-600 border border-transparent hover:bg-blue-700 focus:shadow-outline-blue active:bg-blue-600',
];

$sizes = [
    'sm' => 'px-3 py-2 text-sm',
    'md' => 'px-4 py-2 text-sm',
    'lg' => 'px-6 py-3 text-base',
];

$variantClass = $variants[$variant] ?? $variants['primary'];
$sizeClass = $sizes[$size] ?? $sizes['md'];

$classes = "{$baseClasses} {$variantClass} {$sizeClass}";
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
