<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new class extends Component {
    public array $menu = [];

    public function mount(array $menu): void
    {
        $this->menu = $menu;
    }

    public function isActive(array $item): bool
    {
        if (!empty($item['route']) && str_contains(Route::currentRouteName(), $item['route'])) {
            return true;
        }

        if(!empty($item['children'])) {
            foreach ($item['children'] as $child) {
                if (!empty($child['route']) && str_contains(Route::currentRouteName(), $child['route'])) {
                    return true;
                }

                if (!empty($child['children']) && $this->isActive($child)) {
                    return true;
                }
            }
        }

        return false;
    }
}; ?>

<ul class="[li>ul]:pl-1 [li>ul]:border-l [li>ul]:ml-3 flex flex-col items-stretch min-h-full" x-show="(typeof expanded !== 'undefined') ? expanded : true" x-collapse>
    @foreach ($menu as $item)
        <li
            @if(!empty($item['children']))
                x-data="{ expanded: {{ $this->isActive($item) ? 'true' : 'false' }} }"
            @endif

            @if(!empty($item['fill']))
                class="flex-auto grow-1"
            @endif
        >
            @if(!empty($item['is_header']))
                <div class="text-xs text-primary/80 [li+li>div]:mt-4 px-3">
                    {{ $item['label'] }}
                </div>
            @elseif(!empty($item['fill']))
                {{--  --}}
            @else
                @php
                $href = $item['href'] ?? (!empty($item['route']) ? route($item['route']) : 'javascript:void(0)');
                @endphp
                <a
                    href="{{ $href }}"
                    class="flex items-center gap-2 px-3 py-1 rounded flex-nowrap hover:bg-primary/5 @if(!empty($item['route']) && $this->isActive($item)) active @endif"
                    @if(!empty($item['children']))
                        @click="expanded = !expanded"
                    @else
                        wire:navigate
                    @endif
                >
                    @if(!empty($item['icon']))
                        <x-dynamic-component :component="'heroicon-o-' . $item['icon']" class="size-5 grow-0" />
                    @endif
                    <span class="flex-auto [.active>&]:font-bold">{{ $item['label'] ?? '' }}</span>
                    @if(!empty($item['children']))
                        <x-heroicon-o-chevron-down class="size-4 grow-0" />
                    @endif
                </a>

                @if(!empty($item['children']))
                    <livewire:admin.components.sidebar-menu :menu="$item['children']" />
                @endif
            @endif
        </li>
    @endforeach
</ul>
