{{-- Template: Modern Minimal - Premium --}}
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $invitation->title }}</title>
    <meta name="description" content="Thiệp cưới của {{ $invitation->couple_name }}">
    <meta property="og:title" content="{{ $invitation->title }}">
    <meta property="og:description" content="Mời bạn đến dự lễ cưới của {{ $invitation->couple_name }}">
    <meta property="og:image" content="{{ route('og-image.png', $invitation->slug) }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --accent: {{ $invitation->content['primary_color'] ?? '#2d3436' }};
            --bg: #fafafa;
            --text: #2d3436;
            --light: #dfe6e9;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            font-weight: 300;
        }
        .font-display { font-family: 'Playfair Display', serif; }
        
        section {
            min-height: 100vh;
            padding: 60px 24px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 400;
            margin-bottom: 0.5rem;
        }
        .hero .amp {
            font-size: 2rem;
            opacity: 0.3;
            margin: 1rem 0;
        }
        .hero .date {
            font-size: 0.9rem;
            letter-spacing: 0.3em;
            opacity: 0.6;
            margin-top: 2rem;
        }
        
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            margin-bottom: 2rem;
        }
        
        .card {
            background: #fff;
            padding: 2rem;
            border-radius: 4px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.05);
            width: 100%;
        }
        
        .btn {
            display: inline-block;
            padding: 14px 32px;
            background: var(--text);
            color: #fff;
            border: none;
            font-size: 0.85rem;
            letter-spacing: 0.1em;
            cursor: pointer;
            transition: opacity 0.3s;
        }
        .btn:hover { opacity: 0.8; }
        
        input, select, textarea {
            width: 100%;
            padding: 14px 16px;
            background: var(--bg);
            border: 1px solid var(--light);
            font-family: inherit;
            font-size: 0.95rem;
            margin-bottom: 12px;
            border-radius: 2px;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--text);
        }
        
        .countdown {
            display: flex;
            justify-content: center;
            gap: 24px;
        }
        .countdown-item .number {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
        }
        .countdown-item .label {
            font-size: 0.7rem;
            letter-spacing: 0.2em;
            opacity: 0.5;
            text-transform: uppercase;
        }
        
        .info-item {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin: 12px 0;
        }
        .info-item i { opacity: 0.4; }
        
        .watermark {
            position: fixed;
            bottom: 16px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--text);
            color: #fff;
            padding: 8px 16px;
            font-size: 0.75rem;
            z-index: 1000;
        }
    </style>
