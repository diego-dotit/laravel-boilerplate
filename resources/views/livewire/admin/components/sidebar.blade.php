<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Factories\SidebarMenuFactory;

new class extends Component {
    public array $menu = [];

    public function mount(string $type = 'admin'): void
    {
        $sidebarMenuBuilder = SidebarMenuFactory::make($type);
        $this->menu = $sidebarMenuBuilder->build();
    }
}; ?>

<div class="w-[300px] border-r border-gray-200 py-6 px-3 h-screen flex flex-col flex-nowrap gap-6">
    <div class="flex justify-center grow-0">
        <x-common.app-logo class="h-10" :href="route('admin.dashboard')" />
    </div>

    <div class="flex-auto overflow-y-auto">
        <livewire:admin.components.sidebar-menu :menu="$menu" />
    </div>

    <div class="grow-0">
        <div class="flex items-center gap-2 flex-nowrap">
            <x-avatar class="grow-0">
                <x-avatar.image src="{{ auth()->user()->getFirstMediaUrl('avatars', 'thumb') }}" />
                <x-avatar.fallback>{{ auth()->user()->initials() }}</x-avatar.fallback>
            </x-avatar>
            <div class="flex flex-col items-stretch flex-auto gap-1">
                <div class="text-sm font-medium">{{ auth()->user()->name }}</div>
                <div class="text-xs text-muted-foreground">{{ auth()->user()->email }}</div>
            </div>
            <div class="grow-0">
                <x-link href="#" wire:navigate>
                    <x-heroicon-o-cog-8-tooth class="size-8" />
                </x-link>
            </div>
        </div>
    </div>
</div>
