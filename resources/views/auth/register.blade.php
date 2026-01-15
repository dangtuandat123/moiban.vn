@extends('layouts.app')

@section('title', 'Đăng ký - Mời Bạn')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="glass-card p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-script text-gradient mb-2">Đăng ký</h1>
                <p class="text-white/60">Tạo tài khoản miễn phí</p>
            </div>
            
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf
                
                <div>
                    <label for="name" class="block text-sm font-medium mb-2">Họ và tên</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        class="glass-input @error('name') border-red-500 @enderror" 
                        placeholder="Nguyễn Văn A"
                        required
                        autofocus
                    >
                    @error('name')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
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
                    >
                    @error('email')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="phone" class="block text-sm font-medium mb-2">Số điện thoại <span class="text-white/40">(không bắt buộc)</span></label>
                    <input 
                        type="tel" 
                        id="phone" 
                        name="phone" 
                        value="{{ old('phone') }}"
                        class="glass-input @error('phone') border-red-500 @enderror" 
                        placeholder="0901234567"
                    >
                    @error('phone')
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
                        placeholder="Ít nhất 8 ký tự"
                        required
                    >
                    @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium mb-2">Xác nhận mật khẩu</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        class="glass-input" 
                        placeholder="Nhập lại mật khẩu"
                        required
                    >
                </div>
                
                <button type="submit" class="glass-btn w-full py-3">
                    Đăng ký
                </button>
            </form>
            
            <p class="text-center mt-6 text-sm text-white/60">
                Đã có tài khoản? 
                <a href="{{ route('login') }}" class="text-rose-gold hover:underline">Đăng nhập</a>
            </p>
        </div>
    </div>
</div>
@endsection
