@props([
    'label' => 'Label',
    'descriptionTrailing' => '',
    'required' => false,
])

<x-form.item>
    <x-form.label :required="$required">
        {{ $label }}
    </x-form.label>

    <x-date
        x-form:control
        {{ $attributes }}
    />

    @if ($descriptionTrailing)
        <x-form.description>
            {{ $descriptionTrailing }}
        </x-form.description>
    @endif

    <x-form.message
        name="{{ $attributes->has('wire:model') ? $attributes->get('wire:model') : $attributes->get('name') }}"
    />
</x-form.item>
