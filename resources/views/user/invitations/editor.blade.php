@extends('layouts.editor')

@section('title', 'Chỉnh sửa: ' . $invitation->title . ' - Mời Bạn')

@section('content')
<div class="editor-app">
    <!-- ========== TOOLBAR ========== -->
    <header class="editor-toolbar">
        <div class="toolbar-left">
            <a href="{{ route('user.invitations.show', $invitation) }}" class="toolbar-btn toolbar-btn-ghost toolbar-btn-icon" title="Quay lại">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <span class="toolbar-title">{{ $invitation->title }}</span>
            <span class="autosave-indicator" id="autosave-status">
                <i class="fa-solid fa-cloud-check"></i>
                <span>Đã lưu</span>
            </span>
        </div>

        <div class="toolbar-right">
            <a href="{{ $invitation->public_url }}" target="_blank" class="toolbar-btn toolbar-btn-secondary">
                <i class="fa-solid fa-external-link"></i>
                <span class="hidden lg:inline">Xem thiệp</span>
            </a>
        </div>
    </header>
    
    <!-- ========== MAIN LAYOUT ========== -->
    <div class="editor-main">
        <!-- SIDEBAR -->
        <aside class="editor-sidebar active" id="sidebar-panel">
            <!-- Sidebar Tabs -->
            <div class="sidebar-tabs">
                <button type="button" class="sidebar-tab active" data-tab="content">
                    <i class="fa-solid fa-pen"></i> Nội dung
                </button>
                <button type="button" class="sidebar-tab" data-tab="style">
                    <i class="fa-solid fa-palette"></i> Giao diện
                </button>
                <button type="button" class="sidebar-tab" data-tab="widgets">
                    <i class="fa-solid fa-puzzle-piece"></i> Widgets
                </button>
            </div>
            
            <!-- Sidebar Content -->
            <div class="sidebar-content">
                <form id="editor-form" method="POST" action="{{ route('user.invitations.editor.save', $invitation) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="title" value="{{ $invitation->title }}">
                    
                    <!-- ========== TAB: CONTENT ========== -->
                    <div id="tab-content" class="tab-panel">
                        <!-- Cặp đôi -->
                        <div class="form-section collapsible" data-section="couple">
                            <button type="button" class="section-header collapsible-toggle">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-heart"></i>
                                    <span>Cô dâu & Chú rể</span>
                                </div>
                                <i class="fa-solid fa-chevron-down section-arrow"></i>
                            </button>
                            <div class="section-body">

                            <div class="form-grid-2">
                                <div class="form-group">
                                    <label class="form-label">Tên chú rể</label>
                                    <input type="text" name="content[groom_name]" 
                                           value="{{ $invitation->content['groom_name'] ?? '' }}"
                                           class="form-input" placeholder="Minh Anh" maxlength="100">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Tên cô dâu</label>
                                    <input type="text" name="content[bride_name]" 
                                           value="{{ $invitation->content['bride_name'] ?? '' }}"
                                           class="form-input" placeholder="Thùy Linh" maxlength="100">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Lời chào mừng <span class="optional">(tùy chọn)</span></label>
                                <textarea name="content[couple_message]" rows="3" class="form-input"
                                          placeholder="Cảm ơn bạn đã ghé thăm thiệp cưới của chúng tôi...">{{ $invitation->content['couple_message'] ?? '' }}</textarea>
                            </div>
                            </div>
                        </div>
                        
                        <!-- Sự kiện -->
                        <div class="form-section collapsible" data-section="event">
                            <button type="button" class="section-header collapsible-toggle">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-calendar"></i>
                                    <span>Thông tin sự kiện</span>
                                </div>
                                <i class="fa-solid fa-chevron-down section-arrow"></i>
                            </button>
                            <div class="section-body">

                            <div class="form-grid-2">
                                <div class="form-group">
                                    <label class="form-label">Ngày cưới</label>
                                    <input type="date" name="content[event_date]" 
                                           value="{{ $invitation->content['event_date'] ?? '' }}"
                                           class="form-input" min="{{ date('Y-m-d') }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Giờ</label>
                                    <input type="time" name="content[event_time]" 
                                           value="{{ $invitation->content['event_time'] ?? '10:00' }}"
                                           class="form-input">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Tên địa điểm</label>
                                <input type="text" name="content[venue_name]" 
                                       value="{{ $invitation->content['venue_name'] ?? '' }}"
                                       class="form-input" placeholder="Trung tâm Hội nghị ABC" maxlength="255">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Địa chỉ</label>
                                <input type="text" name="content[venue_address]" 
                                       value="{{ $invitation->content['venue_address'] ?? '' }}"
                                       class="form-input" placeholder="123 Đường ABC, Quận 1, TP.HCM" maxlength="500">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Google Maps Link <span class="optional">(tùy chọn)</span></label>
                                <input type="url" name="content[maps_link]" 
                                       value="{{ $invitation->content['maps_link'] ?? '' }}"
                                       class="form-input" placeholder="https://maps.google.com/..." maxlength="500">
                                <p class="form-hint">Dán link Google Maps để khách dễ tìm đường. Chỉ chấp nhận link từ google.com hoặc goo.gl</p>
                            </div>
                            </div>

                        </div>
                        
                        <!-- Album ảnh -->
                        <div class="form-section collapsible" data-section="album">
                            <button type="button" class="section-header collapsible-toggle">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-images"></i>
                                    <span>Album ảnh</span>
                                </div>
                                <i class="fa-solid fa-chevron-down section-arrow"></i>
                            </button>
                            <div class="section-body">

                            <div class="upload-zone" id="album-upload-zone">
                                <input type="file" id="album-input" name="album_photos[]" multiple accept="image/*" class="hidden">
                                <i class="fa-solid fa-cloud-upload"></i>
                                <p><strong>Kéo thả ảnh vào đây</strong></p>
                                <p>hoặc nhấn để chọn từ máy</p>
                                <p class="form-hint" style="margin-top: 0.5rem;">Tối đa 10 ảnh, mỗi ảnh dưới 5MB</p>
                            </div>
                            
                            <div class="album-grid" id="album-preview">
                                @php
                                    $albumPhotos = $invitation->content['album_photos'] ?? [];
                                    if (is_string($albumPhotos)) {
                                        $albumPhotos = json_decode($albumPhotos, true) ?? [];
                                    }
                                @endphp
                                @if(is_array($albumPhotos) && count($albumPhotos) > 0)
                                    @foreach($albumPhotos as $index => $photo)
                                    <div class="album-item" data-index="{{ $index }}" data-url="{{ $photo }}">
                                        <img src="{{ $photo }}" alt="Album photo">
                                        <button type="button" class="album-item-remove" data-index="{{ $index }}" data-url="{{ $photo }}">
                                            <i class="fa-solid fa-times"></i>
                                        </button>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                            <input type="hidden" name="content[album_photos]" id="album-photos-data" 
                                   value="{{ json_encode($albumPhotos) }}">
                            </div>
                        </div>
                        
                        <!-- QR Mừng tiền -->
                        <div class="form-section collapsible collapsed" data-section="qr">
                            <button type="button" class="section-header collapsible-toggle">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-qrcode"></i>
                                    <span>QR Mừng tiền</span>
                                </div>
                                <i class="fa-solid fa-chevron-down section-arrow"></i>
                            </button>
                            <div class="section-body">

                            <div class="form-group">
                                <label class="form-label">Ngân hàng</label>
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
                            
                            <div class="form-grid-2">
                                <div class="form-group">
                                    <label class="form-label">Số tài khoản</label>
                                    <input type="text" name="content[bank_account]" 
                                           value="{{ $invitation->content['bank_account'] ?? '' }}"
                                           class="form-input" placeholder="0123456789"
                                           maxlength="20" pattern="[0-9]+" title="Chỉ nhập số">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Tên chủ TK</label>
                                    <input type="text" name="content[bank_account_name]" 
                                           value="{{ $invitation->content['bank_account_name'] ?? '' }}"
                                           class="form-input" placeholder="NGUYEN VAN A" maxlength="100">
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    
                    <!-- ========== TAB: STYLE ========== -->
                    <div id="tab-style" class="tab-panel hidden">
                        <!-- Màu sắc -->
                        <div class="form-section collapsible" data-section="color">
                            <button type="button" class="section-header collapsible-toggle">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-fill-drip"></i>
                                    <span>Màu chủ đạo</span>
                                </div>
                                <i class="fa-solid fa-chevron-down section-arrow"></i>
                            </button>
                            <div class="section-body">

                            <div class="form-group">
                                <div class="color-picker-row">
                                    <input type="color" name="content[primary_color]" id="primary-color"
                                           value="{{ $invitation->content['primary_color'] ?? '#b76e79' }}"
                                           class="color-picker-input">
                                    <input type="text" id="primary-color-hex" 
                                           value="{{ $invitation->content['primary_color'] ?? '#b76e79' }}"
                                           class="form-input font-mono" style="flex:1" readonly>
                                </div>
                                
                                <p class="form-label" style="margin-top:1rem; margin-bottom:0.5rem">Chọn nhanh:</p>
                                <div class="color-presets">
                                    @foreach(['#b76e79', '#d4af37', '#2d3436', '#6c5ce7', '#00cec9', '#e17055', '#fd79a8', '#a29bfe', '#55a3ff', '#00b894'] as $color)
                                        <button type="button" class="color-preset" style="background:{{ $color }}" data-color="{{ $color }}"></button>
                                    @endforeach
                                </div>
                            </div>
                            </div>
                        </div>
                        
                        <!-- Typography -->
                        <div class="form-section collapsible" data-section="typography">
                            <button type="button" class="section-header collapsible-toggle">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-font"></i>
                                    <span>Font chữ</span>
                                </div>
                                <i class="fa-solid fa-chevron-down section-arrow"></i>
                            </button>
                            <div class="section-body">
                            
                            <div class="form-group">
                                <label class="form-label">Font tiêu đề</label>
                                <select name="content[font_heading]" class="form-input">
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
                                <label class="form-label">Font nội dung</label>
                                <select name="content[font_body]" class="form-input">
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
                        
                        <!-- Nhạc nền -->
                        <div class="form-section collapsible" data-section="music">
                            <button type="button" class="section-header collapsible-toggle">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-music"></i>
                                    <span>Nhạc nền</span>
                                </div>
                                <i class="fa-solid fa-chevron-down section-arrow"></i>
                            </button>
                            <div class="section-body">
                            
                            @php
                                $musicSource = $invitation->content['music_source'] ?? 'off';
                                $hasUploadedFile = !empty($invitation->content['music_file']);
                                $hasYoutubeUrl = !empty($invitation->content['music_url']);
                            @endphp
                            
                            <!-- Chọn nguồn nhạc -->
                            <div class="form-group">
                                <label class="form-label mb-3">Chọn nguồn nhạc</label>
                                <div class="space-y-2">
                                    <!-- Option: Tắt nhạc -->
                                    <label class="music-option {{ $musicSource === 'off' ? 'active' : '' }}" data-source="off">
                                        <input type="radio" name="content[music_source]" value="off" 
                                               {{ $musicSource === 'off' ? 'checked' : '' }} class="hidden music-source-radio">
                                        <div class="music-option-radio">
                                            <i class="fa-solid fa-check"></i>
                                        </div>
                                        <div class="music-option-content">
                                            <div class="music-option-icon bg-gray-500/20">
                                                <i class="fa-solid fa-volume-xmark text-gray-400"></i>
                                            </div>
                                            <div>
                                                <span class="music-option-title">Tắt nhạc</span>
                                                <span class="music-option-desc">Không phát nhạc nền</span>
                                            </div>
                                        </div>
                                    </label>
                                    
                                    <!-- Option: File upload -->
                                    <label class="music-option {{ $musicSource === 'file' ? 'active' : '' }}" data-source="file">
                                        <input type="radio" name="content[music_source]" value="file" 
                                               {{ $musicSource === 'file' ? 'checked' : '' }} class="hidden music-source-radio">
                                        <div class="music-option-radio">
                                            <i class="fa-solid fa-check"></i>
                                        </div>
                                        <div class="music-option-content">
                                            <div class="music-option-icon bg-blue-500/20">
                                                <i class="fa-solid fa-file-audio text-blue-400"></i>
                                            </div>
                                            <div class="flex-1">
                                                <span class="music-option-title">Upload file nhạc</span>
                                                <span class="music-option-desc">MP3, WAV, OGG</span>
                                            </div>
                                        </div>
                                    </label>
                                    
                                    <!-- Option: YouTube URL -->
                                    <label class="music-option {{ $musicSource === 'url' ? 'active' : '' }}" data-source="url">
                                        <input type="radio" name="content[music_source]" value="url" 
                                               {{ $musicSource === 'url' ? 'checked' : '' }} class="hidden music-source-radio">
                                        <div class="music-option-radio">
                                            <i class="fa-solid fa-check"></i>
                                        </div>
                                        <div class="music-option-content">
                                            <div class="music-option-icon bg-red-500/20">
                                                <i class="fa-brands fa-youtube text-red-400"></i>
                                            </div>
                                            <div class="flex-1">
                                                <span class="music-option-title">Link YouTube</span>
                                                <span class="music-option-desc">Nhạc từ YouTube</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Upload file nhạc (hiện khi chọn file) -->
                            <div id="music-file-section" class="music-source-section mt-4 {{ $musicSource !== 'file' ? 'hidden' : '' }}">
                                <div class="p-4 bg-blue-500/5 border border-blue-500/20 rounded-lg">
                                    <div class="upload-zone" id="music-upload-zone" style="padding: 1rem;">
                                        <input type="file" id="music-input" accept=".mp3,.wav,.ogg" class="hidden">
                                        <i class="fa-solid fa-cloud-upload"></i>
                                        <span>Chọn file nhạc</span>
                                        <p class="text-xs text-white/40 mt-1">Tối đa {{ config('moiban.max_music_size', 10240) / 1024 }}MB</p>
                                    </div>
                                    @if($hasUploadedFile)
                                    <div id="current-music" class="flex items-center gap-2 mt-3 p-3 bg-green-500/10 border border-green-500/30 rounded-lg">
                                        <i class="fa-solid fa-music text-green-400"></i>
                                        <span class="flex-1 text-sm text-green-400">✅ Đã upload file nhạc</span>
                                        <button type="button" id="delete-music-btn" class="text-red-400 hover:text-red-300 p-1" title="Xóa file nhạc">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                    @else
                                    <div id="current-music" class="hidden flex items-center gap-2 mt-3 p-3 bg-green-500/10 border border-green-500/30 rounded-lg">
                                        <i class="fa-solid fa-music text-green-400"></i>
                                        <span class="flex-1 text-sm text-green-400">✅ Đã upload file nhạc</span>
                                        <button type="button" id="delete-music-btn" class="text-red-400 hover:text-red-300 p-1" title="Xóa file nhạc">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Link YouTube (hiện khi chọn url) -->
                            <div id="music-url-section" class="music-source-section mt-4 {{ $musicSource !== 'url' ? 'hidden' : '' }}">
                                <div class="p-4 bg-red-500/5 border border-red-500/20 rounded-lg">
                                    <div class="form-group mb-0">
                                        <input type="url" name="content[music_url]" id="music-url-input"
                                               value="{{ $invitation->content['music_url'] ?? '' }}"
                                               class="form-input" placeholder="https://youtube.com/watch?v=..." maxlength="500">
                                        <p class="form-hint mt-2">Dán link video nhạc từ YouTube</p>
                                    </div>
                                    <a href="https://www.youtube.com/results?search_query=nhạc+đám+cưới+không+lời" target="_blank" 
                                       class="inline-flex items-center gap-2 mt-3 px-3 py-1.5 bg-white/5 text-white/70 rounded-lg hover:bg-white/10 transition text-sm">
                                        <i class="fa-brands fa-youtube text-red-400"></i>
                                        <span>Tìm nhạc trên YouTube</span>
                                    </a>
                                </div>
                            </div>
                            
                            </div>
                        </div>
                    </div>




                    
                    <!-- ========== TAB: WIDGETS ========== -->
                    <div id="tab-widgets" class="tab-panel hidden">
                        <p class="form-hint" style="margin-bottom:1rem">Bật/tắt các tính năng cho thiệp của bạn</p>
                        
                        <div class="widget-list">
                            @php
                                $widgetConfig = [
                                    'countdown' => ['icon' => 'fa-solid fa-clock', 'label' => 'Đếm ngược', 'desc' => 'Hiển thị thời gian còn lại'],
                                    'rsvp' => ['icon' => 'fa-solid fa-user-check', 'label' => 'Xác nhận tham dự', 'desc' => 'Khách gửi RSVP'],
                                    'guestbook' => ['icon' => 'fa-solid fa-message', 'label' => 'Sổ lưu bút', 'desc' => 'Lời chúc từ khách'],
                                    'album' => ['icon' => 'fa-solid fa-images', 'label' => 'Album ảnh', 'desc' => 'Hiển thị ảnh cưới'],
                                    'music' => ['icon' => 'fa-solid fa-music', 'label' => 'Nhạc nền', 'desc' => 'Phát nhạc tự động'],
                                    'maps' => ['icon' => 'fa-solid fa-map-marker-alt', 'label' => 'Bản đồ', 'desc' => 'Chỉ đường đến địa điểm'],
                                    'vietqr' => ['icon' => 'fa-solid fa-qrcode', 'label' => 'QR Mừng tiền', 'desc' => 'Chuyển khoản nhanh'],
                                ];
                            @endphp
                            
                            @foreach($invitation->widgets as $widget)
                                @php $config = $widgetConfig[$widget->widget_type] ?? null; @endphp
                                @if($config)
                                <div class="widget-item">
                                    <div class="widget-info">
                                        <div class="widget-icon">
                                            <i class="{{ $config['icon'] }}"></i>
                                        </div>
                                        <div>
                                            <span class="widget-name">{{ $config['label'] }}</span>
                                        </div>
                                    </div>
                                    <label class="toggle-switch">
                                        {{-- Hidden input trick: send 0 when unchecked --}}
                                        <input type="hidden" name="widgets[{{ $widget->widget_type }}][enabled]" value="0">
                                        <input type="checkbox" name="widgets[{{ $widget->widget_type }}][enabled]" value="1"
                                               {{ $widget->is_enabled ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>
        </aside>
        
        <!-- PREVIEW -->
        <main class="editor-preview" id="preview-panel">
            <div class="preview-header">
                <span class="text-sm font-medium text-white/60">Xem trước</span>
                <div class="device-switcher">
                    <button type="button" class="device-btn active" data-device="mobile" title="Điện thoại">
                        <i class="fa-solid fa-mobile-screen"></i>
                    </button>
                    <button type="button" class="device-btn" data-device="tablet" title="Máy tính bảng">
                        <i class="fa-solid fa-tablet-screen-button"></i>
                    </button>
                    <button type="button" class="device-btn" data-device="desktop" title="Máy tính">
                        <i class="fa-solid fa-desktop"></i>
                    </button>
                </div>
                <button type="button" id="refresh-preview" class="toolbar-btn toolbar-btn-ghost toolbar-btn-icon" title="Làm mới">
                    <i class="fa-solid fa-rotate"></i>
                </button>
            </div>
            
            <div class="preview-container">
                <div id="preview-frame" class="preview-frame preview-frame-mobile">
                    <div id="iframe-loading" class="iframe-loading-overlay">
                        <i class="fa-solid fa-spinner fa-spin text-2xl text-white/60"></i>
                        <p class="text-sm text-white/40 mt-2">Đang tải xem trước...</p>
                    </div>
                    <iframe id="preview-iframe" src="{{ $invitation->public_url }}" onload="document.getElementById('iframe-loading').style.display='none'"></iframe>
                </div>
            </div>
        </main>
    </div>
    
    <!-- Mobile Toggle -->
    <div class="mobile-toggle">
        <button type="button" class="mobile-toggle-btn active" data-panel="sidebar">
            <i class="fa-solid fa-pen"></i> Chỉnh sửa
        </button>
        <button type="button" class="mobile-toggle-btn" data-panel="preview">
            <i class="fa-solid fa-eye"></i> Xem trước
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Cache selectors
    const $formInputs = $('#editor-form').find('input, select, textarea');

    // ========== TAB SWITCHING ==========

    $('.sidebar-tab').on('click', function() {
        const tab = $(this).data('tab');
        $('.sidebar-tab').removeClass('active');
        $(this).addClass('active');
        $('.tab-panel').addClass('hidden');
        $(`#tab-${tab}`).removeClass('hidden');
    });
    
    // ========== MOBILE PANEL TOGGLE ==========
    $('.mobile-toggle-btn').on('click', function() {
        const panel = $(this).data('panel');
        $('.mobile-toggle-btn').removeClass('active');
        $(this).addClass('active');
        
        if (panel === 'sidebar') {
            $('#sidebar-panel').addClass('active');
            $('#preview-panel').removeClass('active');
        } else {
            $('#sidebar-panel').removeClass('active');
            $('#preview-panel').addClass('active');
        }
    });
    
    // ========== COLOR PICKER ==========
    $('#primary-color').on('input', function() {
        $('#primary-color-hex').val($(this).val());
    });
    
    $('.color-preset').on('click', function() {
        const color = $(this).data('color');
        $('#primary-color').val(color);
        $('#primary-color-hex').val(color);
        $('.color-preset').removeClass('active');
        $(this).addClass('active');
    });
    
    // ========== MUSIC PRESETS ==========
    $('.music-preset').on('click', function() {
        const url = $(this).data('url');
        $('input[name="content[music_url]"]').val(url);
        $('.music-preset').removeClass('active');
        $(this).addClass('active');
    });
    
    // ========== DEVICE PREVIEW ==========
    $('.device-btn').on('click', function() {
        const device = $(this).data('device');
        $('.device-btn').removeClass('active');
        $(this).addClass('active');
        
        $('#preview-frame').removeClass('preview-frame-mobile preview-frame-tablet preview-frame-desktop')
                          .addClass(`preview-frame-${device}`);
    });
    
    // ========== REFRESH PREVIEW ==========
    $('#refresh-preview').on('click', function() {
        const iframe = $('#preview-iframe')[0];
        iframe.src = iframe.src;
    });
    
    // ========== ALBUM UPLOAD ==========
    const $uploadZone = $('#album-upload-zone');
    const $albumInput = $('#album-input');
    const $albumPreview = $('#album-preview');
    const $albumData = $('#album-photos-data');
    let albumPhotos = JSON.parse($albumData.val() || '[]');
    
    // Click on zone (but not on input) triggers file input
    $uploadZone.on('click', function(e) {
        // Prevent infinite loop: don't trigger if click came from input
        if (e.target === $albumInput[0]) return;
        $albumInput.trigger('click');
    });
    
    // Prevent input click from bubbling to zone
    $albumInput.on('click', function(e) {
        e.stopPropagation();
    });
    
    $uploadZone.on('dragover', (e) => {
        e.preventDefault();
        $uploadZone.css('border-color', 'var(--color-primary)');
    });
    
    $uploadZone.on('dragleave drop', () => {
        $uploadZone.css('border-color', '');
    });
    
    $uploadZone.on('drop', (e) => {
        e.preventDefault();
        handleFiles(e.originalEvent.dataTransfer.files);
    });
    
    $albumInput.on('change', function() {
        handleFiles(this.files);
    });
    
    function handleFiles(files) {
        if (albumPhotos.length + files.length > 10) {
            showToast('Tối đa 10 ảnh!', 'error');
            return;
        }
        
        Array.from(files).forEach(file => {
            if (file.size > 5 * 1024 * 1024) {
                showToast(`${file.name} quá lớn (max 5MB)`, 'error');
                return;
            }
            
            // Upload via AJAX
            const formData = new FormData();
            formData.append('photo', file);
            formData.append('_token', '{{ csrf_token() }}');
            
            // Show loading state
            const loadingHtml = `<div class="album-item loading"><i class="fa-solid fa-spinner fa-spin"></i></div>`;
            $albumPreview.append(loadingHtml);
            
            $.ajax({
                url: '{{ route("user.invitations.editor.upload", $invitation) }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    albumPhotos.push(response.url);
                    renderAlbumPreview();
                    showToast('✅ Đã upload ảnh!', 'success');
                },
                error: function() {
                    showToast('❌ Upload thất bại!', 'error');
                    $('.album-item.loading').last().remove();
                }
            });
        });
    }
    
    function renderAlbumPreview() {
        $albumPreview.html(albumPhotos.map((photo, i) => `
            <div class="album-item" data-index="${i}" data-url="${photo}">
                <img src="${photo}" alt="Album photo">
                <button type="button" class="album-item-remove" data-index="${i}" data-url="${photo}">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
        `).join(''));
        $albumData.val(JSON.stringify(albumPhotos));
    }
    
    $(document).on('click', '.album-item-remove', function() {
        const url = $(this).data('url');
        const $item = $(this).closest('.album-item');
        
        // Delete via AJAX
        $.ajax({
            url: '{{ route("user.invitations.editor.delete-photo", $invitation) }}',
            method: 'DELETE',
            data: { url: url, _token: '{{ csrf_token() }}' },
            success: function() {
                albumPhotos = albumPhotos.filter(p => p !== url);
                $item.fadeOut(() => $item.remove());
                $albumData.val(JSON.stringify(albumPhotos));
                showToast('✅ Đã xóa ảnh!', 'success');
            },
            error: function() {
                showToast('❌ Xóa thất bại!', 'error');
            }
        });
    });
    
    // ========== MUSIC UPLOAD ==========
    const $musicUploadZone = $('#music-upload-zone');
    const $musicInput = $('#music-input');
    
    // Click on zone triggers file input
    $musicUploadZone.on('click', function(e) {
        if (e.target === $musicInput[0]) return;
        $musicInput.trigger('click');
    });
    
    $musicInput.on('click', function(e) {
        e.stopPropagation();
    });
    
    $musicInput.on('change', function() {
        const file = this.files[0];
        if (!file) return;
        
        // Validate size
        const maxSize = {{ config('moiban.max_music_size', 10240) }} * 1024;
        if (file.size > maxSize) {
            showToast('❌ File nhạc quá lớn!', 'error');
            return;
        }
        
        // Upload via AJAX
        const formData = new FormData();
        formData.append('music', file);
        formData.append('_token', '{{ csrf_token() }}');
        
        $musicUploadZone.html('<i class="fa-solid fa-spinner fa-spin"></i> Đang upload...');
        
        $.ajax({
            url: '{{ route("user.invitations.editor.upload-music", $invitation) }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('input[name="content[music_url]"]').val(response.url);
                $musicUploadZone.html('<i class="fa-solid fa-cloud-upload"></i> <span>Chọn file nhạc</span>');
                
                // Show current music indicator
                if (!$('#current-music').length) {
                    $musicUploadZone.after(`
                        <div id="current-music" class="flex items-center gap-2 mt-2 p-2 bg-white/5 rounded">
                            <i class="fa-solid fa-music text-primary-400"></i>
                            <span class="flex-1 text-sm truncate">Đã upload file nhạc</span>
                            <button type="button" id="delete-music-btn" class="text-red-400 hover:text-red-300">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    `);
                }
                
                showToast('✅ Đã upload nhạc!', 'success');
            },
            error: function(xhr) {
                $musicUploadZone.html('<i class="fa-solid fa-cloud-upload"></i> <span>Chọn file nhạc</span>');
                showToast('❌ Upload thất bại!', 'error');
            }
        });
    });
    
    // Delete music handler moved to line 922 to avoid duplication
    
    // ========== KEYBOARD SHORTCUTS ==========
    $(document).on('keydown', function(e) {
        // Ctrl+S: Save
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            $('#editor-form').submit();
        }
    });

    
    // ========== AUTO-SAVE ==========
    let autoSaveTimer;
    const $autosaveStatus = $('#autosave-status');
    
    $('#editor-form').on('change input', 'input, select, textarea', function() {
        clearTimeout(autoSaveTimer);
        $autosaveStatus.removeClass('saved').addClass('saving')
            .html('<i class="fa-solid fa-spinner fa-spin"></i> <span>Đang lưu...</span>');
        
        autoSaveTimer = setTimeout(() => {
            // Auto-save via AJAX
            const formData = new FormData($('#editor-form')[0]);
            
            $.ajax({
                url: '{{ route('user.invitations.editor.save', $invitation) }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function() {
                    $autosaveStatus.removeClass('saving').addClass('saved')
                        .html('<i class="fa-solid fa-cloud-check"></i> <span>Đã lưu</span>');
                    
                    // Reload preview iframe
                    const iframe = $('#preview-iframe')[0];
                    if (iframe && iframe.contentWindow) {
                        iframe.contentWindow.location.reload();
                    }
                },
                error: function() {
                    $autosaveStatus.removeClass('saving saved')
                        .html('<i class="fa-solid fa-exclamation-circle text-red-400"></i> <span class="text-red-400">Lỗi</span>');
                }
            });
        }, 2000); // Auto-save after 2 seconds of inactivity
    });
    
    // ========== FORM SUBMIT (Ctrl+S) ==========
    $('#editor-form').on('submit', function(e) {
        e.preventDefault();
        clearTimeout(autoSaveTimer);
        
        // Show saving state
        $autosaveStatus.removeClass('saved').addClass('saving')
            .html('<i class="fa-solid fa-spinner fa-spin"></i> <span>Đang lưu...</span>');
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function() {
                showToast('✅ Đã lưu thành công!', 'success');
                $autosaveStatus.removeClass('saving').addClass('saved')
                    .html('<i class="fa-solid fa-cloud-check"></i> <span>Đã lưu</span>');
                
                // Refresh preview
                const iframe = $('#preview-iframe')[0];
                if (iframe && iframe.contentWindow) {
                    iframe.contentWindow.location.reload();
                }
            },
            error: function(xhr) {
                showToast('❌ Có lỗi xảy ra!', 'error');
                $autosaveStatus.removeClass('saving saved')
                    .html('<i class="fa-solid fa-exclamation-circle text-red-400"></i> <span class="text-red-400">Lỗi</span>');
            }
        });
    });

    
    // ========== COLLAPSIBLE SECTIONS ==========
    $('.collapsible-toggle').on('click', function(e) {
        e.preventDefault();
        const $section = $(this).closest('.form-section.collapsible');
        $section.toggleClass('collapsed');
        
        // Lưu trạng thái vào localStorage
        const sectionName = $section.data('section');
        const isCollapsed = $section.hasClass('collapsed');
        localStorage.setItem('editor_section_' + sectionName, isCollapsed ? 'collapsed' : 'expanded');
    });
    
    // Khôi phục trạng thái collapsed từ localStorage
    $('.form-section.collapsible').each(function() {
        const sectionName = $(this).data('section');
        const savedState = localStorage.getItem('editor_section_' + sectionName);
        if (savedState === 'collapsed') {
            $(this).addClass('collapsed');
        } else if (savedState === 'expanded') {
            $(this).removeClass('collapsed');
        }
    });
    
    // ========== MUSIC OPTIONS ==========
    // Show/hide sections dựa trên option được chọn
    function updateMusicSections() {
        const selectedValue = $('input[name="content[music_source]"]:checked').val();
        
        // Ẩn tất cả sections
        $('.music-source-section').addClass('hidden');
        
        // Hiện section tương ứng
        if (selectedValue === 'file') {
            $('#music-file-section').removeClass('hidden');
        } else if (selectedValue === 'url') {
            $('#music-url-section').removeClass('hidden');
        }
        // Nếu 'off' thì không hiện gì
    }
    
    // Handle radio button changes
    // Function to update UI state based on checked input
    function updateMusicOptionUI() {
        $('.music-option').removeClass('active');
        $('input[name="content[music_source]"]:checked').closest('.music-option').addClass('active');
        updateMusicSections();
    }

    // Handle radio button changes
    $(document).on('change', 'input[name="content[music_source]"]', function() {
        updateMusicOptionUI();
        
        // Trigger autosave
        if (typeof $formInputs !== 'undefined') {
            $formInputs.trigger('change');
        } else {
            $('#editor-form').trigger('change');
        }
        
        const value = $(this).val();
        if (value === 'off') {
            showToast('🔇 Đã tắt nhạc nền', 'info');
        } else if (value === 'file') {
            showToast('🎵 Upload file nhạc', 'success');
        } else if (value === 'url') {
            showToast('🎵 Nhập link YouTube', 'success');
        }
    });

    // Initialize state on load
    updateMusicOptionUI();
    
    // Xử lý xóa file nhạc
    $(document).on('click', '#delete-music-btn', function() {
        if (!confirm('Bạn có chắc muốn xóa file nhạc đã upload?')) return;
        
        // Xóa hidden input music_file
        $('input[name="content[music_file]"]').val('');
        
        // Ẩn current-music indicator
        $('#current-music').addClass('hidden');
        
        // Chuyển sang Tắt
        $('input[name="content[music_source]"][value="off"]').prop('checked', true).trigger('change');
        
        // Trigger autosave
        $formInputs.trigger('change');
        showToast('🗑️ Đã xóa file nhạc', 'info');
    });
});

