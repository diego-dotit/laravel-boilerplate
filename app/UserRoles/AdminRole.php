<?php

namespace App\UserRoles;

use App\Contracts\UserRoleCapabilities\CanAccessAdmin;

class AdminRole extends AbstractUserRole implements CanAccessAdmin
{
    public function canAccessAdminPanel(): bool
    {
        return true;
    }
}
