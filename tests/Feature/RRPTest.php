<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\InventoryItem;
use App\Models\MenuItem;
use App\Models\MenuCategory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\RecipeItem;
use App\Models\Expense;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RRPTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_enforces_panel_access_controls_based_on_roles()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $cashier = User::factory()->create(['role' => 'cashier']);
        $waiter = User::factory()->create(['role' => 'waiter']);

        // 1. Admin Panel Routing Checks
        $this->actingAs($admin, 'admin')->get('/admin')->assertStatus(200);
        $this->flushSession();
        $this->assertTrue(in_array($this->actingAs($cashier, 'admin')->get('/admin')->status(), [302, 403]));
        $this->flushSession();
        $this->assertTrue(in_array($this->actingAs($waiter, 'admin')->get('/admin')->status(), [302, 403]));
        $this->flushSession();

        // 2. Cashier POS Panel Routing Checks
        $this->actingAs($admin, 'pos')->get('/pos')->assertStatus(200);
        $this->flushSession();
        $this->actingAs($cashier, 'pos')->get('/pos')->assertStatus(200);
        $this->flushSession();
        $this->assertTrue(in_array($this->actingAs($waiter, 'pos')->get('/pos')->status(), [302, 403]));
        $this->flushSession();

        // 3. Waiter Panel Routing Checks
        $this->actingAs($admin, 'waiter')->get('/waiter')->assertStatus(200);
        $this->flushSession();
        $this->assertTrue(in_array($this->actingAs($cashier, 'waiter')->get('/waiter')->status(), [302, 403]));
        $this->flushSession();
        $this->actingAs($waiter, 'waiter')->get('/waiter')->assertStatus(200);
    }

    /** @test */
    public function it_depletes_inventory_stocks_automatically_upon_order_completion()
    {
        // 1. Setup raw ingredient
        $mutton = InventoryItem::create([
            'name' => 'Mutton Raw',
            'sku' => 'INV-MUT-TST',
            'category' => 'meats',
            'quantity' => 100.00,
            'unit' => 'kg',
            'minimum_qty' => 10.00,
            'unit_cost' => 1800.00,
        ]);

        // 2. Setup category and menu item
        $category = MenuCategory::create(['name' => 'Traditional Karahi', 'slug' => 'traditional-karahi']);
        $karahi = MenuItem::create([
            'category_id' => $category->id,
            'name' => 'Mutton Karahi Half',
            'price' => 2400.00,
            'is_available' => true,
            'is_hero_item' => false,
        ]);

        // 3. Map Recipe: 1 Karahi Half requires 0.5kg mutton
        RecipeItem::create([
            'menu_item_id' => $karahi->id,
            'inventory_item_id' => $mutton->id,
            'required_quantity' => 0.50,
        ]);

        // 4. Create an order with 2x Mutton Karahi (should deplete 1.0kg)
        $order = Order::create([
            'order_number' => 'ND-TST-9901',
            'subtotal' => 4800.00,
            'tax' => 768.00,
            'total' => 5568.00,
            'status' => 'pending', // Starts pending
            'type' => 'dine_in',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'menu_item_id' => $karahi->id,
            'quantity' => 2,
            'unit_price' => 2400.00,
            'total_price' => 4800.00,
        ]);

        // Verify stock is still 100 before completion
        $this->assertEquals(100.00, $mutton->fresh()->quantity);

        // 5. Complete the order (marks paid, triggers observer stock depletion)
        $order->update(['status' => 'completed']);

        // Verify stock is now 99.00 (100 - (0.5 * 2))
        $this->assertEquals(99.00, $mutton->fresh()->quantity);
    }
}
