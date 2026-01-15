<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Model User
 * Người dùng hệ thống (User thường và Admin)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // =========== RELATIONSHIPS ===========

    /**
     * User có 1 ví
     */
    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    /**
     * User có nhiều thiệp
     */
    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    // =========== ACCESSORS ===========

    /**
     * Kiểm tra user có phải admin không
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Lấy số dư ví (tạo ví nếu chưa có)
     */
    public function getWalletBalanceAttribute(): int
    {
        return $this->wallet?->balance ?? 0;
    }

    // =========== SCOPES ===========

    /**
     * Scope: Chỉ lấy admin
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope: Chỉ lấy user thường
     */
    public function scopeUsers($query)
    {
        return $query->where('role', 'user');
    }

    // =========== BOOT ===========

    protected static function booted(): void
    {
        // Tự động tạo ví khi tạo user mới
        static::created(function (User $user) {
            $user->wallet()->create(['balance' => 0]);
        });
    }
}
