<?php

namespace App\Filament\Widgets;

use App\Models\Reservation;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class ReservationPeakHoursChart extends ChartWidget
{
    protected static ?string $heading = '👑 Reservation Peak Hours';
    protected static ?string $maxHeight = '280px';
    protected int | string | array $columnSpan = [
        'md' => 12,
        'xl' => 6,
    ];
    protected static ?string $pollingInterval = '15s';
    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $reservations = Reservation::where('status', '!=', 'cancelled')->get();
        
        // Define standard Nawabi Dera operating hours: 12:00 PM (noon) to 11:00 PM (12 to 23)
        $operatingHours = range(12, 23);
        $data = [];
        $labels = [];
        
        foreach ($operatingHours as $hour) {
            $timeString = Carbon::createFromTime($hour, 0)->format('g:i A');
            $labels[] = $timeString;
            $data[] = 0;
        }
        
        foreach ($reservations as $reservation) {
            if ($reservation->reservation_time) {
                // Keep local timezone parsing or extract hour directly
                $hour = (int)$reservation->reservation_time->format('H');
                $index = array_search($hour, $operatingHours);
                if ($index !== false) {
                    $data[$index] += $reservation->guest_count; // Sum up guests or booking count. Guest count is more representative of peak traffic!
                }
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Guests Booked',
                    'data' => $data,
                    'backgroundColor' => '#D7262E', // Royal Red
                    'borderColor' => '#D7262E',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
