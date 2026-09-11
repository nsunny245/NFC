<?php

namespace Tests\Feature;

use App\Filament\Widgets\SalesChart;
use App\Filament\Widgets\ReservationPeakHoursChart;
use App\Filament\Widgets\TopCategoryChart;
use App\Filament\Widgets\StatsOverview;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnalyticsTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@nawabidera.com',
            'password' => bcrypt('password123'),
        ]);
    }

    public function test_stats_overview_widget_returns_correct_kpis()
    {
        // 1. Seed some orders
        Order::create([
            'order_number' => 'ORD-1001',
            'subtotal' => 4500,
            'tax' => 500,
            'discount' => 0,
            'total' => 5000,
            'status' => 'completed',
            'type' => 'dine_in',
        ]);
        Order::create([
            'order_number' => 'ORD-1002',
            'subtotal' => 3000,
            'tax' => 500,
            'discount' => 0,
            'total' => 3500,
            'status' => 'completed',
            'type' => 'delivery',
        ]);
        Order::create([
            'order_number' => 'ORD-1003',
            'subtotal' => 1800,
            'tax' => 200,
            'discount' => 0,
            'total' => 2000,
            'status' => 'pending',
            'type' => 'takeaway',
        ]);

        // 2. Seed some reservations
        Reservation::create([
            'guest_name' => 'Mian Muhammad',
            'guest_phone' => '03001234567',
            'reservation_time' => now()->addDay()->setTime(19, 0),
            'guest_count' => 4,
            'status' => 'confirmed',
        ]);
        Reservation::create([
            'guest_name' => 'Chaudhary Ali',
            'guest_phone' => '03007654321',
            'reservation_time' => now()->addDay()->setTime(20, 0),
            'guest_count' => 2,
            'status' => 'pending',
        ]);
        Reservation::create([
            'guest_name' => 'Cancelled Guest',
            'guest_phone' => '03009999999',
            'reservation_time' => now()->addDay()->setTime(18, 0),
            'guest_count' => 8,
            'status' => 'cancelled',
        ]);

        $widget = new StatsOverview();
        
        $method = new \ReflectionMethod(StatsOverview::class, 'getStats');
        $method->setAccessible(true);
        $stats = $method->invoke($widget);

        $this->assertCount(3, $stats);
        
        // Assert Revenue (Rs. 8,500 total completed)
        $this->assertStringContainsString('8,500', $stats[0]->getValue());
        
        // Assert Active Bookings (confirmed + pending = 2)
        $this->assertEquals(2, $stats[1]->getValue());
        
        // Assert Total Transactions (all order logs = 3)
        $this->assertEquals(3, $stats[2]->getValue());
    }

    public function test_sales_chart_widget_groups_sales_correctly_by_active_filter()
    {
        // 1. Create completed orders with custom dates
        $orderToday = Order::create([
            'order_number' => 'ORD-TODAY',
            'subtotal' => 1000,
            'tax' => 200,
            'discount' => 0,
            'total' => 1200,
            'status' => 'completed',
            'type' => 'dine_in',
        ]);
        $orderToday->created_at = now();
        $orderToday->save();

        $orderYesterday = Order::create([
            'order_number' => 'ORD-YESTERDAY',
            'subtotal' => 1500,
            'tax' => 300,
            'discount' => 0,
            'total' => 1800,
            'status' => 'completed',
            'type' => 'dine_in',
        ]);
        $orderYesterday->created_at = now()->subDay();
        $orderYesterday->save();

        $widget = new SalesChart();
        $method = new \ReflectionMethod(SalesChart::class, 'getData');
        $method->setAccessible(true);
        
        // Default filter: month (30 days)
        $widget->filter = 'month';
        $dataMonth = $method->invoke($widget);
        $this->assertCount(30, $dataMonth['labels']);
        $this->assertEquals(1200, end($dataMonth['datasets'][0]['data'])); // today's sales
        $this->assertEquals(1800, $dataMonth['datasets'][0]['data'][28]); // yesterday's sales
        
        // Filter: week (7 days)
        $widget->filter = 'week';
        $dataWeek = $method->invoke($widget);
        $this->assertCount(7, $dataWeek['labels']);
        $this->assertEquals(1200, end($dataWeek['datasets'][0]['data'])); // today's sales
        
        // Filter: year (12 months)
        $widget->filter = 'year';
        $dataYear = $method->invoke($widget);
        $this->assertCount(12, $dataYear['labels']);
    }

    public function test_reservation_peak_hours_chart_groups_guests_by_hour()
    {
        // 1. Reservation at 7:30 PM (hour 19)
        Reservation::create([
            'guest_name' => 'Mian Dinner',
            'guest_phone' => '03001234567',
            'reservation_time' => now()->setTime(19, 30),
            'guest_count' => 5,
            'status' => 'confirmed',
        ]);

        // 2. Reservation at 1:15 PM (hour 13)
        Reservation::create([
            'guest_name' => 'Mian Lunch',
            'guest_phone' => '03007654321',
            'reservation_time' => now()->setTime(13, 15),
            'guest_count' => 3,
            'status' => 'confirmed',
        ]);

        // 3. Cancelled reservation at 7:00 PM (should be ignored)
        Reservation::create([
            'guest_name' => 'Mian Cancelled',
            'guest_phone' => '03009999999',
            'reservation_time' => now()->setTime(19, 0),
            'guest_count' => 10,
            'status' => 'cancelled',
        ]);

        $widget = new ReservationPeakHoursChart();
        $method = new \ReflectionMethod(ReservationPeakHoursChart::class, 'getData');
        $method->setAccessible(true);
        $data = $method->invoke($widget);

        // Standard operating hours range: 12 PM to 11 PM (12 hours)
        $this->assertCount(12, $data['labels']);
        
        // 7:00 PM (hour 19) is at index 7 (operatingHours: [12, 13, 14, 15, 16, 17, 18, 19, ...])
        $this->assertEquals(5, $data['datasets'][0]['data'][7]);
        
        // 1:00 PM (hour 13) is at index 1
        $this->assertEquals(3, $data['datasets'][0]['data'][1]);
    }

    public function test_top_category_chart_aggregates_sales_by_menu_category()
    {
        // 1. Create categories
        $catKarahi = MenuCategory::create(['name' => 'Karahi Specialties', 'slug' => 'karahi-specialties']);
        $catBBQ = MenuCategory::create(['name' => 'Royal BBQ', 'slug' => 'royal-bbq']);

        // 2. Create menu items
        $item1 = MenuItem::create([
            'category_id' => $catKarahi->id,
            'name' => 'Chicken Karahi',
            'description' => 'Delicious chicken karahi',
            'price' => 1500,
        ]);
        $item2 = MenuItem::create([
            'category_id' => $catBBQ->id,
            'name' => 'Malai Boti',
            'description' => 'Smoky malai boti',
            'price' => 800,
        ]);

        // 3. Create orders and order items
        $order1 = Order::create([
            'order_number' => 'ORD-001',
            'subtotal' => 4500,
            'tax' => 0,
            'discount' => 0,
            'total' => 4500,
            'status' => 'completed',
            'type' => 'dine_in',
        ]);
        OrderItem::create([
            'order_id' => $order1->id,
            'menu_item_id' => $item1->id,
            'quantity' => 3,
            'unit_price' => 1500,
            'total_price' => 4500,
        ]);

        $order2 = Order::create([
            'order_number' => 'ORD-002',
            'subtotal' => 4000,
            'tax' => 0,
            'discount' => 0,
            'total' => 4000,
            'status' => 'completed',
            'type' => 'delivery',
        ]);
        OrderItem::create([
            'order_id' => $order2->id,
            'menu_item_id' => $item2->id,
            'quantity' => 5,
            'unit_price' => 800,
            'total_price' => 4000,
        ]);
        
        // Pending order item (should be ignored)
        $orderPending = Order::create([
            'order_number' => 'ORD-003',
            'subtotal' => 15000,
            'tax' => 0,
            'discount' => 0,
            'total' => 15000,
            'status' => 'pending',
            'type' => 'takeaway',
        ]);
        OrderItem::create([
            'order_id' => $orderPending->id,
            'menu_item_id' => $item1->id,
            'quantity' => 10,
            'unit_price' => 1500,
            'total_price' => 15000,
        ]);

        $widget = new TopCategoryChart();
        $method = new \ReflectionMethod(TopCategoryChart::class, 'getData');
        $method->setAccessible(true);
        $data = $method->invoke($widget);

        // BBQ should be top with 5 units, Karahi second with 3 units
        $this->assertEquals('Royal BBQ', $data['labels'][0]);
        $this->assertEquals(5, $data['datasets'][0]['data'][0]);

        $this->assertEquals('Karahi Specialties', $data['labels'][1]);
        $this->assertEquals(3, $data['datasets'][0]['data'][1]);
    }
}