</head>
<body>
    @if($invitation->shouldShowWatermark())
    <div class="watermark">Thiệp dùng thử - moiban.vn</div>
    @endif

    @php
        $widgets = $invitation->widgets->where('is_enabled', true)->pluck('widget_type')->toArray();
        $content = $invitation->content;
    @endphp

    <section class="hero">
        <p style="font-size: 0.75rem; letter-spacing: 0.4em; text-transform: uppercase; opacity: 0.5; margin-bottom: 3rem;">We're Getting Married</p>
        <h1>{{ $content['groom_name'] ?? 'Chú Rể' }}</h1>
        <p class="amp">&</p>
        <h1>{{ $content['bride_name'] ?? 'Cô Dâu' }}</h1>
        <p class="date">{{ \Carbon\Carbon::parse($content['event_date'] ?? now())->format('d.m.Y') }}</p>
    </section>

    @if(in_array('countdown', $widgets))
    <section>
        <h2 class="section-title">Còn</h2>
        <div class="countdown" id="countdown" data-date="{{ $content['event_date'] ?? now()->addDays(30)->format('Y-m-d') }}">
            <div class="countdown-item"><div class="number" id="days">00</div><div class="label">Ngày</div></div>
            <div class="countdown-item"><div class="number" id="hours">00</div><div class="label">Giờ</div></div>
            <div class="countdown-item"><div class="number" id="minutes">00</div><div class="label">Phút</div></div>
            <div class="countdown-item"><div class="number" id="seconds">00</div><div class="label">Giây</div></div>
        </div>
    </section>
    @endif

    <section>
        <h2 class="section-title">Tiệc Cưới</h2>
        <div class="card">
            <p style="margin-bottom: 24px; line-height: 1.7; opacity: 0.8;">{{ $content['event_message'] ?? 'Trân trọng kính mời bạn đến dự tiệc cưới' }}</p>
            <div class="info-item"><i class="fa-regular fa-clock"></i> {{ $content['event_time'] ?? '11:00' }}</div>
            <div class="info-item"><i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($content['event_date'] ?? now())->format('d/m/Y') }}</div>
            <div class="info-item"><i class="fa-solid fa-location-dot"></i> {{ $content['venue_name'] ?? 'Địa điểm' }}</div>
            <p style="opacity: 0.5; font-size: 0.85rem;">{{ $content['venue_address'] ?? '' }}</p>
        </div>
    </section>

    @if(in_array('rsvp', $widgets))
    <section id="rsvp">
        <h2 class="section-title">Xác Nhận</h2>
        <div class="card">
            <form action="{{ route('invitation.rsvp.store', $invitation->slug) }}" method="POST">
                @csrf
                <input type="text" name="guest_name" required placeholder="Họ và tên">
                <select name="attendees_count">
                    <option value="1">1 người</option>
                    <option value="2">2 người</option>
                    <option value="3">3 người</option>
                </select>
                <select name="status">
                    <option value="attending">Sẽ tham dự</option>
                    <option value="not_attending">Không thể tham dự</option>
                </select>
                <textarea name="message" rows="2" placeholder="Lời nhắn (tùy chọn)"></textarea>
                <button type="submit" class="btn" style="width: 100%;">Xác nhận</button>
            </form>
        </div>
    </section>
    @endif

    @if(in_array('guestbook', $widgets))
    <section id="guestbook">
        <h2 class="section-title">Lời Chúc</h2>
        <div class="card">
            @foreach($invitation->guestbookEntries()->approved()->recent()->take(5)->get() as $entry)
            <div style="border-bottom: 1px solid var(--light); padding: 16px 0; text-align: left;">
                <p style="font-weight: 500;">{{ $entry->author_name }}</p>
                <p style="opacity: 0.7; font-size: 0.9rem;">{{ $entry->message }}</p>
            </div>
            @endforeach
            <form action="{{ route('invitation.guestbook.store', $invitation->slug) }}" method="POST" style="margin-top: 24px;">
                @csrf
                <input type="text" name="author_name" required placeholder="Tên của bạn">
                <textarea name="message" rows="2" required placeholder="Viết lời chúc..."></textarea>
                <button type="submit" class="btn" style="width: 100%;">Gửi</button>
            </form>
        </div>
    </section>
    @endif

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
        <h2 class="section-title">Album</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); gap: 8px; width: 100%;">
            @foreach($albumPhotos as $photo)
            <div style="aspect-ratio: 1; overflow: hidden; border-radius: 4px; background: var(--light);">
                <img src="{{ $photo }}" alt="Album" style="width: 100%; height: 100%; object-fit: cover; cursor: pointer;" onclick="window.open('{{ $photo }}', '_blank')">
            </div>
            @endforeach
        </div>
    </section>
    @endif
    @endif

    {{-- ========== VIETQR ========== --}}
    @if(in_array('vietqr', $widgets) && !empty($content['bank_code']) && !empty($content['bank_account']))
    <section id="vietqr">
        <h2 class="section-title">Mừng Cưới</h2>
        <div class="card" style="text-align: center;">
            <p style="opacity: 0.6; margin-bottom: 16px; font-size: 0.9rem;">Nếu không tiện đến tham dự, bạn có thể mừng cưới qua QR Code</p>
            @php
                $bankCode = $content['bank_code'];
                $accountNumber = $content['bank_account'];
                $accountName = urlencode($content['bank_account_name'] ?? 'NGUYEN VAN A');
                $addInfo = urlencode("Mung cuoi " . ($content['groom_name'] ?? '') . " " . ($content['bride_name'] ?? ''));
                $qrUrl = "https://img.vietqr.io/image/{$bankCode}-{$accountNumber}-compact.jpg?accountName={$accountName}&addInfo={$addInfo}";
            @endphp
            <div style="background: white; padding: 8px; display: inline-block; border-radius: 4px;">
                <img src="{{ $qrUrl }}" alt="VietQR" style="max-width: 160px;" loading="lazy">
            </div>
            <p style="margin-top: 12px; font-weight: 500;">{{ $content['bank_account_name'] ?? '' }}</p>
            <p style="opacity: 0.5; font-size: 0.9rem;">{{ $content['bank_account'] ?? '' }}</p>
        </div>
    </section>
    @endif

    {{-- Music Button --}}
    @if(in_array('music', $widgets) && !empty($content['music_url']))
    <button style="position: fixed; top: 16px; right: 16px; width: 44px; height: 44px; background: var(--text); color: white; border: none; border-radius: 50%; cursor: pointer; z-index: 100;" id="musicBtn" onclick="toggleMusic()">
        <i class="fa-solid fa-music" id="musicIcon"></i>
    </button>
    <audio id="bgMusic" loop>
        <source src="{{ $content['music_url'] }}" type="audio/mpeg">
    </audio>
    @endif

    <section style="min-height: auto; padding: 40px;">
        <p style="opacity: 0.3; font-size: 0.75rem;">Made with ❤️ by <a href="https://moiban.vn" style="color: inherit;">moiban.vn</a></p>
    </section>

    <script>
        const countdownEl = document.getElementById('countdown');
        if (countdownEl) {
            const targetDate = new Date(countdownEl.dataset.date + 'T00:00:00');
            function updateCountdown() {
                const now = new Date();
                const diff = targetDate - now;
                if (diff > 0) {
                    document.getElementById('days').textContent = String(Math.floor(diff / (1000*60*60*24))).padStart(2, '0');
                    document.getElementById('hours').textContent = String(Math.floor((diff % (1000*60*60*24)) / (1000*60*60))).padStart(2, '0');
                    document.getElementById('minutes').textContent = String(Math.floor((diff % (1000*60*60)) / (1000*60))).padStart(2, '0');
                    document.getElementById('seconds').textContent = String(Math.floor((diff % (1000*60)) / 1000)).padStart(2, '0');
                }
            }
            updateCountdown();
            setInterval(updateCountdown, 1000);
        }
        
        // Music toggle
        let isPlaying = false;
        function toggleMusic() {
            const audio = document.getElementById('bgMusic');
            const icon = document.getElementById('musicIcon');
            if (!audio) return;
            
            if (isPlaying) {
                audio.pause();
                icon.className = 'fa-solid fa-music';
            } else {
                audio.play();
                icon.className = 'fa-solid fa-pause';
            }
            isPlaying = !isPlaying;
        }
    </script>
</body>
</html>
