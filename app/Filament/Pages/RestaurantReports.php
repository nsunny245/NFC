<?php

namespace App\Filament\Pages;

use App\Http\Controllers\RestaurantReportController;
use Filament\Pages\Page;

class RestaurantReports extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static string $view = 'filament.pages.restaurant-reports';

    protected static ?string $navigationGroup = 'Royal Back-Office RRP';

    protected static ?string $navigationLabel = 'Reports & Exports 📊';

    protected static ?string $title = 'Executive Reports & Analytics Hub 📊';

    protected static ?int $navigationSort = 3;

    public string $activeReport = 'sales';
    public string $timeRange = 'today';

    public function setActiveReport(string $type): void
    {
        $this->activeReport = $type;
    }

    public function setTimeRange(string $range): void
    {
        $this->timeRange = $range;
    }

    public function getReportsCatalog(): array
    {
        return [
            'sales' => [
                'id' => 'sales',
                'title' => 'Sales & Revenue Audit',
                'category' => 'Financial',
                'icon' => '💰',
                'description' => 'Gross sales, channel splits (Dine-In, Takeaway, Delivery), GST taxes, customer profiles & average ticket values.',
                'badge' => 'High Frequency',
                'badgeColor' => 'success',
            ],
            'inventory' => [
                'id' => 'inventory',
                'title' => 'Raw Material & Stock Demand',
                'category' => 'Operations',
                'icon' => '🥩',
                'description' => 'In-store raw ingredients, Mandi procurement demands, current asset valuation in PKR & low-stock warnings.',
                'badge' => 'Stock Assets',
                'badgeColor' => 'warning',
            ],
            'expenses' => [
                'id' => 'expenses',
                'title' => 'Expenses & Procurement Ledger',
                'category' => 'Financial',
                'icon' => '💸',
                'description' => 'All restaurant expenditures itemized by stock procurement, gas/power utilities, rent, and staff payroll.',
                'badge' => 'Cash Outflow',
                'badgeColor' => 'danger',
            ],
            'menu_performance' => [
                'id' => 'menu_performance',
                'title' => 'Dishes & Culinary Performance',
                'category' => 'Kitchen',
                'icon' => '🥘',
                'description' => 'Menu engineering matrix, top sales-velocity dishes, portion counts, and profit margins per recipe.',
                'badge' => 'Menu Intel',
                'badgeColor' => 'info',
            ],
            'reservations' => [
                'id' => 'reservations',
                'title' => 'Table Bookings & Seating Logs',
                'category' => 'Guest Relations',
                'icon' => '🪑',
                'description' => 'Guest reservation schedules, party sizes, table assignments across Dining, Family Hall & Outdoor Dera.',
                'badge' => 'Dining Logs',
                'badgeColor' => 'primary',
            ],
            'equipment' => [
                'id' => 'equipment',
                'title' => 'Master Equipment & Asset Audit',
                'category' => 'Assets',
                'icon' => '🔧',
                'description' => 'Complete registry of all 149 restaurant physical assets, kitchen cookware, furniture & HVAC hardware.',
                'badge' => '149 Assets',
                'badgeColor' => 'info',
            ],
            'staff_payroll' => [
                'id' => 'staff_payroll',
                'title' => 'Staff Profiles & Payroll Ledger',
                'category' => 'HR & Payroll',
                'icon' => '👨‍🍳',
                'description' => 'Staff directory, organizational roles, fixed monthly salary liabilities, and system account linkages.',
                'badge' => 'HR Payroll',
                'badgeColor' => 'success',
            ],
            'cashier_till' => [
                'id' => 'cashier_till',
                'title' => 'Cashier Till & Shift Settlement',
                'category' => 'POS Audit',
                'icon' => '🖥️',
                'description' => 'End-of-shift drawer reconciliation, physical cash balances vs card and digital wallet settlements.',
                'badge' => 'Shift Audit',
                'badgeColor' => 'warning',
            ],
        ];
    }

    public function getActiveReportData(): array
    {
        return app(RestaurantReportController::class)->getReportData($this->activeReport, $this->timeRange);
    }
}
