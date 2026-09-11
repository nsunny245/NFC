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
            if (!Schema::hasColumn('users', 'pin')) {
                $table->string('pin', 6)->nullable()->after('password');
            }
            if (!Schema::hasColumn('users', 'terminal_code')) {
                $table->string('terminal_code', 30)->nullable()->after('role');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 30)->nullable()->after('terminal_code');
            }
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('phone');
            }
            if (!Schema::hasColumn('users', 'api_token')) {
                $table->string('api_token', 80)->unique()->nullable()->after('is_active');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $cols = ['pin', 'terminal_code', 'phone', 'is_active', 'api_token'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
