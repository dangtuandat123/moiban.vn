<?php

namespace App\Services;

use App\Models\Invitation;
use App\Models\InvitationSubscription;
use App\Models\Package;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

/**
 * Service: Quản lý Subscription (mua gói, gia hạn)
 */
class SubscriptionService
{
    protected WalletService $walletService;
    protected TelegramService $telegramService;

    public function __construct(WalletService $walletService, TelegramService $telegramService)
    {
        $this->walletService = $walletService;
        $this->telegramService = $telegramService;
    }

    /**
     * Mua gói cho thiệp
     * 
     * @throws Exception Nếu không đủ số dư hoặc gói không hợp lệ
     */
    public function purchase(Invitation $invitation, Package $package, User $user): InvitationSubscription
    {
        // Validate
        if (!$package->is_active) {
            throw new Exception('Gói dịch vụ không khả dụng.');
        }

        // Kiểm tra số dư
        $balance = $this->walletService->getBalance($user);
        if ($balance < $package->price) {
            throw new Exception("Số dư không đủ. Cần {$package->price}đ, hiện có {$balance}đ.");
        }

        return DB::transaction(function () use ($invitation, $package, $user) {
            // Trừ tiền
            $this->walletService->deduct(
                $user,
                $package->price,
                'purchase',
                "Mua gói {$package->name} cho thiệp #{$invitation->id}"
            );

            // Tính thời hạn
            $startsAt = now();
            $endsAt = $package->duration_days > 0 
                ? $startsAt->copy()->addDays($package->duration_days) 
                : null; // null = lifetime

            // Tạo subscription
            $subscription = InvitationSubscription::create([
                'invitation_id' => $invitation->id,
                'package_id' => $package->id,
                'amount_paid' => $package->price,
                'package_type' => $package->type,
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
            ]);

            // Cập nhật invitation status
            $invitation->update([
                'status' => 'active',
                'watermark_enabled' => $package->type === 'basic',
                'expires_at' => $endsAt,
            ]);

            // Notify admin
            $this->telegramService->notifyPurchase($user, $invitation, $package);

            return $subscription;
        });
    }

    /**
     * Gia hạn thiệp (dùng gói hiện tại hoặc upgrade)
     */
    public function extend(Invitation $invitation, Package $package, User $user): InvitationSubscription
    {
        // Validate
        if (!$package->is_active) {
            throw new Exception('Gói dịch vụ không khả dụng.');
        }

        $balance = $this->walletService->getBalance($user);
        if ($balance < $package->price) {
            throw new Exception("Số dư không đủ. Cần {$package->price}đ.");
        }

        return DB::transaction(function () use ($invitation, $package, $user) {
            // Trừ tiền
            $this->walletService->deduct(
                $user,
                $package->price,
                'purchase',
                "Gia hạn thiệp #{$invitation->id} với gói {$package->name}"
            );

            // Tính thời hạn mới (cộng thêm từ ngày hiện tại hoặc ngày hết hạn)
            $baseDate = $invitation->expires_at && $invitation->expires_at->isFuture() 
                ? $invitation->expires_at 
                : now();
            
            $endsAt = $package->duration_days > 0 
                ? $baseDate->copy()->addDays($package->duration_days) 
                : null;

            // Tạo subscription record
            $subscription = InvitationSubscription::create([
                'invitation_id' => $invitation->id,
                'package_id' => $package->id,
                'amount_paid' => $package->price,
                'package_type' => $package->type,
                'starts_at' => now(),
                'ends_at' => $endsAt,
            ]);

            // Cập nhật invitation
            $invitation->update([
                'status' => 'active',
                'watermark_enabled' => $package->type === 'basic',
                'expires_at' => $endsAt,
            ]);

            return $subscription;
        });
    }

    /**
     * Kiểm tra trạng thái subscription
     */
    public function checkStatus(Invitation $invitation): array
    {
        $latestSubscription = $invitation->subscriptions()
            ->latest('created_at')
            ->first();

        if (!$latestSubscription) {
            return [
                'has_subscription' => false,
                'status' => 'trial',
                'expires_at' => $invitation->trial_ends_at,
                'days_remaining' => $invitation->trial_ends_at 
                    ? now()->diffInDays($invitation->trial_ends_at, false) 
                    : 0,
            ];
        }

        $isActive = $latestSubscription->ends_at === null 
            || $latestSubscription->ends_at->isFuture();

        return [
            'has_subscription' => true,
            'status' => $isActive ? 'active' : 'expired',
            'package_type' => $latestSubscription->package_type,
            'expires_at' => $latestSubscription->ends_at,
            'days_remaining' => $latestSubscription->ends_at 
                ? now()->diffInDays($latestSubscription->ends_at, false) 
                : null, // null = lifetime
            'subscription' => $latestSubscription,
        ];
    }

    /**
     * Lấy lịch sử subscription của thiệp
     */
    public function getHistory(Invitation $invitation)
    {
        return $invitation->subscriptions()
            ->with('package')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Kiểm tra xem có thể upgrade không
     */
    public function canUpgrade(Invitation $invitation): bool
    {
        $latestSubscription = $invitation->subscriptions()->latest()->first();
        
        if (!$latestSubscription) {
            return true;
        }

        return $latestSubscription->package_type !== 'premium';
    }

    /**
     * Lấy các gói available cho upgrade/extend
     */
    public function getAvailablePackages(Invitation $invitation)
    {
        $currentType = $invitation->subscriptions()->latest()->value('package_type');
        
        return Package::where('is_active', true)
            ->when($currentType === 'premium', function ($query) {
                // Nếu đang premium, chỉ hiện gói premium để gia hạn
                $query->where('type', 'premium');
            })
            ->orderBy('sort_order')
            ->get();
    }
}
