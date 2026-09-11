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
            if (!Schema::hasColumn('orders', 'uuid')) {
                $table->uuid('uuid')->nullable()->unique()->after('id');
            }
            if (!Schema::hasColumn('orders', 'terminal_code')) {
                $table->string('terminal_code', 30)->nullable()->after('order_number');
            }
            if (!Schema::hasColumn('orders', 'synced_at')) {
                $table->timestamp('synced_at')->nullable()->after('updated_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $cols = ['uuid', 'terminal_code', 'synced_at'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('orders', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
