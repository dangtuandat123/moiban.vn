<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Bảng packages
 * Các gói dịch vụ (Basic, Premium với thời hạn khác nhau)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['basic', 'premium'])->default('basic');
            $table->integer('duration_days')->default(0)->comment('0 = vĩnh viễn');
            $table->bigInteger('price')->comment('Giá gói (VND)');
            $table->json('features')->nullable()->comment('Danh sách tính năng');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            // Indexes
            $table->index('type');
            $table->index('is_active');
            $table->index(['is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
