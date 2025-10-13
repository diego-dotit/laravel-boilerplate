<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Contracts\HasPageMetadata;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Traits\CrudListing;

new
#[Layout('components.layouts.admin', ['title' => 'admin.dashboard.title'])]
class extends Component implements HasPageMetadata {
    use CrudListing;

    public function getModel(): string
    {
        return User::class;
    }

    public function getTitle(): string
    {
        return __('admin.users.title');
    }

    public function getBreadcrumb(): array
    {
        return [
            ['label' => ucwords(__('admin.dashboard.title')), 'href' => route('admin.dashboard')],
            ['label' => ucwords(__('admin.users.title')), 'href' => route('admin.users')],
        ];
    }

    public function getColumns(): array
    {
        return [
            '' => ['', 'w-12'],
            'name' => __('admin.users.fields.name.label'),
            'email' => __('admin.users.fields.email.label'),
            'role' => __('admin.users.fields.role.label'),
            'created_at' => [Str::ucfirst(__('common.created_at')), 'text-end'],
            'updated_at' => [Str::ucfirst(__('common.updated_at')), 'text-end'],
            'actions' => [Str::ucfirst(Str::plural(__('common.action'))), 'text-end']
        ];
    }

    public function getResults(): LengthAwarePaginator
    {
        $query = User::query();

        return $query->paginate(config('crud.pagination_default'));
    }
}; ?>

<div>
    <x-common.heading :title="$this->getTitle()" :breadcrumbs="$this->getBreadcrumb()" />

    <div class="mb-6 text-end">
        <x-table.create-button :href="route('admin.users.create')">{{ __('admin.users.singular') }}</x-table.create-button>
    </div>

    <x-table :columns="$this->getColumns()">
        @foreach($result = $this->getResults() as $user)
            <x-table.row wire:key="user-{{ $user->id }}">
                <x-table.cell>
                    <x-avatar class="grow-0">
                        <x-avatar.image src="{{ $user->getFirstMediaUrl('avatars', 'thumb') }}" />
                        <x-avatar.fallback>{{ $user->initials() }}</x-avatar.fallback>
                    </x-avatar>
                </x-table.cell>
                <x-table.cell>{{ $user->name }}</x-table.cell>
                <x-table.cell>{{ $user->email }}</x-table.cell>
                <x-table.cell>{{ $user->role()->getLabel() }}</x-table.cell>
                <x-table.cell class="text-end">{{ $user->created_at->format('d.m.Y') }}</x-table.cell>
                <x-table.cell class="text-end">{{ $user->updated_at->format('d.m.Y') }}</x-table.cell>
                <x-table.cell class="flex items-center justify-end gap-3">
                    <x-table.edit-button href="{{ route('admin.users.edit', $user) }}" />
                    <x-table.delete-button :model="$user" />
                </x-table.cell>
            </x-table.row>
        @endforeach
    </x-table>

    <x-table.pagination :paginator="$result" />
</div>
