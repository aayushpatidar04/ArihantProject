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
            session(['url.intended' => $request->fullUrl()]);
            return redirect()->route('influencer.login');
        }

        if (auth()->user()->role !== 'influencer') {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}