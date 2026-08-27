<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use App\Http\Middleware\TrackPlatform;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'venue' => \App\Http\Middleware\VenueStaffMiddleware::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);

        $middleware->web(append: [
            TrackPlatform::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'payment/callback/*',
            'webhook/atom',
            'webhook/pickyassist/event',
            'webhook/pickyassist/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Throwable $e, Request $request) {
            // Let Laravel handle validation errors normally (redirect back with errors)
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                return null;
            }

            if ($request->expectsJson() || config('app.debug')) {
                return null;
            }

            $status = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;

            return response()->view('errors.error', ['code' => $status], $status);
        });
    })->create();
