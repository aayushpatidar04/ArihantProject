<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class PermissionServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // @permission('resource', 'view')
        Blade::if('permission', function (string $resource, ?string $action = 'view') {
            $user = Auth::user();
            return $user && $user->isAdmin() && $user->can($resource, $action);
        });

        // @canAction('registrations', 'edit') — same thing
        Blade::if('canAction', function (string $resource, ?string $action = 'view') {
            $user = Auth::user();
            return $user && $user->isAdmin() && $user->can($resource, $action);
        });
    }
}
