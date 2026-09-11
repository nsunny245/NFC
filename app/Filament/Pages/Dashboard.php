<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Operational Command Center 👑';

    protected static ?string $navigationLabel = 'Command Center 👑';

    /**
     * 12-column responsive layout to utilize 100% of the screen.
     */
    public function getColumns(): int | string | array
    {
        return 12;
    }

    /**
     * Display only the elite interactive KPI hub and analytics charts.
     */
    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\PakistaniRestaurantKpisWidget::class,
            \App\Filament\Widgets\RawMaterialDemandExpenseWidget::class,
            \App\Filament\Widgets\SalesChart::class,
            \App\Filament\Widgets\TopCategoryChart::class,
            \App\Filament\Widgets\ReservationPeakHoursChart::class,
            \App\Filament\Widgets\NotificationsWidget::class,
        ];
    }
}
