<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model InvitationSubscription
 * Lịch sử mua gói của thiệp
 */
class InvitationSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'package_id',
        'amount_paid',
        'package_type',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'amount_paid' => 'integer',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    // =========== RELATIONSHIPS ===========

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    // =========== ACCESSORS ===========

    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount_paid, 0, ',', '.') . ' ₫';
    }

    public function isLifetime(): bool
    {
        return $this->ends_at === null;
    }

    public function isActive(): bool
    {
        if ($this->isLifetime()) {
            return true;
        }
        return $this->ends_at->isFuture();
    }
}
