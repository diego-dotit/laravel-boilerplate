@props([
    'side' => 'right',
])

@inject('sheet', 'App\Services\DialogCvaService')

<dialog
    wire:ignore.self
    x-on:cancel="__sheetOpen = false"
    x-trap.noscroll="__sheetOpen"
    x-effect="__sheetOpen ? $el.showModal() : $el.close()"
    {{ $attributes->twMerge($sheet(['side' => $side, 'variant' => 'sheet'])) }}
>
    <x-sheet.close
        variant="icon"
        class="absolute transition-opacity rounded-sm right-4 top-4 opacity-70 ring-offset-background hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:pointer-events-none"
    >
        <x-heroicon-o-x-mark class="size-4" />
    </x-sheet.close>
    {{ $slot }}
</dialog>
