@props(['type' => 'success'])

@php
    $base = 'p-4 rounded-md mb-4 text-sm font-medium';
    $color = $type === 'success'
        ? 'bg-green-100 text-green-800 border border-green-300'
        : ($type === 'error'
            ? 'bg-red-100 text-red-800 border border-red-300'
            : 'bg-yellow-100 text-yellow-800 border border-yellow-300');
@endphp

<div {{ $attributes->merge(['class' => $base . ' ' . $color]) }}>
    {{ $slot }}
</div>