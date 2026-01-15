<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Bảng rsvps
 * Lưu trữ xác nhận tham dự của khách
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rsvps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->cascadeOnDelete();
            $table->string('guest_name');
            $table->integer('attendees_count')->default(1)->comment('Số người tham dự');
            $table->enum('status', ['attending', 'not_attending', 'maybe'])->default('attending');
            $table->text('message')->nullable()->comment('Lời nhắn');
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['invitation_id', 'status']);
            $table->index(['invitation_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rsvps');
    }
};
