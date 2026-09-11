<?php

namespace Tests\Feature;

use App\Filament\Pos\Pages\POSDashboard;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class POSDashboardTest extends TestCase
{
    use RefreshDatabase;

    private $cashier;
    private $category;
    private $menuItem;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cashier = User::factory()->create(['role' => 'cashier']);
        
        \App\Models\PosSetting::set('vat_enabled', '1');
        \App\Models\PosSetting::set('vat_percentage', '16.00');

        $this->category = MenuCategory::create([
            'name' => 'Pizza',
            'slug' => 'pizza',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $this->menuItem = MenuItem::create([
            'category_id' => $this->category->id,
            'name' => 'Royal Tikka Pizza',
            'price' => 1350,
            'is_available' => true,
            'details' => [
                'sizes' => [
                    'large' => ['label' => 'Large', 'price' => 1350],
                    'medium' => ['label' => 'Medium', 'price' => 950],
                ]
            ]
        ]);
    }

    /** @test */
    public function it_can_render_the_pos_dashboard_for_authorized_cashier()
    {
        $this->actingAs($this->cashier, 'pos')
            ->get('/pos')
            ->assertStatus(200);
    }

    /** @test */
    public function it_handles_order_type_setup_and_navigation()
    {
        Livewire::actingAs($this->cashier)
            ->test(POSDashboard::class)
            ->assertSet('posScreen', 'menu')
            ->call('selectOrderSetupType', 'takeaway')
            ->assertSet('orderType', 'takeaway');
    }

    /** @test */
    public function it_can_select_categories_for_filtering()
    {
        Livewire::actingAs($this->cashier)
            ->test(POSDashboard::class)
            ->assertSet('selectedCategoryId', null)
            ->call('selectCategory', $this->category->id)
            ->assertSet('selectedCategoryId', $this->category->id)
            ->call('selectCategory', null)
            ->assertSet('selectedCategoryId', null);
    }

    /** @test */
    public function it_can_add_items_to_cart_with_and_without_sizes()
    {
        // Add without size
        Livewire::actingAs($this->cashier)
            ->test(POSDashboard::class)
            ->call('addToCart', $this->menuItem->id)
            ->assertCount('cart', 1)
            ->assertSet('subtotal', 1350);

        // Add with size
        Livewire::actingAs($this->cashier)
            ->test(POSDashboard::class)
            ->call('addToCart', $this->menuItem->id, 'medium')
            ->assertCount('cart', 1)
            ->assertSet('subtotal', 950);
    }

    /** @test */
    public function it_can_trigger_portion_size_selection_modal()
    {
        Livewire::actingAs($this->cashier)
            ->test(POSDashboard::class)
            ->assertSet('portionSelectionModalOpen', false)
            ->call('openPortionModal', $this->menuItem->id)
            ->assertSet('portionSelectionModalOpen', true)
            ->assertSet('portionModalItemId', $this->menuItem->id)
            ->call('addToCart', $this->menuItem->id, 'medium')
            ->assertSet('portionSelectionModalOpen', false)
            ->assertCount('cart', 1)
            ->assertSet('subtotal', 950);
    }

    /** @test */
    public function it_can_update_quantities_and_remove_from_cart()
    {
        Livewire::actingAs($this->cashier)
            ->test(POSDashboard::class)
            ->call('addToCart', $this->menuItem->id)
            ->call('updateQuantity', $this->menuItem->id, 3)
            ->assertSet('cart.' . $this->menuItem->id . '.quantity', 3)
            ->assertSet('subtotal', 4050)
            ->call('removeFromCart', $this->menuItem->id)
            ->assertCount('cart', 0);
    }

    /** @test */
    public function it_can_proceed_to_payment_and_finalize_checkout()
    {
        Livewire::actingAs($this->cashier)
            ->test(POSDashboard::class)
            ->set('orderType', 'takeaway')
            ->call('addToCart', $this->menuItem->id)
            ->call('proceedToPayment')
            ->assertSet('isPaymentModalOpen', true)
            ->call('selectPaymentMode', 'cash')
            ->set('cashReceived', 2000)
            ->call('recalculateChange')
            ->assertSet('changeAmount', 434) // 1350 + (1350 * 0.16) [tax] = 1566. 2000 - 1566 = 434
            ->call('confirmPayment')
            ->assertSet('isPaymentModalOpen', false)
            ->assertSet('isReceiptModalOpen', true);
    }

    /** @test */
    public function it_can_dispatch_kot_and_handle_kot_corrections()
    {
        Livewire::actingAs($this->cashier)
            ->test(POSDashboard::class)
            ->set('orderType', 'takeaway')
            ->call('addToCart', $this->menuItem->id)
            ->call('placeOrder')
            ->assertSet('receiptType', 'kot') // resetPOSCart does not reset receiptType, so it stays kot
            ->assertSet('isReceiptModalOpen', true);

        // Dispatched order enters cooking queue with status preparing
        $order = Order::latest('id')->first();
        $this->assertEquals('preparing', $order->status);
        $this->assertEquals('takeaway', $order->type);
    }

    /** @test */
    public function it_dispatches_kot_for_dine_in_and_delivery_and_clears_cart()
    {
        // 1. Dine-In KOT dispatch
        Livewire::actingAs($this->cashier)
            ->test(POSDashboard::class)
            ->set('orderType', 'dine_in')
            ->set('selectedTable', 'T5')
            ->call('addToCart', $this->menuItem->id)
            ->call('placeOrder')
            ->assertSet('cart', [])
            ->assertSet('activeOrderId', null);

        $dineOrder = Order::latest('id')->first();
        $this->assertEquals('preparing', $dineOrder->status);
        $this->assertEquals('dine_in', $dineOrder->type);
        $this->assertEquals('T5', $dineOrder->table_number);

        // 2. Delivery KOT dispatch
        Livewire::actingAs($this->cashier)
            ->test(POSDashboard::class)
            ->set('orderType', 'delivery')
            ->set('customerPhone', '03001234567')
            ->set('customerAddress', 'House 12, Street 4, Okara')
            ->call('addToCart', $this->menuItem->id)
            ->call('placeOrder')
            ->assertSet('cart', [])
            ->assertSet('activeOrderId', null);

        $deliveryOrder = Order::latest('id')->first();
        $this->assertEquals('preparing', $deliveryOrder->status);
        $this->assertEquals('delivery', $deliveryOrder->type);
        $this->assertEquals('House 12, Street 4, Okara', $deliveryOrder->customer_address);
    }

    /** @test */
    public function it_can_load_ongoing_orders_and_tables()
    {
        // Create a pending order
        $order = Order::create([
            'user_id' => $this->cashier->id,
            'order_number' => 'ND-POS-TEST',
            'subtotal' => 1350,
            'tax' => 216,
            'total' => 1566,
            'status' => 'pending',
            'type' => 'dine_in',
            'table_number' => 'T1',
            'payment_status' => 'pending',
        ]);

        Livewire::actingAs($this->cashier)
            ->test(POSDashboard::class)
            ->call('loadOngoingOrder', $order->id)
            ->assertSet('activeOrderId', $order->id)
            ->assertSet('posScreen', 'menu');
    }

    /** @test */
    public function it_can_reset_pos_cart()
    {
        Livewire::actingAs($this->cashier)
            ->test(POSDashboard::class)
            ->call('addToCart', $this->menuItem->id)
            ->call('resetPOSCart')
            ->assertCount('cart', 0)
            ->assertSet('posScreen', 'menu');
    }

    /** @test */
    public function it_can_manage_internal_notifications_and_ready_status()
    {
        // 1. Create a dummy pending order
        $order = Order::create([
            'user_id' => $this->cashier->id,
            'order_number' => 'ND-NOTIF-TEST',
            'subtotal' => 1000,
            'tax' => 160,
            'total' => 1160,
            'status' => 'pending',
            'type' => 'dine_in',
            'table_number' => 'T2',
            'payment_status' => 'pending',
        ]);

        // Create an online order notification
        $notif = \App\Models\InternalNotification::create([
            'type' => 'online_order',
            'title' => '🚨 New Online Order #' . $order->order_number,
            'message' => "Placed online.",
            'notifiable_role' => 'all',
            'related_id' => $order->id,
        ]);

        // 2. Test send KOT from notification
        Livewire::actingAs($this->cashier)
            ->test(POSDashboard::class)
            ->call('sendKitchenKOT', $notif->id, $order->id)
            ->assertSet('notificationsOpen', false);

        // Assert order updated to preparing, and notification marked as read
        $this->assertEquals('preparing', $order->refresh()->status);
        $this->assertTrue($notif->refresh()->is_read);

        // 3. Test Ready to Serve transition
        Livewire::actingAs($this->cashier)
            ->test(POSDashboard::class)
            ->call('updateOrderStatusToReady', $order->id);

        // Assert order status is ready
        $this->assertEquals('ready', $order->refresh()->status);

        // Assert new notification created for waiters
        $waiterNotif = \App\Models\InternalNotification::where('type', 'ready_to_serve')
            ->where('related_id', $order->id)
            ->first();

        $this->assertNotNull($waiterNotif);
        $this->assertEquals('waiter', $waiterNotif->notifiable_role);
    }

    /** @test */
    public function it_auto_closes_table_popup_when_starting_dine_in_order_and_supports_delivery_rider()
    {
        // 1. Test auto-close table seating popup
        Livewire::actingAs($this->cashier)
            ->test(POSDashboard::class)
            ->set('seatingModalOpen', true)
            ->call('loadTableOrder', 'T1')
            ->assertSet('seatingModalOpen', false)
            ->assertSet('selectedTable', 'T1')
            ->assertSet('orderType', 'dine_in');

        // 2. Test delivery order with rider
        Livewire::actingAs($this->cashier)
            ->test(POSDashboard::class)
            ->set('orderType', 'delivery')
            ->set('customerPhone', '03449988776')
            ->set('customerAddress', 'Gulshan Colony, Okara')
            ->set('riderName', 'Rider Zubair')
            ->call('addToCart', $this->menuItem->id)
            ->call('placeOrder');

        $this->assertDatabaseHas('orders', [
            'type' => 'delivery',
            'status' => 'preparing',
            'customer_phone' => '03449988776',
            'customer_address' => 'Gulshan Colony, Okara',
            'rider_name' => 'Rider Zubair',
        ]);
    }

    /** @test */
    public function it_controls_kitchen_cooking_monitor_modal_and_closes_when_settling_order()
    {
        $order = Order::create([
            'order_number' => 'ND-POS-TEST1',
            'type' => 'dine_in',
            'table_number' => 'T5',
            'status' => 'ready',
            'total' => 1500,
            'subtotal' => 1500,
        ]);

        Livewire::actingAs($this->cashier)
            ->test(POSDashboard::class)
            ->call('openKitchenStatusModal')
            ->assertSet('kitchenStatusModalOpen', true)
            ->call('closeKitchenStatusModal')
            ->assertSet('kitchenStatusModalOpen', false)
            ->set('kitchenStatusModalOpen', true)
            ->call('loadOngoingOrder', $order->id)
            ->assertSet('kitchenStatusModalOpen', false)
            ->assertSet('activeOrderId', $order->id);
    }

    /** @test */
    public function it_dispatches_takeaway_and_delivery_ready_notifications_on_complete_cooking()
    {
        // 1. Takeaway Order
        $takeawayOrder = Order::create([
            'order_number' => 'ND-POS-TKWY1',
            'type' => 'takeaway',
            'customer_name' => 'Usman Ali',
            'status' => 'preparing',
            'total' => 800,
            'subtotal' => 800,
        ]);

        Livewire::actingAs($this->cashier)
            ->test(POSDashboard::class)
            ->call('completeCooking', $takeawayOrder->id);

        $this->assertEquals('ready', $takeawayOrder->refresh()->status);
        $takeawayNotif = \App\Models\InternalNotification::where('type', 'ready_for_pickup')
            ->where('related_id', $takeawayOrder->id)
            ->first();
        $this->assertNotNull($takeawayNotif);
        $this->assertEquals('cashier', $takeawayNotif->notifiable_role);
        $this->assertStringContainsString('Usman Ali', $takeawayNotif->message);

        // 2. Delivery Order
        $deliveryOrder = Order::create([
            'order_number' => 'ND-POS-DLV1',
            'type' => 'delivery',
            'customer_name' => 'Sara Khan',
            'rider_name' => 'Rider Hamza',
            'customer_address' => 'Mall Road',
            'status' => 'preparing',
            'total' => 2200,
            'subtotal' => 2200,
        ]);

        Livewire::actingAs($this->cashier)
            ->test(POSDashboard::class)
            ->call('completeCooking', $deliveryOrder->id);

        $this->assertEquals('ready', $deliveryOrder->refresh()->status);
        $deliveryNotif = \App\Models\InternalNotification::where('type', 'ready_for_delivery')
            ->where('related_id', $deliveryOrder->id)
            ->first();
        $this->assertNotNull($deliveryNotif);
        $this->assertEquals('cashier', $deliveryNotif->notifiable_role);
        $this->assertStringContainsString('Rider Hamza', $deliveryNotif->message);
    }

    /** @test */
    public function it_handles_serve_and_direct_settle_separately_and_omits_vip_option()
    {
        $waiterUser = User::factory()->create(['role' => 'waiter', 'name' => 'Waiter Haroon']);
        $order = Order::create([
            'order_number' => 'ND-POS-SRV1',
            'type' => 'dine_in',
            'table_number' => 'T3',
            'waiter_id' => $waiterUser->id,
            'status' => 'ready',
            'total' => 1200,
            'subtotal' => 1200,
        ]);

        \App\Models\OrderItem::create([
            'order_id' => $order->id,
            'menu_item_id' => $this->menuItem->id,
            'quantity' => 1,
            'unit_price' => 1200,
            'total_price' => 1200,
        ]);

        // 1. Test Cashier clicks SERVE (Notify Waiter)
        Livewire::actingAs($this->cashier)
            ->test(POSDashboard::class)
            ->call('notifyWaiterToServe', $order->id);

        $this->assertNotNull($order->refresh()->served_at);
        $serveNotif = \App\Models\InternalNotification::where('type', 'ready_to_serve')
            ->where('related_id', $order->id)
            ->first();
        $this->assertNotNull($serveNotif);
        $this->assertEquals('waiter', $serveNotif->notifiable_role);
        $this->assertStringContainsString('T3', $serveNotif->title);

        // 2. Test Cashier clicks Settle (Direct Settlement opens payment modal)
        Livewire::actingAs($this->cashier)
            ->test(POSDashboard::class)
            ->call('openDirectSettlement', $order->id)
            ->assertSet('isPaymentModalOpen', true)
            ->assertSet('activeOrderId', $order->id)
            ->assertDontSee('VIP / Treat');
    }

    /** @test */
    public function it_can_open_modal_and_record_expense_voucher_directly_from_pos_dashboard()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Cashier opens POS and records an operational utility expense (e.g. Okara Gas Cylinder replacement)
        Livewire::actingAs($this->cashier)
            ->test(POSDashboard::class)
            ->call('openExpenseModal')
            ->assertSet('isExpenseModalOpen', true)
            ->set('expenseCategory', 'utility')
            ->set('expenseAmount', 2500)
            ->set('expenseDate', now()->format('Y-m-d'))
            ->set('expenseRecipient', 'Okara Gas Agency')
            ->set('expenseInvoiceNumber', 'VCH-GAS-001')
            ->set('expenseDescription', 'Commercial LPG cylinder refill for tandoor station')
            ->call('saveExpense')
            ->assertSet('isExpenseModalOpen', false)
            ->assertHasNoErrors();

        // 1. Verify saved in database
        $this->assertDatabaseHas('expenses', [
            'category' => 'utility',
            'amount' => 2500,
            'recipient' => 'Okara Gas Agency',
            'invoice_number' => 'VCH-GAS-001',
        ]);

        $createdExpense = \App\Models\Expense::where('invoice_number', 'VCH-GAS-001')->first();
        $this->assertNotNull($createdExpense);
        $this->assertStringContainsString('Commercial LPG cylinder refill', $createdExpense->description);

        // 2. Verify visible in Admin Expenses Ledger
        $this->actingAs($admin, 'admin')
            ->get('/admin/expenses')
            ->assertStatus(200)
            ->assertSee('Okara Gas Agency');
    }

    /** @test */
    public function it_validates_required_fields_when_recording_pos_expense()
    {
        Livewire::actingAs($this->cashier)
            ->test(POSDashboard::class)
            ->call('openExpenseModal')
            ->set('expenseCategory', '')
            ->set('expenseAmount', '')
            ->set('expenseRecipient', '')
            ->call('saveExpense')
            ->assertHasErrors(['expenseCategory', 'expenseAmount', 'expenseRecipient'])
            ->assertSet('isExpenseModalOpen', true)
            // Raw stock inventory procurement is restricted to Admin panel
            ->set('expenseCategory', 'inventory_procurement')
            ->set('expenseAmount', 5000)
            ->set('expenseRecipient', 'Poultry Farm')
            ->call('saveExpense')
            ->assertHasErrors(['expenseCategory']);
    }

    /** @test */
    public function it_records_cash_received_and_change_returned_when_completing_an_order()
    {
        Livewire::actingAs($this->cashier)
            ->test(POSDashboard::class)
            ->set('orderType', 'takeaway')
            ->call('addToCart', $this->menuItem->id)
            ->call('proceedToPayment')
            ->call('selectPaymentMode', 'cash')
            ->set('cashReceived', 2000)
            ->call('recalculateChange')
            ->call('confirmPayment')
            ->assertSet('isPaymentModalOpen', false);

        $order = Order::latest('id')->first();
        $this->assertEquals('completed', $order->status);
        $this->assertEquals('cash', $order->payment_method);
        $this->assertEquals(2000.00, (float)$order->cash_received);
        $this->assertEquals(434.00, (float)$order->change_returned); // 2000 - 1566
    }

    /** @test */
    public function it_calculates_shift_closing_breakdown_with_change_and_payment_methods()
    {
        // 1. Cash Order with change given (Customer bill 880, tendered 1000, change returned 120)
        Order::create([
            'order_number' => 'ND-SHIFT-01',
            'subtotal' => 880,
            'tax' => 0,
            'total' => 880,
            'status' => 'completed',
            'payment_status' => 'paid',
            'payment_method' => 'cash',
            'cash_received' => 1000,
            'change_returned' => 120,
            'type' => 'dine_in',
            'created_at' => now(),
        ]);

        // 2. Bank Transfer Order
        Order::create([
            'order_number' => 'ND-SHIFT-02',
            'subtotal' => 2500,
            'tax' => 0,
            'total' => 2500,
            'status' => 'completed',
            'payment_status' => 'paid',
            'payment_method' => 'bank',
            'type' => 'dine_in',
            'created_at' => now(),
        ]);

        // 3. JazzCash Order
        Order::create([
            'order_number' => 'ND-SHIFT-03',
            'subtotal' => 1200,
            'tax' => 0,
            'total' => 1200,
            'status' => 'completed',
            'payment_status' => 'paid',
            'payment_method' => 'jazzcash',
            'type' => 'takeaway',
            'created_at' => now(),
        ]);

        // 4. Card Order
        Order::create([
            'order_number' => 'ND-SHIFT-04',
            'subtotal' => 3000,
            'tax' => 0,
            'total' => 3000,
            'status' => 'completed',
            'payment_status' => 'paid',
            'payment_method' => 'card',
            'type' => 'dine_in',
            'created_at' => now(),
        ]);

        // 5. Shift operational expense paid out of drawer
        \App\Models\Expense::create([
            'category' => 'utility',
            'amount' => 500,
            'expense_date' => now()->toDateString(),
            'recipient' => 'Ice Factory Okara',
            'description' => '[POS Drawer Cash Out] Ice blocks for beverage chiller',
        ]);

        // Test shift closing calculations
        Livewire::actingAs($this->cashier)
            ->test(POSDashboard::class)
            ->set('openingCash', 10000)
            ->call('openCloseShiftModal')
            ->assertSet('isShiftModalOpen', true)
            ->assertSet('shiftTotalSales', 7580.00) // 880 + 2500 + 1200 + 3000
            ->assertSet('shiftCashSales', 880.00)
            ->assertSet('shiftTenderedCash', 1000.00)
            ->assertSet('shiftChangeReturned', 120.00)
            ->assertSet('shiftBankSales', 2500.00)
            ->assertSet('shiftJazzCashSales', 1200.00)
            ->assertSet('shiftCardSales', 3000.00)
            ->assertSet('shiftExpensesTotal', 500.00)
            ->assertSet('expectedCash', 10380.00) // 10000 (float) + 880 (cash sales) - 500 (expenses)
            ->call('printShiftClosingReport')
            ->assertSet('isShiftPrintModalOpen', true);
    }
}