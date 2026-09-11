<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Reservation;
use App\Observers\OrderObserver;
use App\Observers\ReservationObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('production') || env('FORCE_HTTPS', false)) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        Reservation::observe(ReservationObserver::class);
        Order::observe(OrderObserver::class);

        if (class_exists(\Livewire\Livewire::class) && class_exists(\App\Filament\Widgets\RawMaterialDemandExpenseWidget::class)) {
            \Livewire\Livewire::component('app.filament.widgets.raw-material-demand-expense-widget', \App\Filament\Widgets\RawMaterialDemandExpenseWidget::class);
        }
    }
}

