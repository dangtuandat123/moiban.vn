<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model GuestbookEntry
 * Lời chúc từ khách
 */
class GuestbookEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'author_name',
        'message',
        'is_approved',
        'ip_address',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    // =========== RELATIONSHIPS ===========

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    // =========== SCOPES ===========

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
