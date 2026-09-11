<?php

namespace App\Http\Middleware;

use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate as BaseAuthenticate;
use Filament\Models\Contracts\FilamentUser;

class FilamentPanelAuthenticate extends BaseAuthenticate
{
    /**
     * Authenticate the user for the current Filament panel.
     *
     * If an authenticated user doesn't have permission to access this panel,
     * cleanly log them out of this panel's guard and redirect to the login page,
     * completely eliminating 403 Forbidden dead-end lockout screens.
     */
    protected function authenticate($request, array $guards): void
    {
        $guard = Filament::auth();

        if (! $guard->check()) {
            $this->unauthenticated($request, $guards);
            return;
        }

        $this->auth->shouldUse(Filament::getAuthGuard());

        $user = $guard->user();
        $panel = Filament::getCurrentPanel();

        if ($user instanceof FilamentUser && ! $user->canAccessPanel($panel)) {
            // Log out from this panel's guard so the user can enter authorized credentials
            $guard->logout();

            $this->unauthenticated($request, $guards);
            return;
        }

        abort_if(
            ! ($user instanceof FilamentUser) && (config('app.env') !== 'local'),
            403,
        );
    }
}
