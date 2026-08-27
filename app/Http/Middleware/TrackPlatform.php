<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPlatform
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('platform') && $request->filled('platform')) {
            \Log::info($request->platform);
            session(['registration_platform' => $request->query('platform')]);
        }

        return $next($request);
    }
}