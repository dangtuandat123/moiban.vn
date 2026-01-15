{{-- Template: Romantic Rose --}}
{{-- Đây là sample invitation view cho template Romantic Rose --}}

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
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600&family=Great+Vibes&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: {{ $invitation->content['primary_color'] ?? '#b76e79' }};
            --secondary: {{ $invitation->content['secondary_color'] ?? '#f7e7ce' }};
        }
        
        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        body {
            font-family: 'Be Vietnam Pro', sans-serif;
            background: linear-gradient(135deg, var(--secondary) 0%, #fff 50%, var(--secondary) 100%);
            min-height: 100vh;
            color: #333;
        }
        
        .font-script { font-family: 'Great Vibes', cursive; }
        
        /* Sections */
        section {
            min-height: 100vh;
            padding: 60px 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(to bottom, rgba(183,110,121,0.1), transparent);
        }
        .hero h1 {
            font-family: 'Great Vibes', cursive;
            font-size: 3.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }
        .hero .names {
            font-size: 2rem;
            font-weight: 300;
            letter-spacing: 0.3em;
            margin-bottom: 0.5rem;
        }
        .hero .date {
            font-size: 1.2rem;
            color: #666;
        }
        
        /* Content sections */
        .section-title {
            font-family: 'Great Vibes', cursive;
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 2rem;
        }
        
        .card {
            background: rgba(255,255,255,0.8);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
        }
        
        /* Countdown */
        .countdown {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin: 2rem 0;
        }
        .countdown-item {
            text-align: center;
        }
        .countdown-item .number {
            font-size: 2.5rem;
            font-weight: 600;
            color: var(--primary);
        }
        .countdown-item .label {
            font-size: 0.75rem;
            color: #666;
            text-transform: uppercase;
        }
        
        /* RSVP Form */
        .form-group {
            margin-bottom: 1rem;
            text-align: left;
        }
        .form-group label {
            display: block;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
            color: #555;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            font-size: 1rem;
        }
        .btn {
            display: inline-block;
            padding: 0.875rem 2rem;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            cursor: pointer;
            width: 100%;
        }
        
        /* Guestbook */
        .guestbook-entry {
            background: rgba(255,255,255,0.6);
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            text-align: left;
        }
        .guestbook-entry .author {
            font-weight: 600;
            color: var(--primary);
        }
        
        /* Watermark */
        .watermark {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0,0,0,0.7);
            color: #fff;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 0.875rem;
            z-index: 1000;
        }
        .watermark a { color: var(--secondary); }
        
        /* Background Music Button */
        .music-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            z-index: 100;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    @if($invitation->shouldShowWatermark())
    <div class="watermark">
        Thiệp dùng thử - <a href="https://moiban.vn">moiban.vn</a>
    </div>
    @endif
    
    @php
        $widgets = $invitation->widgets->where('is_enabled', true)->pluck('widget_type')->toArray();
        $content = $invitation->content;
    @endphp
    
    {{-- Music Button --}}
    @if(in_array('music', $widgets) && !empty($content['music_url']))
    <button class="music-btn" id="musicBtn" onclick="toggleMusic()">
        <i class="fa-solid fa-music"></i>
    </button>
    <audio id="bgMusic" loop>
        <source src="{{ $content['music_url'] }}" type="audio/mpeg">
    </audio>
    @endif
    
    {{-- Hero Section --}}
    <section class="hero">
        <p class="text-sm uppercase tracking-widest mb-4" style="color: var(--primary);">Save The Date</p>
        <h1>{{ $content['event_title'] ?? 'Lễ Thành Hôn' }}</h1>
        <p class="names">{{ $content['groom_name'] ?? 'Chú Rể' }} <span style="color: var(--primary);">&</span> {{ $content['bride_name'] ?? 'Cô Dâu' }}</p>
        <p class="date">{{ \Carbon\Carbon::parse($content['event_date'] ?? now())->format('d.m.Y') }}</p>
    </section>
    
    {{-- Countdown Section --}}
    @if(in_array('countdown', $widgets))
    <section id="countdown-section">
        <h2 class="section-title">Đếm Ngược</h2>
        <div class="countdown" id="countdown" data-date="{{ $content['event_date'] ?? now()->addDays(30)->format('Y-m-d') }}">
            <div class="countdown-item">
                <div class="number" id="days">00</div>
                <div class="label">Ngày</div>
            </div>
            <div class="countdown-item">
                <div class="number" id="hours">00</div>
                <div class="label">Giờ</div>
            </div>
            <div class="countdown-item">
                <div class="number" id="minutes">00</div>
                <div class="label">Phút</div>
            </div>
            <div class="countdown-item">
                <div class="number" id="seconds">00</div>
                <div class="label">Giây</div>
            </div>
        </div>
    </section>
    @endif
    
    {{-- Event Details --}}
    <section>
        <h2 class="section-title">Thông Tin Tiệc Cưới</h2>
        <div class="card">
            <p style="margin-bottom: 1.5rem;">{{ $content['event_message'] ?? 'Trân trọng kính mời bạn đến dự lễ cưới của chúng tôi' }}</p>
            <div style="margin-bottom: 1rem;">
                <i class="fa-solid fa-clock" style="color: var(--primary); margin-right: 0.5rem;"></i>
                <strong>{{ $content['event_time'] ?? '11:00' }}</strong>
            </div>
            <div style="margin-bottom: 1rem;">
                <i class="fa-solid fa-calendar" style="color: var(--primary); margin-right: 0.5rem;"></i>
                <strong>{{ \Carbon\Carbon::parse($content['event_date'] ?? now())->format('d/m/Y') }}</strong>
            </div>
            <div>
                <i class="fa-solid fa-location-dot" style="color: var(--primary); margin-right: 0.5rem;"></i>
                <strong>{{ $content['venue_name'] ?? 'Địa điểm tổ chức' }}</strong>
                <p style="color: #666; font-size: 0.875rem;">{{ $content['venue_address'] ?? 'Địa chỉ' }}</p>
            </div>
        </div>
    </section>
    
    {{-- RSVP Section --}}
    @if(in_array('rsvp', $widgets))
    <section id="rsvp">
        <h2 class="section-title">Xác Nhận Tham Dự</h2>
        <div class="card">
            <form action="{{ route('invitation.rsvp.store', $invitation->slug) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Họ tên của bạn</label>
                    <input type="text" name="guest_name" required placeholder="Nhập họ tên">
                </div>
                <div class="form-group">
                    <label>Số người tham dự</label>
                    <select name="attendees_count">
                        <option value="1">1 người</option>
                        <option value="2">2 người</option>
                        <option value="3">3 người</option>
                        <option value="4">4 người</option>
                        <option value="5">5+ người</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Bạn sẽ tham dự?</label>
                    <select name="status">
                        <option value="attending">Sẽ tham dự</option>
                        <option value="not_attending">Không thể tham dự</option>
                        <option value="maybe">Chưa chắc chắn</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Lời nhắn (tùy chọn)</label>
                    <textarea name="message" rows="2" placeholder="Gửi lời chúc..."></textarea>
                </div>
                <button type="submit" class="btn">Xác nhận</button>
            </form>
        </div>
    </section>
    @endif
    
    {{-- Guestbook Section --}}
    @if(in_array('guestbook', $widgets))
    <section id="guestbook">
        <h2 class="section-title">Sổ Lưu Bút</h2>
        <div class="card">
            @foreach($invitation->guestbookEntries()->approved()->recent()->take(5)->get() as $entry)
            <div class="guestbook-entry">
                <p class="author">{{ $entry->author_name }}</p>
                <p>{{ $entry->message }}</p>
            </div>
            @endforeach
            
            <form action="{{ route('invitation.guestbook.store', $invitation->slug) }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="text" name="author_name" required placeholder="Tên của bạn">
                </div>
                <div class="form-group">
                    <textarea name="message" rows="3" required placeholder="Viết lời chúc..."></textarea>
                </div>
                <button type="submit" class="btn">Gửi lời chúc</button>
            </form>
        </div>
    </section>
    @endif
    
    {{-- Map Section --}}
    @if(in_array('map', $widgets) && !empty($content['map_embed']))
    <section id="map">
        <h2 class="section-title">Bản Đồ</h2>
        <div style="width: 100%; max-width: 600px; border-radius: 1rem; overflow: hidden;">
            {!! $content['map_embed'] !!}
        </div>
    </section>
    @endif
    
    {{-- Footer --}}
    <section style="min-height: auto; padding: 40px 20px;">
        <p style="color: #999;">Made with ❤️ by <a href="https://moiban.vn" style="color: var(--primary);">moiban.vn</a></p>
    </section>
    
    <script>
        // Countdown
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
                }
            }
            
            updateCountdown();
            setInterval(updateCountdown, 1000);
        }
        
        // Music
        let isPlaying = false;
        function toggleMusic() {
            const audio = document.getElementById('bgMusic');
            const btn = document.getElementById('musicBtn');
            if (isPlaying) {
                audio.pause();
                btn.innerHTML = '<i class="fa-solid fa-music"></i>';
            } else {
                audio.play();
                btn.innerHTML = '<i class="fa-solid fa-pause"></i>';
            }
            isPlaying = !isPlaying;
        }
    </script>
</body>
</html>
