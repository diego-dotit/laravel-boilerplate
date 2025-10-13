<?php

namespace App\UserRoles;

abstract class AbstractUserRole
{
    public function getKey(): string
    {
        return strtolower(str_replace('Role', '', class_basename($this)));
    }

    public function getLabel(): string
    {
        return __("enum.user_role.{$this->getKey()}");
    }

    public function has(string $capability): bool
    {
        $interfaceName = "App\\Contracts\\UserRoleCapabilities\\{$capability}";

        if (interface_exists($interfaceName)) {
            return $this instanceof $interfaceName;
        }

        $traitName = "App\\Traits\\UserRoleCapabilities\\{$capability}";
        if (trait_exists($traitName)) {
            return in_array($traitName, class_uses_recursive($this));
        }

        return false;
    }
}
