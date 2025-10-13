@props([
    'title' => null
])

<!doctype html>
<html class="h-full" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="lofi2">
    <head>
        <x-common.head :title="$title" />
    </head>
    <body class="flex h-full font-sans flex-nowrap">
        <livewire:admin.components.sidebar sidebarMenuClass="App\Builders\AdminSidebarMenu" />

        <div class="flex-1">
            <div class="container p-6 mx-auto">
                {{ $slot }}
            </div>
        </div>

        <x-common.foot />

        <livewire:components.alerts />
    </body>
</html>
