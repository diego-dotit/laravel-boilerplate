<?php

use Livewire\Volt\Component;
use App\Models\User;
use App\Traits\CrudShow;
use App\Contracts\HasPageMetadata;
use Livewire\Attributes\Layout;

new
#[Layout('components.panel.layouts.panel', ['title' => 'admin.dashboard.title'])]
class extends Component implements HasPageMetadata {
    use CrudShow;

    public function getTitle(): string
    {
        return __('admin.users.title');
    }

    public function getBreadcrumb(): array
    {
        return [
            ['label' => ucwords(__('admin.dashboard.title')), 'href' => route('admin.dashboard')],
            ['label' => ucwords(__('admin.users.title')), 'href' => route('admin.users')],
            ['label' => $this->model->name, 'href' => 'javascript:void(0)'],
        ];
    }

    public function getModel(): string
    {
        return User::class;
    }
}; ?>

<div>
    <x-panel.common.heading :title="$this->getTitle()" :breadcrumbs="$this->getBreadcrumb()" />

    <div class="flex items-center justify-between mb-6">
        <div class="text-lg font-semibold">{{ $this->model->name }}</div>
        <div>
            <x-link :href="route('admin.users')">{{ __('common.back') }}</x-link>
        </div>
    </div>

    <div>
        / info about the user /
    </div>
</div>
