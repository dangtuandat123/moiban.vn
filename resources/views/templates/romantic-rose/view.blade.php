{{-- Template: Romantic Rose - Premium Wedding Invitation --}}
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $invitation->title }}</title>
    
    <!-- SEO Meta -->
    <meta name="description" content="Thiệp cưới của {{ $invitation->couple_name }}">
    <meta property="og:title" content="{{ $invitation->title }}">
    <meta property="og:description" content="Mời bạn đến dự lễ cưới của {{ $invitation->couple_name }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $invitation->public_url }}">
    <meta property="og:image" content="{{ route('og-image.png', $invitation->slug) }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600&family=Great+Vibes&family=Playfair+Display:wght@400;500;600&family=Dancing+Script:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @php
        $content = $invitation->content;
        $primaryColor = $content['primary_color'] ?? '#b76e79';
        $fontHeading = $content['font_heading'] ?? 'Great Vibes';
        $fontBody = $content['font_body'] ?? 'Be Vietnam Pro';
        $widgets = $invitation->widgets->where('is_enabled', true)->pluck('widget_type')->toArray();
    @endphp
    
    <style>
        :root {
            --primary: {{ $primaryColor }};
            --primary-light: {{ $primaryColor }}33;
            --cream: #f7e7ce;
            --white: #ffffff;
            --text: #4a4a4a;
            --text-light: #888888;
        }
        
        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        html {
            scroll-behavior: smooth;
        }
        
        body {
            font-family: '{{ $fontBody }}', 'Be Vietnam Pro', sans-serif;
            background: linear-gradient(180deg, var(--cream) 0%, var(--white) 20%, var(--white) 80%, var(--cream) 100%);
            min-height: 100vh;
            color: var(--text);
            overflow-x: hidden;
        }
        
        .font-script { 
            font-family: '{{ $fontHeading }}', 'Great Vibes', cursive; 
        }
        
        /* ========== ANIMATIONS ========== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        
        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out forwards;
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        .delay-1 { animation-delay: 0.2s; }
        .delay-2 { animation-delay: 0.4s; }
        .delay-3 { animation-delay: 0.6s; }
        
        /* ========== SECTIONS ========== */
        section {
            min-height: 100vh;
            padding: 60px 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
        }
        
        .section-title {
            font-family: '{{ $fontHeading }}', 'Great Vibes', cursive;
            font-size: clamp(2rem, 8vw, 3rem);
            color: var(--primary);
            margin-bottom: 2rem;
        }
        
        /* ========== HERO SECTION ========== */
        .hero {
            background: 
                radial-gradient(ellipse at top, var(--primary-light) 0%, transparent 50%),
                linear-gradient(180deg, var(--cream) 0%, var(--white) 100%);
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 200px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%23{{ substr($primaryColor, 1) }}' fill-opacity='0.1' d='M0,192L48,181.3C96,171,192,149,288,149.3C384,149,480,171,576,165.3C672,160,768,128,864,128C960,128,1056,160,1152,165.3C1248,171,1344,149,1392,138.7L1440,128L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z'%3E%3C/path%3E%3C/svg%3E") no-repeat;
            background-size: cover;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        .hero-badge {
            display: inline-block;
            padding: 0.5rem 1.5rem;
            background: var(--primary-light);
            border: 1px solid var(--primary);
            border-radius: 9999px;
            font-size: 0.75rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--primary);
            margin-bottom: 1.5rem;
        }
        
        .hero h1 {
            font-family: '{{ $fontHeading }}', 'Great Vibes', cursive;
            font-size: clamp(3rem, 12vw, 5rem);
            color: var(--primary);
            margin-bottom: 1rem;
            line-height: 1.2;
        }
        
        .hero .couple-names {
            font-size: clamp(1.5rem, 5vw, 2.5rem);
            font-weight: 300;
            letter-spacing: 0.1em;
            margin-bottom: 0.5rem;
        }
        
        .hero .couple-names .and {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            font-size: 1rem;
            margin: 0 0.5rem;
        }
        
        .hero .event-date {
            font-size: 1.2rem;
            color: var(--text-light);
            letter-spacing: 0.3em;
        }
        
        .scroll-indicator {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            animation: float 2s ease-in-out infinite;
        }
        .scroll-indicator i {
            font-size: 1.5rem;
            color: var(--primary);
        }
        
        /* ========== DECORATIVE ELEMENTS ========== */
        .heart-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin: 2rem 0;
            color: var(--primary);
        }
        .heart-divider::before,
        .heart-divider::after {
            content: '';
            width: 60px;
            height: 1px;
            background: var(--primary);
            opacity: 0.5;
        }
        
        /* ========== CARD ========== */
        .card {
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(10px);
            border-radius: 1.5rem;
            padding: 2rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
            max-width: 420px;
            width: 100%;
            border: 1px solid rgba(183,110,121,0.1);
        }
        
        /* ========== COUNTDOWN ========== */
        .countdown {
            display: flex;
            justify-content: center;
            gap: 0.75rem;
            margin: 2rem 0;
        }
        .countdown-item {
            background: linear-gradient(135deg, var(--white), var(--cream));
            border-radius: 1rem;
            padding: 1rem;
            min-width: 70px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }
        .countdown-item .number {
            font-size: clamp(1.5rem, 6vw, 2.5rem);
            font-weight: 600;
            color: var(--primary);
            line-height: 1;
        }
        .countdown-item .label {
            font-size: 0.65rem;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-top: 0.25rem;
        }
        
        /* ========== EVENT DETAILS ========== */
        .event-card {
            text-align: left;
        }
        .event-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px dashed rgba(0,0,0,0.1);
        }
        .event-item:last-child { border-bottom: none; }
        .event-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            flex-shrink: 0;
        }
        .event-info strong {
            display: block;
            margin-bottom: 0.25rem;
        }
        .event-info span {
            color: var(--text-light);
            font-size: 0.875rem;
        }
        
        /* ========== FORMS ========== */
        .form-group {
            margin-bottom: 1rem;
            text-align: left;
        }
        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--text);
        }
        .form-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 1.5px solid #e0e0e0;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-family: inherit;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 1rem 2rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(183,110,121,0.3);
        }
        
        /* ========== GUESTBOOK ========== */
        .guestbook-entries {
            max-height: 300px;
            overflow-y: auto;
            margin-bottom: 1.5rem;
        }
        .guestbook-entry {
            background: var(--cream);
            border-radius: 0.75rem;
            padding: 1rem;
            margin-bottom: 0.75rem;
            text-align: left;
        }
        .guestbook-entry .author {
            font-weight: 600;
            color: var(--primary);
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }
        .guestbook-entry .message {
            font-size: 0.9rem;
            line-height: 1.5;
        }
        
        /* ========== VIETQR ========== */
        .vietqr-card {
            text-align: center;
        }
        .vietqr-image {
            max-width: 200px;
            margin: 1rem auto;
            border-radius: 0.75rem;
            overflow: hidden;
            background: white;
            padding: 0.5rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .vietqr-image img {
            width: 100%;
            height: auto;
        }
        .vietqr-info {
            font-size: 0.875rem;
            color: var(--text-light);
        }
        .vietqr-info strong {
            display: block;
            color: var(--text);
            font-size: 1rem;
        }
        
        /* ========== WATERMARK ========== */
        .watermark {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0,0,0,0.8);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            z-index: 1000;
            pointer-events: none;
            user-select: none;
        }
        .watermark a { 
            color: var(--cream); 
            pointer-events: auto;
            text-decoration: underline;
        }
        
        /* ========== MUSIC BUTTON ========== */
        .music-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            z-index: 100;
            font-size: 1.2rem;
            box-shadow: 0 5px 20px rgba(183,110,121,0.3);
            transition: transform 0.3s;
        }
        .music-btn:hover { transform: scale(1.1); }
        .music-btn.playing { animation: pulse 1s infinite; }
        
        /* ========== FOOTER ========== */
        .footer {
            min-height: auto !important;
            padding: 40px 20px;
            background: var(--cream);
        }
        .footer p {
            color: var(--text-light);
            font-size: 0.875rem;
        }
        .footer a { color: var(--primary); }
        
        /* ========== RESPONSIVE ========== */
        @media (max-width: 480px) {
            section { padding: 40px 16px; }
            .card { padding: 1.5rem; }
            .countdown { gap: 0.5rem; }
            .countdown-item { min-width: 60px; padding: 0.75rem; }
        }
    </style>
