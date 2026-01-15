<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\WalletService;
use Illuminate\Http\Request;

/**
 * Controller: Quản lý ví
 */
class WalletController extends Controller
{
    public function __construct(
        private WalletService $walletService
    ) {}

    /**
     * Trang ví - hiển thị số dư và lịch sử
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $balance = $this->walletService->getBalance($user);
        $transactions = $this->walletService->getTransactionHistory($user, 20);

        return view('user.wallet.index', compact('user', 'balance', 'transactions'));
    }

    /**
     * Trang nạp tiền - hiển thị VietQR
     */
    public function deposit(Request $request)
    {
        $user = $request->user();
        $qrUrl = $this->walletService->generateVietQrUrl($user);
        $depositInfo = "TTGR_{$user->id}_NAP";

        return view('user.wallet.deposit', compact('user', 'qrUrl', 'depositInfo'));
    }
}
