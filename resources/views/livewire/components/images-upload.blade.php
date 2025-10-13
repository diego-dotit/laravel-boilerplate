<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Modelable;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

new class extends Component {
    use WithFileUploads;

    #[Modelable]
    public array $images = [];

    public array $tmp = [];
    public ?MediaCollection $media = null;
    public array $tmpStorage = [];

    public int $maxSize = 2048;

    public ?string $label = null;

    public function updatedTmp(): void
    {
        $this->images = $this->tmpStorage;

        $this->validate([
            'tmp.*' => 'image|max:' . $this->maxSize,
        ]);

        foreach ($this->tmp as $image) {
            $this->images[] = [
                'file' => $image,
                'thumbnail' => $image->temporaryUrl(),
            ];
        }

        $this->tmpStorage = $this->images;
    }

    public function mount(): void
    {
        if ($this->media) {
            foreach ($this->media as $item) {
                $thumbnail = $item->getPath('preview');

                if(file_exists($thumbnail)) {
                    $thumbnail = $item->getFullUrl('preview');
                } else {
                    $thumbnail = $item->getFullUrl();
                }

                $this->images[] = [
                    'file' => 'media:' . $item->id,
                    'thumbnail' => $thumbnail,
                ];
            }
        }

        $this->tmpStorage = $this->images;
    }

    public function removeImage(int $index): void
    {
        $this->images = $this->tmpStorage;

        $this->images[$index]['removed'] = true;

        $this->tmpStorage = $this->images;
    }
}; ?>

<div>
    <x-form.item>
        @if($label)
            <x-form.label>{{ $label }}</x-form.label>
        @endif

        <div class="relative flex items-start justify-start gap-2 p-2 border border-gray-200 rounded-md">
            @foreach($images as $key => $image)
                @if(isset($image['removed'])) @continue @endif
                <div class="relative">
                    <img
                        src="{{ $image['thumbnail'] }}"
                        alt="Preview"
                        class="object-cover w-32 h-32 border border-gray-200 rounded-md"
                    />
                    <button
                        type="button"
                        class="absolute p-1 text-white bg-red-500 rounded-full cursor-pointer bottom-1 right-1 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                        wire:click="removeImage({{ $key }})"
                    >
                        <x-heroicon-s-x-mark class="w-4 h-4" />
                    </button>
                </div>
            @endforeach

            <div class="relative w-32 h-32 bg-gray-100 border border-gray-200 rounded-md">
                <input type="file" multiple wire:model="tmp" class="absolute top-0 left-0 w-full h-full opacity-0 cursor-pointer" accept="image/*" />

                <span class="absolute text-xs text-gray-500 transform top-1/2 left-1/2 -translate-1/2" wire:loading wire:target="image">{{ __('common.loading') }}<br />&nbsp;</span>

                <div class="flex items-center justify-center w-32 h-32 bg-gray-100 border border-gray-200 rounded-md">
                    <span class="text-xs text-gray-400">&nbsp;<br />{{ __('common.click_or_drop_image') }}</span>
                </div>
            </div>
        </div>

        <x-form.message />
    </x-form.item>
</div>
