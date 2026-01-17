@extends('layouts.app')

@section('title', 'Mời Bạn - Thiệp Cưới Online Đẹp, Chuyên Nghiệp')
@section('description', 'Tạo thiệp cưới online miễn phí. Hàng trăm mẫu thiệp đẹp. RSVP, đếm ngược, album ảnh và nhiều tính năng khác.')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Background Orbs -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
        <div class="absolute top-1/4 -left-20 w-80 h-80 bg-primary-500/20 rounded-full blur-[100px] animate-float"></div>
        <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-accent-violet/20 rounded-full blur-[100px] animate-float" style="animation-delay: -3s;"></div>
        <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-accent-champagne/10 rounded-full blur-[80px]"></div>
    </div>
    
    <div class="container relative z-10 py-20 text-center">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-white/20 bg-white/5 backdrop-blur mb-8">
            <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
            <span class="text-sm text-white/70">Tạo thiệp miễn phí, không cần cài đặt</span>
        </div>
        
        <!-- Main Heading -->
        <h1 class="text-5xl md:text-7xl font-heading font-bold mb-6">
            <span class="text-gradient">Mời Bạn</span>
            <br>
            <span class="text-white">Thiệp Cưới Online</span>
        </h1>
        
        <p class="text-xl text-white/70 max-w-2xl mx-auto mb-10">
            Tạo thiệp cưới đẹp trong 5 phút. Chia sẻ qua link, nhận RSVP online, 
            đếm ngược ngày cưới và nhiều tính năng tuyệt vời khác.
        </p>
        
        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('register') }}" class="glass-btn glass-btn-lg">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
                Tạo thiệp ngay
            </a>
            <a href="{{ route('templates') }}" class="glass-btn-secondary glass-btn glass-btn-lg">
                <i class="fa-regular fa-images"></i>
                Xem mẫu thiệp
            </a>
        </div>
        
        <!-- Stats -->
        <div class="flex flex-wrap items-center justify-center gap-8 mt-16">
            <div class="text-center">
                <p class="text-3xl font-bold text-gradient">{{ number_format($stats['total_invitations'] ?? 500) }}+</p>
                <p class="text-sm text-white/50">Thiệp đã tạo</p>
            </div>
            <div class="w-px h-10 bg-white/20 hidden sm:block"></div>
            <div class="text-center">
                <p class="text-3xl font-bold text-gradient">{{ number_format($stats['total_templates'] ?? 50) }}+</p>
                <p class="text-sm text-white/50">Mẫu thiệp đẹp</p>
            </div>
            <div class="w-px h-10 bg-white/20 hidden sm:block"></div>
            <div class="text-center">
                <p class="text-3xl font-bold text-gradient">4.9</p>
                <p class="text-sm text-white/50">Đánh giá</p>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-20">
    <div class="container">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-heading font-bold mb-4">
                Tại sao chọn <span class="text-gradient">Mời Bạn</span>?
            </h2>
            <p class="text-white/60 max-w-2xl mx-auto">
                Chúng tôi mang đến trải nghiệm tạo thiệp cưới online tốt nhất với công nghệ hiện đại.
            </p>
        </div>
        
        <div class="grid-responsive">
            <!-- Feature 1 -->
            <article class="glass-card p-6 text-center">
                <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-pink-500/20 to-purple-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-mobile-screen text-2xl text-pink-400"></i>
                </div>
                <h3 class="font-semibold text-lg mb-2">Mobile First</h3>
                <p class="text-sm text-white/60">Tối ưu cho điện thoại - 95% khách mời xem thiệp trên mobile</p>
            </article>
            
            <!-- Feature 2 -->
            <article class="glass-card p-6 text-center">
                <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-blue-500/20 to-cyan-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-clock text-2xl text-cyan-400"></i>
                </div>
                <h3 class="font-semibold text-lg mb-2">Nhanh chóng</h3>
                <p class="text-sm text-white/60">Tạo thiệp chỉ trong 5 phút với trình chỉnh sửa trực quan</p>
            </article>
            
            <!-- Feature 3 -->
            <article class="glass-card p-6 text-center">
                <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-emerald-500/20 to-green-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-chart-pie text-2xl text-emerald-400"></i>
                </div>
                <h3 class="font-semibold text-lg mb-2">RSVP Online</h3>
                <p class="text-sm text-white/60">Khách xác nhận tham dự online, bạn quản lý dễ dàng</p>
            </article>
            
            <!-- Feature 4 -->
            <article class="glass-card p-6 text-center">
                <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-amber-500/20 to-orange-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-qrcode text-2xl text-amber-400"></i>
                </div>
                <h3 class="font-semibold text-lg mb-2">VietQR</h3>
                <p class="text-sm text-white/60">Nhận tiền mừng online qua mã QR ngân hàng</p>
            </article>
        </div>
    </div>
