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
            // Store the intended URL before redirecting to admin login
            // Use getPathAndQuery() to store path + query string (without the domain)
            session(['url.intended' => $request->getPathAndQuery()]);
            return redirect()->route('admin.login');
        }

        $allowedEmails = array_map('strtolower', config('event.admin_emails', []));
        if (!in_array(strtolower(auth()->user()->email), $allowedEmails, true)) {
            abort(403, 'Unauthorized access.');
        }
        return $next($request);
    }
}
