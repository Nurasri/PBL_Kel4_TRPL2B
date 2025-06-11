{{-- resources/views/components/input.blade.php --}}
@props(['name', 'type' => 'text', 'multiple' => false])

<input 
    type="{{ $type }}" 
    name="{{ $name }}{{ ($type === 'file' && $multiple) ? '[]' : '' }}" 
    id="{{ $name }}"
    {{ $multiple && $type === 'file' ? 'multiple' : '' }}
    {{ $attributes->merge([
        'class' => $type === 'file' 
            ? 'block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 dark:file:bg-green-900 dark:file:text-green-100'
            : 'block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:border-green-400 focus:ring focus:ring-green-400 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:focus:border-green-400 dark:focus:ring-green-400'
    ]) }}
/>