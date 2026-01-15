{{-- 
Pagination Component (Laravel Tailwind)
Override Laravel's default pagination
--}}

@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
    <div class="flex justify-between flex-1 sm:hidden">
        @if ($paginator->onFirstPage())
            <span class="glass-btn-secondary glass-btn opacity-50 cursor-not-allowed">
                <i class="fa-solid fa-chevron-left"></i> Trước
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="glass-btn-secondary glass-btn">
                <i class="fa-solid fa-chevron-left"></i> Trước
            </a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="glass-btn-secondary glass-btn">
                Sau <i class="fa-solid fa-chevron-right"></i>
            </a>
        @else
            <span class="glass-btn-secondary glass-btn opacity-50 cursor-not-allowed">
                Sau <i class="fa-solid fa-chevron-right"></i>
            </span>
        @endif
    </div>

    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-white/60">
                Hiển thị
                <span class="font-medium">{{ $paginator->firstItem() }}</span>
                đến
                <span class="font-medium">{{ $paginator->lastItem() }}</span>
                trong tổng số
                <span class="font-medium">{{ $paginator->total() }}</span>
                kết quả
            </p>
        </div>

        <div>
            <span class="inline-flex rounded-xl overflow-hidden glass-panel">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span class="px-3 py-2 text-white/30 cursor-not-allowed">
                        <i class="fa-solid fa-chevron-left"></i>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 text-white/70 hover:text-white hover:bg-white/10 transition">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span class="px-3 py-2 text-white/50">{{ $element }}</span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="px-3 py-2 font-medium bg-primary-500/30 text-white">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-3 py-2 text-white/70 hover:text-white hover:bg-white/10 transition">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 text-white/70 hover:text-white hover:bg-white/10 transition">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                @else
                    <span class="px-3 py-2 text-white/30 cursor-not-allowed">
                        <i class="fa-solid fa-chevron-right"></i>
                    </span>
                @endif
            </span>
        </div>
    </div>
</nav>
@endif
