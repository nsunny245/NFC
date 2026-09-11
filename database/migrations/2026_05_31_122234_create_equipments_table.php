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
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category'); // 'kitchen_appliances', 'dining_furniture', 'cooling_heating', 'pos_it', 'lighting_electrical', 'other'
            $table->string('serial_number')->nullable();
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_cost', 10, 2)->default(0);
            $table->string('functional_status')->default('operational'); // 'operational', 'under_maintenance', 'degraded', 'broken'
            $table->date('last_maintenance_date')->nullable();
            $table->date('next_maintenance_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};
