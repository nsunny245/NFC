<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class SalesChart extends ChartWidget
{
    protected static ?string $heading = '👑 Royal Sales Revenue';
    protected static ?string $maxHeight = '320px';
    protected int | string | array $columnSpan = [
        'md' => 12,
        'xl' => 8,
    ];
    protected static ?string $pollingInterval = '15s';
    protected static ?int $sort = 2;
    
    public ?string $filter = 'month';

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'Last 7 Days',
            'month' => 'Last 30 Days',
            'year' => 'This Year',
        ];
    }

    protected function getData(): array
    {
        $activeFilter = $this->filter ?? 'month';
        
        $query = Order::query()->where('status', 'completed');
        
        if ($activeFilter === 'today') {
            $orders = $query->whereDate('created_at', now()->toDateString())->get();
            $data = array_fill(0, 24, 0);
            foreach ($orders as $order) {
                $hour = (int)$order->created_at->format('H');
                $data[$hour] += (float)$order->total;
            }
            $labels = array_map(fn($h) => sprintf('%02d:00', $h), range(0, 23));
            $chartData = array_values($data);
            $label = 'Sales (Rs.) - Today';
        } elseif ($activeFilter === 'week') {
            $orders = $query->where('created_at', '>=', now()->subDays(6)->startOfDay())->get();
            $data = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i)->format('Y-m-d');
                $data[$date] = 0;
            }
            foreach ($orders as $order) {
                $date = $order->created_at->format('Y-m-d');
                if (isset($data[$date])) {
                    $data[$date] += (float)$order->total;
                }
            }
            $labels = array_map(fn($d) => Carbon::parse($d)->format('M d'), array_keys($data));
            $chartData = array_values($data);
            $label = 'Sales (Rs.) - Last 7 Days';
        } elseif ($activeFilter === 'year') {
            $orders = $query->whereYear('created_at', now()->year)->get();
            $data = array_fill(1, 12, 0);
            foreach ($orders as $order) {
                $month = (int)$order->created_at->format('m');
                $data[$month] += (float)$order->total;
            }
            $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            $chartData = array_values($data);
            $label = 'Sales (Rs.) - This Year';
        } else { // default 'month'
            $orders = $query->where('created_at', '>=', now()->subDays(29)->startOfDay())->get();
            $data = [];
            for ($i = 29; $i >= 0; $i--) {
                $date = now()->subDays($i)->format('Y-m-d');
                $data[$date] = 0;
            }
            foreach ($orders as $order) {
                $date = $order->created_at->format('Y-m-d');
                if (isset($data[$date])) {
                    $data[$date] += (float)$order->total;
                }
            }
            $labels = array_map(fn($d) => Carbon::parse($d)->format('M d'), array_keys($data));
            $chartData = array_values($data);
            $label = 'Sales (Rs.) - Last 30 Days';
        }

        return [
            'datasets' => [
                [
                    'label' => $label,
                    'data' => $chartData,
                    'backgroundColor' => 'rgba(212, 164, 55, 0.2)',
                    'borderColor' => '#D4A437',
                    'borderWidth' => 3,
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
