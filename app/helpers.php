<?php

use App\Factories\UserRoleFactory;
use App\UserRoles\AbstractUserRole;

if (!function_exists('user_role')) {
    function user_role(): AbstractUserRole
    {
        if (auth()->check()) {
            return auth()->user()->role();
        }

        return UserRoleFactory::create('guest');
    }
}
