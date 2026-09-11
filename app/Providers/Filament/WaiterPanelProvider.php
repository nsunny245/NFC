<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class WaiterPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('waiter')
            ->path('waiter')
            ->login()
            ->authGuard('waiter')
            ->brandName('NFC Waiter Pad 🍽️')
            ->brandLogo(fn () => asset('images/logo_circular.png'))
            ->brandLogoHeight('3rem')
            ->favicon(asset('images/logo_circular.png'))
            ->topNavigation()
            ->maxContentWidth('full')
            ->colors([
                'primary' => Color::hex('#D4A437'), // Warm Gold
                'danger' => Color::hex('#D7262E'),  // Nawabi Red
                'gray' => Color::Slate,
            ])
            ->discoverResources(in: app_path('Filament/Waiter/Resources'), for: 'App\\Filament\\Waiter\\Resources')
            ->discoverPages(in: app_path('Filament/Waiter/Pages'), for: 'App\\Filament\\Waiter\\Pages')
            ->pages([
                \App\Filament\Waiter\Pages\WaiterDashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Waiter/Widgets'), for: 'App\\Filament\\Waiter\\Widgets')
            ->widgets([
                // Widgets are disabled on waiter panel to keep it clean and fast on mobile
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                \App\Http\Middleware\FilamentPanelAuthenticate::class,
            ]);
    }
}
