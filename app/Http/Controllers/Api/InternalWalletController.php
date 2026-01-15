<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\TelegramService;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Controller: Internal API nhận webhook nạp tiền
 */
class InternalWalletController extends Controller
{
    public function __construct(
        private WalletService $walletService,
        private TelegramService $telegramService
    ) {}

    /**
     * Endpoint: POST /api/internal/wallet/deposit
     * Nhận từ ACB.py hoặc service bên ngoài
     */
    public function deposit(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'amount' => ['required', 'integer', 'min:1000'],
            'reference' => ['required', 'string', 'max:100'],
        ]);

        try {
            $transaction = $this->walletService->deposit(
                $validated['user_id'],
                $validated['amount'],
                $validated['reference']
            );

            $user = User::find($validated['user_id']);

            // Thông báo Telegram
            $this->telegramService->notifyDeposit(
                $user,
                $validated['amount'],
                $transaction->balance_after
            );

            Log::info('Deposit API success', [
                'user_id' => $validated['user_id'],
                'amount' => $validated['amount'],
                'reference' => $validated['reference'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Nạp tiền thành công',
                'data' => [
                    'transaction_id' => $transaction->id,
                    'new_balance' => $transaction->balance_after,
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Deposit API failed', [
                'user_id' => $validated['user_id'],
                'amount' => $validated['amount'],
                'reference' => $validated['reference'],
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}
