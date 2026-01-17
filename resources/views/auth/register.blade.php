@extends('layouts.app')

@section('title', 'Đăng ký - Mời Bạn')

@section('content')
<section class="min-h-[80vh] flex items-center justify-center py-12">
    <div class="container max-w-md">
        <div class="glass-panel-elevated rounded-3xl p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-2xl font-heading font-bold mb-2">Tạo tài khoản mới</h1>
                <p class="text-white/60">Bắt đầu tạo thiệp cưới online của bạn</p>
            </div>
            
            <!-- Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-5" novalidate>
                @csrf
                
                <div>
                    <label for="name" class="block text-sm font-medium mb-2">Họ và tên</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="glass-input @error('name') input-error @enderror"
                           placeholder="Nguyễn Văn A"
                           required
                           autocomplete="name"
                           maxlength="255">
                    @error('name')
                        <p id="name-error" class="mt-2 text-sm text-red-400" role="alert">{{ $message }}</p>
                    @enderror
                </div>
                
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
                           maxlength="255">
                    @error('email')
                        <p id="email-error" class="mt-2 text-sm text-red-400" role="alert">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="phone" class="block text-sm font-medium mb-2">Số điện thoại <span class="text-white/40">(tùy chọn)</span></label>
                    <input type="tel" 
                           id="phone" 
                           name="phone" 
                           value="{{ old('phone') }}"
                           class="glass-input @error('phone') input-error @enderror"
                           placeholder="0901234567"
                           autocomplete="tel"
                           maxlength="20">
                    @error('phone')
                        <p id="phone-error" class="mt-2 text-sm text-red-400" role="alert">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium mb-2">Mật khẩu</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="glass-input @error('password') input-error @enderror"
                           placeholder="Tối thiểu 8 ký tự"
                           required
                           autocomplete="new-password"
                           aria-describedby="password-error">
                    @error('password')
                        <p id="password-error" class="mt-2 text-sm text-red-400" role="alert">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium mb-2">Xác nhận mật khẩu</label>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           class="glass-input"
                           placeholder="Nhập lại mật khẩu"
                           required
                           autocomplete="new-password">
                </div>
                
                <button type="submit" class="glass-btn glass-btn-full glass-btn-lg" id="register-btn" onclick="this.disabled=true; this.innerHTML='<i class=\'fa-solid fa-spinner fa-spin\'></i> Đang xử lý...'; this.form.submit();">
                    <i class="fa-solid fa-user-plus"></i>
                    Đăng ký
                </button>
            </form>
            
            <!-- Divider -->
            <div class="flex items-center my-6">
                <div class="flex-1 border-t border-white/10"></div>
                <span class="px-4 text-sm text-white/40">hoặc</span>
                <div class="flex-1 border-t border-white/10"></div>
            </div>
            
            <!-- Login Link -->
            <p class="text-center text-sm text-white/60">
                Đã có tài khoản? 
                <a href="{{ route('login') }}" class="text-primary-400 hover:text-primary-300 font-medium transition">
                    Đăng nhập
                </a>
            </p>
        </div>
    </div>
</section>
@endsection
