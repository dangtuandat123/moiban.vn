<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model Wallet
 * Ví nội bộ của user
 */
class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance',
    ];

    protected $casts = [
        'balance' => 'integer',
    ];

    // =========== RELATIONSHIPS ===========

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class);
    }

    // =========== METHODS ===========

    /**
     * Nạp tiền vào ví
     * @param int $amount Số tiền nạp (VND)
     * @param string $referenceCode Mã tham chiếu
     * @param string $description Mô tả giao dịch
     * @param array|null $metadata Dữ liệu bổ sung
     */
    public function deposit(int $amount, string $referenceCode, string $description, ?array $metadata = null): WalletTransaction
    {
        $this->balance += $amount;
        $this->save();

        return $this->transactions()->create([
            'type' => 'deposit',
            'amount' => $amount,
            'balance_after' => $this->balance,
            'reference_code' => $referenceCode,
            'description' => $description,
            'metadata' => $metadata,
        ]);
    }

    /**
     * Trừ tiền từ ví (mua gói)
     * @param int $amount Số tiền trừ
     * @param string $description Mô tả
     * @param array|null $metadata Dữ liệu bổ sung
     */
    public function purchase(int $amount, string $description, ?array $metadata = null): WalletTransaction
    {
        if ($this->balance < $amount) {
            throw new \App\Exceptions\InsufficientBalanceException(
                "Số dư không đủ. Hiện có: " . number_format($this->balance) . " VND"
            );
        }

        $this->balance -= $amount;
        $this->save();

        return $this->transactions()->create([
            'type' => 'purchase',
            'amount' => -$amount,
            'balance_after' => $this->balance,
            'description' => $description,
            'metadata' => $metadata,
        ]);
    }

    /**
     * Hoàn tiền
     */
    public function refund(int $amount, string $description, ?array $metadata = null): WalletTransaction
    {
        $this->balance += $amount;
        $this->save();

        return $this->transactions()->create([
            'type' => 'refund',
            'amount' => $amount,
            'balance_after' => $this->balance,
            'description' => $description,
            'metadata' => $metadata,
        ]);
    }

    /**
     * Format số dư thành chuỗi VND
     */
    public function getFormattedBalanceAttribute(): string
    {
        return number_format($this->balance, 0, ',', '.') . ' ₫';
    }
}
