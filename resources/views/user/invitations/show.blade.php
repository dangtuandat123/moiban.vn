@extends('layouts.app')

@section('title', 'Chi tiết thiệp - Mời Bạn')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ route('user.invitations.index') }}" class="text-white/60 hover:text-white mb-2 inline-block">
                <i class="fa-solid fa-arrow-left mr-2"></i> Quay lại
            </a>
            <h1 class="text-2xl font-semibold">{{ $invitation->title }}</h1>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('user.invitations.editor', $invitation) }}" class="glass-btn">
                <i class="fa-solid fa-pen mr-2"></i> Chỉnh sửa
            </a>
            <a href="{{ $invitation->public_url }}" target="_blank" class="px-4 py-2 rounded-lg bg-white/10 hover:bg-white/20" aria-label="Xem thiệp">
                <i class="fa-solid fa-external-link"></i>
            </a>
            <form action="{{ route('user.invitations.destroy', $invitation) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc muốn xóa thiệp này? Hành động này không thể hoàn tác.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 rounded-lg bg-red-500/20 hover:bg-red-500/40 text-red-400 transition" aria-label="Xóa thiệp">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </form>
        </div>
    </div>
    
    <!-- Status & Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="glass-card p-4 text-center">
            <p class="text-2xl font-bold">{{ number_format($invitation->view_count) }}</p>
            <p class="text-sm text-white/60">Lượt xem</p>
        </div>
        <div class="glass-card p-4 text-center">
            <span class="px-3 py-1 rounded-full {{ $invitation->status_class }}">{{ $invitation->status_label }}</span>
        </div>
        <div class="glass-card p-4 text-center">
            <p class="text-sm text-white/60">RSVP</p>
            <p class="text-xl font-bold">{{ $invitation->rsvps->where('status', 'attending')->sum('attendees_count') }}</p>
        </div>
        <div class="glass-card p-4 text-center">
            <p class="text-sm text-white/60">Lời chúc</p>
            <p class="text-xl font-bold">{{ $invitation->guestbookEntries->count() }}</p>
        </div>
    </div>
    
    @if($invitation->isTrial() || $invitation->isLocked())
    <!-- Purchase CTA -->
    <div class="glass-card p-6 mb-8 border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-semibold">{{ $invitation->isTrial() ? 'Đang dùng thử' : 'Thiệp đã bị khóa' }}</h3>
                <p class="text-sm text-white/60">Mua gói để loại bỏ watermark và mở khóa đầy đủ tính năng</p>
            </div>
            <a href="{{ route('user.invitations.purchase', $invitation) }}" class="glass-btn">
                <i class="fa-solid fa-shopping-cart mr-2"></i> Mua gói
            </a>
        </div>
    </div>
    @endif
    
    <div class="grid md:grid-cols-2 gap-6">
        <!-- Thông tin thiệp -->
        <div class="glass-card p-6">
            <h2 class="text-lg font-semibold mb-4">Thông tin</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-white/60">Template</span>
                    <span>{{ $invitation->template?->name ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-white/60">Ngày tạo</span>
                    <span>{{ $invitation->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-white/60">Link thiệp</span>
                    <a href="{{ $invitation->public_url }}" target="_blank" class="text-primary-400">{{ $invitation->slug }}</a>
                </div>
            </div>
        </div>
        
        <!-- RSVP List -->
        <div class="glass-card p-6">
            <h2 class="text-lg font-semibold mb-4">Danh sách RSVP</h2>
            <div class="space-y-2 max-h-60 overflow-y-auto">
                @forelse($invitation->rsvps as $rsvp)
                <div class="flex items-center justify-between p-2 rounded bg-white/5">
                    <div>
                        <p class="font-medium">{{ $rsvp->guest_name }}</p>
                        <p class="text-xs text-white/60">{{ $rsvp->attendees_count }} người</p>
                    </div>
                    <i class="{{ $rsvp->status_icon }}"></i>
                </div>
                @empty
                <p class="text-white/60 text-center py-4">Chưa có RSVP</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
