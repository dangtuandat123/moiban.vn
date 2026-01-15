<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model WalletTransaction
 * Lịch sử giao dịch ví
 */
class WalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'type',
        'amount',
        'balance_after',
        'reference_code',
        'description',
        'metadata',
    ];

    protected $casts = [
        'amount' => 'integer',
        'balance_after' => 'integer',
        'metadata' => 'array',
    ];

    // =========== RELATIONSHIPS ===========

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    // =========== ACCESSORS ===========

    /**
     * Format số tiền giao dịch
     */
    public function getFormattedAmountAttribute(): string
    {
        $prefix = $this->amount > 0 ? '+' : '';
        return $prefix . number_format($this->amount, 0, ',', '.') . ' ₫';
    }

    /**
     * Lấy class CSS cho loại giao dịch
     */
    public function getTypeClassAttribute(): string
    {
        return match ($this->type) {
            'deposit' => 'text-green-500',
            'purchase' => 'text-red-500',
            'refund' => 'text-blue-500',
            default => 'text-gray-500',
        };
    }

    /**
     * Lấy label tiếng Việt cho loại giao dịch
     */
    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'deposit' => 'Nạp tiền',
            'purchase' => 'Mua gói',
            'refund' => 'Hoàn tiền',
            default => 'Khác',
        };
    }

    // =========== SCOPES ===========

    public function scopeDeposits($query)
    {
        return $query->where('type', 'deposit');
    }

    public function scopePurchases($query)
    {
        return $query->where('type', 'purchase');
    }
}
