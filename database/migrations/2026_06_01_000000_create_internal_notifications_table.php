<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('internal_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('title');
            $table->text('message');
            $table->string('notifiable_role');
            $table->boolean('is_read')->default(false);
            $table->unsignedBigInteger('related_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internal_notifications');
    }
};
