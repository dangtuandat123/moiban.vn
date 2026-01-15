<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Bảng templates
 * Lưu trữ các mẫu thiệp cưới (upload từ ZIP)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('thumbnail_path')->comment('Đường dẫn ảnh thumbnail');
            $table->string('folder_path')->comment('Đường dẫn thư mục template');
            $table->json('config')->comment('Cấu hình từ config.json');
            $table->enum('type', ['basic', 'premium'])->default('basic');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('type');
            $table->index('is_active');
            $table->index(['is_active', 'type', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
