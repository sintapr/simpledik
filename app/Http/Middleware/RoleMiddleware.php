<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $userRole = session('role');

        Log::info('Current Role: ' . $userRole . ' | Allowed: ' . implode(', ', $roles));

        if (!in_array($userRole, $roles)) {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}