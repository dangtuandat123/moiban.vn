@extends('layouts.app')

@section('title', 'Đăng nhập - Mời Bạn')

@section('content')
<section class="min-h-[80vh] flex items-center justify-center py-12">
    <div class="container max-w-md">
        <div class="glass-panel-elevated rounded-3xl p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-2xl font-heading font-bold mb-2">Chào mừng trở lại!</h1>
                <p class="text-white/60">Đăng nhập để quản lý thiệp cưới của bạn</p>
            </div>
            
            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5" novalidate>
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-medium mb-2">Email</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           class="glass-input @error('email') input-error @enderror"
                           placeholder="email@example.com"
                           required
                           autocomplete="email"
                           aria-describedby="email-error">
                    @error('email')
                        <p id="email-error" class="mt-2 text-sm text-red-400" role="alert">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                        <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block text-sm font-medium">Mật khẩu</label>
                    </div>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="glass-input @error('password') input-error @enderror"
                           placeholder="••••••••"
                           required
                           autocomplete="current-password"
                           aria-describedby="password-error">
                    @error('password')
                        <p id="password-error" class="mt-2 text-sm text-red-400" role="alert">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" 
                           id="remember" 
                           name="remember"
                           class="w-4 h-4 rounded border-white/20 bg-white/5 text-primary-500 focus:ring-primary-500 focus:ring-offset-0">
                    <label for="remember" class="ml-2 text-sm text-white/70">Ghi nhớ đăng nhập</label>
                </div>
                
                <button type="submit" class="glass-btn glass-btn-full glass-btn-lg" id="login-btn" onclick="this.disabled=true; this.innerHTML='<i class=\\'fa-solid fa-spinner fa-spin\\'></i> Đang xử lý...'; this.form.submit();">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Đăng nhập
                </button>
            </form>
            
            <!-- Divider -->
            <div class="flex items-center my-6">
                <div class="flex-1 border-t border-white/10"></div>
                <span class="px-4 text-sm text-white/40">hoặc</span>
                <div class="flex-1 border-t border-white/10"></div>
            </div>
            
            <!-- Register Link -->
            <p class="text-center text-sm text-white/60">
                Chưa có tài khoản? 
                <a href="{{ route('register') }}" class="text-primary-400 hover:text-primary-300 font-medium transition">
                    Đăng ký ngay
                </a>
            </p>
        </div>
    </div>
</section>
@endsection
