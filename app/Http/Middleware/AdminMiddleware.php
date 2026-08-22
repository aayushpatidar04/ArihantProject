<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('admin.login', ['redirect' => $request->getRequestUri()]);
        }

        $allowedEmails = array_map('strtolower', config('event.admin_emails', []));
        if (!in_array(strtolower(auth()->user()->email), $allowedEmails, true)) {
            abort(403, 'Unauthorized access.');
        }
        return $next($request);
    }
}