</head>
<body>
    @if($invitation->shouldShowWatermark())
    <div class="watermark">
        Thiệp dùng thử - <a href="https://moiban.vn">moiban.vn</a>
    </div>
    @endif
    
    {{-- Music Button --}}
    @if(in_array('music', $widgets) && !empty($content['music_url']))
    <button class="music-btn" id="musicBtn" onclick="toggleMusic()" title="Bật/tắt nhạc">
        <i class="fa-solid fa-music" id="musicIcon"></i>
    </button>
    <audio id="bgMusic" loop>
        <source src="{{ $content['music_url'] }}" type="audio/mpeg">
    </audio>
    @endif
    
    {{-- ========== HERO SECTION ========== --}}
    <section class="hero">
        <div class="hero-content animate-fadeInUp">
            <span class="hero-badge">Save The Date</span>
            <h1>{{ $content['event_title'] ?? 'Lễ Thành Hôn' }}</h1>
            <p class="couple-names">
                {{ $content['groom_name'] ?? 'Chú Rể' }}
                <span class="and">&</span>
                {{ $content['bride_name'] ?? 'Cô Dâu' }}
            </p>
            <p class="event-date">{{ \Carbon\Carbon::parse($content['event_date'] ?? now())->format('d . m . Y') }}</p>
        </div>
        
        <div class="scroll-indicator">
            <i class="fa-solid fa-chevron-down"></i>
        </div>
    </section>
    
    {{-- ========== COUNTDOWN ========== --}}
    @if(in_array('countdown', $widgets))
    <section>
        <h2 class="section-title animate-fadeInUp">Đếm Ngược</h2>
        <div class="heart-divider"><i class="fa-solid fa-heart"></i></div>
        
        <div class="countdown" id="countdown" data-date="{{ $content['event_date'] ?? now()->addDays(30)->format('Y-m-d') }}">
            <div class="countdown-item animate-fadeInUp">
                <div class="number" id="days">00</div>
                <div class="label">Ngày</div>
            </div>
            <div class="countdown-item animate-fadeInUp delay-1">
                <div class="number" id="hours">00</div>
                <div class="label">Giờ</div>
            </div>
            <div class="countdown-item animate-fadeInUp delay-2">
                <div class="number" id="minutes">00</div>
                <div class="label">Phút</div>
            </div>
            <div class="countdown-item animate-fadeInUp delay-3">
                <div class="number" id="seconds">00</div>
                <div class="label">Giây</div>
            </div>
        </div>
    </section>
    @endif
    
    {{-- ========== EVENT DETAILS ========== --}}
    <section>
        <h2 class="section-title">Tiệc Cưới</h2>
        <div class="heart-divider"><i class="fa-solid fa-heart"></i></div>
        
        <div class="card event-card">
            @if(!empty($content['event_message']))
            <p style="text-align: center; margin-bottom: 1.5rem; font-style: italic; color: var(--text-light);">
                "{{ $content['event_message'] }}"
            </p>
            @endif
            
            <div class="event-item">
                <div class="event-icon"><i class="fa-solid fa-clock"></i></div>
                <div class="event-info">
                    <strong>{{ $content['event_time'] ?? '11:00' }}</strong>
                    <span>Thời gian</span>
                </div>
            </div>
            
            <div class="event-item">
                <div class="event-icon"><i class="fa-solid fa-calendar"></i></div>
                <div class="event-info">
                    <strong>{{ \Carbon\Carbon::parse($content['event_date'] ?? now())->format('l, d/m/Y') }}</strong>
                    <span>Ngày cưới</span>
                </div>
            </div>
            
            <div class="event-item">
                <div class="event-icon"><i class="fa-solid fa-location-dot"></i></div>
                <div class="event-info">
                    <strong>{{ $content['venue_name'] ?? 'Địa điểm tổ chức' }}</strong>
                    <span>{{ $content['venue_address'] ?? 'Địa chỉ' }}</span>
                </div>
            </div>
            
            @if(!empty($content['maps_link']))
            <a href="{{ $content['maps_link'] }}" target="_blank" class="btn" style="margin-top: 1rem;">
                <i class="fa-solid fa-map-marker-alt"></i> Xem bản đồ
            </a>
            @endif
        </div>
        
        {{-- Maps Embed --}}
        @if(in_array('maps', $widgets) && (!empty($content['maps_link']) || (!empty($content['latitude']) && !empty($content['longitude']))))
        <div class="card" style="margin-top: 2rem; padding: 0; overflow: hidden;">
            @php
                // Ưu tiên dùng lat/lng nếu có
                if (!empty($content['latitude']) && !empty($content['longitude'])) {
                    $lat = $content['latitude'];
                    $lng = $content['longitude'];
                    $embedUrl = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919!2d{$lng}!3d{$lat}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zLat%2FLng!5e0!3m2!1svi!2svn";
                } elseif (!empty($content['maps_link'])) {
                    $mapsLink = $content['maps_link'];
                    if (str_contains($mapsLink, 'google.com/maps')) {
                        if (preg_match('/place\/([^\/]+)/', $mapsLink, $matches)) {
                            $embedUrl = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919!2d106.6!3d10.8!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2s' . urlencode($matches[1]) . '!5e0!3m2!1svi!2svn!4v1';
                        } else {
                            $embedUrl = str_replace('/maps/', '/maps/embed?', $mapsLink);
                        }
                    } else {
                        $embedUrl = $mapsLink;
                    }
                }
            @endphp
            <iframe 
                src="{{ $embedUrl }}"
                width="100%" 
                height="250" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
        @endif
    </section>
    
    {{-- ========== ALBUM ========== --}}
    @if(in_array('album', $widgets))
    @php
        $albumPhotos = $content['album_photos'] ?? [];
        if (is_string($albumPhotos)) {
            $albumPhotos = json_decode($albumPhotos, true) ?? [];
        }
    @endphp
    @if(is_array($albumPhotos) && count($albumPhotos) > 0)
    <section id="album">
        <h2 class="section-title">Album Ảnh</h2>
        <div class="heart-divider"><i class="fa-solid fa-heart"></i></div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 0.75rem; max-width: 500px; width: 100%;">
            @foreach($albumPhotos as $photo)
            <div style="aspect-ratio: 1; border-radius: 0.75rem; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                <img src="{{ $photo }}" alt="Album ảnh cưới" style="width: 100%; height: 100%; object-fit: cover; cursor: pointer;" onclick="window.open('{{ $photo }}', '_blank')">
            </div>
            @endforeach
        </div>
    </section>
    @endif
    @endif
    
    {{-- ========== RSVP ========== --}}
    @if(in_array('rsvp', $widgets))
    <section id="rsvp">
        <h2 class="section-title">Xác Nhận Tham Dự</h2>
        <div class="heart-divider"><i class="fa-solid fa-heart"></i></div>
        
        <div class="card">
            <form action="{{ route('invitation.rsvp.store', $invitation->slug) }}" method="POST" id="rsvpForm">
                @csrf
                <div class="form-group">
                    <label>Họ tên của bạn *</label>
                    <input type="text" name="guest_name" class="form-input" required placeholder="Nhập họ tên">
                </div>
                <div class="form-group">
                    <label>Số người tham dự</label>
                    <select name="attendees_count" class="form-input">
                        <option value="1">1 người</option>
                        <option value="2">2 người</option>
                        <option value="3">3 người</option>
                        <option value="4">4 người</option>
                        <option value="5">5+ người</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Bạn sẽ tham dự?</label>
                    <select name="status" class="form-input">
                        <option value="attending">✅ Sẽ tham dự</option>
                        <option value="not_attending">❌ Không thể tham dự</option>
                        <option value="maybe">🤔 Chưa chắc chắn</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Lời nhắn (tùy chọn)</label>
                    <textarea name="message" class="form-input" rows="2" placeholder="Gửi lời chúc đến cặp đôi..."></textarea>
                </div>
                <button type="submit" class="btn">
                    <i class="fa-solid fa-paper-plane"></i> Xác nhận
                </button>
            </form>
        </div>
    </section>
    @endif
    
    {{-- ========== GUESTBOOK ========== --}}
    @if(in_array('guestbook', $widgets))
    <section id="guestbook">
        <h2 class="section-title">Sổ Lưu Bút</h2>
        <div class="heart-divider"><i class="fa-solid fa-heart"></i></div>
        
        <div class="card">
            <div class="guestbook-entries">
                @forelse($invitation->guestbookEntries()->approved()->recent()->take(10)->get() as $entry)
                <div class="guestbook-entry">
                    <p class="author"><i class="fa-solid fa-user"></i> {{ $entry->author_name }}</p>
                    <p class="message">{{ $entry->message }}</p>
                </div>
                @empty
                <p style="text-align: center; color: var(--text-light); padding: 1rem;">Hãy là người đầu tiên gửi lời chúc!</p>
                @endforelse
            </div>
            
            <form action="{{ route('invitation.guestbook.store', $invitation->slug) }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="text" name="author_name" class="form-input" required placeholder="Tên của bạn">
                </div>
                <div class="form-group">
                    <textarea name="message" class="form-input" rows="3" required placeholder="Viết lời chúc..."></textarea>
                </div>
                <button type="submit" class="btn">
                    <i class="fa-solid fa-heart"></i> Gửi lời chúc
                </button>
            </form>
        </div>
    </section>
    @endif
    
    {{-- ========== VIETQR ========== --}}
    @if(in_array('vietqr', $widgets) && !empty($content['bank_code']) && !empty($content['bank_account']))
    <section id="vietqr">
        <h2 class="section-title">Mừng Cưới</h2>
        <div class="heart-divider"><i class="fa-solid fa-heart"></i></div>
        
        <div class="card vietqr-card">
            <p style="margin-bottom: 1rem; color: var(--text-light);">
                Nếu không tiện đến tham dự, bạn có thể mừng cưới qua QR Code
            </p>
            
            @php
                $bankCode = $content['bank_code'];
                $accountNumber = $content['bank_account'];
                $accountName = urlencode($content['bank_account_name'] ?? 'NGUYEN VAN A');
                $addInfo = urlencode("Mung cuoi " . ($content['groom_name'] ?? '') . " " . ($content['bride_name'] ?? ''));
                $qrUrl = "https://img.vietqr.io/image/{$bankCode}-{$accountNumber}-compact.jpg?accountName={$accountName}&addInfo={$addInfo}";
            @endphp
            
            <div class="vietqr-image">
                <img src="{{ $qrUrl }}" alt="VietQR" loading="lazy">
            </div>
            
            <div class="vietqr-info">
                <strong>{{ $content['bank_account_name'] ?? 'Chủ tài khoản' }}</strong>
                <p>{{ $content['bank_account'] ?? 'Số tài khoản' }}</p>
            </div>
        </div>
    </section>
    @endif
    
    {{-- ========== FOOTER ========== --}}
    <section class="footer">
        <p>Made with ❤️ by <a href="https://moiban.vn">moiban.vn</a></p>
    </section>
    
    <script>
        // ========== COUNTDOWN ==========
        const countdownEl = document.getElementById('countdown');
        if (countdownEl) {
            const targetDate = new Date(countdownEl.dataset.date + 'T00:00:00');
            
            function updateCountdown() {
                const now = new Date();
                const diff = targetDate - now;
                
                if (diff > 0) {
                    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((diff % (1000 * 60)) / 1000);
                    
                    document.getElementById('days').textContent = String(days).padStart(2, '0');
                    document.getElementById('hours').textContent = String(hours).padStart(2, '0');
                    document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
                    document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
                } else {
                    document.getElementById('days').textContent = '🎉';
                    document.getElementById('hours').textContent = '';
                    document.getElementById('minutes').textContent = '';
                    document.getElementById('seconds').textContent = '';
                }
            }
            
            updateCountdown();
            setInterval(updateCountdown, 1000);
        }
        
        // ========== MUSIC ==========
        let isPlaying = false;
        function toggleMusic() {
            const audio = document.getElementById('bgMusic');
            const btn = document.getElementById('musicBtn');
            const icon = document.getElementById('musicIcon');
            
            if (isPlaying) {
                audio.pause();
                btn.classList.remove('playing');
                icon.className = 'fa-solid fa-music';
            } else {
                audio.play();
                btn.classList.add('playing');
                icon.className = 'fa-solid fa-pause';
            }
            isPlaying = !isPlaying;
        }
        
        // ========== SCROLL ANIMATIONS ==========
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                }
            });
        }, observerOptions);
        
        document.querySelectorAll('.animate-fadeInUp').forEach(el => {
            el.style.animationPlayState = 'paused';
            observer.observe(el);
        });
    </script>
</body>
</html>
