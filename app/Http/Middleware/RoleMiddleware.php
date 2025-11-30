<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (! $request->user()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if (! in_array($request->user()->role, $roles)) {
            return response()->json(['message' => 'Forbidden Role tidak diizinkan'], 403);
        }

        return $next($request);
    }
}
