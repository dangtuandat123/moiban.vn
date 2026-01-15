@extends('layouts.admin')

@section('title', 'Dashboard - Admin')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-semibold">Dashboard</h1>
    <p class="text-white/60">Tổng quan hệ thống</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="glass-card p-6">
        <div class="flex items-center justify-between mb-2">
            <i class="fa-solid fa-users text-blue-400 text-2xl"></i>
        </div>
        <p class="text-3xl font-bold">{{ number_format($stats['total_users']) }}</p>
        <p class="text-sm text-white/60">Người dùng</p>
    </div>
    
    <div class="glass-card p-6">
        <div class="flex items-center justify-between mb-2">
            <i class="fa-solid fa-envelope text-pink-400 text-2xl"></i>
        </div>
        <p class="text-3xl font-bold">{{ number_format($stats['total_invitations']) }}</p>
        <p class="text-sm text-white/60">Tổng thiệp</p>
    </div>
    
    <div class="glass-card p-6">
        <div class="flex items-center justify-between mb-2">
            <i class="fa-solid fa-check-circle text-green-400 text-2xl"></i>
        </div>
        <p class="text-3xl font-bold">{{ number_format($stats['active_invitations']) }}</p>
        <p class="text-sm text-white/60">Thiệp active</p>
    </div>
    
    <div class="glass-card p-6">
        <div class="flex items-center justify-between mb-2">
            <i class="fa-solid fa-money-bill text-yellow-400 text-2xl"></i>
        </div>
        <p class="text-3xl font-bold">{{ number_format($monthlyRevenue, 0, ',', '.') }}đ</p>
        <p class="text-sm text-white/60">Doanh thu tháng</p>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-6">
    <!-- Recent Invitations -->
    <div class="glass-card p-6">
        <h2 class="text-lg font-semibold mb-4">Thiệp mới</h2>
        <div class="space-y-3">
            @forelse($recentInvitations as $inv)
            <div class="flex items-center justify-between p-3 rounded-lg bg-white/5">
                <div>
                    <p class="font-medium">{{ Str::limit($inv->title, 30) }}</p>
                    <p class="text-xs text-white/60">{{ $inv->user->name }} - {{ $inv->created_at->diffForHumans() }}</p>
                </div>
                <span class="px-2 py-1 text-xs rounded {{ $inv->status_class }}">{{ $inv->status_label }}</span>
            </div>
            @empty
            <p class="text-white/60 text-center py-4">Chưa có thiệp nào</p>
            @endforelse
        </div>
    </div>
    
    <!-- Recent Transactions -->
    <div class="glass-card p-6">
        <h2 class="text-lg font-semibold mb-4">Nạp tiền gần đây</h2>
        <div class="space-y-3">
            @forelse($recentTransactions as $tx)
            <div class="flex items-center justify-between p-3 rounded-lg bg-white/5">
                <div>
                    <p class="font-medium">{{ $tx->wallet->user->name ?? 'N/A' }}</p>
                    <p class="text-xs text-white/60">{{ $tx->created_at->diffForHumans() }}</p>
                </div>
                <span class="text-green-400 font-semibold">+{{ number_format($tx->amount, 0, ',', '.') }}đ</span>
            </div>
            @empty
            <p class="text-white/60 text-center py-4">Chưa có giao dịch nào</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
