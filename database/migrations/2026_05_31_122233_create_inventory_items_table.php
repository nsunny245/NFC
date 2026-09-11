<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->unique();
            $table->string('category'); // 'meats', 'dry_goods', 'dairy', 'vegetables', 'beverages', 'packaging', 'other'
            $table->decimal('quantity', 10, 2)->default(0);
            $table->string('unit'); // 'kg', 'g', 'liter', 'piece', 'box'
            $table->decimal('minimum_qty', 10, 2)->default(10.00); // Low-stock threshold
            $table->decimal('unit_cost', 10, 2)->default(0.00); // Cost per unit
            $table->string('supplier_name')->nullable();
            $table->timestamp('last_restocked_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
