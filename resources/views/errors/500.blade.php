@extends('layouts.app')

@section('title', '500 - Lỗi máy chủ')

@section('content')
<section class="min-h-[70vh] flex items-center justify-center py-12">
    <div class="container text-center max-w-lg">
        <!-- Illustration -->
        <div class="relative mb-8">
            <div class="text-9xl font-heading font-bold text-red-500/20">500</div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-32 h-32 rounded-full bg-red-500/20 flex items-center justify-center animate-pulse">
                    <i class="fa-solid fa-server text-5xl text-red-400"></i>
                </div>
            </div>
        </div>
        
        <h1 class="text-2xl md:text-3xl font-heading font-bold mb-4">
            Lỗi máy chủ
        </h1>
        <p class="text-white/60 mb-8">
            Đã xảy ra lỗi khi xử lý yêu cầu của bạn. Đội ngũ kỹ thuật đã được thông báo và đang khắc phục. Vui lòng thử lại sau.
        </p>
        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('home') }}" class="glass-btn">
                <i class="fa-solid fa-home"></i>
                Về trang chủ
            </a>
            <button onclick="location.reload()" class="glass-btn-secondary glass-btn">
                <i class="fa-solid fa-rotate"></i>
                Thử lại
            </button>
        </div>
    </div>
</section>
@endsection
