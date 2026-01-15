@extends('layouts.app')

@section('title', 'Mời Bạn - Tạo Thiệp Cưới Online Đẹp, Chuyên Nghiệp')
@section('description', 'Tạo thiệp cưới online miễn phí trong 5 phút. Hàng trăm mẫu thiệp đẹp, hiện đại. Chia sẻ dễ dàng qua link.')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Background Gradient Orbs -->
    <div class="absolute top-20 left-10 w-72 h-72 bg-rose-gold/30 rounded-full blur-3xl animate-float"></div>
    <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-500/20 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
    
    <div class="relative z-10 text-center px-4 max-w-4xl mx-auto">
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-script text-gradient mb-6">
            Thiệp Cưới Online
        </h1>
        <p class="text-xl md:text-2xl text-white/70 mb-8 font-light">
            Tạo thiệp cưới đẹp trong <span class="text-white font-semibold">5 phút</span>.<br>
            Chia sẻ với bạn bè qua <span class="text-white font-semibold">một đường link</span>.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('register') }}" class="glass-btn text-lg px-8 py-4">
                <i class="fa-solid fa-wand-magic-sparkles mr-2"></i>
                Tạo thiệp miễn phí
            </a>
            <a href="{{ route('templates') }}" class="glass-card px-8 py-4 text-white/80 hover:text-white hover:bg-white/10 transition text-center">
                <i class="fa-solid fa-palette mr-2"></i>
                Xem mẫu thiệp
            </a>
        </div>
        
        <p class="mt-6 text-sm text-white/50">
            <i class="fa-solid fa-check text-green-400 mr-1"></i> Miễn phí dùng thử 2 ngày
            <span class="mx-3">|</span>
            <i class="fa-solid fa-check text-green-400 mr-1"></i> Không cần tải app
        </p>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 px-4">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl md:text-4xl font-semibold text-center mb-4">Tại sao chọn Mời Bạn?</h2>
        <p class="text-white/60 text-center mb-12 max-w-2xl mx-auto">
            Chúng tôi giúp bạn tạo thiệp cưới online đẹp, chuyên nghiệp chỉ trong vài phút.
        </p>
        
        <div class="grid md:grid-cols-3 gap-6">
            <!-- Feature 1 -->
            <div class="glass-card p-8 text-center hover:bg-white/10 transition">
                <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-rose-gold to-purple-500 flex items-center justify-center">
                    <i class="fa-solid fa-palette text-2xl text-white"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Mẫu thiệp đẹp</h3>
                <p class="text-white/60">Hàng trăm mẫu thiệp được thiết kế bởi chuyên gia, phù hợp mọi phong cách.</p>
            </div>
            
            <!-- Feature 2 -->
            <div class="glass-card p-8 text-center hover:bg-white/10 transition">
                <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-blue-400 to-cyan-500 flex items-center justify-center">
                    <i class="fa-solid fa-mobile-screen text-2xl text-white"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Mobile First</h3>
                <p class="text-white/60">Thiệp hiển thị đẹp trên mọi thiết bị, đặc biệt tối ưu cho điện thoại.</p>
            </div>
            
            <!-- Feature 3 -->
            <div class="glass-card p-8 text-center hover:bg-white/10 transition">
                <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center">
                    <i class="fa-solid fa-share-nodes text-2xl text-white"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Chia sẻ dễ dàng</h3>
                <p class="text-white/60">Gửi link thiệp qua Zalo, Facebook, Messenger. Không cần cài app.</p>
            </div>
        </div>
    </div>
</section>

<!-- Widgets Section -->
<section class="py-20 px-4 bg-white/5">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl md:text-4xl font-semibold text-center mb-4">Tính năng nổi bật</h2>
        <p class="text-white/60 text-center mb-12 max-w-2xl mx-auto">
            Thiệp của bạn không chỉ đẹp mà còn có đầy đủ tính năng tương tác.
        </p>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="glass-card p-6 flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-pink-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-user-check text-pink-400"></i>
                </div>
                <span>Xác nhận tham dự</span>
            </div>
            <div class="glass-card p-6 flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-book-open text-blue-400"></i>
                </div>
                <span>Sổ lưu bút</span>
            </div>
            <div class="glass-card p-6 flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-images text-purple-400"></i>
                </div>
                <span>Album ảnh</span>
            </div>
            <div class="glass-card p-6 flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-green-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-music text-green-400"></i>
                </div>
                <span>Nhạc nền</span>
            </div>
            <div class="glass-card p-6 flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-yellow-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-hourglass-half text-yellow-400"></i>
                </div>
                <span>Đếm ngược</span>
            </div>
            <div class="glass-card p-6 flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-red-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-map-location-dot text-red-400"></i>
                </div>
                <span>Bản đồ</span>
            </div>
            <div class="glass-card p-6 flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-cyan-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-qrcode text-cyan-400"></i>
                </div>
                <span>QR Mừng tiền</span>
            </div>
            <div class="glass-card p-6 flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-orange-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-share-from-square text-orange-400"></i>
                </div>
                <span>SEO & OG Image</span>
            </div>
        </div>
    </div>
</section>

<!-- Templates Preview -->
@if($templates->count() > 0)
<section class="py-20 px-4">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl md:text-4xl font-semibold text-center mb-4">Mẫu thiệp nổi bật</h2>
        <p class="text-white/60 text-center mb-12">Chọn một mẫu và bắt đầu tạo thiệp của bạn</p>
        
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($templates->take(3) as $template)
            <div class="glass-card overflow-hidden group">
                <div class="aspect-[3/4] bg-gradient-to-br from-rose-gold/20 to-purple-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-image text-4xl text-white/20"></i>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-lg font-semibold">{{ $template->name }}</h3>
                        <span class="px-2 py-1 text-xs rounded-full {{ $template->type === 'premium' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-green-500/20 text-green-400' }}">
                            {{ $template->type === 'premium' ? 'Premium' : 'Basic' }}
                        </span>
                    </div>
                    <p class="text-sm text-white/60">{{ Str::limit($template->description, 80) }}</p>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-8">
            <a href="{{ route('templates') }}" class="glass-card inline-block px-8 py-3 hover:bg-white/10 transition">
                Xem tất cả mẫu <i class="fa-solid fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-20 px-4">
    <div class="max-w-4xl mx-auto text-center">
        <div class="glass-card p-12 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-r from-rose-gold/10 to-purple-500/10"></div>
            <div class="relative z-10">
                <h2 class="text-3xl md:text-4xl font-semibold mb-4">Sẵn sàng tạo thiệp cưới?</h2>
                <p class="text-white/70 mb-8 text-lg">Bắt đầu miễn phí ngay hôm nay. Không cần thẻ tín dụng.</p>
                <a href="{{ route('register') }}" class="glass-btn text-lg px-10 py-4 inline-block">
                    <i class="fa-solid fa-rocket mr-2"></i>
                    Tạo thiệp ngay
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
