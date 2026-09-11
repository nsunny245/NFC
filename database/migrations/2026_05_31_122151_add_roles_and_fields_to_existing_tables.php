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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('admin')->after('password'); // 'admin', 'cashier', 'waiter'
            }
        });

        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'table_number')) {
                $table->string('table_number')->nullable()->index()->after('order_number');
            }
            if (!Schema::hasColumn('orders', 'waiter_id')) {
                $table->foreignId('waiter_id')->nullable()->after('user_id')->constrained('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('orders', 'payment_status')) {
                $table->string('payment_status')->default('pending')->after('status'); // 'pending', 'paid', 'refunded'
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });

        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'table_number')) {
                $table->dropColumn('table_number');
            }
            if (Schema::hasColumn('orders', 'waiter_id')) {
                $table->dropForeign(['waiter_id']);
                $table->dropColumn('waiter_id');
            }
            if (Schema::hasColumn('orders', 'payment_status')) {
                $table->dropColumn('payment_status');
            }
        });
    }
};
