<x-dialog>
    <x-dialog.trigger-link {{ $attributes }} class="text-red-700">{{ trim(__('button.delete_object', ['object' => $slot ?? ''])) }}</x-dialog.trigger-link>
    <x-dialog.content>
        <x-dialog.header>
            <x-dialog.title>{{ __('common.confirm_delete_title') }}</x-dialog.title>
        </x-dialog.header>
        <x-dialog.description class="my-4">{{ __('common.confirm_delete') }}</x-dialog.description>
        <x-dialog.footer class="sm:justify-between">
            <x-dialog.close>{{ __('button.cancel') }}</x-dialog.close>
            <x-button
                variant="destructive"
                wire:click="delete({{ $model->id }});"
                x-on:click="__dialogOpen = false"
            >{{ __('button.confirm_delete') }}</x-button>
        </x-dialog.footer>
    </x-dialog.content>
</x-dialog>