// Toast Notification Helper
function showToast(message, type = 'info') {
    // Create toast container if not exists
    if (!$('#toast-container').length) {
        $('body').append('<div id="toast-container" class="fixed bottom-4 right-4 z-50 flex flex-col gap-2"></div>');
    }
    
    // Create toast element
    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        info: 'bg-blue-500',
        warning: 'bg-amber-500'
    };
    
    const icon = {
        success: 'fa-check-circle',
        error: 'fa-exclamation-circle',
        info: 'fa-info-circle',
        warning: 'fa-exclamation-triangle'
    };
    
    const toast = $(`
        <div class="toast-item ${colors[type] || colors.info} text-white px-4 py-3 rounded-lg shadow-lg transform transition-all duration-300 translate-y-10 opacity-0 flex items-center gap-3 min-w-[300px]">
            <i class="fa-solid ${icon[type] || icon.info}"></i>
            <span class="font-medium">${message}</span>
            <button class="ml-auto text-white/80 hover:text-white" onclick="$(this).parent().remove()">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
    `);
    
    $('#toast-container').append(toast);
    
    // Animate in
    requestAnimationFrame(() => {
        toast.removeClass('translate-y-10 opacity-0');
    });
    
    // Auto remove
    setTimeout(() => {
        toast.addClass('translate-y-10 opacity-0');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>




@endpush
