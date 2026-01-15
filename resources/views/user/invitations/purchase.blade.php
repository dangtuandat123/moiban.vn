@extends('layouts.app')

@section('title', 'Mua gói - Mời Bạn')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('user.invitations.show', $invitation) }}" class="text-white/60 hover:text-white mb-4 inline-block">
            <i class="fa-solid fa-arrow-left mr-2"></i> Quay lại
        </a>
        <h1 class="text-3xl font-semibold">Chọn gói cho thiệp</h1>
        <p class="text-white/60 mt-1">{{ $invitation->title }}</p>
    </div>
    
    @if(session('error'))
    <div class="glass-card p-4 mb-6 border-l-4 border-red-500">
        <div class="flex items-center space-x-3">
            <i class="fa-solid fa-exclamation-circle text-red-400"></i>
            <p>{{ session('error') }}</p>
        </div>
    </div>
    @endif
    
    <!-- Balance Info -->
    <div class="glass-card p-4 mb-6 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center">
                <i class="fa-solid fa-wallet text-blue-400"></i>
            </div>
            <div>
                <p class="text-sm text-white/60">Số dư ví</p>
                <p class="font-semibold">{{ number_format($balance, 0, ',', '.') }} ₫</p>
            </div>
        </div>
        <a href="{{ route('user.wallet.deposit') }}" class="text-sm text-rose-gold hover:underline">
            <i class="fa-solid fa-plus mr-1"></i> Nạp thêm
        </a>
    </div>
    
    <form method="POST" action="{{ route('user.invitations.purchase.process', $invitation) }}">
        @csrf
        
        <!-- Package Selection -->
        <div class="grid md:grid-cols-2 gap-4 mb-8">
            @foreach($packages as $package)
            <label class="cursor-pointer">
                <input type="radio" name="package_id" value="{{ $package->id }}" 
                       class="hidden peer" {{ old('package_id') == $package->id ? 'checked' : '' }}>
                <div class="glass-card p-6 peer-checked:ring-2 peer-checked:ring-rose-gold transition {{ $balance < $package->price ? 'opacity-50' : '' }}">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold">{{ $package->name }}</h3>
                            <span class="text-sm px-2 py-0.5 rounded {{ $package->type === 'premium' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-green-500/20 text-green-400' }}">
                                {{ $package->type === 'premium' ? 'Premium' : 'Basic' }}
                            </span>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-gradient">{{ $package->formatted_price }}</p>
                            <p class="text-sm text-white/60">{{ $package->duration_label }}</p>
                        </div>
                    </div>
                    
                    <p class="text-sm text-white/60 mb-4">{{ $package->description }}</p>
                    
                    <!-- Features -->
                    @if($package->features)
                    <div class="flex flex-wrap gap-2">
                        @foreach($package->features as $feature)
                        <span class="text-xs px-2 py-1 rounded bg-white/10">
                            <i class="fa-solid fa-check text-green-400 mr-1"></i> {{ $feature }}
                        </span>
                        @endforeach
                    </div>
                    @endif
                    
                    @if($balance < $package->price)
                    <p class="mt-4 text-sm text-red-400">
                        <i class="fa-solid fa-exclamation-triangle mr-1"></i> Số dư không đủ
                    </p>
                    @endif
                </div>
            </label>
            @endforeach
        </div>
        
        <!-- Submit -->
        <div class="flex justify-end">
            <button type="submit" class="glass-btn px-8 py-3">
                <i class="fa-solid fa-shopping-cart mr-2"></i>
                Mua gói
            </button>
        </div>
    </form>
</div>
@endsection
