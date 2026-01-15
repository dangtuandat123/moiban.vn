@extends('layouts.app')

@section('title', 'Thiệp của tôi - Mời Bạn')

@section('content')
<section class="py-8">
    <div class="container">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-heading font-bold">Thiệp của tôi</h1>
                <p class="text-white/60 mt-1">Quản lý tất cả thiệp cưới của bạn</p>
            </div>
            <a href="{{ route('user.invitations.create') }}" class="glass-btn">
                <i class="fa-solid fa-plus"></i>
                Tạo thiệp mới
            </a>
        </div>
        
        <!-- Filter Tabs -->
        <div class="flex flex-wrap gap-2 mb-6">
            <button class="filter-btn active" data-filter="all">
                Tất cả <span class="ml-1 opacity-60">({{ $invitations->count() }})</span>
            </button>
            <button class="filter-btn" data-filter="active">
                <i class="fa-solid fa-check-circle text-green-400"></i> Hoạt động
            </button>
            <button class="filter-btn" data-filter="trial">
                <i class="fa-solid fa-clock text-amber-400"></i> Dùng thử
            </button>
            <button class="filter-btn" data-filter="locked">
                <i class="fa-solid fa-lock text-red-400"></i> Đã khóa
            </button>
        </div>
        
        <!-- Invitations Grid -->
        @if($invitations->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" id="invitations-grid">
            @foreach($invitations as $invitation)
            <article class="glass-card overflow-hidden group invitation-item" data-status="{{ $invitation->status }}">
                <!-- Thumbnail -->
                <div class="aspect-[3/4] relative overflow-hidden bg-gradient-to-br from-primary-500/20 to-purple-500/20">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <i class="fa-solid fa-envelope text-4xl text-white/30 mb-3"></i>
                            <p class="font-script text-2xl text-gradient">{{ Str::limit($invitation->title, 20) }}</p>
                        </div>
                    </div>
                    
                    <!-- Status Badge -->
                    <div class="absolute top-3 right-3">
                        <x-badge :type="$invitation->status">{{ $invitation->status_label }}</x-badge>
                    </div>
                    
                    <!-- Hover Overlay -->
                    <div class="absolute inset-0 bg-black/70 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center gap-3">
                        <a href="{{ route('user.invitations.editor', $invitation) }}" class="glass-btn glass-btn-sm">
                            <i class="fa-solid fa-pen"></i>
                            Chỉnh sửa
                        </a>
                        <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank" class="glass-btn-secondary glass-btn glass-btn-sm">
                            <i class="fa-solid fa-external-link"></i>
                            Xem thiệp
                        </a>
                    </div>
                </div>
                
                <!-- Info -->
                <div class="p-4">
                    <h3 class="font-semibold mb-1 line-clamp-1">{{ $invitation->title }}</h3>
                    <p class="text-xs text-white/50 mb-3">
                        {{ $invitation->template->name ?? 'N/A' }} • 
                        {{ $invitation->created_at->format('d/m/Y') }}
                    </p>
                    
                    <!-- Stats -->
                    <div class="flex items-center gap-4 text-sm text-white/60">
                        <span title="Lượt xem">
                            <i class="fa-solid fa-eye text-blue-400"></i> 
                            {{ number_format($invitation->views_count) }}
                        </span>
                        <span title="RSVP">
                            <i class="fa-solid fa-user-check text-green-400"></i> 
                            {{ $invitation->rsvps_count ?? 0 }}
                        </span>
                        <span title="Lời chúc">
                            <i class="fa-solid fa-heart text-pink-400"></i> 
                            {{ $invitation->guestbook_entries_count ?? 0 }}
                        </span>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-white/10">
                        <a href="{{ route('user.invitations.show', $invitation) }}" class="text-sm text-primary-400 hover:text-primary-300 transition">
                            Chi tiết <i class="fa-solid fa-arrow-right ml-1"></i>
                        </a>
                        
                        @if($invitation->status === 'trial' || $invitation->status === 'locked')
                        <a href="{{ route('user.invitations.purchase', $invitation) }}" class="text-sm text-amber-400 hover:text-amber-300 transition">
                            <i class="fa-solid fa-unlock"></i> Mở khóa
                        </a>
                        @endif
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($invitations->hasPages())
        <div class="mt-8">
            {{ $invitations->links() }}
        </div>
        @endif
        
        @else
        <!-- Empty State -->
        <div class="glass-card p-12 text-center">
            <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-primary-500/10 flex items-center justify-center">
                <i class="fa-solid fa-envelope-open text-4xl text-primary-400"></i>
            </div>
            <h3 class="text-xl font-heading font-semibold mb-2">Chưa có thiệp nào</h3>
            <p class="text-white/60 mb-6">Bắt đầu tạo thiệp cưới online đầu tiên của bạn ngay bây giờ!</p>
            <a href="{{ route('user.invitations.create') }}" class="glass-btn glass-btn-lg">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
                Tạo thiệp đầu tiên
            </a>
        </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
    .filter-btn {
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 500;
        color: rgba(255,255,255,0.7);
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        cursor: pointer;
        transition: all 0.2s;
    }
    .filter-btn:hover {
        color: white;
        background: rgba(255,255,255,0.1);
    }
    .filter-btn.active {
        color: white;
        background: linear-gradient(135deg, #b76e79, #ec4899);
        border-color: transparent;
    }
    .invitation-item.hidden {
        display: none;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $('.filter-btn').on('click', function() {
            const filter = $(this).data('filter');
            
            $('.filter-btn').removeClass('active');
            $(this).addClass('active');
            
            $('.invitation-item').each(function() {
                if (filter === 'all' || $(this).data('status') === filter) {
                    $(this).removeClass('hidden');
                } else {
                    $(this).addClass('hidden');
                }
            });
        });
    });
</script>
@endpush
