<?php

namespace App\Factories;

use App\UserRoles\AbstractUserRole;
use App\UserRoles\AdminRole;
use App\UserRoles\UserRole;
use App\UserRoles\GuestRole;

class UserRoleFactory
{
    private static array $roles = [
        'admin' => AdminRole::class,
        'user' => UserRole::class,
        'guest' => GuestRole::class,
    ];

    public static function create(string $role): AbstractUserRole
    {
        if (!isset(self::$roles[$role])) {
            throw new \InvalidArgumentException("Role '{$role}' does not exist.");
        }

        $class = self::$roles[$role];
        return new $class();
    }

    public static function getRoles(): array
    {
        return array_keys(self::$roles);
    }

    public static function getLabels(): array
    {
        $labels = [];
        foreach (self::$roles as $key => $class) {
            $role = new $class();
            $labels[$key] = $role->getLabel();
        }
        return $labels;
    }
}
