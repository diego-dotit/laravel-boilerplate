@props([
    'class' => '',
])

@php
    $baseClasses = 'p-4 border-b border-gray-200 text-sm';
    $baseClasses .= ' ' . $class;
@endphp

<td {{ $attributes->merge(['class' => $baseClasses]) }}>
    {{ $slot }}
</td>
