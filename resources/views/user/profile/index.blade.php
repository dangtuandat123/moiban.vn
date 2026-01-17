@extends('layouts.app')

@section('title', 'Hồ sơ của tôi - Mời Bạn')

@section('content')
<section class="py-8">
    <div class="container max-w-4xl">
        <!-- Header -->
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('user.dashboard') }}" class="text-white/60 hover:text-white transition" aria-label="Quay lại Dashboard">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-heading font-bold">Hồ sơ của tôi</h1>
                <p class="text-white/60">Quản lý thông tin cá nhân</p>
            </div>
        </div>
        
        <div class="grid md:grid-cols-3 gap-6">
            <!-- Sidebar -->
            <div class="md:col-span-1">
                <div class="glass-card p-6 text-center">
                    <!-- Avatar -->
                    <div class="w-24 h-24 mx-auto mb-4 rounded-full bg-gradient-to-br from-primary-500 to-pink-500 flex items-center justify-center">
                        <span class="text-3xl font-bold text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <h2 class="font-semibold text-lg">{{ Auth::user()->name }}</h2>
                    <p class="text-sm text-white/60">{{ Auth::user()->email }}</p>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-4 mt-6 pt-6 border-t border-white/10">
                        <div>
                            <p class="text-2xl font-bold text-gradient">{{ Auth::user()->invitations()->count() }}</p>
                            <p class="text-xs text-white/50">Thiệp</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gradient">{{ number_format(Auth::user()->wallet?->balance ?? 0, 0, ',', '.') }}</p>
                            <p class="text-xs text-white/50">VND</p>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="glass-card p-4 mt-4">
                    <nav class="space-y-1">
                        <a href="{{ route('user.wallet') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-white/5 transition">
                            <i class="fa-solid fa-wallet text-amber-400"></i>
                            <span>Ví của tôi</span>
                        </a>
                        <a href="{{ route('user.invitations.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-white/5 transition">
                            <i class="fa-solid fa-envelope text-pink-400"></i>
                            <span>Thiệp của tôi</span>
                        </a>
                    </nav>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="md:col-span-2 space-y-6">
                <!-- Profile Form -->
                <div class="glass-card p-6">
                    <h3 class="font-semibold text-lg mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-user text-primary-400"></i>
                        Thông tin cá nhân
                    </h3>
                    
                    <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')
                        
                        <x-input name="name" label="Họ và tên" :value="Auth::user()->name" required />
                        
                        <x-input name="email" label="Email" type="email" :value="Auth::user()->email" required disabled helper="Email không thể thay đổi" />
                        
                        <x-input name="phone" label="Số điện thoại" type="tel" :value="Auth::user()->phone" placeholder="0901234567" />
                        
                        <div class="pt-4">
                            <x-button type="submit" icon="fa-solid fa-save">
                                Lưu thay đổi
                            </x-button>
                        </div>
                    </form>
                </div>
                
                <!-- Change Password -->
                <div class="glass-card p-6">
                    <h3 class="font-semibold text-lg mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-lock text-amber-400"></i>
                        Đổi mật khẩu
                    </h3>
                    
                    <form action="{{ route('user.profile.password') }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')
                        
                        <x-input name="current_password" label="Mật khẩu hiện tại" type="password" required />
                        
                        <x-input name="password" label="Mật khẩu mới" type="password" required helper="Tối thiểu 8 ký tự" />
                        
                        <x-input name="password_confirmation" label="Xác nhận mật khẩu mới" type="password" required />
                        
                        <div class="pt-4">
                            <x-button type="submit" variant="secondary" icon="fa-solid fa-key">
                                Đổi mật khẩu
                            </x-button>
                        </div>
                    </form>
                </div>
                
                <!-- Member Info -->
                <div class="glass-card p-6">
                    <h3 class="font-semibold text-lg mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-info-circle text-blue-400"></i>
                        Thông tin tài khoản
                    </h3>
                    
                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between py-2 border-b border-white/10">
                            <dt class="text-white/60">Ngày đăng ký</dt>
                            <dd>{{ Auth::user()->created_at->format('d/m/Y') }}</dd>
                        </div>
                        <div class="flex justify-between py-2 border-b border-white/10">
                            <dt class="text-white/60">Loại tài khoản</dt>
                            <dd>
                                <x-badge type="primary">{{ ucfirst(Auth::user()->role) }}</x-badge>
                            </dd>
                        </div>
                        <div class="flex justify-between py-2">
                            <dt class="text-white/60">ID tài khoản</dt>
                            <dd class="font-mono">#{{ Auth::user()->id }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
