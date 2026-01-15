@extends('layouts.app')

@section('title', '404 - Không tìm thấy trang')

@section('content')
<section class="min-h-[70vh] flex items-center justify-center py-12">
    <div class="container text-center max-w-lg">
        <!-- Illustration -->
        <div class="relative mb-8">
            <div class="text-9xl font-heading font-bold text-gradient opacity-20">404</div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-32 h-32 rounded-full bg-primary-500/20 flex items-center justify-center animate-float">
                    <i class="fa-solid fa-ghost text-5xl text-primary-400"></i>
                </div>
            </div>
        </div>
        
        <h1 class="text-2xl md:text-3xl font-heading font-bold mb-4">
            Không tìm thấy trang
        </h1>
        <p class="text-white/60 mb-8">
            Trang bạn đang tìm kiếm không tồn tại hoặc đã bị di chuyển. Hãy kiểm tra lại đường dẫn hoặc quay về trang chủ.
        </p>
        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('home') }}" class="glass-btn">
                <i class="fa-solid fa-home"></i>
                Về trang chủ
            </a>
            <button onclick="history.back()" class="glass-btn-secondary glass-btn">
                <i class="fa-solid fa-arrow-left"></i>
                Quay lại
            </button>
        </div>
    </div>
</section>
@endsection
