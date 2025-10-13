<?php

namespace App\Http\Controllers\Middleware;

use Closure;
use App\UserRoles\AdminRole;

class CanAccessAdmin
{
    public function handle($request, \Closure $next)
    {
        if (
            user_role() instanceof AdminRole
            && user_role()->canAccessAdminPanel()
        ) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
