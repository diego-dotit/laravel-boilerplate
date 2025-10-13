@props([
])

<x-link
    href="javascript:void(0);"
    x-on:click="__dialogOpen = true"
    {{ $attributes }}
>
    {{ $slot }}
</x-link>
