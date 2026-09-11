<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Order;
use App\Models\InventoryItem;
use App\Models\Expense;
use App\Models\Equipment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_render_the_admin_reports_hub_page()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin, 'admin')->get('/admin/restaurant-reports');
        $this->assertTrue(in_array($response->status(), [200, 302]));
    }

    /** @test */
    public function it_can_export_sales_report_csv()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        Order::create([
            'order_number' => 'ND-TST-9901',
            'type' => 'dine_in',
            'status' => 'completed',
            'subtotal' => 1500,
            'tax' => 240,
            'total' => 1740,
            'payment_status' => 'paid',
            'payment_method' => 'cash',
        ]);

        $response = $this->actingAs($admin, 'admin')->get('/admin/reports/export/sales?range=all');
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');
    }

    /** @test */
    public function it_can_export_inventory_report_json()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        InventoryItem::create([
            'name' => 'Kainat Basmati Rice',
            'sku' => 'SKU-RPT-01',
            'category' => 'dry_goods',
            'quantity' => 100,
            'unit' => 'kg',
            'minimum_qty' => 20,
            'unit_cost' => 300,
        ]);

        $response = $this->actingAs($admin, 'admin')->get('/admin/reports/json/inventory?range=all');
        $response->assertStatus(200);
        $response->assertJsonPath('meta.report_type', 'inventory');
    }

    /** @test */
    public function it_can_render_printable_equipment_report()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        Equipment::create([
            'name' => 'Sajji Counter',
            'quantity' => 1,
            'category' => 'kitchen_appliances',
            'serial_number' => 'ND-EQ-001',
            'functional_status' => 'operational',
            'purchase_cost' => 50000,
        ]);

        $response = $this->actingAs($admin, 'admin')->get('/admin/reports/print/equipment?range=all');
        $response->assertStatus(200);
        $response->assertSee('Restaurant Master Equipment & Asset Audit');
        $response->assertSee('Sajji Counter');
    }
}
