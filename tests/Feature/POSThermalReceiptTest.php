<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class POSThermalReceiptTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_renders_thermal_receipt_with_official_specs_and_permanent_copyright(): void
    {
        $order = Order::create([
            'order_number' => 'BILL# 29021',
            'type' => 'takeaway',
            'status' => 'completed',
            'subtotal' => 4220,
            'total' => 4220,
            'payment_status' => 'paid',
        ]);

        $category = \App\Models\MenuCategory::create([
            'name' => 'Fast Food',
            'slug' => 'fast-food',
        ]);

        $item = MenuItem::create([
            'category_id' => $category->id,
            'name' => 'Chicken Fajita Pizza L',
            'price' => 1350,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'menu_item_id' => $item->id,
            'quantity' => 1,
            'unit_price' => 1350,
            'total_price' => 1350,
        ]);

        $rendered = view('receipts.thermal-receipt', [
            'order' => $order,
            'cashierName' => 'admin',
            'type' => 'bill',
        ])->render();

        $this->assertStringContainsString('logo_circular.png', $rendered);
        $this->assertStringContainsString('NEAR AL-REHMAN GARDEN AKBAR', $rendered);
        $this->assertStringContainsString('ROAD OKARA', $rendered);
        $this->assertStringContainsString('0311-8484987 : 0339-8484987', $rendered);
        $this->assertStringContainsString('Chicken Fajita Pizza L', $rendered);
        $this->assertStringContainsString('SUB TOTAL', $rendered);
        $this->assertStringContainsString('TOTAL CHARGE', $rendered);
        $this->assertStringContainsString('Software designed and developed by: MNS Technologies and consultant', $rendered);
        $this->assertStringContainsString('0347-6824180', $rendered);
    }

    public function test_welcome_page_contains_permanent_footer_copyright(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Software designed and developed by');
        $response->assertSee('MNS Technologies and consultant');
        $response->assertSee('0347-6824180');
        $response->assertSee('logo_circular.png');
    }

    public function test_it_renders_waiter_cashier_and_rider_names_on_receipt(): void
    {
        $waiter = User::factory()->create(['name' => 'Waiter Waqas', 'role' => 'waiter']);
        $cashier = User::factory()->create(['name' => 'Cashier Asif', 'role' => 'cashier']);

        // 1. Order taken by Waiter
        $waiterOrder = Order::create([
            'order_number' => 'BILL# 1001',
            'type' => 'dine_in',
            'table_number' => 'T-01',
            'waiter_id' => $waiter->id,
            'status' => 'preparing',
            'subtotal' => 1500,
            'total' => 1500,
            'payment_status' => 'pending',
        ]);

        $waiterReceipt = view('receipts.thermal-receipt', [
            'order' => $waiterOrder,
            'type' => 'bill',
        ])->render();

        $this->assertStringContainsString('Waiter: Waiter Waqas', $waiterReceipt);

        // 2. Order taken by Cashier
        $cashierOrder = Order::create([
            'order_number' => 'BILL# 1002',
            'type' => 'takeaway',
            'user_id' => $cashier->id,
            'status' => 'completed',
            'subtotal' => 800,
            'total' => 800,
            'payment_status' => 'paid',
        ]);

        $cashierReceipt = view('receipts.thermal-receipt', [
            'order' => $cashierOrder,
            'type' => 'bill',
        ])->render();

        $this->assertStringContainsString('Cashier: Cashier Asif', $cashierReceipt);

        // 3. Delivery Order with Rider
        $deliveryOrder = Order::create([
            'order_number' => 'BILL# 1003',
            'type' => 'delivery',
            'user_id' => $cashier->id,
            'rider_name' => 'Rider Zubair',
            'customer_name' => 'Tariq Mehmood',
            'customer_address' => 'House 12, Street 4, Okara',
            'status' => 'preparing',
            'subtotal' => 2200,
            'total' => 2200,
            'payment_status' => 'pending',
        ]);

        $deliveryReceipt = view('receipts.thermal-receipt', [
            'order' => $deliveryOrder,
            'type' => 'bill',
        ])->render();

        $this->assertStringContainsString('Rider: Rider Zubair', $deliveryReceipt);
        $this->assertStringContainsString('Tariq Mehmood', $deliveryReceipt);
    }
}
