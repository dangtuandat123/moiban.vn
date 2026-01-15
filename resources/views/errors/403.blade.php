@extends('layouts.app')

@section('title', '403 - Không có quyền truy cập')

@section('content')
<section class="min-h-[70vh] flex items-center justify-center py-12">
    <div class="container text-center max-w-lg">
        <!-- Illustration -->
        <div class="relative mb-8">
            <div class="text-9xl font-heading font-bold text-amber-500/20">403</div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-32 h-32 rounded-full bg-amber-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-lock text-5xl text-amber-400"></i>
                </div>
            </div>
        </div>
        
        <h1 class="text-2xl md:text-3xl font-heading font-bold mb-4">
            Không có quyền truy cập
        </h1>
        <p class="text-white/60 mb-8">
            Bạn không có quyền truy cập vào trang này. Nếu bạn cho rằng đây là lỗi, vui lòng liên hệ hỗ trợ.
        </p>
        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('home') }}" class="glass-btn">
                <i class="fa-solid fa-home"></i>
                Về trang chủ
            </a>
            @guest
                <a href="{{ route('login') }}" class="glass-btn-secondary glass-btn">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Đăng nhập
                </a>
            @endguest
        </div>
    </div>
</section>
@endsection
