<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Usage: Route::middleware(['admin', 'permission:registrations,view'])
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, string $resource, ?string $action = 'view'): Response
    {
        $user = auth()->user();

        if (!$user || !$user->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        if (!$user->can($resource, $action)) {
            abort(403, 'You do not have permission to access this resource.');
        }

        return $next($request);
    }
}
