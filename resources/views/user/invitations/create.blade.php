@extends('layouts.app')

@section('title', 'Tạo thiệp mới - Mời Bạn')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('user.invitations.index') }}" class="text-white/60 hover:text-white mb-4 inline-block">
            <i class="fa-solid fa-arrow-left mr-2"></i> Quay lại
        </a>
        <h1 class="text-3xl font-semibold">Tạo thiệp mới</h1>
        <p class="text-white/60 mt-1">Chọn mẫu và nhập thông tin cơ bản</p>
    </div>
    
    <form method="POST" action="{{ route('user.invitations.store') }}" class="space-y-8">
        @csrf
        
        <!-- Step 1: Chọn Template -->
        <div class="glass-card p-6">
            <h2 class="text-xl font-semibold mb-4">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-rose-gold text-white text-sm mr-3">1</span>
                Chọn mẫu thiệp
            </h2>
            
            @error('template_id')
                <p class="mb-4 text-sm text-red-400">{{ $message }}</p>
            @enderror
            
            <div class="grid md:grid-cols-3 gap-4">
                @foreach($templates as $template)
                <label class="cursor-pointer">
                    <input type="radio" name="template_id" value="{{ $template->id }}" 
                           class="hidden peer" {{ old('template_id') == $template->id ? 'checked' : '' }}>
                    <div class="glass-card overflow-hidden peer-checked:ring-2 peer-checked:ring-rose-gold transition group">
                        <div class="aspect-[3/4] bg-gradient-to-br from-rose-gold/20 to-purple-500/20 relative overflow-hidden">
                            @php
                                $thumbnailPath = 'images/templates/' . $template->slug . '.png';
                            @endphp
                            @if(file_exists(public_path($thumbnailPath)))
                                <img src="{{ asset($thumbnailPath) }}" alt="{{ $template->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fa-solid fa-heart text-3xl text-white/20"></i>
                                </div>
                            @endif
                            <!-- Checked indicator -->
                            <div class="absolute top-2 left-2 w-6 h-6 rounded-full bg-rose-gold text-white flex items-center justify-center opacity-0 peer-checked:opacity-100 transition">
                                <i class="fa-solid fa-check text-xs"></i>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center justify-between">
                                <span class="font-medium">{{ $template->name }}</span>
                                <span class="px-2 py-0.5 text-xs rounded {{ $template->type === 'premium' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-green-500/20 text-green-400' }}">
                                    {{ $template->type === 'premium' ? 'Premium' : 'Basic' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </label>
                @endforeach
            </div>
        </div>
        
        <!-- Step 2: Thông tin cơ bản -->
        <div class="glass-card p-6">
            <h2 class="text-xl font-semibold mb-4">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-rose-gold text-white text-sm mr-3">2</span>
                Thông tin cặp đôi
            </h2>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="groom_name" class="block text-sm font-medium mb-2">Tên chú rể</label>
                    <input type="text" id="groom_name" name="groom_name" value="{{ old('groom_name') }}"
                           class="glass-input @error('groom_name') border-red-500 @enderror" 
                           placeholder="Minh Anh" required>
                    @error('groom_name')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="bride_name" class="block text-sm font-medium mb-2">Tên cô dâu</label>
                    <input type="text" id="bride_name" name="bride_name" value="{{ old('bride_name') }}"
                           class="glass-input @error('bride_name') border-red-500 @enderror" 
                           placeholder="Thùy Linh" required>
                    @error('bride_name')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="mt-6">
                <label for="title" class="block text-sm font-medium mb-2">Tiêu đề thiệp</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}"
                       class="glass-input @error('title') border-red-500 @enderror" 
                       placeholder="Thiệp cưới Minh Anh & Thùy Linh" required>
                @error('title')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mt-6">
                <label for="event_date" class="block text-sm font-medium mb-2">Ngày cưới</label>
                <input type="date" id="event_date" name="event_date" value="{{ old('event_date') }}"
                       class="glass-input @error('event_date') border-red-500 @enderror" 
                       min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                @error('event_date')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <!-- Trial Notice -->
        <div class="glass-card p-6 border-l-4 border-yellow-500">
            <div class="flex items-start space-x-4">
                <div class="w-10 h-10 rounded-full bg-yellow-500/20 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-info text-yellow-400"></i>
                </div>
                <div>
                    <h3 class="font-semibold mb-1">Dùng thử miễn phí 2 ngày</h3>
                    <p class="text-sm text-white/60">
                        Thiệp sẽ có watermark trong thời gian dùng thử. 
                        Sau khi hài lòng, bạn có thể mua gói để loại bỏ watermark và kích hoạt đầy đủ tính năng.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Submit -->
        <div class="flex justify-end">
            <button type="submit" class="glass-btn px-8 py-3">
                <i class="fa-solid fa-wand-magic-sparkles mr-2"></i>
                Tạo thiệp
            </button>
        </div>
    </form>
</div>
@endsection
