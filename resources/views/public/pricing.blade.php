@extends('layouts.app')

@section('title', 'Bảng giá - Mời Bạn')
@section('description', 'Bảng giá các gói thiệp cưới online. Từ gói Basic đến Premium với đầy đủ tính năng.')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-semibold mb-4">Bảng giá</h1>
        <p class="text-white/60 text-lg">Chọn gói phù hợp với nhu cầu của bạn</p>
    </div>
    
    <!-- Filter Tabs -->
    <div class="flex justify-center space-x-4 mb-8">
        <button class="tab-btn active px-6 py-2 rounded-full bg-rose-gold" data-filter="all">Tất cả</button>
        <button class="tab-btn px-6 py-2 rounded-full bg-white/10" data-filter="basic">Basic</button>
        <button class="tab-btn px-6 py-2 rounded-full bg-white/10" data-filter="premium">Premium</button>
    </div>
    
    <!-- Packages Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="packages-grid">
        @foreach($packages as $package)
        <div class="package-card glass-card p-6 relative {{ $package->isLifetime() ? 'ring-2 ring-rose-gold' : '' }}" data-type="{{ $package->type }}">
            @if($package->isLifetime())
            <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                <span class="px-4 py-1 text-xs rounded-full bg-rose-gold text-white">Phổ biến nhất</span>
            </div>
            @endif
            
            <div class="text-center mb-6">
                <span class="inline-block mb-2 px-3 py-1 text-xs rounded-full {{ $package->type === 'premium' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-green-500/20 text-green-400' }}">
                    {{ $package->type === 'premium' ? '★ Premium' : 'Basic' }}
                </span>
                <h3 class="text-xl font-semibold">{{ $package->name }}</h3>
                <p class="text-3xl font-bold text-gradient mt-2">{{ $package->formatted_price }}</p>
                <p class="text-sm text-white/60">{{ $package->duration_label }}</p>
            </div>
            
            <p class="text-sm text-white/60 text-center mb-6">{{ $package->description }}</p>
            
            @if($package->features)
            <ul class="space-y-2 mb-6">
                @foreach($package->features as $feature)
                <li class="flex items-center text-sm">
                    <i class="fa-solid fa-check text-green-400 mr-2"></i> {{ $feature }}
                </li>
                @endforeach
            </ul>
            @endif
            
            <a href="{{ route('register') }}" class="block text-center py-3 rounded-lg {{ $package->isLifetime() ? 'glass-btn' : 'bg-white/10 hover:bg-white/20' }} transition">
                Bắt đầu ngay
            </a>
        </div>
        @endforeach
    </div>
    
    <!-- FAQ Section -->
    <div class="mt-20 max-w-3xl mx-auto">
        <h2 class="text-2xl font-semibold text-center mb-8">Câu hỏi thường gặp</h2>
        
        <div class="space-y-4">
            <div class="glass-card p-6">
                <h3 class="font-semibold mb-2">Dùng thử miễn phí như thế nào?</h3>
                <p class="text-white/60 text-sm">Bạn có 2 ngày dùng thử miễn phí với đầy đủ tính năng. Thiệp sẽ có watermark trong thời gian này.</p>
            </div>
            <div class="glass-card p-6">
                <h3 class="font-semibold mb-2">Thanh toán bằng cách nào?</h3>
                <p class="text-white/60 text-sm">Chúng tôi hỗ trợ thanh toán qua VietQR - quét mã với mọi ứng dụng ngân hàng.</p>
            </div>
            <div class="glass-card p-6">
                <h3 class="font-semibold mb-2">Gói vĩnh viễn là gì?</h3>
                <p class="text-white/60 text-sm">Thiệp sẽ hoạt động mãi mãi, không bao giờ hết hạn. Phù hợp để lưu giữ kỷ niệm.</p>
            </div>
        </div>
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
            $('.package-card').show();
        } else {
            $('.package-card').hide();
            $(`.package-card[data-type="${filter}"]`).show();
        }
    });
</script>
@endpush
