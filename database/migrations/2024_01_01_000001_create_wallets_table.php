<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Bảng wallets
 * Ví nội bộ của mỗi user để thanh toán dịch vụ
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->bigInteger('balance')->default(0)->comment('Số dư ví (VND)');
            $table->timestamps();

            // Indexes
            $table->index('balance');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
