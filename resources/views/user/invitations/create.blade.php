@extends('layouts.app')

@section('title', 'Tạo thiệp mới - Mời Bạn')

@section('content')
<div class="min-h-screen py-6 md:py-12">
    <div class="container max-w-5xl">
        <!-- Header -->
        <div class="mb-6 md:mb-8">
            <a href="{{ route('user.invitations.index') }}" class="inline-flex items-center text-white/60 hover:text-white transition mb-4">
                <i class="fa-solid fa-arrow-left mr-2"></i> Quay lại danh sách
            </a>
            <h1 class="text-2xl md:text-3xl font-heading font-bold">Tạo thiệp mới</h1>
            <p class="text-white/60 mt-1">Chọn mẫu thiệp và nhập thông tin cơ bản</p>
        </div>
        
        <form method="POST" action="{{ route('user.invitations.store') }}" class="space-y-6" id="create-form">
            @csrf
            
            <!-- Step 1: Chọn Template -->
            <div class="glass-card p-5 md:p-6">
                <div class="flex items-center gap-3 mb-5">
                    <span class="w-8 h-8 rounded-full bg-primary-500 flex items-center justify-center text-white font-semibold text-sm">1</span>
                    <h2 class="text-lg md:text-xl font-semibold">Chọn mẫu thiệp</h2>
                </div>
                
                @error('template_id')
                    <div class="mb-4 p-3 rounded-lg bg-red-500/10 border border-red-500/30 text-red-400 text-sm">
                        <i class="fa-solid fa-exclamation-circle mr-2"></i>{{ $message }}
                    </div>
                @enderror
                
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-4">
                    @foreach($templates as $template)
                    <label class="template-card cursor-pointer relative group">
                        <input type="radio" name="template_id" value="{{ $template->id }}" 
                               class="sr-only template-radio" {{ old('template_id') == $template->id ? 'checked' : '' }}>
                        
                        <div class="template-wrapper rounded-xl md:rounded-2xl overflow-hidden border-2 border-transparent transition-all duration-300">
                            <!-- Thumbnail -->
                            <div class="aspect-[3/4] relative bg-gradient-to-br from-primary-500/20 to-purple-500/20 overflow-hidden">
                                @php
                                    $thumbnailPath = 'images/templates/' . $template->slug . '.png';
                                @endphp
                                @if(file_exists(public_path($thumbnailPath)))
                                    <img src="{{ asset($thumbnailPath) }}" alt="{{ $template->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <!-- Placeholder -->
                                    <div class="w-full h-full flex flex-col items-center justify-center p-4 text-center">
                                        <i class="fa-solid fa-heart text-4xl md:text-5xl text-white/20 mb-3"></i>
                                        <span class="text-sm text-white/40 font-script">{{ $template->name }}</span>
                                    </div>
                                @endif
                                
                                <!-- Selected Check -->
                                <div class="check-indicator absolute top-2 right-2 w-6 h-6 md:w-7 md:h-7 rounded-full bg-primary-500 text-white flex items-center justify-center opacity-0 scale-75 transition-all duration-300">
                                    <i class="fa-solid fa-check text-xs"></i>
                                </div>
                                
                                <!-- Type Badge -->
                                <div class="absolute bottom-2 left-2">
                                    <span class="px-2 py-0.5 text-[10px] md:text-xs rounded-full {{ $template->type === 'premium' ? 'bg-amber-500/90 text-black' : 'bg-white/20 text-white' }} font-medium backdrop-blur-sm">
                                        {{ $template->type === 'premium' ? '✨ Premium' : 'Basic' }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Info -->
                            <div class="p-2 md:p-3 bg-white/5">
                                <span class="text-sm font-medium line-clamp-1">{{ $template->name }}</span>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
            
            <!-- Step 2: Thông tin cặp đôi -->
            <div class="glass-card p-5 md:p-6">
                <div class="flex items-center gap-3 mb-5">
                    <span class="w-8 h-8 rounded-full bg-primary-500 flex items-center justify-center text-white font-semibold text-sm">2</span>
                    <h2 class="text-lg md:text-xl font-semibold">Thông tin cặp đôi</h2>
                </div>
                
                <div class="grid md:grid-cols-2 gap-4 md:gap-5">
                    <div>
                        <label for="groom_name" class="block text-sm font-medium mb-2">
                            <i class="fa-solid fa-user-tie text-blue-400 mr-2"></i>Tên chú rể
                        </label>
                        <input type="text" id="groom_name" name="groom_name" value="{{ old('groom_name') }}"
                               class="glass-input @error('groom_name') border-red-500 @enderror" 
                               placeholder="Nguyễn Văn A" required maxlength="100">
                        @error('groom_name')
                            <p class="mt-2 text-sm text-red-400"><i class="fa-solid fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="bride_name" class="block text-sm font-medium mb-2">
                            <i class="fa-solid fa-user text-pink-400 mr-2"></i>Tên cô dâu
                        </label>
                        <input type="text" id="bride_name" name="bride_name" value="{{ old('bride_name') }}"
                               class="glass-input @error('bride_name') border-red-500 @enderror" 
                               placeholder="Trần Thị B" required maxlength="100">
                        @error('bride_name')
                            <p class="mt-2 text-sm text-red-400"><i class="fa-solid fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mt-4 md:mt-5">
                    <label for="title" class="block text-sm font-medium mb-2">
                        <i class="fa-solid fa-heading text-purple-400 mr-2"></i>Tiêu đề thiệp
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}"
                           class="glass-input @error('title') border-red-500 @enderror" 
                           placeholder="Thiệp cưới A & B" required maxlength="255">
                    @error('title')
                        <p class="mt-2 text-sm text-red-400"><i class="fa-solid fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mt-4 md:mt-5">
                    <label for="event_date" class="block text-sm font-medium mb-2">
                        <i class="fa-solid fa-calendar-heart text-red-400 mr-2"></i>Ngày cưới
                    </label>
                    <input type="date" id="event_date" name="event_date" value="{{ old('event_date') }}"
                           class="glass-input @error('event_date') border-red-500 @enderror" 
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                    @error('event_date')
                        <p class="mt-2 text-sm text-red-400"><i class="fa-solid fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Trial Notice -->
            <div class="glass-card p-5 md:p-6 border-l-4 border-amber-500">
                <div class="flex gap-4">
                    <div class="w-12 h-12 rounded-full bg-amber-500/20 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-gift text-xl text-amber-400"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-1">🎉 Dùng thử miễn phí 2 ngày!</h3>
                        <p class="text-sm text-white/60">
                            Bạn có 2 ngày để trải nghiệm đầy đủ tính năng. Sau đó, mua gói để kích hoạt vĩnh viễn và xóa watermark.
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Submit -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <p class="text-sm text-white/50">
                    <i class="fa-solid fa-info-circle mr-1"></i>
                    Bạn có thể chỉnh sửa nội dung chi tiết sau khi tạo thiệp
                </p>
                <button type="submit" class="glass-btn glass-btn-lg w-full md:w-auto" id="submit-btn">
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                    <span>Tạo thiệp ngay</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Template card selection */
    .template-radio:checked + .template-wrapper {
        border-color: var(--color-primary-500, #b76e79);
        box-shadow: 0 0 0 4px rgba(183, 110, 121, 0.2);
    }
    
    .template-radio:checked + .template-wrapper .check-indicator {
        opacity: 1;
        transform: scale(1);
    }
    
    .template-wrapper:hover {
        border-color: rgba(255, 255, 255, 0.3);
    }
    
    /* Font Script */
    .font-script {
        font-family: 'Great Vibes', 'Dancing Script', cursive;
    }
    
    /* Loading state */
    .btn-loading {
        pointer-events: none;
        opacity: 0.7;
    }
    .btn-loading i:first-child {
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-generate title from names
    $('#groom_name, #bride_name').on('input', function() {
        const groom = $('#groom_name').val().trim();
        const bride = $('#bride_name').val().trim();
        const currentTitle = $('#title').val();
        
        // Only auto-fill if title is empty or was auto-generated
        if (!currentTitle || currentTitle.match(/^Thiệp cưới .+ & .+$/)) {
            if (groom && bride) {
                $('#title').val(`Thiệp cưới ${groom} & ${bride}`);
            }
        }
    });
    
    // Form submit loading state
    $('#create-form').on('submit', function() {
        const btn = $('#submit-btn');
        btn.addClass('btn-loading');
        btn.find('i').removeClass('fa-wand-magic-sparkles').addClass('fa-spinner');
        btn.find('span').text('Đang tạo...');
    });
</script>
@endpush
