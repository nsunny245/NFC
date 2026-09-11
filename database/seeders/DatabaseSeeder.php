<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\InventoryItem;
use App\Models\StaffMember;
use App\Models\Equipment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users with explicit roles
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@nawabidera.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $cashierUser = User::factory()->create([
            'name' => 'Cashier Nabeel',
            'email' => 'cashier@nawabidera.com',
            'password' => bcrypt('password123'),
            'role' => 'cashier',
        ]);

        $waiterUser = User::factory()->create([
            'name' => 'Waiter Waqas',
            'email' => 'waiter@nawabidera.com',
            'password' => bcrypt('password123'),
            'role' => 'waiter',
        ]);

        // 2. Call Menu Seeder
        $this->call([
            MenuSeeder::class,
        ]);

        // 3. Seed Staff Members
        StaffMember::create([
            'user_id' => $cashierUser->id,
            'full_name' => 'Nabeel Ahmed',
            'phone' => '0312-3456789',
            'email' => 'cashier@nawabidera.com',
            'role_designation' => 'cashier',
            'salary' => 35000.00,
            'hire_date' => '2026-01-15',
            'status' => 'active',
        ]);

        StaffMember::create([
            'user_id' => $waiterUser->id,
            'full_name' => 'Waqas Khan',
            'phone' => '0313-9876543',
            'email' => 'waiter@nawabidera.com',
            'role_designation' => 'waiter',
            'salary' => 20000.00,
            'hire_date' => '2026-02-10',
            'status' => 'active',
        ]);

        StaffMember::create([
            'user_id' => null,
            'full_name' => 'Chef Kamran',
            'phone' => '0321-4567123',
            'email' => 'kamran@nawabidera.com',
            'role_designation' => 'chef',
            'salary' => 75000.00,
            'hire_date' => '2025-11-01',
            'status' => 'active',
        ]);

        StaffMember::create([
            'user_id' => null,
            'full_name' => 'Rider Zubair',
            'phone' => '0344-9988776',
            'email' => 'zubair@nawabidera.com',
            'role_designation' => 'rider',
            'salary' => 25000.00,
            'hire_date' => '2026-03-01',
            'status' => 'active',
        ]);

        // 4. Seed Inventory Items
        InventoryItem::create([
            'name' => 'Royal Mutton Leg',
            'sku' => 'INV-MUT-001',
            'category' => 'meats',
            'quantity' => 45.50,
            'unit' => 'kg',
            'minimum_qty' => 15.00,
            'unit_cost' => 1800.00,
            'supplier_name' => 'Lahore Halal Meat Co.',
            'last_restocked_at' => now(),
        ]);

        InventoryItem::create([
            'name' => 'Premium Desi Chicken',
            'sku' => 'INV-CHK-002',
            'category' => 'meats',
            'quantity' => 12.00, // Close to minimum threshold for triggering alert
            'unit' => 'kg',
            'minimum_qty' => 10.00,
            'unit_cost' => 650.00,
            'supplier_name' => 'Okara Poultry Hub',
            'last_restocked_at' => now(),
        ]);

        InventoryItem::create([
            'name' => 'Fine Basmati Rice',
            'sku' => 'INV-RIC-003',
            'category' => 'dry_goods',
            'quantity' => 150.00,
            'unit' => 'kg',
            'minimum_qty' => 50.00,
            'unit_cost' => 320.00,
            'supplier_name' => 'Punjab Grain Distributors',
            'last_restocked_at' => now(),
        ]);

        InventoryItem::create([
            'name' => 'Special Spice Blends',
            'sku' => 'INV-SPI-004',
            'category' => 'dry_goods',
            'quantity' => 8.50, // Under the threshold! Alert should trigger
            'unit' => 'kg',
            'minimum_qty' => 12.00,
            'unit_cost' => 1200.00,
            'supplier_name' => 'Khyber Spice Bazaar',
            'last_restocked_at' => now(),
        ]);

        InventoryItem::create([
            'name' => 'Packaging Boxes Large',
            'sku' => 'INV-PKG-005',
            'category' => 'packaging',
            'quantity' => 200.00,
            'unit' => 'piece',
            'minimum_qty' => 50.00,
            'unit_cost' => 45.00,
            'supplier_name' => 'Royal Packs Ltd.',
            'last_restocked_at' => now(),
        ]);

        // 5. Seed Equipments
        Equipment::create([
            'name' => 'Industrial Mutton Stove Rig',
            'category' => 'kitchen_appliances',
            'serial_number' => 'STV-99201-ND',
            'purchase_date' => '2025-10-15',
            'purchase_cost' => 120000.00,
            'functional_status' => 'operational',
            'last_maintenance_date' => '2026-04-10',
            'next_maintenance_date' => '2026-07-10',
            'notes' => 'Rigged for high-pressure flame necessary for Mutton Karahi wok firing.',
        ]);

        Equipment::create([
            'name' => 'Commercial Deep Freezer Double-Door',
            'category' => 'kitchen_appliances',
            'serial_number' => 'FRZ-7731-DF',
            'purchase_date' => '2025-09-01',
            'purchase_cost' => 165000.00,
            'functional_status' => 'operational',
            'last_maintenance_date' => '2026-03-15',
            'next_maintenance_date' => '2026-06-15',
            'notes' => 'Ensure temperature is set strictly at -18C for meat preserving.',
        ]);

        Equipment::create([
            'name' => 'Central Air Conditioner 4-Ton Cabinet',
            'category' => 'cooling_heating',
            'serial_number' => 'AC-4829-GREE',
            'purchase_date' => '2025-05-10',
            'purchase_cost' => 240000.00,
            'functional_status' => 'under_maintenance', // Alerts cashier/admin
            'last_maintenance_date' => '2026-05-20',
            'next_maintenance_date' => '2026-06-20',
            'notes' => 'Compressor service in progress by AC mechanic.',
        ]);

        Equipment::create([
            'name' => 'Thermal Cashier POS Printer (Epson)',
            'category' => 'pos_it',
            'serial_number' => 'PRN-88210-EPS',
            'purchase_date' => '2026-01-20',
            'purchase_cost' => 38000.00,
            'functional_status' => 'operational',
            'last_maintenance_date' => '2026-01-20',
            'next_maintenance_date' => '2026-07-20',
            'notes' => 'Uses 80mm standard paper rolls.',
        ]);
    }
}
