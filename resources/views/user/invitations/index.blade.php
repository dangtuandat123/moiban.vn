@extends('layouts.app')

@section('title', 'Thiệp của tôi - Mời Bạn')

@section('content')
<section class="py-6 md:py-8">
    <div class="container">
        <!-- Header - Clear and Friendly -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <div class="flex items-center gap-2 text-sm text-white/60 mb-2">
                    <a href="{{ route('user.dashboard') }}" class="hover:text-white transition">
                        <i class="fa-solid fa-home"></i> Dashboard
                    </a>
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                    <span>Thiệp của tôi</span>
                </div>
                <h1 class="text-2xl md:text-3xl font-heading font-bold">📨 Thiệp của tôi</h1>
                <p class="text-white/60 mt-1">Xem và quản lý tất cả thiệp cưới của bạn</p>
            </div>
            <a href="{{ route('user.invitations.create') }}" class="glass-btn glass-btn-lg flex items-center justify-center gap-2">
                <i class="fa-solid fa-plus"></i>
                <span>Tạo thiệp mới</span>
            </a>
        </div>
        
        <!-- Simple Filter - Easy to understand -->
        @php
            $activeCount = $invitations->where('status', 'active')->count();
            $trialCount = $invitations->where('status', 'trial')->count();
            $lockedCount = $invitations->where('status', 'locked')->count();
        @endphp
        <div class="glass-card p-4 mb-6">
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-sm text-white/60 mr-2">Lọc theo:</span>
                <button class="filter-btn active" data-filter="all">
                    Tất cả ({{ $invitations->count() }})
                </button>
                <button class="filter-btn" data-filter="active">
                    <i class="fa-solid fa-check-circle text-green-400"></i> Hoạt động ({{ $activeCount }})
                </button>
                <button class="filter-btn" data-filter="trial">
                    <i class="fa-solid fa-gift text-amber-400"></i> Dùng thử ({{ $trialCount }})
                </button>
                <button class="filter-btn" data-filter="locked">
                    <i class="fa-solid fa-lock text-red-400"></i> Đã khóa ({{ $lockedCount }})
                </button>
            </div>
        </div>
        
        @if($invitations->count() > 0)
        <!-- Invitations List - Clear Cards with Big Buttons -->
        <div class="space-y-4" id="invitations-list">
            @foreach($invitations as $invitation)
            <article class="invitation-card glass-card overflow-hidden" data-status="{{ $invitation->status }}">
                <div class="flex flex-col md:flex-row">
                    <!-- Left: Visual -->
                    <div class="md:w-48 lg:w-56 flex-shrink-0">
                        <div class="aspect-[4/3] md:aspect-[3/4] bg-gradient-to-br from-primary-500/20 to-purple-500/20 flex items-center justify-center relative">
                            <div class="text-center p-4">
                                <i class="fa-solid fa-envelope text-3xl md:text-4xl text-white/30 mb-2"></i>
                                <p class="font-script text-xl md:text-2xl text-gradient line-clamp-2">
                                    {{ Str::limit($invitation->title, 15) }}
                                </p>
                            </div>
                            <!-- Status Badge -->
                            <div class="absolute top-3 right-3">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium rounded-full {{ $invitation->status_class }}">
                                    @if($invitation->status === 'active')
                                        <i class="fa-solid fa-check-circle"></i>
                                    @elseif($invitation->status === 'trial')
                                        <i class="fa-solid fa-gift"></i>
                                    @else
                                        <i class="fa-solid fa-lock"></i>
                                    @endif
                                    {{ $invitation->status_label }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right: Info & Actions -->
                    <div class="flex-1 p-4 md:p-5 flex flex-col">
                        <!-- Title & Meta -->
                        <div class="mb-4">
                            <h3 class="font-semibold text-lg mb-1">{{ $invitation->title }}</h3>
                            <p class="text-sm text-white/60">
                                <i class="fa-solid fa-palette mr-1"></i> {{ $invitation->template->name ?? 'N/A' }}
                                <span class="mx-2">•</span>
                                <i class="fa-solid fa-calendar mr-1"></i> {{ $invitation->created_at->format('d/m/Y') }}
                            </p>
                        </div>
                        
                        <!-- Stats Row -->
                        <div class="flex flex-wrap gap-4 mb-4 text-sm">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-blue-500/20 flex items-center justify-center">
                                    <i class="fa-solid fa-eye text-blue-400"></i>
                                </div>
                                <div>
                                    <p class="font-semibold">{{ number_format($invitation->view_count) }}</p>
                                    <p class="text-xs text-white/50">Lượt xem</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-green-500/20 flex items-center justify-center">
                                    <i class="fa-solid fa-user-check text-green-400"></i>
                                </div>
                                <div>
                                    <p class="font-semibold">{{ $invitation->rsvps_count ?? 0 }}</p>
                                    <p class="text-xs text-white/50">RSVP</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-pink-500/20 flex items-center justify-center">
                                    <i class="fa-solid fa-heart text-pink-400"></i>
                                </div>
                                <div>
                                    <p class="font-semibold">{{ $invitation->guestbook_entries_count ?? 0 }}</p>
                                    <p class="text-xs text-white/50">Lời chúc</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons - Big and Clear -->
                        <div class="flex flex-wrap gap-2 mt-auto pt-4 border-t border-white/10">
                            <a href="{{ route('user.invitations.editor', $invitation) }}" class="action-btn action-btn-primary">
                                <i class="fa-solid fa-pen"></i>
                                <span>Chỉnh sửa</span>
                            </a>
                            <a href="{{ $invitation->public_url }}" target="_blank" class="action-btn action-btn-secondary">
                                <i class="fa-solid fa-eye"></i>
                                <span>Xem thiệp</span>
                            </a>
                            <a href="{{ route('user.invitations.show', $invitation) }}" class="action-btn action-btn-ghost">
                                <i class="fa-solid fa-chart-bar"></i>
                                <span>Thống kê</span>
                            </a>
                            <button type="button" class="action-btn action-btn-ghost share-btn" 
                                    data-url="{{ $invitation->public_url }}" 
                                    data-title="{{ $invitation->title }}">
                                <i class="fa-solid fa-share-nodes"></i>
                                <span>Chia sẻ</span>
                            </button>
                            
                            @if($invitation->status === 'trial' || $invitation->status === 'locked')
                            <a href="{{ route('user.invitations.purchase', $invitation) }}" class="action-btn action-btn-warning ml-auto">
                                <i class="fa-solid fa-unlock"></i>
                                <span>Mở khóa</span>
                            </a>
                            @endif
                        </div>
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
        <!-- Empty State - Friendly and Encouraging -->
        <div class="glass-card p-8 md:p-12 text-center">
            <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gradient-to-br from-pink-500/20 to-purple-500/20 flex items-center justify-center">
                <i class="fa-solid fa-heart text-5xl text-pink-400 animate-pulse"></i>
            </div>
            <h2 class="text-2xl font-heading font-bold mb-3">Chưa có thiệp nào 💝</h2>
            <p class="text-white/60 max-w-md mx-auto mb-8">
                Bắt đầu tạo thiệp cưới online đẹp và chuyên nghiệp cho ngày trọng đại của bạn!
                <br><br>
                <span class="text-amber-400">🎁 Dùng thử MIỄN PHÍ 2 ngày</span>
            </p>
            
            <a href="{{ route('user.invitations.create') }}" class="glass-btn glass-btn-lg inline-flex items-center gap-3">
                <i class="fa-solid fa-wand-magic-sparkles text-xl"></i>
                <span class="text-lg">Tạo thiệp đầu tiên</span>
            </a>
            
            <div class="mt-8 pt-8 border-t border-white/10 text-sm text-white/50">
                <p>Chỉ mất 2 phút để tạo thiệp • Không cần kỹ năng thiết kế</p>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Filter Buttons */
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
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
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
    
    /* Invitation Card */
    .invitation-card {
        transition: all 0.3s ease;
        animation: fadeIn 0.3s ease;
    }
    .invitation-card:hover {
        transform: translateY(-2px);
        border-color: rgba(255,255,255,0.2);
    }
    .invitation-card.hidden {
        display: none;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Action Buttons - Big touch targets */
    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.625rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 0.75rem;
        transition: all 0.2s;
    }
    .action-btn-primary {
        background: linear-gradient(135deg, #b76e79, #ec4899);
        color: white;
    }
    .action-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(183,110,121,0.3);
    }
    .action-btn-secondary {
        background: rgba(255,255,255,0.1);
        color: white;
        border: 1px solid rgba(255,255,255,0.2);
    }
    .action-btn-secondary:hover {
        background: rgba(255,255,255,0.15);
    }
    .action-btn-ghost {
        background: transparent;
        color: rgba(255,255,255,0.7);
    }
    .action-btn-ghost:hover {
        background: rgba(255,255,255,0.05);
        color: white;
    }
    .action-btn-warning {
        background: linear-gradient(135deg, #f59e0b, #fbbf24);
        color: #1a1a1a;
    }
    .action-btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(245,158,11,0.3);
    }
    
    /* Font Script */
    .font-script {
        font-family: 'Great Vibes', cursive;
    }
    
    @media (max-width: 767px) {
        .action-btn {
            padding: 0.75rem 1rem;
            flex: 1 1 calc(50% - 0.25rem);
            justify-content: center;
        }
        .action-btn-warning {
            flex: 1 1 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Filter functionality
        $('.filter-btn').on('click', function() {
            const filter = $(this).data('filter');
            
            $('.filter-btn').removeClass('active');
            $(this).addClass('active');
            
            $('.invitation-card').each(function() {
                if (filter === 'all' || $(this).data('status') === filter) {
                    $(this).removeClass('hidden');
                } else {
                    $(this).addClass('hidden');
                }
            });
        });
        
        // Share functionality
        $('.share-btn').on('click', function() {
            const url = $(this).data('url');
            const title = $(this).data('title');
            
            // Try Web Share API first (mobile friendly)
            if (navigator.share) {
                navigator.share({
                    title: title,
                    text: 'Mời bạn tham dự: ' + title,
                    url: url
                }).catch(() => {});
            } else {
                // Fallback: copy to clipboard
                navigator.clipboard.writeText(url).then(() => {
                    showToast('✅ Đã copy link thiệp!', 'success');
                }).catch(() => {
                    // Final fallback
                    prompt('Copy link này:', url);
                });
            }
        });
    });
</script>
@endpush
