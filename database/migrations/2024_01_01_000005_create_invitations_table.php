<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Bảng invitations
 * Bảng chính lưu trữ thiệp cưới của user
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('template_id')->constrained()->restrictOnDelete();
            $table->string('slug', 100)->unique()->comment('Link chia sẻ: moiban.vn/{slug}');
            $table->string('title')->comment('Tiêu đề thiệp');
            $table->json('content')->comment('Nội dung động từ form editor');
            $table->enum('status', ['trial', 'active', 'locked', 'expired'])->default('trial');
            $table->timestamp('trial_ends_at')->nullable()->comment('Hết hạn dùng thử');
            $table->timestamp('expires_at')->nullable()->comment('Hết hạn gói (null = vĩnh viễn)');
            $table->boolean('watermark_enabled')->default(true)->comment('Hiển thị watermark');
            $table->json('seo_meta')->nullable()->comment('SEO: title, description, og_image');
            $table->bigInteger('view_count')->default(0)->comment('Lượt xem');
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('user_id');
            $table->index('status');
            $table->index('trial_ends_at');
            $table->index('expires_at');
            $table->index(['status', 'trial_ends_at']); // Cho cron job
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
