<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Bảng wallet_transactions
 * Lịch sử giao dịch của ví (nạp tiền, mua gói, hoàn tiền)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['deposit', 'purchase', 'refund'])->comment('Loại giao dịch');
            $table->bigInteger('amount')->comment('Số tiền giao dịch (VND)');
            $table->bigInteger('balance_after')->comment('Số dư sau giao dịch');
            $table->string('reference_code', 100)->nullable()->unique()->comment('Mã tham chiếu (chống duplicate)');
            $table->string('description')->comment('Mô tả giao dịch');
            $table->json('metadata')->nullable()->comment('Dữ liệu bổ sung');
            $table->timestamps();

            // Indexes
            $table->index('type');
            $table->index('created_at');
            $table->index(['wallet_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