</section>

<!-- Widgets Section -->
<section class="py-20 relative">
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-primary-500/5 to-transparent pointer-events-none"></div>
    
    <div class="container relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-heading font-bold mb-4">
                <span class="text-gradient">Widgets</span> mạnh mẽ
            </h2>
            <p class="text-white/60 max-w-2xl mx-auto">
                Mỗi thiệp có thể tùy chỉnh với các widget hữu ích.
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $widgets = [
                    ['icon' => 'fa-clock', 'name' => 'Countdown', 'desc' => 'Đếm ngược đến ngày cưới', 'color' => 'pink'],
                    ['icon' => 'fa-images', 'name' => 'Album', 'desc' => 'Thư viện ảnh cưới đẹp', 'color' => 'blue'],
                    ['icon' => 'fa-heart', 'name' => 'Guestbook', 'desc' => 'Lời chúc từ bạn bè', 'color' => 'red'],
                    ['icon' => 'fa-map-location-dot', 'name' => 'Maps', 'desc' => 'Bản đồ chỉ đường', 'color' => 'green'],
                    ['icon' => 'fa-music', 'name' => 'Music', 'desc' => 'Nhạc nền lãng mạn', 'color' => 'purple'],
                    ['icon' => 'fa-qrcode', 'name' => 'VietQR', 'desc' => 'Nhận tiền mừng online', 'color' => 'amber'],
                ];
            @endphp
            
            @foreach($widgets as $widget)
            @php
                $colors = [
                    'pink' => 'rgba(236,72,153,0.2)',
                    'blue' => 'rgba(59,130,246,0.2)',
                    'red' => 'rgba(239,68,68,0.2)',
                    'green' => 'rgba(34,197,94,0.2)',
                    'purple' => 'rgba(168,85,247,0.2)',
                    'amber' => 'rgba(245,158,11,0.2)',
                ];
                $textColors = [
                    'pink' => '#f472b6',
                    'blue' => '#60a5fa',
                    'red' => '#f87171',
                    'green' => '#4ade80',
                    'purple' => '#c084fc',
                    'amber' => '#fbbf24',
                ];
            @endphp
            <div class="glass-card p-6 flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background: {{ $colors[$widget['color']] ?? 'rgba(255,255,255,0.1)' }}">
                    <i class="fa-solid {{ $widget['icon'] }}" style="color: {{ $textColors[$widget['color']] ?? '#fff' }}"></i>
                </div>
                <div>
                    <h3 class="font-semibold mb-1">{{ $widget['name'] }}</h3>
                    <p class="text-sm text-white/60">{{ $widget['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Templates Section -->
<section class="py-20">
    <div class="container">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-heading font-bold mb-4">
                Mẫu thiệp <span class="text-gradient">nổi bật</span>
            </h2>
            <p class="text-white/60">Được thiết kế bởi đội ngũ chuyên nghiệp</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-6 mb-10">
            @foreach($templates as $template)
            <article class="glass-card overflow-hidden group">
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
                    @endif
                    
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-6">
                        <a href="{{ route('register') }}" class="glass-btn glass-btn-sm">
                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                            Sử dụng mẫu này
                        </a>
                    </div>
                </div>
                
                <div class="p-4">
                    <h3 class="font-semibold text-lg">{{ $template->name }}</h3>
                    <p class="text-sm text-white/60 mt-1">{{ Str::limit($template->description, 50) }}</p>
                </div>
            </article>
            @endforeach
        </div>
        
        <div class="text-center">
            <a href="{{ route('templates') }}" class="glass-btn-secondary glass-btn">
                Xem tất cả mẫu thiệp <i class="fa-solid fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20">
    <div class="container">
        <div class="glass-panel-elevated rounded-3xl p-8 md:p-12 text-center">
            <h2 class="text-3xl md:text-4xl font-heading font-bold mb-4">
                Bắt đầu tạo thiệp <span class="text-gradient">ngay hôm nay</span>
            </h2>
            <p class="text-white/70 max-w-xl mx-auto mb-8">
                Dùng thử miễn phí 2 ngày. Không cần thẻ tín dụng. Hủy bất cứ lúc nào.
            </p>
            <a href="{{ route('register') }}" class="glass-btn glass-btn-lg">
                <i class="fa-solid fa-rocket"></i>
                Tạo thiệp miễn phí
            </a>
        </div>
    </div>
</section>
@endsection
