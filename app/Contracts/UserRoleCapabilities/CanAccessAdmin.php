<?php

namespace App\Contracts\UserRoleCapabilities;

interface CanAccessAdmin
{
    public function canAccessAdminPanel(): bool;
}
