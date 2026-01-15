@extends('layouts.app')

@section('title', 'Dashboard - Mời Bạn')

@section('content')
<section class="py-6 md:py-8">
    <div class="container">
        <!-- Welcome Header - Clear and friendly -->
        <div class="glass-card p-6 md:p-8 mb-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-40 h-40 bg-primary-500/20 rounded-full blur-3xl -z-0"></div>
            <div class="relative z-10">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <p class="text-sm text-white/60 mb-1">👋 Chào mừng bạn!</p>
                        <h1 class="text-2xl md:text-3xl font-heading font-bold text-gradient-gold">
                            {{ Auth::user()->name }}
                        </h1>
                        <p class="text-white/60 mt-2">Đây là trang quản lý thiệp cưới của bạn</p>
                    </div>
                    <a href="{{ route('user.invitations.create') }}" class="glass-btn glass-btn-lg flex items-center justify-center gap-3">
                        <i class="fa-solid fa-plus text-lg"></i>
                        <span class="font-semibold">Tạo thiệp mới</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions - Big, Clear Buttons for Low-Tech Users -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4 flex items-center gap-2">
                <i class="fa-solid fa-bolt text-amber-400"></i>
                Bạn muốn làm gì?
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
                <a href="{{ route('user.invitations.create') }}" class="quick-action-card group">
                    <div class="quick-action-icon bg-gradient-to-br from-emerald-500/20 to-green-500/20 group-hover:from-emerald-500/30 group-hover:to-green-500/30">
                        <i class="fa-solid fa-plus text-xl md:text-2xl text-emerald-400"></i>
                    </div>
                    <span class="quick-action-label">Tạo thiệp mới</span>
                    <span class="quick-action-hint">Bắt đầu từ đây</span>
                </a>
                
                <a href="{{ route('user.invitations.index') }}" class="quick-action-card group">
                    <div class="quick-action-icon bg-gradient-to-br from-pink-500/20 to-rose-500/20 group-hover:from-pink-500/30 group-hover:to-rose-500/30">
                        <i class="fa-solid fa-envelope-open-text text-xl md:text-2xl text-pink-400"></i>
                    </div>
                    <span class="quick-action-label">Thiệp của tôi</span>
                    <span class="quick-action-hint">{{ $stats['total_invitations'] ?? 0 }} thiệp</span>
                </a>
                
                <a href="{{ route('user.wallet') }}" class="quick-action-card group">
                    <div class="quick-action-icon bg-gradient-to-br from-amber-500/20 to-orange-500/20 group-hover:from-amber-500/30 group-hover:to-orange-500/30">
                        <i class="fa-solid fa-wallet text-xl md:text-2xl text-amber-400"></i>
                    </div>
                    <span class="quick-action-label">Ví của tôi</span>
                    <span class="quick-action-hint">{{ number_format(Auth::user()->wallet->balance ?? 0, 0, ',', '.') }}đ</span>
                </a>
                
                <a href="{{ route('user.profile') }}" class="quick-action-card group">
                    <div class="quick-action-icon bg-gradient-to-br from-blue-500/20 to-cyan-500/20 group-hover:from-blue-500/30 group-hover:to-cyan-500/30">
                        <i class="fa-solid fa-user-gear text-xl md:text-2xl text-blue-400"></i>
                    </div>
                    <span class="quick-action-label">Tài khoản</span>
                    <span class="quick-action-hint">Cài đặt</span>
                </a>
            </div>
        </div>
        
        <!-- Stats - Clear, Visual -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-8">
            <div class="glass-card p-4 md:p-5">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-pink-500/20 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-envelope text-pink-400 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-2xl md:text-3xl font-bold">{{ $stats['total_invitations'] ?? 0 }}</p>
                        <p class="text-xs md:text-sm text-white/50">Tổng số thiệp</p>
                    </div>
                </div>
            </div>
            
            <div class="glass-card p-4 md:p-5">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-green-500/20 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-check-circle text-green-400 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-2xl md:text-3xl font-bold">{{ $stats['active_invitations'] ?? 0 }}</p>
                        <p class="text-xs md:text-sm text-white/50">Đang hoạt động</p>
                    </div>
                </div>
            </div>
            
            <div class="glass-card p-4 md:p-5">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-user-check text-blue-400 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-2xl md:text-3xl font-bold">{{ $stats['total_rsvps'] ?? 0 }}</p>
                        <p class="text-xs md:text-sm text-white/50">Lượt RSVP</p>
                    </div>
                </div>
            </div>
            
            <div class="glass-card p-4 md:p-5">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/20 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-wallet text-amber-400 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-2xl md:text-3xl font-bold">{{ number_format(Auth::user()->wallet->balance ?? 0, 0, ',', '.') }}<span class="text-sm font-normal">đ</span></p>
                        <p class="text-xs md:text-sm text-white/50">Số dư ví</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Invitations with clear CTAs -->
        <div class="glass-panel rounded-2xl p-5 md:p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-semibold text-lg flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-primary-400"></i>
                    Thiệp gần đây
                </h2>
                <a href="{{ route('user.invitations.index') }}" class="text-sm text-primary-400 hover:text-primary-300 transition flex items-center gap-1">
                    Xem tất cả <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
            
            @if(isset($recentInvitations) && $recentInvitations->count() > 0)
            <div class="space-y-3">
                @foreach($recentInvitations as $invitation)
                <div class="flex flex-col md:flex-row md:items-center justify-between p-4 rounded-xl bg-white/5 hover:bg-white/10 transition gap-3">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary-500/20 to-pink-500/20 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-envelope text-primary-400"></i>
                        </div>
                        <div class="min-w-0">
                            <h3 class="font-medium truncate">{{ $invitation->title }}</h3>
                            <p class="text-xs text-white/50">{{ $invitation->template->name ?? 'N/A' }} • {{ $invitation->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 md:gap-3 ml-16 md:ml-0">
                        <span class="px-3 py-1 text-xs rounded-full {{ $invitation->status_class }}">
                            {{ $invitation->status_label }}
                        </span>
                        <a href="{{ route('user.invitations.editor', $invitation) }}" class="px-3 py-1.5 text-xs bg-primary-500/20 text-primary-400 rounded-lg hover:bg-primary-500/30 transition">
                            <i class="fa-solid fa-pen mr-1"></i> Sửa
                        </a>
                        <a href="{{ $invitation->public_url }}" target="_blank" class="px-3 py-1.5 text-xs bg-white/10 rounded-lg hover:bg-white/20 transition">
                            <i class="fa-solid fa-eye mr-1"></i> Xem
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <!-- Empty state with clear CTA -->
            <div class="text-center py-12">
                <div class="w-20 h-20 mx-auto mb-5 rounded-full bg-gradient-to-br from-primary-500/10 to-pink-500/10 flex items-center justify-center">
                    <i class="fa-solid fa-heart text-3xl text-primary-400"></i>
                </div>
                <h3 class="font-heading font-semibold text-xl mb-2">Chưa có thiệp nào 💝</h3>
                <p class="text-white/60 mb-6 max-w-sm mx-auto">
                    Bắt đầu tạo thiệp cưới online đầu tiên của bạn ngay bây giờ!
                    <br><span class="text-amber-400">🎁 Dùng thử miễn phí 2 ngày</span>
                </p>
                <a href="{{ route('user.invitations.create') }}" class="glass-btn glass-btn-lg inline-flex">
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                    Tạo thiệp đầu tiên
                </a>
            </div>
            @endif
        </div>
        
        <!-- Help Section for Low-Tech Users -->
        <div class="mt-8 glass-card p-5 md:p-6 border-l-4 border-blue-500">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="w-12 h-12 rounded-full bg-blue-500/20 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-question-circle text-xl text-blue-400"></i>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">Bạn cần hỗ trợ?</h3>
                    <p class="text-sm text-white/60 mb-3">
                        Nếu bạn gặp khó khăn trong việc tạo thiệp, hãy liên hệ với chúng tôi qua:
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <a href="https://zalo.me/0901234567" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500/20 rounded-lg text-sm hover:bg-blue-500/30 transition">
                            <i class="fa-solid fa-comments"></i> Zalo
                        </a>
                        <a href="tel:0901234567" class="inline-flex items-center gap-2 px-4 py-2 bg-green-500/20 rounded-lg text-sm hover:bg-green-500/30 transition">
                            <i class="fa-solid fa-phone"></i> Hotline
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Quick Action Cards - Big touch targets for mobile */
    .quick-action-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 1.25rem 0.75rem;
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 1rem;
        transition: all 0.3s ease;
        min-height: 140px;
    }
    .quick-action-card:hover {
        background: rgba(255,255,255,0.06);
        border-color: rgba(255,255,255,0.15);
        transform: translateY(-4px);
    }
    .quick-action-icon {
        width: 3.5rem;
        height: 3.5rem;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.75rem;
        transition: all 0.3s ease;
    }
    .quick-action-label {
        font-weight: 600;
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
    }
    .quick-action-hint {
        font-size: 0.75rem;
        color: rgba(255,255,255,0.5);
    }
    
    @media (min-width: 768px) {
        .quick-action-card {
            padding: 1.5rem 1rem;
            min-height: 160px;
        }
        .quick-action-icon {
            width: 4rem;
            height: 4rem;
        }
        .quick-action-label {
            font-size: 1rem;
        }
    }
    
    /* Gold Gradient */
    .text-gradient-gold {
        background: linear-gradient(135deg, #f59e0b, #fbbf24, #f59e0b);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>
@endpush
