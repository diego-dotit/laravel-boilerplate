<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Modelable;

new class extends Component {
    use WithFileUploads;

    #[Modelable]
    public $image;

    public int $maxSize = 2048;

    public ?string $label = null;
    public ?string $thumbnail = null;

    public function updatedImage(): void
    {
        $this->validate([
            'image' => 'image|max:' . $this->maxSize,
        ]);

        $this->thumbnail = $this->image->temporaryUrl();
    }

    public function removeImage(): void
    {
        $this->image = false;
        $this->thumbnail = null;
    }
}; ?>

<div>
    <x-form.item>
        @if($label)
            <x-form.label>{{ $label }}</x-form.label>
        @endif

        <div class="relative w-32 h-32">
            @if($image || $thumbnail)
                <img
                    src="{{ $thumbnail }}"
                    alt="Preview"
                    class="object-cover w-32 h-32 border border-gray-200 rounded-md"
                />
                <button
                    type="button"
                    class="absolute p-1 text-white bg-red-500 rounded-full cursor-pointer bottom-1 right-1 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                    wire:click="removeImage"
                >
                    <x-heroicon-s-x-mark class="w-4 h-4" />
                </button>
            @else
                <input type="file" wire:model="image" class="absolute top-0 left-0 w-full h-full opacity-0 cursor-pointer" accept="image/*" />

                <span class="absolute text-xs text-gray-500 transform top-1/2 left-1/2 -translate-1/2" wire:loading wire:target="image">{{ __('common.loading') }}<br />&nbsp;</span>

                <div class="flex items-center justify-center w-32 h-32 bg-gray-100 border border-gray-200 rounded-md">
                    <span class="text-xs text-gray-400">&nbsp;<br />{{ __('common.click_or_drop_image') }}</span>
                </div>
            @endif
        </div>

        <x-form.message />
    </x-form.item>
</div>
