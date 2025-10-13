<?php

namespace App\Factories;

use App\Builders\SidebarMenuBuilders\AdminSidebarMenuBuilder;
use App\Contracts\SidebarMenuBuilder;

class SidebarMenuFactory
{
    public static function make(string $type): SidebarMenuBuilder
    {
        return match($type) {
            'admin' => new AdminSidebarMenuBuilder(),
            default => new AdminSidebarMenuBuilder()
        };
    }
}
