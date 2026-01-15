@extends('layouts.app')

@section('title', 'Ví của tôi - Mời Bạn')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-semibold">Ví của tôi</h1>
            <p class="text-white/60 mt-1">Quản lý số dư và lịch sử giao dịch</p>
        </div>
        <a href="{{ route('user.wallet.deposit') }}" class="glass-btn mt-4 md:mt-0">
            <i class="fa-solid fa-plus mr-2"></i> Nạp tiền
        </a>
    </div>
    
    <!-- Balance Card -->
    <div class="glass-card p-8 mb-8 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-40 h-40 bg-rose-gold/20 rounded-full blur-3xl"></div>
        <div class="relative">
            <p class="text-white/60 mb-2">Số dư hiện tại</p>
            <p class="text-4xl md:text-5xl font-bold text-gradient">
                {{ number_format($balance, 0, ',', '.') }} <span class="text-2xl">₫</span>
            </p>
        </div>
    </div>
    
    <!-- Transaction History -->
    <div class="glass-card p-6">
        <h2 class="text-xl font-semibold mb-6">Lịch sử giao dịch</h2>
        
        @if($transactions->count() > 0)
            <div class="space-y-4">
                @foreach($transactions as $transaction)
                <div class="flex items-center justify-between p-4 rounded-xl bg-white/5">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center
                            {{ $transaction->type === 'deposit' ? 'bg-green-500/20' : ($transaction->type === 'refund' ? 'bg-blue-500/20' : 'bg-red-500/20') }}">
                            <i class="fa-solid {{ $transaction->type === 'deposit' ? 'fa-arrow-down text-green-400' : ($transaction->type === 'refund' ? 'fa-rotate-left text-blue-400' : 'fa-arrow-up text-red-400') }}"></i>
                        </div>
                        <div>
                            <p class="font-medium">{{ $transaction->type_label }}</p>
                            <p class="text-sm text-white/60">{{ $transaction->description }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold {{ $transaction->type_class }}">
                            {{ $transaction->formatted_amount }}
                        </p>
                        <p class="text-xs text-white/40">
                            {{ $transaction->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-white/5 flex items-center justify-center">
                    <i class="fa-solid fa-receipt text-2xl text-white/30"></i>
                </div>
                <p class="text-white/60">Chưa có giao dịch nào</p>
            </div>
        @endif
    </div>
</div>
@endsection
