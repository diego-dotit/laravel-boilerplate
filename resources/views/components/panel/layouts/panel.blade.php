@props([
    'title' => null
])

<!doctype html>
<html class="max-h-screen overflow-hidden" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="lofi2">
    <head>
        <x-panel.common.head :title="$title" />
    </head>
    <body class="flex h-screen font-sans flex-nowrap">
        <livewire:panel.components.sidebar sidebarMenuClass="App\Builders\AdminSidebarMenu" />

        <div class="flex-1 overflow-y-auto">
            <div class="p-6 mx-auto">
                {{ $slot }}
            </div>
        </div>

        <x-panel.common.foot />

        <livewire:panel.components.alerts />
    </body>
</html>
