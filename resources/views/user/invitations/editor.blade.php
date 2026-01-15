@extends('layouts.app')

@section('title', 'Chỉnh sửa thiệp - Mời Bạn')

@section('content')
<div class="editor-layout">
    <!-- Mobile Header -->
    <div class="editor-mobile-header lg:hidden">
        <div class="flex items-center justify-between p-3 bg-slate-900/95 border-b border-white/10">
            <div class="flex items-center gap-3">
                <a href="{{ route('user.invitations.show', $invitation) }}" class="text-white/60 hover:text-white">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <span class="font-semibold text-sm">{{ Str::limit($invitation->title, 20) }}</span>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" id="toggle-preview-mobile" class="p-2 text-white/60 hover:text-white">
                    <i class="fa-solid fa-eye"></i>
                </button>
                <button type="submit" form="editor-form" class="px-3 py-1.5 bg-primary-500 rounded-lg text-sm font-medium">
                    <i class="fa-solid fa-save"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile Tabs -->
        <div class="flex border-b border-white/10 bg-slate-900">
            <button type="button" class="mobile-tab-btn active flex-1 py-2.5 text-xs" data-tab="content">
                <i class="fa-solid fa-pen mr-1"></i>Nội dung
            </button>
            <button type="button" class="mobile-tab-btn flex-1 py-2.5 text-xs text-white/60" data-tab="style">
                <i class="fa-solid fa-palette mr-1"></i>Giao diện
            </button>
            <button type="button" class="mobile-tab-btn flex-1 py-2.5 text-xs text-white/60" data-tab="widgets">
                <i class="fa-solid fa-puzzle-piece mr-1"></i>Widgets
            </button>
        </div>
    </div>
    
    <!-- Main Layout -->
    <div class="editor-main flex flex-col lg:flex-row h-[calc(100vh-108px)] lg:h-[calc(100vh-64px)]">
        
        <!-- Sidebar Editor -->
        <div class="editor-sidebar w-full lg:w-80 xl:w-96 bg-slate-900/95 border-r border-white/10 overflow-y-auto order-2 lg:order-1" id="editor-sidebar">
            <!-- Desktop Header -->
            <div class="hidden lg:block sticky top-0 bg-slate-900 border-b border-white/10 p-4 z-10">
                <div class="flex items-center justify-between mb-2">
                    <a href="{{ route('user.invitations.show', $invitation) }}" class="text-white/60 hover:text-white text-sm">
                        <i class="fa-solid fa-arrow-left mr-1"></i>Quay lại
                    </a>
                    <span class="status-badge">
                        {{ $invitation->status_label }}
                    </span>
                </div>
                <h2 class="font-semibold">{{ Str::limit($invitation->title, 28) }}</h2>
            </div>
            
            <form id="editor-form" method="POST" action="{{ route('user.invitations.editor.save', $invitation) }}" class="p-4">
                @csrf
                <input type="hidden" name="title" value="{{ $invitation->title }}">
                
                <!-- Desktop Tabs -->
                <div class="hidden lg:flex border-b border-white/10 mb-4">
                    <button type="button" class="tab-btn active flex-1 py-2 text-sm" data-tab="content">
                        <i class="fa-solid fa-pen mr-1"></i>Nội dung
                    </button>
                    <button type="button" class="tab-btn flex-1 py-2 text-sm text-white/60" data-tab="style">
                        <i class="fa-solid fa-palette mr-1"></i>Giao diện
                    </button>
                    <button type="button" class="tab-btn flex-1 py-2 text-sm text-white/60" data-tab="widgets">
                        <i class="fa-solid fa-puzzle-piece mr-1"></i>Widgets
                    </button>
                </div>
                
                <!-- Tab: Content -->
                <div id="tab-content" class="tab-panel">
                    <!-- Thông tin cặp đôi -->
                    <div class="editor-section">
                        <h3 class="section-title">
                            <i class="fa-solid fa-heart"></i> Cô dâu & Chú rể
                        </h3>
                        
                        <div class="form-group">
                            <label>Tên chú rể</label>
                            <input type="text" name="content[groom_name]" 
                                   value="{{ $invitation->content['groom_name'] ?? '' }}"
                                   class="form-input" placeholder="Minh Anh">
                        </div>
                        <div class="form-group">
                            <label>Tên cô dâu</label>
                            <input type="text" name="content[bride_name]" 
                                   value="{{ $invitation->content['bride_name'] ?? '' }}"
                                   class="form-input" placeholder="Thùy Linh">
                        </div>
                        <div class="form-group">
                            <label>Lời chào mừng</label>
                            <textarea name="content[couple_message]" rows="3" class="form-input"
                                      placeholder="Cảm ơn bạn đã ghé thăm...">{{ $invitation->content['couple_message'] ?? '' }}</textarea>
                        </div>
                    </div>
                    
                    <!-- Thông tin sự kiện -->
                    <div class="editor-section">
                        <h3 class="section-title">
                            <i class="fa-solid fa-calendar"></i> Sự kiện
                        </h3>
                        
                        <div class="grid grid-cols-2 gap-3">
                            <div class="form-group">
                                <label>Ngày cưới</label>
                                <input type="date" name="content[event_date]" 
                                       value="{{ $invitation->content['event_date'] ?? '' }}"
                                       class="form-input">
                            </div>
                            <div class="form-group">
                                <label>Giờ</label>
                                <input type="time" name="content[event_time]" 
                                       value="{{ $invitation->content['event_time'] ?? '10:00' }}"
                                       class="form-input">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tên địa điểm</label>
                            <input type="text" name="content[venue_name]" 
                                   value="{{ $invitation->content['venue_name'] ?? '' }}"
                                   class="form-input" placeholder="Trung tâm Hội nghị ABC">
                        </div>
                        <div class="form-group">
                            <label>Địa chỉ</label>
                            <input type="text" name="content[venue_address]" 
                                   value="{{ $invitation->content['venue_address'] ?? '' }}"
                                   class="form-input" placeholder="123 Đường ABC, Quận 1, TP.HCM">
                        </div>
                        <div class="form-group">
                            <label>Google Maps Link <span class="optional">(tùy chọn)</span></label>
                            <input type="url" name="content[maps_link]" 
                                   value="{{ $invitation->content['maps_link'] ?? '' }}"
                                   class="form-input" placeholder="https://maps.google.com/...">
                        </div>
                    </div>
                    
                    <!-- QR Mừng tiền -->
                    <div class="editor-section">
                        <h3 class="section-title">
                            <i class="fa-solid fa-qrcode"></i> QR Mừng tiền
                        </h3>
                        
                        <div class="form-group">
                            <label>Ngân hàng</label>
                            <select name="content[bank_code]" class="form-input">
                                <option value="">-- Chọn ngân hàng --</option>
                                @foreach([
                                    '970416' => 'ACB', '970422' => 'MB Bank', '970415' => 'Vietinbank',
                                    '970436' => 'Vietcombank', '970418' => 'BIDV', '970407' => 'Techcombank',
                                    '970423' => 'TPBank', '970403' => 'Sacombank', '970432' => 'VPBank'
                                ] as $code => $name)
                                    <option value="{{ $code }}" {{ ($invitation->content['bank_code'] ?? '') == $code ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Số tài khoản</label>
                            <input type="text" name="content[bank_account]" 
                                   value="{{ $invitation->content['bank_account'] ?? '' }}"
                                   class="form-input" placeholder="0123456789">
                        </div>
                        <div class="form-group">
                            <label>Tên chủ TK</label>
                            <input type="text" name="content[bank_account_name]" 
                                   value="{{ $invitation->content['bank_account_name'] ?? '' }}"
                                   class="form-input" placeholder="NGUYEN VAN A">
                        </div>
                    </div>
                </div>
                
                <!-- Tab: Style -->
                <div id="tab-style" class="tab-panel hidden">
                    <div class="editor-section">
                        <h3 class="section-title">
                            <i class="fa-solid fa-fill-drip"></i> Màu sắc
                        </h3>
                        
                        <div class="form-group">
                            <label>Màu chủ đạo</label>
                            <div class="color-picker-wrap">
                                <input type="color" name="content[primary_color]" id="primary-color"
                                       value="{{ $invitation->content['primary_color'] ?? '#b76e79' }}"
                                       class="color-input">
                                <input type="text" id="primary-color-hex" 
                                       value="{{ $invitation->content['primary_color'] ?? '#b76e79' }}"
                                       class="form-input font-mono" readonly>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Chọn nhanh</label>
                            <div class="color-presets">
                                @foreach(['#b76e79', '#d4af37', '#2d3436', '#6c5ce7', '#00cec9', '#e17055', '#fd79a8', '#a29bfe'] as $color)
                                    <button type="button" class="color-preset" style="background:{{ $color }}" data-color="{{ $color }}"></button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <div class="editor-section">
                        <h3 class="section-title">
                            <i class="fa-solid fa-font"></i> Typography
                        </h3>
                        
                        <div class="form-group">
                            <label>Font tiêu đề</label>
                            <select name="content[font_heading]" class="form-input font-preview" id="font-heading">
                                @foreach([
                                    'Great Vibes' => 'Great Vibes (Script)',
                                    'Playfair Display' => 'Playfair Display (Elegant)',
                                    'Cormorant Garamond' => 'Cormorant Garamond (Classic)',
                                    'Dancing Script' => 'Dancing Script (Handwriting)',
                                    'Pinyon Script' => 'Pinyon Script (Formal)'
                                ] as $font => $label)
                                    <option value="{{ $font }}" {{ ($invitation->content['font_heading'] ?? 'Great Vibes') == $font ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Font nội dung</label>
                            <select name="content[font_body]" class="form-input" id="font-body">
                                @foreach([
                                    'Be Vietnam Pro' => 'Be Vietnam Pro (Việt Nam)',
                                    'Inter' => 'Inter (Modern)',
                                    'Montserrat' => 'Montserrat (Geometric)',
                                    'Roboto' => 'Roboto (Clean)',
                                    'Open Sans' => 'Open Sans (Friendly)'
                                ] as $font => $label)
                                    <option value="{{ $font }}" {{ ($invitation->content['font_body'] ?? 'Be Vietnam Pro') == $font ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Tab: Widgets -->
                <div id="tab-widgets" class="tab-panel hidden">
                    <p class="text-sm text-white/60 mb-4">Bật/tắt các tính năng cho thiệp</p>
                    
                    @php
                        $widgetIcons = [
                            'countdown' => 'fa-solid fa-clock',
                            'rsvp' => 'fa-solid fa-user-check',
                            'guestbook' => 'fa-solid fa-message',
                            'album' => 'fa-solid fa-images',
                            'music' => 'fa-solid fa-music',
                            'maps' => 'fa-solid fa-map-marker-alt',
                            'vietqr' => 'fa-solid fa-qrcode',
                        ];
                        $widgetLabels = [
                            'countdown' => 'Đếm ngược',
                            'rsvp' => 'Xác nhận tham dự',
                            'guestbook' => 'Sổ lưu bút',
                            'album' => 'Album ảnh',
                            'music' => 'Nhạc nền',
                            'maps' => 'Bản đồ',
                            'vietqr' => 'QR Mừng tiền',
                        ];
                    @endphp
                    
                    @foreach($invitation->widgets as $widget)
                    <div class="widget-toggle">
                        <div class="widget-info">
                            <div class="widget-icon">
                                <i class="{{ $widgetIcons[$widget->widget_type] ?? 'fa-solid fa-puzzle-piece' }}"></i>
                            </div>
                            <div>
                                <span class="widget-name">{{ $widgetLabels[$widget->widget_type] ?? $widget->widget_type }}</span>
                            </div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="widgets[{{ $widget->widget_type }}][enabled]" value="1"
                                   {{ $widget->is_enabled ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    @endforeach
                </div>
                
                <!-- Save Button (Desktop) -->
                <div class="hidden lg:block sticky bottom-0 bg-slate-900 pt-4 pb-2 border-t border-white/10 mt-6">
                    <button type="submit" class="w-full py-3 bg-primary-500 hover:bg-primary-600 rounded-xl font-semibold flex items-center justify-center gap-2 transition">
                        <i class="fa-solid fa-save"></i> Lưu thay đổi
                    </button>
                    <p class="text-xs text-center text-white/40 mt-2">
                        <kbd class="px-1.5 py-0.5 bg-white/10 rounded text-[10px]">Ctrl</kbd> + 
                        <kbd class="px-1.5 py-0.5 bg-white/10 rounded text-[10px]">S</kbd> để lưu nhanh
                    </p>
                </div>
            </form>
        </div>
        
        <!-- Preview Panel -->
        <div class="editor-preview flex-1 bg-slate-800 p-3 md:p-4 overflow-hidden order-1 lg:order-2 hidden lg:block" id="preview-panel">
            <div class="flex items-center justify-between mb-3 md:mb-4">
                <div class="flex items-center gap-3 md:gap-4">
                    <h3 class="font-semibold text-sm md:text-base">Xem trước</h3>
                    <div class="device-switcher hidden md:flex">
                        <button type="button" class="device-btn active" data-device="mobile" title="Mobile">
                            <i class="fa-solid fa-mobile-screen"></i>
                        </button>
                        <button type="button" class="device-btn" data-device="tablet" title="Tablet">
                            <i class="fa-solid fa-tablet-screen-button"></i>
                        </button>
                        <button type="button" class="device-btn" data-device="desktop" title="Desktop">
                            <i class="fa-solid fa-desktop"></i>
                        </button>
                    </div>
                </div>
                <div class="flex items-center gap-2 md:gap-3">
                    <button type="button" id="refresh-preview" class="p-2 text-white/60 hover:text-white transition" title="Làm mới">
                        <i class="fa-solid fa-rotate"></i>
                    </button>
                    <a href="{{ $invitation->public_url }}" target="_blank" class="text-xs md:text-sm text-primary-400 hover:underline">
                        <i class="fa-solid fa-external-link mr-1"></i><span class="hidden md:inline">Mở tab mới</span>
                    </a>
                </div>
            </div>
            
            <div id="preview-container" class="flex justify-center items-start h-[calc(100%-2.5rem)] md:h-[calc(100%-3rem)] overflow-auto">
                <div id="preview-frame" class="preview-device-mobile rounded-2xl overflow-hidden bg-white shadow-2xl">
                    <iframe id="preview-iframe" src="{{ $invitation->public_url }}" class="w-full h-full border-0"></iframe>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Mobile Preview Modal -->
    <div id="mobile-preview-modal" class="fixed inset-0 z-50 bg-black/90 hidden lg:hidden">
        <div class="flex flex-col h-full">
            <div class="flex items-center justify-between p-3 bg-slate-900">
                <span class="text-sm font-medium">Xem trước thiệp</span>
                <button type="button" id="close-preview-mobile" class="p-2 text-white/60 hover:text-white">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            <div class="flex-1 overflow-auto p-3">
                <div class="max-w-sm mx-auto rounded-2xl overflow-hidden bg-white">
                    <iframe id="mobile-preview-iframe" class="w-full h-[600px] border-0"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Layout */
    .editor-layout { min-height: 100vh; background: var(--color-surface-base); }
    
    /* Status badge */
    .status-badge {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        border-radius: 9999px;
        background: rgba(251, 191, 36, 0.2);
        color: #fbbf24;
    }
    
    /* Section & Form */
    .editor-section { margin-bottom: 1.5rem; }
    .section-title {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--color-primary-500, #b76e79);
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .form-group { margin-bottom: 0.75rem; }
    .form-group label {
        display: block;
        font-size: 0.75rem;
        color: rgba(255,255,255,0.6);
        margin-bottom: 0.375rem;
    }
    .form-group .optional { font-weight: normal; color: rgba(255,255,255,0.4); }
    .form-input {
        width: 100%;
        padding: 0.625rem 0.75rem;
        font-size: 0.875rem;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 0.5rem;
        color: white;
        transition: border-color 0.2s;
    }
    .form-input:hover { border-color: rgba(255,255,255,0.2); }
    .form-input:focus { border-color: var(--color-primary-500); outline: none; }
    
    /* Tabs */
    .tab-btn, .mobile-tab-btn { border-bottom: 2px solid transparent; transition: all 0.2s; }
    .tab-btn.active, .mobile-tab-btn.active { 
        color: #fff !important; 
        border-bottom-color: var(--color-primary-500); 
    }
    
    /* Color picker */
    .color-picker-wrap { display: flex; gap: 0.75rem; align-items: center; }
    .color-input {
        width: 3rem;
        height: 3rem;
        padding: 0.25rem;
        background: transparent;
        border: 2px solid rgba(255,255,255,0.2);
        border-radius: 0.5rem;
        cursor: pointer;
    }
    .color-presets { display: flex; flex-wrap: wrap; gap: 0.5rem; }
    .color-preset {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        border: 2px solid rgba(255,255,255,0.2);
        cursor: pointer;
        transition: all 0.2s;
    }
    .color-preset:hover { border-color: white; transform: scale(1.1); }
    
    /* Widget toggle */
    .widget-toggle {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem;
        margin-bottom: 0.5rem;
        background: rgba(255,255,255,0.05);
        border-radius: 0.75rem;
        transition: background 0.2s;
    }
    .widget-toggle:hover { background: rgba(255,255,255,0.08); }
    .widget-info { display: flex; align-items: center; gap: 0.75rem; }
    .widget-icon {
        width: 2.25rem;
        height: 2.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(183,110,121,0.2);
        border-radius: 0.5rem;
        color: var(--color-primary-500);
    }
    .widget-name { font-size: 0.875rem; font-weight: 500; }
    
    /* Toggle switch */
    .toggle-switch { position: relative; display: inline-block; width: 2.75rem; height: 1.5rem; }
    .toggle-switch input { opacity: 0; width: 0; height: 0; }
    .toggle-slider {
        position: absolute;
        inset: 0;
        background: rgba(255,255,255,0.2);
        border-radius: 9999px;
        transition: background 0.3s;
    }
    .toggle-slider::before {
        content: '';
        position: absolute;
        height: 1.125rem;
        width: 1.125rem;
        left: 0.1875rem;
        bottom: 0.1875rem;
        background: white;
        border-radius: 50%;
        transition: transform 0.3s;
    }
    .toggle-switch input:checked + .toggle-slider { background: var(--color-primary-500); }
    .toggle-switch input:checked + .toggle-slider::before { transform: translateX(1.25rem); }
    
    /* Device switcher */
    .device-switcher { display: flex; background: rgba(255,255,255,0.1); border-radius: 0.5rem; padding: 0.25rem; }
    .device-btn { 
        padding: 0.375rem 0.625rem; 
        border-radius: 0.375rem; 
        color: rgba(255,255,255,0.5);
        transition: all 0.2s;
    }
    .device-btn.active { background: rgba(255,255,255,0.2); color: white; }
    
    /* Preview frame sizes */
    .preview-device-mobile { width: 375px; height: 667px; }
    .preview-device-tablet { width: 768px; height: 600px; }
    .preview-device-desktop { width: 100%; height: 100%; }
    
    /* Mobile responsive */
    @media (max-width: 1023px) {
        .editor-sidebar { 
            height: calc(100vh - 108px);
            overflow-y: auto;
        }
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Tab switching (Desktop & Mobile)
    $('.tab-btn, .mobile-tab-btn').on('click', function() {
        const tab = $(this).data('tab');
        
        // Update desktop tabs
        $('.tab-btn').removeClass('active').addClass('text-white/60');
        $(`.tab-btn[data-tab="${tab}"]`).addClass('active').removeClass('text-white/60');
        
        // Update mobile tabs
        $('.mobile-tab-btn').removeClass('active').addClass('text-white/60');
        $(`.mobile-tab-btn[data-tab="${tab}"]`).addClass('active').removeClass('text-white/60');
        
        // Show panel
        $('.tab-panel').addClass('hidden');
        $(`#tab-${tab}`).removeClass('hidden');
    });
    
    // Color picker sync
    $('#primary-color').on('input', function() {
        $('#primary-color-hex').val($(this).val());
    });
    
    // Color presets
    $('.color-preset').on('click', function() {
        const color = $(this).data('color');
        $('#primary-color').val(color);
        $('#primary-color-hex').val(color);
    });
    
    // Device preview
    $('.device-btn').on('click', function() {
        const device = $(this).data('device');
        $('.device-btn').removeClass('active');
        $(this).addClass('active');
        
        $('#preview-frame').removeClass('preview-device-mobile preview-device-tablet preview-device-desktop')
                           .addClass(`preview-device-${device}`);
    });
    
    // Refresh preview
    $('#refresh-preview').on('click', function() {
        const iframe = $('#preview-iframe')[0];
        iframe.src = iframe.src;
    });
    
    // Keyboard shortcut Ctrl+S
    $(document).on('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            $('#editor-form').submit();
        }
    });
    
    // Mobile preview toggle
    $('#toggle-preview-mobile').on('click', function() {
        const modal = $('#mobile-preview-modal');
        const iframe = $('#mobile-preview-iframe');
        iframe.attr('src', '{{ $invitation->public_url }}');
        modal.removeClass('hidden');
    });
    
    $('#close-preview-mobile').on('click', function() {
        $('#mobile-preview-modal').addClass('hidden');
        $('#mobile-preview-iframe').attr('src', '');
    });
    
    // Form submit feedback
    $('#editor-form').on('submit', function() {
        const btn = $(this).find('button[type="submit"]');
        btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin mr-2"></i>Đang lưu...');
    });
});
</script>
@endpush
