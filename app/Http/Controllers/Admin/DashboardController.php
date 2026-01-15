<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;

/**
 * Controller: Admin Dashboard
 */
class DashboardController extends Controller
{
    public function index()
    {
        // Thống kê tổng quan
        $stats = [
            'total_users' => User::users()->count(),
            'total_invitations' => Invitation::count(),
            'active_invitations' => Invitation::active()->count(),
            'trial_invitations' => Invitation::trial()->count(),
        ];

        // Doanh thu tháng này
        $currentMonth = now()->startOfMonth();
        $monthlyRevenue = WalletTransaction::where('type', 'deposit')
            ->where('created_at', '>=', $currentMonth)
            ->sum('amount');

        // Doanh thu theo ngày trong tháng (cho chart)
        $dailyRevenue = WalletTransaction::where('type', 'deposit')
            ->where('created_at', '>=', $currentMonth)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Users mới trong 7 ngày qua
        $newUsers = User::where('created_at', '>=', now()->subDays(7))->count();

        // Recent activities
        $recentInvitations = Invitation::with('user', 'template')
            ->latest()
            ->take(10)
            ->get();

        $recentTransactions = WalletTransaction::with('wallet.user')
            ->where('type', 'deposit')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'monthlyRevenue',
            'dailyRevenue',
            'newUsers',
            'recentInvitations',
            'recentTransactions'
        ));
    }
}
