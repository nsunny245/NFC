<?php

namespace App\Filament\Widgets;

use App\Models\OrderItem;
use App\Models\MenuCategory;
use Filament\Widgets\ChartWidget;

class TopCategoryChart extends ChartWidget
{
    protected static ?string $heading = '👑 Top-Selling Categories';
    protected static ?string $maxHeight = '320px';
    protected int | string | array $columnSpan = [
        'md' => 12,
        'xl' => 4,
    ];
    protected static ?string $pollingInterval = '15s';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        // Query completed order items with their menu item and category relations
        $items = OrderItem::whereHas('order', function ($query) {
            $query->where('status', 'completed');
        })->with(['menuItem.category'])->get();

        $categoryQuantities = [];

        foreach ($items as $item) {
            $categoryName = $item->menuItem?->category?->name ?? 'Uncategorized';
            $qty = $item->quantity ?: 0;
            
            if (!isset($categoryQuantities[$categoryName])) {
                $categoryQuantities[$categoryName] = 0;
            }
            $categoryQuantities[$categoryName] += $qty;
        }

        // Sort descending so the highest sellers show up first
        arsort($categoryQuantities);

        // Ensure we always have at least some default keys for clean rendering if no database records exist
        if (empty($categoryQuantities)) {
            $categoryQuantities = [
                'Desi Specialties (Karahi)' => 0,
                'BBQ Items' => 0,
                'Fast Food & Pizzas' => 0,
                'Chinese Favorites' => 0,
            ];
        }

        $labels = array_keys($categoryQuantities);
        $data = array_values($categoryQuantities);

        return [
            'datasets' => [
                [
                    'label' => 'Units Sold',
                    'data' => $data,
                    'backgroundColor' => [
                        '#D4A437', // Gold (Karahi / Desi Specialties)
                        '#D7262E', // Red (BBQ Items)
                        '#1E3A8A', // Dark Blue (Fast Food & Pizzas)
                        '#10B981', // Emerald Green (Chinese Favorites)
                        '#8B5CF6', // Purple
                        '#6B7280', // Gray
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
