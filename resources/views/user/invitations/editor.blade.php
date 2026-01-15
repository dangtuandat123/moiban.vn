@extends('layouts.app')

@section('title', 'Chỉnh sửa thiệp - Mời Bạn')

@section('content')
<div class="flex h-[calc(100vh-4rem)]">
    <!-- Sidebar Editor -->
    <div class="w-96 bg-slate-900/95 border-r border-white/10 overflow-y-auto">
        <!-- Header -->
        <div class="sticky top-0 bg-slate-900 border-b border-white/10 p-4 z-10">
            <div class="flex items-center justify-between mb-2">
                <a href="{{ route('user.invitations.show', $invitation) }}" class="text-white/60 hover:text-white text-sm">
                    <i class="fa-solid fa-arrow-left mr-2"></i>Quay lại
                </a>
                <span class="px-2 py-1 text-xs rounded {{ $invitation->status === 'active' ? 'bg-green-500/20 text-green-400' : 'bg-yellow-500/20 text-yellow-400' }}">
                    {{ $invitation->status_label }}
                </span>
            </div>
            <h2 class="text-lg font-semibold">{{ Str::limit($invitation->title, 25) }}</h2>
        </div>
        
        <form id="editor-form" method="POST" action="{{ route('user.invitations.editor.save', $invitation) }}" class="p-4">
            @csrf
            <input type="hidden" name="title" value="{{ $invitation->title }}">
            
            <!-- Tabs -->
            <div class="flex border-b border-white/10 mb-4">
                <button type="button" class="tab-btn active flex-1 py-2 text-sm" data-tab="content">
                    <i class="fa-solid fa-pen mr-1"></i> Nội dung
                </button>
                <button type="button" class="tab-btn flex-1 py-2 text-sm text-white/60" data-tab="style">
                    <i class="fa-solid fa-palette mr-1"></i> Giao diện
                </button>
                <button type="button" class="tab-btn flex-1 py-2 text-sm text-white/60" data-tab="widgets">
                    <i class="fa-solid fa-puzzle-piece mr-1"></i> Widgets
                </button>
            </div>
            
            <!-- Tab: Content -->
            <div id="tab-content" class="tab-panel">
                <!-- Thông tin cặp đôi -->
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-rose-gold mb-3 flex items-center">
                        <i class="fa-solid fa-heart mr-2"></i> Cô dâu & Chú rể
                    </h3>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs text-white/60 mb-1">Tên chú rể</label>
                            <input type="text" name="content[groom_name]" 
                                   value="{{ $invitation->content['groom_name'] ?? '' }}"
                                   class="w-full p-2.5 text-sm bg-white/5 border border-white/10 rounded-lg focus:border-rose-gold focus:outline-none transition"
                                   placeholder="Minh Anh">
                        </div>
                        <div>
                            <label class="block text-xs text-white/60 mb-1">Tên cô dâu</label>
                            <input type="text" name="content[bride_name]" 
                                   value="{{ $invitation->content['bride_name'] ?? '' }}"
                                   class="w-full p-2.5 text-sm bg-white/5 border border-white/10 rounded-lg focus:border-rose-gold focus:outline-none transition"
                                   placeholder="Thùy Linh">
                        </div>
                        <div>
                            <label class="block text-xs text-white/60 mb-1">Lời chào mừng</label>
                            <textarea name="content[couple_message]" rows="3"
                                      class="w-full p-2.5 text-sm bg-white/5 border border-white/10 rounded-lg focus:border-rose-gold focus:outline-none transition resize-none"
                                      placeholder="Cảm ơn bạn đã ghé thăm...">{{ $invitation->content['couple_message'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
                
                <!-- Thông tin sự kiện -->
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-rose-gold mb-3 flex items-center">
                        <i class="fa-solid fa-calendar mr-2"></i> Sự kiện
                    </h3>
                    
                    <div class="space-y-3">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs text-white/60 mb-1">Ngày cưới</label>
                                <input type="date" name="content[event_date]" 
                                       value="{{ $invitation->content['event_date'] ?? '' }}"
                                       class="w-full p-2.5 text-sm bg-white/5 border border-white/10 rounded-lg focus:border-rose-gold focus:outline-none transition">
                            </div>
                            <div>
                                <label class="block text-xs text-white/60 mb-1">Giờ</label>
                                <input type="time" name="content[event_time]" 
                                       value="{{ $invitation->content['event_time'] ?? '10:00' }}"
                                       class="w-full p-2.5 text-sm bg-white/5 border border-white/10 rounded-lg focus:border-rose-gold focus:outline-none transition">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs text-white/60 mb-1">Tên địa điểm</label>
                            <input type="text" name="content[venue_name]" 
                                   value="{{ $invitation->content['venue_name'] ?? '' }}"
                                   class="w-full p-2.5 text-sm bg-white/5 border border-white/10 rounded-lg focus:border-rose-gold focus:outline-none transition"
                                   placeholder="Trung tâm Hội nghị ABC">
                        </div>
                        <div>
                            <label class="block text-xs text-white/60 mb-1">Địa chỉ</label>
                            <input type="text" name="content[venue_address]" 
                                   value="{{ $invitation->content['venue_address'] ?? '' }}"
                                   class="w-full p-2.5 text-sm bg-white/5 border border-white/10 rounded-lg focus:border-rose-gold focus:outline-none transition"
                                   placeholder="123 Đường ABC, Quận 1, TP.HCM">
                        </div>
                        <div>
                            <label class="block text-xs text-white/60 mb-1">Lời mời</label>
                            <textarea name="content[event_message]" rows="2"
                                      class="w-full p-2.5 text-sm bg-white/5 border border-white/10 rounded-lg focus:border-rose-gold focus:outline-none transition resize-none"
                                      placeholder="Trân trọng kính mời...">{{ $invitation->content['event_message'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
                
                <!-- VietQR mừng tiền -->
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-rose-gold mb-3 flex items-center">
                        <i class="fa-solid fa-qrcode mr-2"></i> QR Mừng tiền
                    </h3>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs text-white/60 mb-1">Mã ngân hàng (VietQR)</label>
                            <select name="content[bank_code]" class="w-full p-2.5 text-sm bg-white/5 border border-white/10 rounded-lg focus:border-rose-gold focus:outline-none transition">
                                <option value="">-- Chọn ngân hàng --</option>
                                <option value="970416" {{ ($invitation->content['bank_code'] ?? '') == '970416' ? 'selected' : '' }}>ACB</option>
                                <option value="970422" {{ ($invitation->content['bank_code'] ?? '') == '970422' ? 'selected' : '' }}>MB Bank</option>
                                <option value="970415" {{ ($invitation->content['bank_code'] ?? '') == '970415' ? 'selected' : '' }}>Vietinbank</option>
                                <option value="970436" {{ ($invitation->content['bank_code'] ?? '') == '970436' ? 'selected' : '' }}>Vietcombank</option>
                                <option value="970418" {{ ($invitation->content['bank_code'] ?? '') == '970418' ? 'selected' : '' }}>BIDV</option>
                                <option value="970407" {{ ($invitation->content['bank_code'] ?? '') == '970407' ? 'selected' : '' }}>Techcombank</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs text-white/60 mb-1">Số tài khoản</label>
                            <input type="text" name="content[bank_account]" 
                                   value="{{ $invitation->content['bank_account'] ?? '' }}"
                                   class="w-full p-2.5 text-sm bg-white/5 border border-white/10 rounded-lg focus:border-rose-gold focus:outline-none transition"
                                   placeholder="0123456789">
                        </div>
                        <div>
                            <label class="block text-xs text-white/60 mb-1">Tên chủ TK</label>
                            <input type="text" name="content[bank_account_name]" 
                                   value="{{ $invitation->content['bank_account_name'] ?? '' }}"
                                   class="w-full p-2.5 text-sm bg-white/5 border border-white/10 rounded-lg focus:border-rose-gold focus:outline-none transition"
                                   placeholder="NGUYEN VAN A">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tab: Style -->
            <div id="tab-style" class="tab-panel hidden">
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-rose-gold mb-3 flex items-center">
                        <i class="fa-solid fa-fill-drip mr-2"></i> Màu sắc
                    </h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs text-white/60 mb-2">Màu chủ đạo</label>
                            <div class="flex items-center space-x-3">
                                <input type="color" name="content[primary_color]" 
                                       value="{{ $invitation->content['primary_color'] ?? '#b76e79' }}"
                                       class="w-12 h-12 p-1 bg-transparent border-2 border-white/20 rounded-lg cursor-pointer">
                                <input type="text" value="{{ $invitation->content['primary_color'] ?? '#b76e79' }}"
                                       class="flex-1 p-2.5 text-sm bg-white/5 border border-white/10 rounded-lg font-mono"
                                       id="primary-color-hex" readonly>
                            </div>
                        </div>
                        
                        <!-- Quick colors -->
                        <div>
                            <label class="block text-xs text-white/60 mb-2">Chọn nhanh</label>
                            <div class="flex flex-wrap gap-2">
                                <button type="button" class="color-preset w-8 h-8 rounded-full border-2 border-white/20 hover:border-white/50 transition" style="background:#b76e79" data-color="#b76e79"></button>
                                <button type="button" class="color-preset w-8 h-8 rounded-full border-2 border-white/20 hover:border-white/50 transition" style="background:#d4af37" data-color="#d4af37"></button>
                                <button type="button" class="color-preset w-8 h-8 rounded-full border-2 border-white/20 hover:border-white/50 transition" style="background:#2d3436" data-color="#2d3436"></button>
                                <button type="button" class="color-preset w-8 h-8 rounded-full border-2 border-white/20 hover:border-white/50 transition" style="background:#6c5ce7" data-color="#6c5ce7"></button>
                                <button type="button" class="color-preset w-8 h-8 rounded-full border-2 border-white/20 hover:border-white/50 transition" style="background:#00cec9" data-color="#00cec9"></button>
                                <button type="button" class="color-preset w-8 h-8 rounded-full border-2 border-white/20 hover:border-white/50 transition" style="background:#e17055" data-color="#e17055"></button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-rose-gold mb-3 flex items-center">
                        <i class="fa-solid fa-font mr-2"></i> Typography
                    </h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs text-white/60 mb-2">Font tiêu đề</label>
                            <select name="content[font_heading]" class="w-full p-2.5 text-sm bg-white/5 border border-white/10 rounded-lg focus:border-rose-gold focus:outline-none transition">
                                <option value="Great Vibes" {{ ($invitation->content['font_heading'] ?? '') == 'Great Vibes' ? 'selected' : '' }} style="font-family: 'Great Vibes'">Great Vibes (Script)</option>
                                <option value="Playfair Display" {{ ($invitation->content['font_heading'] ?? '') == 'Playfair Display' ? 'selected' : '' }}>Playfair Display (Elegant)</option>
                                <option value="Cormorant Garamond" {{ ($invitation->content['font_heading'] ?? '') == 'Cormorant Garamond' ? 'selected' : '' }}>Cormorant Garamond (Classic)</option>
                                <option value="Dancing Script" {{ ($invitation->content['font_heading'] ?? '') == 'Dancing Script' ? 'selected' : '' }}>Dancing Script (Handwriting)</option>
                                <option value="Pinyon Script" {{ ($invitation->content['font_heading'] ?? '') == 'Pinyon Script' ? 'selected' : '' }}>Pinyon Script (Formal)</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-xs text-white/60 mb-2">Font nội dung</label>
                            <select name="content[font_body]" class="w-full p-2.5 text-sm bg-white/5 border border-white/10 rounded-lg focus:border-rose-gold focus:outline-none transition">
                                <option value="Be Vietnam Pro" {{ ($invitation->content['font_body'] ?? '') == 'Be Vietnam Pro' ? 'selected' : '' }}>Be Vietnam Pro (Việt Nam)</option>
                                <option value="Inter" {{ ($invitation->content['font_body'] ?? '') == 'Inter' ? 'selected' : '' }}>Inter (Modern)</option>
                                <option value="Montserrat" {{ ($invitation->content['font_body'] ?? '') == 'Montserrat' ? 'selected' : '' }}>Montserrat (Geometric)</option>
                                <option value="Roboto" {{ ($invitation->content['font_body'] ?? '') == 'Roboto' ? 'selected' : '' }}>Roboto (Clean)</option>
                                <option value="Open Sans" {{ ($invitation->content['font_body'] ?? '') == 'Open Sans' ? 'selected' : '' }}>Open Sans (Friendly)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tab: Widgets -->
            <div id="tab-widgets" class="tab-panel hidden">
                <p class="text-sm text-white/60 mb-4">Bật/tắt các tính năng cho thiệp của bạn</p>
                
                @foreach($invitation->widgets as $widget)
                <div class="flex items-center justify-between p-3 mb-2 rounded-lg bg-white/5 hover:bg-white/10 transition">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-lg bg-rose-gold/20 flex items-center justify-center">
                            <i class="{{ $widget->icon }} text-rose-gold"></i>
                        </div>
                        <div>
                            <span class="text-sm font-medium">{{ $widget->label }}</span>
                            <p class="text-xs text-white/50">{{ $widget->description }}</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="widgets[{{ $widget->widget_type }}][enabled]" value="1"
                               {{ $widget->is_enabled ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-white/20 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-rose-gold"></div>
                    </label>
                </div>
                @endforeach
            </div>
            
            <!-- Save Button -->
            <div class="sticky bottom-0 bg-slate-900 pt-4 pb-2 border-t border-white/10 mt-6">
                <button type="submit" class="glass-btn w-full py-3 flex items-center justify-center">
                    <i class="fa-solid fa-save mr-2"></i> Lưu thay đổi
                </button>
                <p class="text-xs text-center text-white/40 mt-2">Ctrl + S để lưu nhanh</p>
            </div>
        </form>
    </div>
    
    <!-- Preview Panel -->
    <div class="flex-1 bg-slate-800 p-4 overflow-hidden">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-4">
                <h3 class="font-semibold">Xem trước</h3>
                <div class="flex bg-white/10 rounded-lg p-1">
                    <button type="button" class="device-btn active px-3 py-1 rounded text-sm" data-device="mobile">
                        <i class="fa-solid fa-mobile-screen"></i>
                    </button>
                    <button type="button" class="device-btn px-3 py-1 rounded text-sm text-white/60" data-device="tablet">
                        <i class="fa-solid fa-tablet-screen-button"></i>
                    </button>
                    <button type="button" class="device-btn px-3 py-1 rounded text-sm text-white/60" data-device="desktop">
                        <i class="fa-solid fa-desktop"></i>
                    </button>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <button type="button" id="refresh-preview" class="text-white/60 hover:text-white transition">
                    <i class="fa-solid fa-rotate"></i>
                </button>
                <a href="{{ $invitation->public_url }}" target="_blank" class="text-sm text-rose-gold hover:underline">
                    <i class="fa-solid fa-external-link mr-1"></i> Mở tab mới
                </a>
            </div>
        </div>
        
        <div id="preview-container" class="flex justify-center items-start h-[calc(100%-3rem)] overflow-auto">
            <div id="preview-frame" class="bg-white rounded-2xl shadow-2xl overflow-hidden transition-all duration-300" style="width: 375px; height: 667px;">
                <iframe id="preview-iframe" src="{{ $invitation->public_url }}" class="w-full h-full border-0"></iframe>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    main { padding-top: 0 !important; }
    .tab-btn.active { color: #fff; border-bottom: 2px solid #b76e79; }
    .device-btn.active { background: rgba(255,255,255,0.2); color: #fff; }
</style>
@endpush

@push('scripts')
<script>
    // Tab switching
    $('.tab-btn').on('click', function() {
        const tab = $(this).data('tab');
        $('.tab-btn').removeClass('active').addClass('text-white/60');
        $(this).addClass('active').removeClass('text-white/60');
        $('.tab-panel').addClass('hidden');
        $(`#tab-${tab}`).removeClass('hidden');
    });
    
    // Color picker sync
    $('input[name="content[primary_color]"]').on('input', function() {
        $('#primary-color-hex').val($(this).val());
    });
    
    // Color presets
    $('.color-preset').on('click', function() {
        const color = $(this).data('color');
        $('input[name="content[primary_color]"]').val(color);
        $('#primary-color-hex').val(color);
    });
    
    // Device preview
    $('.device-btn').on('click', function() {
        const device = $(this).data('device');
        $('.device-btn').removeClass('active').addClass('text-white/60');
        $(this).addClass('active').removeClass('text-white/60');
        
        const sizes = {
            mobile: { width: '375px', height: '667px' },
            tablet: { width: '768px', height: '600px' },
            desktop: { width: '100%', height: '100%' }
        };
        
        $('#preview-frame').css(sizes[device]);
    });
    
    // Refresh preview
    $('#refresh-preview').on('click', function() {
        $('#preview-iframe').attr('src', $('#preview-iframe').attr('src'));
    });
    
    // Keyboard shortcut Ctrl+S
    $(document).on('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            $('#editor-form').submit();
        }
    });
</script>
@endpush
