<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Model Invitation
 * Thiệp cưới - Core entity của hệ thống
 */
class Invitation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'template_id',
        'slug',
        'title',
        'content',
        'status',
        'trial_ends_at',
        'expires_at',
        'watermark_enabled',
        'seo_meta',
        'view_count',
    ];

    protected $casts = [
        'content' => 'array',
        'seo_meta' => 'array',
        'watermark_enabled' => 'boolean',
        'trial_ends_at' => 'datetime',
        'expires_at' => 'datetime',
        'view_count' => 'integer',
    ];

    // =========== RELATIONSHIPS ===========

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(InvitationSubscription::class);
    }

    public function widgets(): HasMany
    {
        return $this->hasMany(InvitationWidget::class);
    }

    public function albums(): HasMany
    {
        return $this->hasMany(InvitationAlbum::class)->orderBy('sort_order');
    }

    public function rsvps(): HasMany
    {
        return $this->hasMany(Rsvp::class);
    }

    public function guestbookEntries(): HasMany
    {
        return $this->hasMany(GuestbookEntry::class);
    }

    // =========== ACCESSORS ===========

    /**
     * Lấy URL công khai của thiệp
     */
    public function getPublicUrlAttribute(): string
    {
        return url('/' . $this->slug);
    }

    /**
     * Lấy tên cặp đôi từ content
     */
    public function getCoupleNameAttribute(): string
    {
        $groom = $this->content['groom_name'] ?? 'Chú rể';
        $bride = $this->content['bride_name'] ?? 'Cô dâu';
        return "{$groom} & {$bride}";
    }

    /**
     * Lấy ngày cưới từ content
     */
    public function getEventDateAttribute(): ?string
    {
        return $this->content['event_date'] ?? null;
    }

    /**
     * Lấy label status tiếng Việt
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'trial' => 'Dùng thử',
            'active' => 'Đang hoạt động',
            'locked' => 'Đã khóa',
            'expired' => 'Hết hạn',
            default => 'Không xác định',
        };
    }

    /**
     * Lấy class CSS cho status
     */
    public function getStatusClassAttribute(): string
    {
        return match ($this->status) {
            'trial' => 'bg-yellow-500',
            'active' => 'bg-green-500',
            'locked' => 'bg-red-500',
            'expired' => 'bg-gray-500',
            default => 'bg-gray-400',
        };
    }

    // =========== STATUS CHECKS ===========

    public function isTrial(): bool
    {
        return $this->status === 'trial';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isLocked(): bool
    {
        return $this->status === 'locked';
    }

    public function isExpired(): bool
    {
        return $this->status === 'expired';
    }

    public function isAccessible(): bool
    {
        return in_array($this->status, ['trial', 'active']);
    }

    public function shouldShowWatermark(): bool
    {
        return $this->watermark_enabled || $this->isTrial();
    }

    // =========== SCOPES ===========

    public function scopeTrial($query)
    {
        return $query->where('status', 'trial');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeLocked($query)
    {
        return $query->where('status', 'locked');
    }

    public function scopeExpiredTrials($query)
    {
        return $query->where('status', 'trial')
                     ->where('trial_ends_at', '<', now());
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // =========== METHODS ===========

    /**
     * Tăng lượt xem
     */
    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }

    /**
     * Khóa thiệp (hết trial)
     */
    public function lock(): void
    {
        $this->update(['status' => 'locked']);
    }

    /**
     * Kích hoạt thiệp (sau khi mua gói)
     */
    public function activate(?int $durationDays = null): void
    {
        $data = [
            'status' => 'active',
            'watermark_enabled' => false,
        ];

        if ($durationDays !== null && $durationDays > 0) {
            $data['expires_at'] = now()->addDays($durationDays);
        } else {
            $data['expires_at'] = null; // Vĩnh viễn
        }

        $this->update($data);
    }

    /**
     * Gia hạn thêm ngày
     */
    public function extend(int $days): void
    {
        $baseDate = $this->expires_at ?? now();
        $this->update([
            'expires_at' => $baseDate->addDays($days),
            'status' => 'active',
        ]);
    }

    // =========== BOOT ===========

    protected static function booted(): void
    {
        // Tự động tạo slug khi tạo mới
        static::creating(function (Invitation $invitation) {
            if (empty($invitation->slug)) {
                $invitation->slug = Str::random(8);
            }
            
            // Tự động set trial_ends_at
            if (empty($invitation->trial_ends_at)) {
                $trialDays = config('app.trial_duration_days', 2);
                $invitation->trial_ends_at = now()->addDays($trialDays);
            }
        });

        // Tạo các widgets mặc định sau khi tạo thiệp
        static::created(function (Invitation $invitation) {
            $widgetTypes = ['countdown', 'album', 'rsvp', 'guestbook', 'maps', 'music', 'vietqr'];
            
            foreach ($widgetTypes as $index => $type) {
                $invitation->widgets()->create([
                    'widget_type' => $type,
                    'is_enabled' => in_array($type, ['countdown', 'album', 'rsvp']), // Bật mặc định một số widget
                    'sort_order' => $index,
                ]);
            }
        });
    }
}
