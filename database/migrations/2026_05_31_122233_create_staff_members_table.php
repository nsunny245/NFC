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
        Schema::create('staff_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Optional user login links
            $table->string('full_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('role_designation'); // 'waiter', 'chef', 'cashier', 'manager', 'cleaner', 'rider'
            $table->decimal('salary', 10, 2); // Monthly fixed salary
            $table->date('hire_date');
            $table->string('status')->default('active'); // 'active', 'inactive'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_members');
    }
};
