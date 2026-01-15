@extends('layouts.app')

@section('title', 'Đăng nhập - Mời Bạn')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="glass-card p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-script text-gradient mb-2">Đăng nhập</h1>
                <p class="text-white/60">Chào mừng trở lại!</p>
            </div>
            
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-medium mb-2">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        class="glass-input @error('email') border-red-500 @enderror" 
                        placeholder="email@example.com"
                        required
                        autofocus
                    >
                    @error('email')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium mb-2">Mật khẩu</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="glass-input @error('password') border-red-500 @enderror" 
                        placeholder="••••••••"
                        required
                    >
                    @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex items-center justify-between">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-white/20 bg-black/30 text-rose-gold focus:ring-rose-gold">
                        <span class="ml-2 text-sm text-white/70">Ghi nhớ đăng nhập</span>
                    </label>
                </div>
                
                <button type="submit" class="glass-btn w-full py-3">
                    Đăng nhập
                </button>
            </form>
            
            <p class="text-center mt-6 text-sm text-white/60">
                Chưa có tài khoản? 
                <a href="{{ route('register') }}" class="text-rose-gold hover:underline">Đăng ký ngay</a>
            </p>
        </div>
    </div>
</div>
@endsection
