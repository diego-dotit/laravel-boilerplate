<?php

namespace App\Builders\SidebarMenuBuilders;

use App\Contracts\SidebarMenuBuilder;
use App\Models\User;

class AdminSidebarMenuBuilder implements SidebarMenuBuilder
{
    public function __construct(protected ?User $user = null)
    {
        if (!$this->user) {
            $this->user = auth()->user();
        }
    }

    public function build(): array
    {
        return [
            [
                'label' => ucfirst(__('common.general')),
                'is_header' => true,
            ],
            [
                'label' => __('admin.dashboard.title'),
                'icon' => 'home',
                'route' => 'admin.dashboard',
            ],
            [
                'label' => ucfirst(__('common.system')),
                'is_header' => true,
            ],
            [
                'label' => 'Settings',
                'icon' => 'cog-6-tooth',
                'href' => '#',
            ],
            [
                'label' => __('admin.users.title'),
                'icon' => 'users',
                'route' => 'admin.users',
            ],
            [
                'label' => 'Localisation',
                'icon' => 'globe-alt',
                'children' => [
                    [
                        'label' => 'Languages',
                        'icon' => 'language',
                        'href' => '#',
                    ],
                ],
            ],
            [
                'fill' => true,
            ],
            [
                'label' => ucfirst(__('common.logout')),
                'icon' => 'arrow-uturn-left',
                'route' => 'logout',
            ],
        ];
    }
}
