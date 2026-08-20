<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VenueStaffMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $pin = config('event.venue_pin');

        if (empty($pin)) {
            // No PIN configured = allow (for local dev)
            return $next($request);
        }

        if (session('venue_authenticated') !== true) {
            return redirect()->route('venue.login');
        }

        return $next($request);
    }
}