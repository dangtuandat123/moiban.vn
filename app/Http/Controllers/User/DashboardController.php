<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Controller: Dashboard người dùng
 */
class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Thống kê
        $invitationsCount = $user->invitations()->count();
        $activeInvitations = $user->invitations()->active()->count();
        $trialInvitations = $user->invitations()->trial()->count();
        $walletBalance = $user->wallet_balance;
        
        // Thiệp gần đây
        $recentInvitations = $user->invitations()
            ->with('template')
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact(
            'user',
            'invitationsCount',
            'activeInvitations',
            'trialInvitations',
            'walletBalance',
            'recentInvitations'
        ));
    }
}
