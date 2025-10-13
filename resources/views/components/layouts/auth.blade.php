@props([
    'title' => null
])

<!doctype html>
<html class="h-full" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="lofi2">
    <head>
        <x-common.head :title="$title" />
    </head>
    <body class="flex flex-row items-stretch w-full h-full font-sans justify-stretch">
        <div class="flex flex-col items-stretch justify-center gap-12 p-12 flex-1/2 grow-0">
            <div class="text-center">
                <x-common.app-logo class="mx-auto h-16 w-auto" :title="$title" />
            </div>
            <div>
                {{ $slot }}
            </div>

        </div>
        <div class="flex-1/2 grow-0 bg-primary">

        </div>

        <x-common.foot />

        <livewire:components.alerts />
    </body>
</html>
