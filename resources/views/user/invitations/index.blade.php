@extends('layouts.app')

@section('title', 'Thiệp của tôi - Mời Bạn')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-semibold">Thiệp của tôi</h1>
            <p class="text-white/60 mt-1">Quản lý tất cả thiệp cưới của bạn</p>
        </div>
        <a href="{{ route('user.invitations.create') }}" class="glass-btn mt-4 md:mt-0">
            <i class="fa-solid fa-plus mr-2"></i> Tạo thiệp mới
        </a>
    </div>
    
    @if($invitations->count() > 0)
        <!-- Invitations Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($invitations as $invitation)
            <div class="glass-card overflow-hidden group">
                <!-- Thumbnail -->
                <div class="aspect-video bg-gradient-to-br from-rose-gold/20 to-purple-500/20 flex items-center justify-center relative">
                    <i class="fa-solid fa-heart text-4xl text-white/20"></i>
                    
                    <!-- Status Badge -->
                    <span class="absolute top-3 right-3 px-3 py-1 text-xs rounded-full {{ $invitation->status_class }} text-white">
                        {{ $invitation->status_label }}
                    </span>
                    
                    <!-- Watermark indicator -->
                    @if($invitation->shouldShowWatermark())
                    <span class="absolute top-3 left-3 px-2 py-1 text-xs rounded bg-yellow-500/80 text-white">
                        <i class="fa-solid fa-droplet mr-1"></i> Watermark
                    </span>
                    @endif
                </div>
                
                <!-- Content -->
                <div class="p-5">
                    <h3 class="text-lg font-semibold mb-1 truncate">{{ $invitation->title }}</h3>
                    <p class="text-sm text-white/60 mb-3">{{ $invitation->couple_name }}</p>
                    
                    <div class="flex items-center justify-between text-sm text-white/50 mb-4">
                        <span><i class="fa-solid fa-eye mr-1"></i> {{ number_format($invitation->view_count) }} lượt xem</span>
                        <span>{{ $invitation->template->name }}</span>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('user.invitations.editor', $invitation) }}" 
                           class="flex-1 text-center py-2 px-3 rounded-lg bg-white/10 hover:bg-white/20 transition text-sm">
                            <i class="fa-solid fa-pen-to-square mr-1"></i> Chỉnh sửa
                        </a>
                        <a href="{{ $invitation->public_url }}" 
                           target="_blank"
                           class="py-2 px-3 rounded-lg bg-white/10 hover:bg-white/20 transition text-sm">
                            <i class="fa-solid fa-external-link-alt"></i>
                        </a>
                        @if($invitation->isTrial() || $invitation->isLocked())
                        <a href="{{ route('user.invitations.purchase', $invitation) }}" 
                           class="py-2 px-3 rounded-lg bg-rose-gold hover:bg-rose-gold/80 transition text-sm">
                            <i class="fa-solid fa-shopping-cart"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
            {{ $invitations->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="glass-card p-12 text-center">
            <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-white/5 flex items-center justify-center">
                <i class="fa-solid fa-envelope-open text-4xl text-white/30"></i>
            </div>
            <h3 class="text-xl font-semibold mb-2">Chưa có thiệp nào</h3>
            <p class="text-white/60 mb-6">Bắt đầu tạo thiệp cưới đầu tiên của bạn ngay bây giờ!</p>
            <a href="{{ route('user.invitations.create') }}" class="glass-btn inline-block">
                <i class="fa-solid fa-plus mr-2"></i> Tạo thiệp mới
            </a>
        </div>
    @endif
</div>
@endsection
