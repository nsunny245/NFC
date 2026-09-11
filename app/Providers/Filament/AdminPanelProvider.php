<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationItem;
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

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->authGuard('admin')
            ->maxContentWidth(\Filament\Support\Enums\MaxWidth::Full)
            ->brandName('NFC Admin Panel 👑')
            ->brandLogo(fn () => asset('images/logo_circular.png'))
            ->brandLogoHeight('3rem')
            ->favicon(asset('images/logo_circular.png'))
            ->colors([
                'primary' => Color::hex('#D4A437'), // Warm Gold
                'danger' => Color::hex('#D7262E'),  // Nawabi Red
                'gray' => Color::Slate,
            ])
            ->renderHook(
                \Filament\View\PanelsRenderHook::USER_MENU_BEFORE,
                fn () => view('filament.components.topbar-admin-controls')
            )
            ->renderHook(
                \Filament\View\PanelsRenderHook::HEAD_END,
                fn () => view('filament.components.admin-head-styles')
            )
            ->navigationItems([
                NavigationItem::make('Cashier POS')
                    ->url('/pos')
                    ->icon('heroicon-o-computer-desktop')
                    ->group('Floor Operations')
                    ->openUrlInNewTab()
                    ->sort(98),
                NavigationItem::make('Waiter Pad')
                    ->url('/waiter')
                    ->icon('heroicon-o-device-phone-mobile')
                    ->group('Floor Operations')
                    ->openUrlInNewTab()
                    ->sort(99),
            ])
            ->userMenuItems([
                MenuItem::make()
                    ->label('Open Cashier POS')
                    ->url('/pos')
                    ->icon('heroicon-o-computer-desktop')
                    ->openUrlInNewTab(),
                MenuItem::make()
                    ->label('Open Waiter Pad')
                    ->url('/waiter')
                    ->icon('heroicon-o-device-phone-mobile')
                    ->openUrlInNewTab(),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                \App\Filament\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                \App\Filament\Widgets\PakistaniRestaurantKpisWidget::class,
                \App\Filament\Widgets\RawMaterialDemandExpenseWidget::class,
                \App\Filament\Widgets\SalesChart::class,
                \App\Filament\Widgets\TopCategoryChart::class,
                \App\Filament\Widgets\ReservationPeakHoursChart::class,
                \App\Filament\Widgets\NotificationsWidget::class,
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
