<?php

namespace App\Services;

use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Service: WalletService
 * Xử lý logic ví và giao dịch
 */
class WalletService
{
    public function __construct(
        private TelegramService $telegramService
    ) {}

    /**
     * Nạp tiền vào ví từ webhook
     * @param int $userId ID của user
     * @param int $amount Số tiền nạp (VND)
     * @param string $referenceCode Mã tham chiếu (từ nội dung chuyển khoản)
     */
    public function deposit(int $userId, int $amount, string $referenceCode): WalletTransaction
    {
        return DB::transaction(function () use ($userId, $amount, $referenceCode) {
            // Kiểm tra duplicate
            if (WalletTransaction::where('reference_code', $referenceCode)->exists()) {
                throw new \Exception("Giao dịch đã được xử lý: {$referenceCode}");
            }

            // Tìm user và wallet
            $user = User::findOrFail($userId);
            $wallet = $user->wallet;

            if (!$wallet) {
                // Tạo ví nếu chưa có (edge case)
                $wallet = $user->wallet()->create(['balance' => 0]);
            }

            // Nạp tiền
            $transaction = $wallet->deposit(
                $amount,
                $referenceCode,
                "Nạp tiền qua VietQR"
            );

            // Log
            Log::info('Wallet deposit successful', [
                'user_id' => $userId,
                'amount' => $amount,
                'reference' => $referenceCode,
                'new_balance' => $wallet->balance,
            ]);

            // Thông báo Telegram
            $this->telegramService->notifyDeposit($user, $amount, $wallet->balance);

            return $transaction;
        });
    }

    /**
     * Lấy số dư ví của user
     */
    public function getBalance(User $user): int
    {
        return $user->wallet?->balance ?? 0;
    }

    /**
     * Lấy lịch sử giao dịch
     */
    public function getTransactionHistory(User $user, int $limit = 20)
    {
        return $user->wallet?->transactions()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get() ?? collect();
    }

    /**
     * Generate VietQR URL cho user
     */
    public function generateVietQrUrl(User $user): string
    {
        $bankCode = config('services.vietqr.bank_code', '970416');
        $accountNumber = config('services.vietqr.account_number', '11183041');
        $accountName = urlencode(config('services.vietqr.account_name', 'DANG TUAN DAT'));
        $addInfo = urlencode("TTGR_{$user->id}_NAP");

        return "https://api.vietqr.io/image/{$bankCode}-{$accountNumber}-rdXzPHV.jpg?accountName={$accountName}&addInfo={$addInfo}";
    }
}
