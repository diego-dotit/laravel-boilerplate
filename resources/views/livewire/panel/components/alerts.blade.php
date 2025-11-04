<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On;

new class extends Component {
    public array $alerts = [];

    #[On('alert')]
    public function showAlert(string $title, string $description = '', string $variant = 'default', string $icon = 'information-circle'): void
    {
        $unique = md5($variant.$title.$description.(time()*1000+rand(0, 999)));

        $this->alerts[$unique] = [
            'variant' => $variant . '-full',
            'title' => $title,
            'description' => $description,
            'icon' => $icon,
            'unique' => $unique,
        ];
    }

    public function closeAlert(string $unique): void
    {
        unset($this->alerts[$unique]);
    }

    public function mount(): void
    {
        if(session()->has('alert')) {
            $alert = session('alert');
            $this->showAlert($alert['title'], $alert['description'] ?? '', $alert['variant'] ?? 'default', $alert['icon'] ?? 'information-circle');
        }
    }
}; ?>

<div class="fixed z-50 max-w-full transform -translate-x-1/2 bottom-4 left-1/2">
    <div class="flex flex-col items-end gap-4">
        @foreach ($alerts as $alert)
            <x-alert :variant="$alert['variant']">
                <div class="flex items-center gap-3">
                    <x-dynamic-component :component="'heroicon-o-'.$alert['icon']" class="size-5" />
                    <div>
                        <x-alert.title>{{ $alert['title'] }}</x-alert.title>
                        @if($alert['description'])
                            <x-alert.description>{{ $alert['description'] }}</x-alert.description>
                        @endif
                    </div>
                    <div>
                        <x-button wire:click="closeAlert('{{ $alert['unique'] }}')" size="sm">
                            <x-heroicon-o-x-mark class="size-4" />
                        </x-button>
                    </div>
                </div>
            </x-alert>
        @endforeach
    </div>
</div>
