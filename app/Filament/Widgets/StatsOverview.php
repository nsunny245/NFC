<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Reservation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '10s';
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $revenue = Order::where('status', 'completed')->sum('total');
        $activeBookings = Reservation::whereIn('status', ['pending', 'confirmed'])->count();
        $totalOrders = Order::count();

        return [
            Stat::make('👑 Royal Revenue', 'Rs. ' . number_format($revenue, 0))
                ->description('Total completed sales')
                ->descriptionIcon('heroicon-m-banknotes')
                ->chart([
                    Order::where('status', 'completed')->where('created_at', '>=', now()->subDays(6))->orderBy('created_at')->pluck('total')->toArray() ?: [0, 0]
                ])
                ->color('success'),
                
            Stat::make('👑 Active Bookings', $activeBookings)
                ->description('Pending and confirmed tables')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info'),
                
            Stat::make('👑 Total Transactions', $totalOrders)
                ->description('All order logs generated')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('warning'),
        ];
    }
}
