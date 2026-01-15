<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Bảng invitation_widgets
 * Cấu hình các widget của thiệp (RSVP, Guestbook, Album, Music,...)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitation_widgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->cascadeOnDelete();
            $table->enum('widget_type', [
                'rsvp',
                'guestbook', 
                'album',
                'music',
                'countdown',
                'maps',
                'vietqr'
            ]);
            $table->boolean('is_enabled')->default(false);
            $table->json('config')->nullable()->comment('Cấu hình riêng của widget');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            // Composite unique
            $table->unique(['invitation_id', 'widget_type']);
            
            // Indexes
            $table->index(['invitation_id', 'is_enabled']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitation_widgets');
    }
};
