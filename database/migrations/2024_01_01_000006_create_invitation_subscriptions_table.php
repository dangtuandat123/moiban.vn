<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Bảng invitation_subscriptions
 * Lịch sử mua gói của thiệp
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitation_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('package_id')->constrained()->restrictOnDelete();
            $table->bigInteger('amount_paid')->comment('Số tiền đã trả (VND)');
            $table->enum('package_type', ['basic', 'premium']);
            $table->timestamp('starts_at');
            $table->timestamp('ends_at')->nullable()->comment('null = vĩnh viễn');
            $table->timestamps();

            // Indexes
            $table->index(['invitation_id', 'starts_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitation_subscriptions');
    }
};
