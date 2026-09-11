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
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'served_at')) {
                $table->timestamp('served_at')->nullable()->after('status');
            }
            if (!Schema::hasColumn('orders', 'bill_requested')) {
                $table->boolean('bill_requested')->default(false)->after('served_at');
            }
            if (!Schema::hasColumn('orders', 'bill_requested_at')) {
                $table->timestamp('bill_requested_at')->nullable()->after('bill_requested');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'bill_requested_at')) {
                $table->dropColumn('bill_requested_at');
            }
            if (Schema::hasColumn('orders', 'bill_requested')) {
                $table->dropColumn('bill_requested');
            }
            if (Schema::hasColumn('orders', 'served_at')) {
                $table->dropColumn('served_at');
            }
        });
    }
};
