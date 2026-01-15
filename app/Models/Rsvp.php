<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model Rsvp
 * Xác nhận tham dự từ khách mời
 */
class Rsvp extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'guest_name',
        'attendees_count',
        'status',
        'message',
        'ip_address',
    ];

    // =========== RELATIONSHIPS ===========

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    // =========== ACCESSORS ===========

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'attending' => 'Sẽ tham dự',
            'not_attending' => 'Không tham dự',
            'maybe' => 'Chưa chắc chắn',
            default => 'Không xác định',
        };
    }

    public function getStatusIconAttribute(): string
    {
        return match ($this->status) {
            'attending' => 'fa-solid fa-circle-check text-green-500',
            'not_attending' => 'fa-solid fa-circle-xmark text-red-500',
            'maybe' => 'fa-solid fa-circle-question text-yellow-500',
            default => 'fa-solid fa-circle text-gray-500',
        };
    }

    // =========== SCOPES ===========

    public function scopeAttending($query)
    {
        return $query->where('status', 'attending');
    }

    public function scopeNotAttending($query)
    {
        return $query->where('status', 'not_attending');
    }
}
