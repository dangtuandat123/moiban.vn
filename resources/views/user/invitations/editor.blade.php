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
            <a href="{{ $invitation->public_url }}" target="_blank" class="toolbar-btn toolbar-btn-secondary hidden md:inline-flex">
                <i class="fa-solid fa-external-link"></i>
                <span class="hidden lg:inline">Xem thiệp</span>
            </a>
            <button type="submit" form="editor-form" class="toolbar-btn toolbar-btn-primary" id="save-btn">
                <i class="fa-solid fa-save"></i>
                <span>Lưu</span>
            </button>
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
                        <div class="form-section">
                            <h3 class="section-header">
                                <i class="fa-solid fa-heart"></i> Cô dâu & Chú rể
                            </h3>
                            
                            <div class="form-grid-2">
                                <div class="form-group">
                                    <label class="form-label">Tên chú rể</label>
                                    <input type="text" name="content[groom_name]" 
                                           value="{{ $invitation->content['groom_name'] ?? '' }}"
                                           class="form-input" placeholder="Minh Anh">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Tên cô dâu</label>
                                    <input type="text" name="content[bride_name]" 
                                           value="{{ $invitation->content['bride_name'] ?? '' }}"
                                           class="form-input" placeholder="Thùy Linh">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Lời chào mừng <span class="optional">(tùy chọn)</span></label>
                                <textarea name="content[couple_message]" rows="3" class="form-input"
                                          placeholder="Cảm ơn bạn đã ghé thăm thiệp cưới của chúng tôi...">{{ $invitation->content['couple_message'] ?? '' }}</textarea>
                            </div>
                        </div>
                        
                        <!-- Sự kiện -->
                        <div class="form-section">
                            <h3 class="section-header">
                                <i class="fa-solid fa-calendar"></i> Thông tin sự kiện
                            </h3>
                            
                            <div class="form-grid-2">
                                <div class="form-group">
                                    <label class="form-label">Ngày cưới</label>
                                    <input type="date" name="content[event_date]" 
                                           value="{{ $invitation->content['event_date'] ?? '' }}"
                                           class="form-input">
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
                                       class="form-input" placeholder="Trung tâm Hội nghị ABC">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Địa chỉ</label>
                                <input type="text" name="content[venue_address]" 
                                       value="{{ $invitation->content['venue_address'] ?? '' }}"
                                       class="form-input" placeholder="123 Đường ABC, Quận 1, TP.HCM">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Google Maps Link <span class="optional">(tùy chọn)</span></label>
                                <input type="url" name="content[maps_link]" 
                                       value="{{ $invitation->content['maps_link'] ?? '' }}"
                                       class="form-input" placeholder="https://maps.google.com/...">
                                <p class="form-hint">Dán link Google Maps để khách dễ tìm đường</p>
                            </div>
                        </div>
                        
                        <!-- Album ảnh -->
                        <div class="form-section">
                            <h3 class="section-header">
                                <i class="fa-solid fa-images"></i> Album ảnh
                            </h3>
                            
                            <div class="upload-zone" id="album-upload-zone">
                                <input type="file" id="album-input" name="album_photos[]" multiple accept="image/*" class="hidden">
                                <i class="fa-solid fa-cloud-upload"></i>
                                <p><strong>Kéo thả ảnh vào đây</strong></p>
                                <p>hoặc nhấn để chọn từ máy</p>
                                <p class="form-hint" style="margin-top: 0.5rem;">Tối đa 10 ảnh, mỗi ảnh dưới 5MB</p>
                            </div>
                            
                            <div class="album-grid" id="album-preview">
                                @if(isset($invitation->content['album_photos']))
                                    @foreach($invitation->content['album_photos'] as $index => $photo)
                                    <div class="album-item" data-index="{{ $index }}">
                                        <img src="{{ $photo }}" alt="Album photo">
                                        <button type="button" class="album-item-remove" data-index="{{ $index }}">
                                            <i class="fa-solid fa-times"></i>
                                        </button>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                            <input type="hidden" name="content[album_photos]" id="album-photos-data" 
                                   value="{{ json_encode($invitation->content['album_photos'] ?? []) }}">
                        </div>
                        
                        <!-- QR Mừng tiền -->
                        <div class="form-section">
                            <h3 class="section-header">
                                <i class="fa-solid fa-qrcode"></i> QR Mừng tiền
                            </h3>
                            
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
                                           class="form-input" placeholder="0123456789">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Tên chủ TK</label>
                                    <input type="text" name="content[bank_account_name]" 
                                           value="{{ $invitation->content['bank_account_name'] ?? '' }}"
                                           class="form-input" placeholder="NGUYEN VAN A">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- ========== TAB: STYLE ========== -->
                    <div id="tab-style" class="tab-panel hidden">
                        <!-- Màu sắc -->
                        <div class="form-section">
                            <h3 class="section-header">
                                <i class="fa-solid fa-fill-drip"></i> Màu chủ đạo
                            </h3>
                            
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
                        
                        <!-- Typography -->
                        <div class="form-section">
                            <h3 class="section-header">
                                <i class="fa-solid fa-font"></i> Font chữ
                            </h3>
                            
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
                        
                        <!-- Nhạc nền -->
                        <div class="form-section">
                            <h3 class="section-header">
                                <i class="fa-solid fa-music"></i> Nhạc nền
                            </h3>
                            
                            <div class="form-group">
                                <label class="form-label">Link nhạc <span class="optional">(YouTube/SoundCloud)</span></label>
                                <input type="url" name="content[music_url]" 
                                       value="{{ $invitation->content['music_url'] ?? '' }}"
                                       class="form-input" placeholder="https://youtube.com/watch?v=...">
                                <p class="form-hint">Dán link video nhạc từ YouTube hoặc SoundCloud</p>
                            </div>
                            
                            <p class="form-label">Hoặc chọn nhạc có sẵn:</p>
                            <div class="music-presets">
                                <button type="button" class="music-preset" data-url="">💕 Tắt nhạc</button>
                                <button type="button" class="music-preset" data-url="/audio/romantic.mp3">🎵 Romantic</button>
                                <button type="button" class="music-preset" data-url="/audio/piano.mp3">🎹 Piano</button>
                                <button type="button" class="music-preset" data-url="/audio/acoustic.mp3">🎸 Acoustic</button>
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
                    <iframe id="preview-iframe" src="{{ $invitation->public_url }}"></iframe>
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
    
    $uploadZone.on('click', () => $albumInput.click());
    
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
            
            const reader = new FileReader();
            reader.onload = (e) => {
                albumPhotos.push(e.target.result);
                renderAlbumPreview();
            };
            reader.readAsDataURL(file);
        });
    }
    
    function renderAlbumPreview() {
        $albumPreview.html(albumPhotos.map((photo, i) => `
            <div class="album-item" data-index="${i}">
                <img src="${photo}" alt="Album photo">
                <button type="button" class="album-item-remove" data-index="${i}">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
        `).join(''));
        $albumData.val(JSON.stringify(albumPhotos));
    }
    
    $(document).on('click', '.album-item-remove', function() {
        const index = $(this).data('index');
        albumPhotos.splice(index, 1);
        renderAlbumPreview();
    });
    
    // ========== KEYBOARD SHORTCUTS ==========
    $(document).on('keydown', function(e) {
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
                },
                error: function() {
                    $autosaveStatus.removeClass('saving saved')
                        .html('<i class="fa-solid fa-exclamation-circle text-red-400"></i> <span class="text-red-400">Lỗi</span>');
                }
            });
        }, 2000); // Auto-save after 2 seconds of inactivity
    });
    
    // ========== FORM SUBMIT ==========
    $('#editor-form').on('submit', function(e) {
        e.preventDefault();
        clearTimeout(autoSaveTimer);
        
        const $btn = $('#save-btn');
        $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Đang lưu...');
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function() {
                showToast('✅ Đã lưu thành công!', 'success');
                $btn.prop('disabled', false).html('<i class="fa-solid fa-save"></i> <span>Lưu</span>');
                $autosaveStatus.removeClass('saving').addClass('saved')
                    .html('<i class="fa-solid fa-cloud-check"></i> <span>Đã lưu</span>');
                
                // Refresh preview
                $('#preview-iframe')[0].contentWindow.location.reload();
            },
            error: function(xhr) {
                showToast('❌ Có lỗi xảy ra!', 'error');
                $btn.prop('disabled', false).html('<i class="fa-solid fa-save"></i> <span>Lưu</span>');
            }
        });
    });
});
</script>
@endpush
