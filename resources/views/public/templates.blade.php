@extends('layouts.app')

@section('title', 'Mẫu Thiệp Cưới - Mời Bạn')
@section('description', 'Khám phá hàng trăm mẫu thiệp cưới online đẹp, chuyên nghiệp. Từ cổ điển đến hiện đại.')

@section('content')
<section class="py-12">
    <div class="container">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-heading font-bold mb-4">
                Mẫu <span class="text-gradient">Thiệp Cưới</span>
            </h1>
            <p class="text-white/60 max-w-2xl mx-auto">
                Khám phá bộ sưu tập mẫu thiệp được thiết kế bởi đội ngũ chuyên nghiệp. 
                Từ phong cách cổ điển đến hiện đại.
            </p>
        </div>
        
        <!-- Filter Tabs -->
        <div class="flex flex-wrap justify-center gap-3 mb-10" role="tablist" aria-label="Lọc mẫu thiệp">
            <button class="filter-btn active" data-filter="all" role="tab" aria-selected="true">
                Tất cả
            </button>
            <button class="filter-btn" data-filter="basic" role="tab" aria-selected="false">
                Basic
            </button>
            <button class="filter-btn" data-filter="premium" role="tab" aria-selected="false">
                Premium
            </button>
        </div>
        
        <!-- Templates Grid -->
        <div class="grid-responsive" id="templates-grid">
            @foreach($templates as $template)
            <article class="glass-card overflow-hidden group template-item" data-type="{{ $template->type }}">
                <div class="aspect-[3/4] relative overflow-hidden">
                    @php
                        $thumbnailPath = public_path('images/templates/' . $template->slug . '.png');
                        $hasThumbnail = file_exists($thumbnailPath);
                    @endphp
                    
                    @if($hasThumbnail)
                        <img src="{{ asset('images/templates/' . $template->slug . '.png') }}" 
                             alt="Thiệp {{ $template->name }}" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                             loading="lazy">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-500/20 to-purple-500/20">
                            <i class="fa-solid fa-image text-5xl text-white/30"></i>
                        </div>
                    @endif
                    
                    <!-- Badge -->
                    @if($template->type === 'premium')
                    <span class="absolute top-3 right-3 px-2 py-1 text-xs font-bold bg-gradient-to-r from-amber-500 to-yellow-400 text-black rounded-full">
                        Premium
                    </span>
                    @else
                    <span class="absolute top-3 right-3 px-2 py-1 text-xs font-bold bg-white/20 backdrop-blur text-white rounded-full">
                        Basic
                    </span>
                    @endif
                    
                    <!-- Hover Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-end pb-6 gap-3">
                        <a href="{{ route('register') }}" class="glass-btn">
                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                            Dùng mẫu này
                        </a>
                        <button class="glass-btn-ghost glass-btn glass-btn-sm preview-btn" data-template="{{ $template->slug }}">
                            <i class="fa-solid fa-eye"></i>
                            Xem trước
                        </button>
                    </div>
                </div>
                
                <div class="p-4">
                    <h3 class="font-semibold text-lg">{{ $template->name }}</h3>
                    <p class="text-sm text-white/60 mt-1 line-clamp-2">{{ $template->description }}</p>
                </div>
            </article>
            @endforeach
        </div>
        
        <!-- Empty State -->
        @if($templates->isEmpty())
        <div class="text-center py-16">
            <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-white/5 flex items-center justify-center">
                <i class="fa-solid fa-image-slash text-3xl text-white/30"></i>
            </div>
            <h3 class="text-xl font-semibold mb-2">Chưa có mẫu thiệp nào</h3>
            <p class="text-white/60">Đội ngũ đang cập nhật mẫu thiệp mới. Vui lòng quay lại sau.</p>
        </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
    .filter-btn {
        padding: var(--space-2) var(--space-5);
        border-radius: var(--radius-full);
        font-size: var(--text-sm);
        font-weight: 500;
        color: var(--color-text-secondary);
        background: var(--color-surface-glass);
        border: 1px solid var(--color-border-subtle);
        backdrop-filter: blur(10px);
        cursor: pointer;
        transition: all var(--transition-fast);
    }
    .filter-btn:hover {
        color: var(--color-text-primary);
        background: var(--color-surface-glass-hover);
    }
    .filter-btn.active {
        color: white;
        background: linear-gradient(135deg, var(--color-primary-500), var(--color-accent-pink));
        border-color: transparent;
    }
    .template-item.hidden {
        display: none;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Filter functionality
        $('.filter-btn').on('click', function() {
            const filter = $(this).data('filter');
            
            // Update button states
            $('.filter-btn').removeClass('active').attr('aria-selected', 'false');
            $(this).addClass('active').attr('aria-selected', 'true');
            
            // Filter templates
            $('.template-item').each(function() {
                if (filter === 'all' || $(this).data('type') === filter) {
                    $(this).removeClass('hidden');
                } else {
                    $(this).addClass('hidden');
                }
            });
        });
    });
</script>
@endpush
