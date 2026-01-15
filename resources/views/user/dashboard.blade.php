@extends('layouts.app')

@section('title', 'Dashboard - Mời Bạn')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Welcome Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-semibold">Xin chào, {{ $user->name }}!</h1>
        <p class="text-white/60 mt-1">Quản lý thiệp cưới của bạn tại đây.</p>
    </div>
    
    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="glass-card p-6">
            <div class="flex items-center justify-between mb-2">
                <i class="fa-solid fa-envelope-open-text text-pink-400 text-2xl"></i>
            </div>
            <p class="text-2xl font-bold">{{ $invitationsCount }}</p>
            <p class="text-sm text-white/60">Tổng thiệp</p>
        </div>
        
        <div class="glass-card p-6">
            <div class="flex items-center justify-between mb-2">
                <i class="fa-solid fa-check-circle text-green-400 text-2xl"></i>
            </div>
            <p class="text-2xl font-bold">{{ $activeInvitations }}</p>
            <p class="text-sm text-white/60">Đang hoạt động</p>
        </div>
        
        <div class="glass-card p-6">
            <div class="flex items-center justify-between mb-2">
                <i class="fa-solid fa-hourglass-start text-yellow-400 text-2xl"></i>
            </div>
            <p class="text-2xl font-bold">{{ $trialInvitations }}</p>
            <p class="text-sm text-white/60">Đang dùng thử</p>
        </div>
        
        <div class="glass-card p-6">
            <div class="flex items-center justify-between mb-2">
                <i class="fa-solid fa-wallet text-blue-400 text-2xl"></i>
            </div>
            <p class="text-2xl font-bold">{{ number_format($walletBalance, 0, ',', '.') }}đ</p>
            <p class="text-sm text-white/60">Số dư ví</p>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="grid md:grid-cols-2 gap-6 mb-8">
        <a href="{{ route('user.invitations.create') }}" class="glass-card p-6 flex items-center space-x-4 hover:bg-white/10 transition group">
            <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-rose-gold to-purple-500 flex items-center justify-center">
                <i class="fa-solid fa-plus text-2xl text-white"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold group-hover:text-rose-gold transition">Tạo thiệp mới</h3>
                <p class="text-sm text-white/60">Chọn mẫu và bắt đầu tạo thiệp</p>
            </div>
        </a>
        
        <a href="{{ route('user.wallet.deposit') }}" class="glass-card p-6 flex items-center space-x-4 hover:bg-white/10 transition group">
            <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-green-400 to-cyan-500 flex items-center justify-center">
                <i class="fa-solid fa-money-bill-wave text-2xl text-white"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold group-hover:text-green-400 transition">Nạp tiền</h3>
                <p class="text-sm text-white/60">Nạp tiền vào ví để mua gói</p>
            </div>
        </a>
    </div>
    
    <!-- Recent Invitations -->
    <div class="glass-card p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold">Thiệp gần đây</h2>
            <a href="{{ route('user.invitations.index') }}" class="text-sm text-rose-gold hover:underline">Xem tất cả</a>
        </div>
        
        @if($recentInvitations->count() > 0)
            <div class="space-y-4">
                @foreach($recentInvitations as $invitation)
                <div class="flex items-center justify-between p-4 rounded-xl bg-white/5 hover:bg-white/10 transition">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-rose-gold/20 to-purple-500/20 flex items-center justify-center">
                            <i class="fa-solid fa-heart text-rose-gold"></i>
                        </div>
                        <div>
                            <h3 class="font-medium">{{ $invitation->title }}</h3>
                            <p class="text-sm text-white/60">{{ $invitation->template->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="px-3 py-1 text-xs rounded-full {{ $invitation->status_class }} text-white">
                            {{ $invitation->status_label }}
                        </span>
                        <a href="{{ route('user.invitations.editor', $invitation) }}" class="text-white/60 hover:text-white">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-white/5 flex items-center justify-center">
                    <i class="fa-solid fa-envelope-open text-3xl text-white/30"></i>
                </div>
                <p class="text-white/60 mb-4">Bạn chưa có thiệp nào</p>
                <a href="{{ route('user.invitations.create') }}" class="glass-btn inline-block">
                    Tạo thiệp đầu tiên
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
