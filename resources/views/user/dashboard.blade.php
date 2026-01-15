@extends('layouts.app')

@section('title', 'Dashboard - Mời Bạn')

@section('content')
<section class="py-8">
    <div class="container">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-heading font-bold">
                    Xin chào, <span class="text-gradient">{{ Auth::user()->name }}</span>!
                </h1>
                <p class="text-white/60 mt-1">Quản lý thiệp cưới và tài khoản của bạn</p>
            </div>
            <a href="{{ route('user.invitations.create') }}" class="glass-btn">
                <i class="fa-solid fa-plus"></i>
                Tạo thiệp mới
            </a>
        </div>
        
        <!-- Stats Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="glass-card p-5">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-pink-500/20 flex items-center justify-center">
                        <i class="fa-solid fa-envelope text-pink-400"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold">{{ $stats['total_invitations'] ?? 0 }}</p>
                        <p class="text-xs text-white/50">Tổng thiệp</p>
                    </div>
                </div>
            </div>
            
            <div class="glass-card p-5">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-green-500/20 flex items-center justify-center">
                        <i class="fa-solid fa-check-circle text-green-400"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold">{{ $stats['active_invitations'] ?? 0 }}</p>
                        <p class="text-xs text-white/50">Đang hoạt động</p>
                    </div>
                </div>
            </div>
            
            <div class="glass-card p-5">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center">
                        <i class="fa-solid fa-user-check text-blue-400"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold">{{ $stats['total_rsvps'] ?? 0 }}</p>
                        <p class="text-xs text-white/50">Lượt RSVP</p>
                    </div>
                </div>
            </div>
            
            <div class="glass-card p-5">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/20 flex items-center justify-center">
                        <i class="fa-solid fa-wallet text-amber-400"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold">{{ number_format(Auth::user()->wallet->balance ?? 0, 0, ',', '.') }}<span class="text-sm font-normal">đ</span></p>
                        <p class="text-xs text-white/50">Số dư ví</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="grid md:grid-cols-3 gap-4 mb-8">
            <a href="{{ route('user.invitations.index') }}" class="glass-card p-6 hover:border-primary-500/50 transition group">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-pink-500/20 to-purple-500/20 flex items-center justify-center group-hover:scale-110 transition">
                        <i class="fa-solid fa-envelope-open-text text-2xl text-pink-400"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">Quản lý thiệp</h3>
                        <p class="text-sm text-white/50">Xem và chỉnh sửa thiệp</p>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('user.wallet') }}" class="glass-card p-6 hover:border-primary-500/50 transition group">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-500/20 to-orange-500/20 flex items-center justify-center group-hover:scale-110 transition">
                        <i class="fa-solid fa-wallet text-2xl text-amber-400"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">Ví của tôi</h3>
                        <p class="text-sm text-white/50">Nạp tiền & lịch sử</p>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('user.invitations.create') }}" class="glass-card p-6 hover:border-primary-500/50 transition group">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500/20 to-green-500/20 flex items-center justify-center group-hover:scale-110 transition">
                        <i class="fa-solid fa-plus text-2xl text-emerald-400"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold">Tạo thiệp mới</h3>
                        <p class="text-sm text-white/50">Dùng thử 2 ngày miễn phí</p>
                    </div>
                </div>
            </a>
        </div>
        
        <!-- Recent Invitations -->
        <div class="glass-panel rounded-2xl p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-semibold text-lg">Thiệp gần đây</h2>
                <a href="{{ route('user.invitations.index') }}" class="text-sm text-primary-400 hover:text-primary-300 transition">
                    Xem tất cả <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
            
            @if(isset($recentInvitations) && $recentInvitations->count() > 0)
            <div class="space-y-3">
                @foreach($recentInvitations as $invitation)
                <a href="{{ route('user.invitations.show', $invitation) }}" 
                   class="flex items-center justify-between p-4 rounded-xl bg-white/5 hover:bg-white/10 transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary-500/20 to-pink-500/20 flex items-center justify-center">
                            <i class="fa-solid fa-envelope text-primary-400"></i>
                        </div>
                        <div>
                            <h3 class="font-medium group-hover:text-primary-400 transition">{{ Str::limit($invitation->title, 30) }}</h3>
                            <p class="text-xs text-white/50">{{ $invitation->template->name ?? 'N/A' }} • {{ $invitation->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 text-xs rounded-full {{ $invitation->status_class }}">
                            {{ $invitation->status_label }}
                        </span>
                        <i class="fa-solid fa-chevron-right text-white/30 group-hover:text-white/60 transition"></i>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-white/5 flex items-center justify-center">
                    <i class="fa-solid fa-envelope-open text-2xl text-white/30"></i>
                </div>
                <h3 class="font-medium mb-2">Chưa có thiệp nào</h3>
                <p class="text-sm text-white/50 mb-4">Bắt đầu tạo thiệp cưới đầu tiên của bạn</p>
                <a href="{{ route('user.invitations.create') }}" class="glass-btn">
                    <i class="fa-solid fa-plus"></i>
                    Tạo thiệp ngay
                </a>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
