<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model Package
 * Gói dịch vụ (Basic/Premium với các thời hạn khác nhau)
 */
class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'duration_days',
        'price',
        'features',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'duration_days' => 'integer',
        'price' => 'integer',
        'features' => 'array',
        'is_active' => 'boolean',
    ];

    // =========== RELATIONSHIPS ===========

    public function subscriptions(): HasMany
    {
        return $this->hasMany(InvitationSubscription::class);
    }

    // =========== ACCESSORS ===========

    /**
     * Lấy giá đã format
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0, ',', '.') . ' ₫';
    }

    /**
     * Lấy label thời hạn
     */
    public function getDurationLabelAttribute(): string
    {
        if ($this->duration_days === 0) {
            return 'Vĩnh viễn';
        }
        return $this->duration_days . ' ngày';
    }

    /**
     * Kiểm tra gói vĩnh viễn
     */
    public function isLifetime(): bool
    {
        return $this->duration_days === 0;
    }

    /**
     * Kiểm tra gói premium
     */
    public function isPremium(): bool
    {
        return $this->type === 'premium';
    }

    // =========== SCOPES ===========

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeBasic($query)
    {
        return $query->where('type', 'basic');
    }

    public function scopePremium($query)
    {
        return $query->where('type', 'premium');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('price');
    }
}
