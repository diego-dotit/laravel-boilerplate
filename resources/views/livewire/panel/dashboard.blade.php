<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Contracts\HasPageMetadata;

new
#[Layout('components.panel.layouts.panel', ['title' => 'admin.dashboard.title'])]
class extends Component implements HasPageMetadata {
    public function getTitle(): string
    {
        return __('admin.dashboard.title');
    }

    public function getBreadcrumb(): array
    {
        return [
            ['label' => ucwords(__('admin.dashboard.title')), 'href' => route('admin.dashboard')],
        ];
    }
}; ?>

<div>
    <x-panel.common.heading :title="$this->getTitle()" :breadcrumbs="$this->getBreadcrumb()" />

    /dashboard content/
</div>
