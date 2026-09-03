<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InfluencerMiddleware
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        if (!auth()->check()) {
            // Store the intended URL before redirecting to influencer login
            // Use getPathAndQuery() to store path + query string (without the domain)
            session(['url.intended' => $request->getPathAndQuery()]);
            return redirect()->route('influencer.login');
        }

        if (auth()->user()->role !== 'influencer') {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}