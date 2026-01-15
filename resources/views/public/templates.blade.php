@extends('layouts.app')

@section('title', 'Mẫu thiệp - Mời Bạn')
@section('description', 'Khám phá hàng trăm mẫu thiệp cưới online đẹp, chuyên nghiệp. Chọn mẫu phù hợp và bắt đầu tạo thiệp ngay.')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-semibold mb-4">Mẫu thiệp cưới</h1>
        <p class="text-white/60 text-lg">Chọn mẫu phù hợp với phong cách của bạn</p>
    </div>
    
    <!-- Filter Tabs -->
    <div class="flex justify-center space-x-4 mb-8">
        <button class="tab-btn active px-6 py-2 rounded-full bg-rose-gold" data-filter="all">Tất cả</button>
        <button class="tab-btn px-6 py-2 rounded-full bg-white/10" data-filter="basic">Basic</button>
        <button class="tab-btn px-6 py-2 rounded-full bg-white/10" data-filter="premium">Premium</button>
    </div>
    
    <!-- Templates Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8" id="templates-grid">
        @foreach($templates as $template)
        <div class="template-card glass-card overflow-hidden group" data-type="{{ $template->type }}">
            <div class="aspect-[3/4] bg-gradient-to-br from-rose-gold/20 to-purple-500/20 relative overflow-hidden">
                @php
                    $thumbnailPath = 'images/templates/' . $template->slug . '.png';
                @endphp
                @if(file_exists(public_path($thumbnailPath)))
                    <img src="{{ asset($thumbnailPath) }}" alt="{{ $template->name }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <i class="fa-solid fa-heart text-6xl text-white/10"></i>
                    </div>
                @endif
                
                <!-- Overlay on hover -->
                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                    <a href="{{ route('register') }}" class="glass-btn">Sử dụng mẫu này</a>
                </div>
                
                <!-- Badge -->
                <span class="absolute top-4 right-4 px-3 py-1 text-xs rounded-full {{ $template->type === 'premium' ? 'bg-yellow-500 text-black' : 'bg-green-500 text-white' }}">
                    {{ $template->type === 'premium' ? '★ Premium' : 'Basic' }}
                </span>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-semibold mb-2">{{ $template->name }}</h3>
                <p class="text-white/60 text-sm mb-4">{{ Str::limit($template->description, 80) }}</p>
                <div class="flex flex-wrap gap-2">
                    @foreach($template->supported_widgets as $widget)
                    <span class="text-xs px-2 py-1 rounded bg-white/10">{{ $widget }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('.tab-btn').on('click', function() {
        $('.tab-btn').removeClass('active bg-rose-gold').addClass('bg-white/10');
        $(this).addClass('active bg-rose-gold').removeClass('bg-white/10');
        
        const filter = $(this).data('filter');
        if (filter === 'all') {
            $('.template-card').show();
        } else {
            $('.template-card').hide();
            $(`.template-card[data-type="${filter}"]`).show();
        }
    });
</script>
@endpush
