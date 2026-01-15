@extends('layouts.admin')

@section('title', 'Chi tiết Thiệp - Admin')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.invitations.index') }}" class="text-white/60 hover:text-white">
        <i class="fa-solid fa-arrow-left mr-2"></i> Quay lại
    </a>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <!-- Info -->
    <div class="glass-card p-6">
        <h2 class="text-lg font-semibold mb-4">Thông tin thiệp</h2>
        <div class="space-y-4">
            <div>
                <p class="text-sm text-white/60">Tiêu đề</p>
                <p class="font-medium">{{ $invitation->title }}</p>
            </div>
            <div>
                <p class="text-sm text-white/60">Slug</p>
                <p><code class="bg-white/10 px-2 py-1 rounded">{{ $invitation->slug }}</code></p>
            </div>
            <div>
                <p class="text-sm text-white/60">User</p>
                <p>{{ $invitation->user->name ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm text-white/60">Template</p>
                <p>{{ $invitation->template->name ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm text-white/60">Status</p>
                <span class="px-2 py-1 text-xs rounded {{ $invitation->status_class }}">{{ $invitation->status_label }}</span>
            </div>
            <div>
                <p class="text-sm text-white/60">Lượt xem</p>
                <p class="text-xl font-bold">{{ number_format($invitation->view_count) }}</p>
            </div>
            <div>
                <a href="{{ $invitation->public_url }}" target="_blank" class="glass-btn inline-block">
                    <i class="fa-solid fa-external-link mr-2"></i> Xem thiệp
                </a>
            </div>
        </div>
    </div>
    
    <!-- Subscriptions -->
    <div class="glass-card p-6">
        <h2 class="text-lg font-semibold mb-4">Lịch sử mua gói</h2>
        <div class="space-y-3">
            @forelse($invitation->subscriptions as $sub)
            <div class="p-3 rounded-lg bg-white/5">
                <p class="font-medium">{{ $sub->package->name ?? 'N/A' }}</p>
                <p class="text-sm text-green-400">{{ number_format($sub->amount_paid, 0, ',', '.') }}đ</p>
                <p class="text-xs text-white/60">{{ $sub->created_at->format('d/m/Y H:i') }}</p>
            </div>
            @empty
            <p class="text-white/60 text-center py-4">Chưa mua gói</p>
            @endforelse
        </div>
    </div>
    
    <!-- RSVPs & Guestbook -->
    <div class="space-y-6">
        <div class="glass-card p-6">
            <h2 class="text-lg font-semibold mb-4">RSVP ({{ $invitation->rsvps->count() }})</h2>
            <div class="space-y-2 max-h-40 overflow-y-auto">
                @forelse($invitation->rsvps as $rsvp)
                <div class="flex items-center justify-between text-sm">
                    <span>{{ $rsvp->guest_name }}</span>
                    <span class="{{ $rsvp->status === 'attending' ? 'text-green-400' : 'text-red-400' }}">
                        {{ $rsvp->status_label }}
                    </span>
                </div>
                @empty
                <p class="text-white/60 text-sm">Chưa có RSVP</p>
                @endforelse
            </div>
        </div>
        
        <div class="glass-card p-6">
            <h2 class="text-lg font-semibold mb-4">Lời chúc ({{ $invitation->guestbookEntries->count() }})</h2>
            <div class="space-y-2 max-h-40 overflow-y-auto">
                @forelse($invitation->guestbookEntries as $entry)
                <div class="text-sm">
                    <p class="font-medium">{{ $entry->author_name }}</p>
                    <p class="text-white/60">{{ Str::limit($entry->message, 50) }}</p>
                </div>
                @empty
                <p class="text-white/60 text-sm">Chưa có lời chúc</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
