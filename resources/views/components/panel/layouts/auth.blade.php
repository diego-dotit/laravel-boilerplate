@props([
    'title' => null
])

<!doctype html>
<html class="h-full" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="lofi2">
    <head>
        <x-panel.common.head :title="$title" />
    </head>
    <body class="flex flex-row items-stretch w-full h-full font-sans justify-stretch">
        <div class="flex flex-col items-stretch justify-center gap-12 p-12 flex-1/2 grow-0">
            <div class="text-center">
                <x-panel.common.app-logo class="w-auto h-16 mx-auto" :title="$title" />
            </div>
            <div>
                {{ $slot }}
            </div>

        </div>
        <div class="flex-1/2 grow-0 bg-primary">

        </div>

        <x-panel.common.foot />

        <livewire:panel.components.alerts />
    </body>
</html>
