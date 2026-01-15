<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model InvitationWidget
 * Cấu hình widget của thiệp
 */
class InvitationWidget extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'widget_type',
        'is_enabled',
        'config',
        'sort_order',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'config' => 'array',
    ];

    // =========== RELATIONSHIPS ===========

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    // =========== ACCESSORS ===========

    /**
     * Lấy label tiếng Việt của widget
     */
    public function getLabelAttribute(): string
    {
        return match ($this->widget_type) {
            'rsvp' => 'Xác nhận tham dự',
            'guestbook' => 'Sổ lưu bút',
            'album' => 'Album ảnh',
            'music' => 'Nhạc nền',
            'countdown' => 'Đếm ngược',
            'maps' => 'Bản đồ',
            'vietqr' => 'QR Mừng tiền',
            default => ucfirst($this->widget_type),
        };
    }

    /**
     * Lấy icon của widget
     */
    public function getIconAttribute(): string
    {
        return match ($this->widget_type) {
            'rsvp' => 'fa-solid fa-user-check',
            'guestbook' => 'fa-solid fa-book-open',
            'album' => 'fa-solid fa-images',
            'music' => 'fa-solid fa-music',
            'countdown' => 'fa-solid fa-hourglass-half',
            'maps' => 'fa-solid fa-map-location-dot',
            'vietqr' => 'fa-solid fa-qrcode',
            default => 'fa-solid fa-puzzle-piece',
        };
    }

    // =========== SCOPES ===========

    public function scopeEnabled($query)
    {
        return $query->where('is_enabled', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
