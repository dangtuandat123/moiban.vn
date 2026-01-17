@extends('layouts.app')

@section('title', 'Ví của tôi - Mời Bạn')

@section('content')
<section class="py-6 md:py-8">
    <div class="container max-w-4xl">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-sm text-white/60 mb-4">
            <a href="{{ route('user.dashboard') }}" class="hover:text-white transition">
                <i class="fa-solid fa-home"></i> Dashboard
            </a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span>Ví của tôi</span>
        </div>
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-heading font-bold">💰 Ví của tôi</h1>
                <p class="text-white/60 mt-1">Quản lý số dư và lịch sử giao dịch</p>
            </div>
            <a href="{{ route('user.wallet.deposit') }}" class="glass-btn glass-btn-lg flex items-center justify-center gap-2">
                <i class="fa-solid fa-plus"></i>
                <span>Nạp tiền</span>
            </a>
        </div>
        
        <!-- Balance Card - Big and Clear -->
        <div class="glass-card p-6 md:p-8 mb-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-48 h-48 bg-amber-500/20 rounded-full blur-3xl -z-0"></div>
            <div class="relative z-10">
                <p class="text-white/60 mb-2 flex items-center gap-2">
                    <i class="fa-solid fa-wallet text-amber-400"></i>
                    Số dư hiện tại
                </p>
                <p class="text-4xl md:text-5xl font-bold text-gradient-gold mb-4">
                    {{ number_format($balance, 0, ',', '.') }} <span class="text-2xl">₫</span>
                </p>
                
                @if($balance < 50000)
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500/20 rounded-lg text-sm text-amber-300">
                    <i class="fa-solid fa-info-circle"></i>
                    <span>Số dư thấp - Nạp thêm để mua gói thiệp</span>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="grid grid-cols-2 gap-4 mb-8">
            <a href="{{ route('user.wallet.deposit') }}" class="glass-card p-5 text-center hover:border-amber-500/50 transition group">
                <div class="w-14 h-14 mx-auto mb-3 rounded-full bg-gradient-to-br from-amber-500/20 to-orange-500/20 flex items-center justify-center group-hover:scale-110 transition">
                    <i class="fa-solid fa-qrcode text-2xl text-amber-400"></i>
                </div>
                <span class="font-semibold">Nạp tiền qua QR</span>
                <p class="text-xs text-white/50 mt-1">Quét mã VietQR</p>
            </a>
            
            <a href="{{ route('user.invitations.index') }}" class="glass-card p-5 text-center hover:border-primary-500/50 transition group">
                <div class="w-14 h-14 mx-auto mb-3 rounded-full bg-gradient-to-br from-pink-500/20 to-purple-500/20 flex items-center justify-center group-hover:scale-110 transition">
                    <i class="fa-solid fa-shopping-cart text-2xl text-pink-400"></i>
                </div>
                <span class="font-semibold">Mua gói thiệp</span>
                <p class="text-xs text-white/50 mt-1">Mở khóa tính năng</p>
            </a>
        </div>
        
        <!-- Transaction History -->
        <div class="glass-card p-5 md:p-6">
            <h2 class="text-lg font-semibold mb-5 flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-blue-400"></i>
                Lịch sử giao dịch
            </h2>
            
            @if($transactions->count() > 0)
            <div class="space-y-3">
                @foreach($transactions as $transaction)
                <div class="flex items-center justify-between p-4 rounded-xl bg-white/5 hover:bg-white/10 transition">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0
                            {{ $transaction->type === 'deposit' ? 'bg-green-500/20' : ($transaction->type === 'refund' ? 'bg-blue-500/20' : 'bg-red-500/20') }}">
                            @if($transaction->type === 'deposit')
                                <i class="fa-solid fa-arrow-down text-xl text-green-400"></i>
                            @elseif($transaction->type === 'refund')
                                <i class="fa-solid fa-rotate-left text-xl text-blue-400"></i>
                            @else
                                <i class="fa-solid fa-arrow-up text-xl text-red-400"></i>
                            @endif
                        </div>
                        <div>
                            <p class="font-medium">{{ $transaction->type_label }}</p>
                            <p class="text-sm text-white/60">{{ $transaction->description }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-lg {{ $transaction->type_class }}">
                            {{ $transaction->formatted_amount }}
                        </p>
                        <p class="text-xs text-white/40">
                            {{ $transaction->created_at->format('d/m/Y') }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <div class="w-20 h-20 mx-auto mb-5 rounded-full bg-white/5 flex items-center justify-center">
                    <i class="fa-solid fa-receipt text-3xl text-white/30"></i>
                </div>
                <h3 class="font-semibold text-lg mb-2">Chưa có giao dịch nào</h3>
                <p class="text-white/60 mb-5">Nạp tiền để bắt đầu sử dụng dịch vụ</p>
                <a href="{{ route('user.wallet.deposit') }}" class="glass-btn inline-flex">
                    <i class="fa-solid fa-plus"></i>
                    Nạp tiền ngay
                </a>
            </div>
            @endif
        </div>
        
        <!-- Help Section -->
        <div class="mt-6 glass-card p-5 border-l-4 border-blue-500">
            <div class="flex gap-4">
                <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-question-circle text-blue-400"></i>
                </div>
                <div>
                    <h3 class="font-semibold mb-1">Cần hỗ trợ nạp tiền?</h3>
                    <p class="text-sm text-white/60 mb-3">
                        Nếu gặp vấn đề khi nạp tiền, liên hệ ngay với chúng tôi để được hỗ trợ.
                    </p>
                    <a href="https://zalo.me/0901234567" target="_blank" class="inline-flex items-center gap-2 text-sm text-blue-400 hover:text-blue-300 transition">
                        <i class="fa-solid fa-comments"></i> Liên hệ Zalo hỗ trợ
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .text-gradient-gold {
        background: linear-gradient(135deg, #f59e0b, #fbbf24, #f59e0b);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>
@endpush
