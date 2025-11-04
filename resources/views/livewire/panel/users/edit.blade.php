<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Contracts\HasPageMetadata;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

new
#[Layout('components.panel.layouts.panel', ['title' => 'admin.users.title'])]
class extends Component implements HasPageMetadata
{
    public ?User $model = null;

    public function mount(...$params): void
    {
        $id = $params[0] ?? null;

        if ($id) {
            $this->model = User::findOrFail($id);
        }
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
            ['label' => ucwords(__('admin.users.singular')), 'href' => 'javascript:void(0)'],
        ];
    }
}; ?>

<div>
    <x-panel.common.heading :title="$this->getTitle()" :breadcrumbs="$this->getBreadcrumb()" />

    <div class="flex items-center justify-end gap-4 mb-6">
        <x-button type="submit" form="user-form">{{ __('button.save') }}</x-button>
        <x-link href="{{ route('admin.users') }}">{{ __('button.cancel') }}</x-link>
    </div>

    <livewire:panel.users.form :model="$model" />
</div>
