<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
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

class PosPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('pos')
            ->path('pos')
            ->login()
            ->authGuard('pos')
            ->brandName('Nawabi Food Corner POS 👑')
            ->brandLogo(fn () => asset('images/logo_circular.png'))
            ->brandLogoHeight('3rem')
            ->favicon(asset('images/logo_circular.png'))
            ->colors([
                'primary' => Color::hex('#D4A437'), // Warm Gold
                'danger' => Color::hex('#D7262E'),  // Nawabi Red
                'gray' => Color::Slate,
            ])
            ->userMenuItems([
                MenuItem::make()
                    ->label('Admin Dashboard')
                    ->url('/admin')
                    ->icon('heroicon-o-shield-check')
                    ->openUrlInNewTab(),
            ])
            ->discoverResources(in: app_path('Filament/Pos/Resources'), for: 'App\\Filament\\Pos\\Resources')
            ->discoverPages(in: app_path('Filament/Pos/Pages'), for: 'App\\Filament\\Pos\\Pages')
            ->pages([
                \App\Filament\Pos\Pages\POSDashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Pos/Widgets'), for: 'App\\Filament\\Pos\\Widgets')
            ->widgets([
                // Widgets are disabled on cashier POS to keep it clean
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
