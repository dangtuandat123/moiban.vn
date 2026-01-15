@extends('layouts.app')

@section('title', 'Bảng giá - Mời Bạn')
@section('description', 'Các gói dịch vụ thiệp cưới online phù hợp với mọi ngân sách.')

@section('content')
<section class="py-12">
    <div class="container">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-heading font-bold mb-4">
                Bảng <span class="text-gradient">giá</span>
            </h1>
            <p class="text-white/60 max-w-2xl mx-auto">
                Chọn gói phù hợp với nhu cầu của bạn. Dùng thử miễn phí 2 ngày trước khi quyết định.
            </p>
        </div>
        
        <!-- Pricing Cards -->
        <div class="grid md:grid-cols-3 gap-6 max-w-5xl mx-auto">
            @foreach($packages as $package)
            <article class="glass-card p-6 relative {{ $package->is_popular ? 'ring-2 ring-primary-500' : '' }}">
                @if($package->is_popular)
                <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                    <x-badge type="premium" size="lg">
                        <i class="fa-solid fa-star mr-1"></i> Phổ biến
                    </x-badge>
                </div>
                @endif
                
                <div class="text-center mb-6 pt-4">
                    <h3 class="text-xl font-heading font-bold mb-2">{{ $package->name }}</h3>
                    <p class="text-sm text-white/60 mb-4">{{ $package->description }}</p>
                    <div class="flex items-baseline justify-center gap-1">
                        <span class="text-4xl font-bold text-gradient">{{ number_format($package->price, 0, ',', '.') }}</span>
                        <span class="text-white/50">đ</span>
                    </div>
                    @if($package->duration_days)
                        <p class="text-xs text-white/40 mt-1">{{ $package->duration_days }} ngày</p>
                    @endif
                </div>
                
                <!-- Features -->
                <ul class="space-y-3 mb-6">
                    @foreach($package->features ?? [] as $feature)
                    <li class="flex items-start gap-2 text-sm">
                        <i class="fa-solid fa-check text-green-400 mt-0.5"></i>
                        <span class="text-white/70">{{ $feature }}</span>
                    </li>
                    @endforeach
                </ul>
                
                <x-button href="{{ route('register') }}" variant="{{ $package->is_popular ? 'primary' : 'secondary' }}" class="w-full">
                    Chọn gói này
                </x-button>
            </article>
            @endforeach
        </div>
        
        <!-- FAQ Section -->
        <div class="max-w-3xl mx-auto mt-20">
            <h2 class="text-2xl md:text-3xl font-heading font-bold text-center mb-10">
                Câu hỏi <span class="text-gradient">thường gặp</span>
            </h2>
            
            <div class="space-y-4">
                @php
                    $faqs = [
                        ['q' => 'Tôi có thể dùng thử miễn phí không?', 'a' => 'Có! Bạn được dùng thử miễn phí 2 ngày với đầy đủ tính năng. Sau 2 ngày, nếu không mua gói, thiệp sẽ bị khóa.'],
                        ['q' => 'Thiệp có hoạt động mãi mãi không?', 'a' => 'Thời hạn hoạt động phụ thuộc vào gói bạn chọn. Gói cao cấp nhất có thời hạn 365 ngày. Bạn có thể gia hạn khi hết thời gian.'],
                        ['q' => 'Tôi có thể chỉnh sửa thiệp sau khi mua không?', 'a' => 'Hoàn toàn được! Bạn có thể chỉnh sửa nội dung, hình ảnh, màu sắc bất cứ lúc nào trong suốt thời gian thiệp còn hoạt động.'],
                        ['q' => 'Phương thức thanh toán nào được hỗ trợ?', 'a' => 'Chúng tôi hỗ trợ chuyển khoản ngân hàng (VietQR) với hệ thống xác nhận tự động, nhanh chóng.'],
                    ];
                @endphp
                
                @foreach($faqs as $faq)
                <details class="glass-card group">
                    <summary class="p-5 cursor-pointer flex items-center justify-between list-none font-medium">
                        {{ $faq['q'] }}
                        <i class="fa-solid fa-chevron-down text-white/40 transition-transform group-open:rotate-180"></i>
                    </summary>
                    <div class="px-5 pb-5 text-sm text-white/60 border-t border-white/10 pt-4">
                        {{ $faq['a'] }}
                    </div>
                </details>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
