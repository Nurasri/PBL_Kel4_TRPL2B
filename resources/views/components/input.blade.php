{{-- resources/views/components/input.blade.php --}}
@props(['type' => 'text'])

<input
    type="{{ $type }}"
    {{ $attributes->merge([
        'class' => 'block w-full rounded-md border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:outline-none transition p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200'
    ]) }}
>