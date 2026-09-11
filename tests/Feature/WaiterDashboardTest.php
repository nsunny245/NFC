<?php

namespace Tests\Feature;

use App\Filament\Waiter\Pages\WaiterDashboard;
use App\Models\InternalNotification;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class WaiterDashboardTest extends TestCase
{
    use RefreshDatabase;

    private $waiter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->waiter = User::factory()->create(['role' => 'waiter']);
    }

    /** @test */
    public function it_can_render_the_waiter_dashboard_page()
    {
        $this->actingAs($this->waiter, 'waiter')
            ->get('/waiter')
            ->assertStatus(200);
    }

    /** @test */
    public function it_can_fetch_and_dismiss_serving_notifications()
    {
        // 1. Create a ready to serve notification
        $notif = InternalNotification::create([
            'type' => 'ready_to_serve',
            'title' => '🍳 Order Ready to Serve!',
            'message' => "Order #123 is ready.",
            'notifiable_role' => 'waiter',
            'related_id' => 999,
        ]);

        // 2. Test waiter fetches and serves the notification
        Livewire::actingAs($this->waiter)
            ->test(WaiterDashboard::class)
            ->assertCount('servingNotifications', 1)
            ->call('dismissServingNotification', $notif->id)
            ->assertCount('servingNotifications', 0);

        // Assert notification marked as read
        $this->assertTrue($notif->refresh()->is_read);
    }

    /** @test */
    public function it_can_select_a_table_and_add_dishes_and_dispatch_kot_to_kitchen()
    {
        $category = \App\Models\MenuCategory::create([
            'name' => 'Pizza',
            'slug' => 'pizza',
        ]);

        $item = \App\Models\MenuItem::create([
            'category_id' => $category->id,
            'name' => 'Chicken Supreme Pizza',
            'description' => 'Delicious pizza with rich toppings',
            'price' => 1300,
            'is_available' => true,
        ]);

        Livewire::actingAs($this->waiter)
            ->test(WaiterDashboard::class)
            // 1. Select Table T-01
            ->call('selectTableForFeast', 'T-01')
            ->assertSet('selectedTable', 'T-01')
            // 2. Add item to cart
            ->call('addToCart', $item->id)
            ->assertCount('cart', 1)
            // 3. Update quantity
            ->call('updateQuantity', $item->id, 2)
            ->assertSet('cart.' . $item->id . '.quantity', 2)
            // 4. Update kitchen note and optional guest details
            ->call('updateItemComment', $item->id, 'Extra crispy crust')
            ->set('specialNotes', 'Deliver fresh and hot')
            ->set('customerName', 'Sheikh Hammad')
            ->set('customerPhone', '03001234567')
            // 5. Send order to kitchen
            ->call('sendToKitchen')
            ->assertSet('selectedTable', null)
            ->assertCount('cart', 0);

        // Verify Order is created in Database with status preparing
        $this->assertDatabaseHas('orders', [
            'table_number' => 'T-01',
            'type' => 'dine_in',
            'status' => 'preparing',
            'customer_name' => 'Sheikh Hammad',
            'customer_phone' => '03001234567',
            'special_notes' => 'Deliver fresh and hot',
        ]);

        $this->assertDatabaseHas('order_items', [
            'menu_item_id' => $item->id,
            'quantity' => 2,
            'notes' => 'Extra crispy crust',
        ]);
    }

    /** @test */
    public function it_can_filter_items_by_category_and_search()
    {
        $category1 = \App\Models\MenuCategory::create(['name' => 'Burgers', 'slug' => 'burgers']);
        $category2 = \App\Models\MenuCategory::create(['name' => 'Pizzas', 'slug' => 'pizzas']);

        $burger = \App\Models\MenuItem::create([
            'category_id' => $category1->id,
            'name' => 'Zinger Burger',
            'price' => 370,
            'is_available' => true,
        ]);

        $pizza = \App\Models\MenuItem::create([
            'category_id' => $category2->id,
            'name' => 'Crown Crust Pizza',
            'price' => 1500,
            'is_available' => true,
        ]);

        Livewire::actingAs($this->waiter)
            ->test(WaiterDashboard::class)
            ->call('selectTableForFeast', 'T-02')
            ->call('selectCategory', $category1->id)
            ->assertSet('selectedCategoryId', $category1->id)
            ->set('search', 'Zinger')
            ->assertSet('search', 'Zinger');
    }

    /** @test */
    public function it_can_switch_sections_and_toggle_quick_kitchen_notes()
    {
        Livewire::actingAs($this->waiter)
            ->test(WaiterDashboard::class)
            ->assertSet('activeSection', 'all')
            ->call('setSection', 'family_hall')
            ->assertSet('activeSection', 'family_hall')
            ->call('selectTableForFeast', 'F-01')
            ->call('toggleQuickNote', '🌶️ Mild Spice')
            ->assertSet('specialNotes', '🌶️ Mild Spice')
            ->call('toggleQuickNote', '⏱️ Urgent / Jaldi')
            ->assertSet('specialNotes', '🌶️ Mild Spice, ⏱️ Urgent / Jaldi')
            ->call('toggleQuickNote', '🌶️ Mild Spice')
            ->assertSet('specialNotes', '⏱️ Urgent / Jaldi');
    }

    /** @test */
    public function it_supports_mobile_app_navigation_and_cart_drawer()
    {
        Livewire::actingAs($this->waiter)
            ->test(WaiterDashboard::class)
            ->assertSet('currentTab', 'tables')
            ->call('setTab', 'alerts')
            ->assertSet('currentTab', 'alerts')
            ->call('setTab', 'shift')
            ->assertSet('currentTab', 'shift')
            ->assertSet('cartDrawerOpen', false)
            ->call('openCartDrawer')
            ->assertSet('cartDrawerOpen', true)
            ->call('closeCartDrawer')
            ->assertSet('cartDrawerOpen', false)
            ->call('toggleCartDrawer')
            ->assertSet('cartDrawerOpen', true);
    }

    /** @test */
    public function it_supports_category_selection_modal()
    {
        $cat = \App\Models\MenuCategory::create(['name' => 'Burgers', 'slug' => 'burgers-test']);

        Livewire::actingAs($this->waiter)
            ->test(WaiterDashboard::class)
            ->assertSet('categoryModalOpen', false)
            ->call('openCategoryModal')
            ->assertSet('categoryModalOpen', true)
            ->call('selectCategory', $cat->id)
            ->assertSet('categoryModalOpen', false)
            ->assertSet('selectedCategoryId', $cat->id)
            ->call('openCategoryModal')
            ->call('closeCategoryModal')
            ->assertSet('categoryModalOpen', false);
    }

    /** @test */
    public function it_can_select_portions_and_adjust_quantities()
    {
        $category = \App\Models\MenuCategory::create(['name' => 'Karahi', 'slug' => 'karahi']);
        $item = \App\Models\MenuItem::create([
            'category_id' => $category->id,
            'name' => 'Mutton Karahi',
            'price' => 1400,
            'is_available' => true,
            'details' => [
                'sizes' => [
                    'half' => 1400,
                    'full' => 2600,
                ],
            ],
        ]);

        $cartKey = $item->id . '_full';

        Livewire::actingAs($this->waiter)
            ->test(WaiterDashboard::class)
            ->call('selectTableForFeast', 'T-03')
            ->assertSet('portionSelectionModalOpen', false)
            ->call('openPortionModal', $item->id)
            ->assertSet('portionSelectionModalOpen', true)
            ->assertSet('portionModalItemId', $item->id)
            ->call('addToCart', $item->id, 'full')
            ->assertSet("cart.{$cartKey}.name", 'Mutton Karahi (Full)')
            ->assertSet("cart.{$cartKey}.size_key", 'full')
            ->assertSet("cart.{$cartKey}.size_label", 'Full')
            ->assertSet("cart.{$cartKey}.price", 2600.0)
            ->assertSet("cart.{$cartKey}.quantity", 1)
            ->call('updateQuantity', $cartKey, 3)
            ->assertSet("cart.{$cartKey}.quantity", 3)
            ->call('closePortionModal')
            ->assertSet('portionSelectionModalOpen', false);
    }

    /** @test */
    public function it_can_hold_table_order_as_draft_and_reload_it()
    {
        $category = \App\Models\MenuCategory::create(['name' => 'BBQ', 'slug' => 'bbq']);
        $item = \App\Models\MenuItem::create([
            'category_id' => $category->id,
            'name' => 'Chicken Tikka',
            'price' => 450,
            'is_available' => true,
        ]);

        Livewire::actingAs($this->waiter)
            ->test(WaiterDashboard::class)
            ->call('selectTableForFeast', 'T-05')
            ->call('addToCart', $item->id)
            ->call('updateQuantity', $item->id, 2)
            ->set('specialNotes', 'Hold for guest arrival')
            ->call('holdOrder')
            ->assertSet('selectedTable', null)
            ->assertCount('cart', 0);

        // Verify order saved as pending in database
        $this->assertDatabaseHas('orders', [
            'table_number' => 'T-05',
            'type' => 'dine_in',
            'status' => 'pending',
            'special_notes' => 'Hold for guest arrival',
        ]);

        // Re-selecting T-05 should reload the draft order back into the cart
        Livewire::actingAs($this->waiter)
            ->test(WaiterDashboard::class)
            ->call('selectTableForFeast', 'T-05')
            ->assertSet('selectedTable', 'T-05')
            ->assertCount('cart', 1)
            ->assertSet("cart.{$item->id}.quantity", 2);
    }

    /** @test */
    public function it_can_request_bill_settlement_for_active_dining_table()
    {
        $order = Order::create([
            'order_number' => 'ND-POS-WTR1',
            'type' => 'dine_in',
            'table_number' => 'T-02',
            'waiter_id' => $this->waiter->id,
            'status' => 'ready',
            'total' => 1800,
            'subtotal' => 1800,
        ]);

        Livewire::actingAs($this->waiter)
            ->test(WaiterDashboard::class)
            ->call('selectTableForFeast', 'T-02')
            ->assertSet('activeOrderId', $order->id)
            ->call('requestBillSettlement');

        $this->assertTrue($order->refresh()->bill_requested);
        $this->assertNotNull($order->refresh()->bill_requested_at);

        $notif = \App\Models\InternalNotification::where('type', 'bill_requested')
            ->where('related_id', $order->id)
            ->first();
        $this->assertNotNull($notif);
        $this->assertEquals('cashier', $notif->notifiable_role);
        $this->assertStringContainsString('T-02', $notif->title);
    }
}
