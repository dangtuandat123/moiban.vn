{{-- Template: Elegant Gold - Premium --}}
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
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --gold: {{ $invitation->content['primary_color'] ?? '#d4af37' }};
            --gold-light: #f5e6a3;
            --dark: #1a1a1a;
            --cream: #fffef5;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Montserrat', sans-serif;
            background: var(--dark);
            color: var(--cream);
            min-height: 100vh;
        }
        .font-serif { font-family: 'Cormorant Garamond', serif; }
        
        section {
            min-height: 100vh;
            padding: 80px 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
        }
        
        /* Elegant border frame */
        .frame {
            position: absolute;
            top: 20px; left: 20px; right: 20px; bottom: 20px;
            border: 1px solid var(--gold);
            pointer-events: none;
        }
        .frame::before {
            content: '';
            position: absolute;
            top: 10px; left: 10px; right: 10px; bottom: 10px;
            border: 1px solid rgba(212, 175, 55, 0.3);
        }
        
        .hero h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 4rem;
            font-weight: 300;
            color: var(--gold);
            letter-spacing: 0.2em;
            margin-bottom: 1rem;
        }
        .hero .names {
            font-size: 2.5rem;
            font-weight: 300;
            letter-spacing: 0.5em;
            text-transform: uppercase;
        }
        .hero .ampersand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 4rem;
            color: var(--gold);
            display: block;
            margin: 1rem 0;
        }
        
        .divider {
            width: 100px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            margin: 2rem auto;
        }
        
        .card {
            background: rgba(212, 175, 55, 0.05);
            border: 1px solid rgba(212, 175, 55, 0.3);
            padding: 3rem;
            max-width: 500px;
            width: 100%;
        }
        
        .btn {
            display: inline-block;
            padding: 1rem 3rem;
            background: transparent;
            border: 1px solid var(--gold);
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 0.2em;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn:hover {
            background: var(--gold);
            color: var(--dark);
        }
        
        input, select, textarea {
            width: 100%;
            padding: 1rem;
            background: transparent;
            border: 1px solid rgba(212, 175, 55, 0.3);
            color: var(--cream);
            font-family: inherit;
            margin-bottom: 1rem;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--gold);
        }
        
        .countdown {
            display: flex;
            justify-content: center;
            gap: 2rem;
        }
        .countdown-item .number {
            font-family: 'Cormorant Garamond', serif;
            font-size: 4rem;
            color: var(--gold);
        }
        .countdown-item .label {
            text-transform: uppercase;
            letter-spacing: 0.2em;
            font-size: 0.7rem;
            opacity: 0.7;
        }
        
        .watermark {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0,0,0,0.8);
            color: #fff;
            padding: 10px 20px;
            font-size: 0.8rem;
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
        <div class="frame"></div>
        <p style="letter-spacing: 0.5em; text-transform: uppercase; opacity: 0.7; margin-bottom: 2rem;">Wedding Invitation</p>
        <p class="names">{{ $content['groom_name'] ?? 'Chú Rể' }}</p>
        <span class="ampersand">&</span>
        <p class="names">{{ $content['bride_name'] ?? 'Cô Dâu' }}</p>
        <div class="divider"></div>
        <p style="letter-spacing: 0.3em;">{{ \Carbon\Carbon::parse($content['event_date'] ?? now())->format('d . m . Y') }}</p>
    </section>

    @if(in_array('countdown', $widgets))
    <section>
        <div class="frame"></div>
        <p class="font-serif" style="font-size: 2rem; color: var(--gold); margin-bottom: 3rem;">Đếm Ngược</p>
        <div class="countdown" id="countdown" data-date="{{ $content['event_date'] ?? now()->addDays(30)->format('Y-m-d') }}">
            <div class="countdown-item"><div class="number" id="days">00</div><div class="label">Ngày</div></div>
            <div class="countdown-item"><div class="number" id="hours">00</div><div class="label">Giờ</div></div>
            <div class="countdown-item"><div class="number" id="minutes">00</div><div class="label">Phút</div></div>
            <div class="countdown-item"><div class="number" id="seconds">00</div><div class="label">Giây</div></div>
        </div>
    </section>
    @endif

    <section>
        <div class="frame"></div>
        <p class="font-serif" style="font-size: 2rem; color: var(--gold); margin-bottom: 1rem;">Tiệc Cưới</p>
        <div class="divider"></div>
        <div class="card">
            <p style="margin-bottom: 2rem; line-height: 1.8;">{{ $content['event_message'] ?? 'Trân trọng kính mời quý khách đến dự bữa tiệc chung vui cùng gia đình chúng tôi' }}</p>
            <p><i class="fa-regular fa-clock" style="color: var(--gold);"></i> {{ $content['event_time'] ?? '18:00' }}</p>
            <p style="margin: 1rem 0;"><i class="fa-regular fa-calendar" style="color: var(--gold);"></i> {{ \Carbon\Carbon::parse($content['event_date'] ?? now())->format('d/m/Y') }}</p>
            <p><i class="fa-solid fa-location-dot" style="color: var(--gold);"></i> {{ $content['venue_name'] ?? 'Địa điểm' }}</p>
            <p style="opacity: 0.7; font-size: 0.9rem;">{{ $content['venue_address'] ?? '' }}</p>
        </div>
    </section>

    @if(in_array('rsvp', $widgets))
    <section id="rsvp">
        <div class="frame"></div>
        <p class="font-serif" style="font-size: 2rem; color: var(--gold); margin-bottom: 1rem;">Xác Nhận Tham Dự</p>
        <div class="divider"></div>
        <div class="card">
            <form action="{{ route('invitation.rsvp.store', $invitation->slug) }}" method="POST">
                @csrf
                <input type="text" name="guest_name" required placeholder="Họ và tên" maxlength="255">
                <select name="attendees_count">
                    <option value="1">1 người</option>
                    <option value="2">2 người</option>
                    <option value="3">3 người</option>
                </select>
                <select name="status">
                    <option value="attending">Sẽ tham dự</option>
                    <option value="not_attending">Không thể tham dự</option>
                </select>
                <textarea name="message" rows="3" placeholder="Lời nhắn..." maxlength="500"></textarea>
                <button type="submit" class="btn" style="width: 100%;">Gửi</button>
            </form>
        </div>
    </section>
    @endif

    @if(in_array('guestbook', $widgets))
    <section id="guestbook">
        <div class="frame"></div>
        <p class="font-serif" style="font-size: 2rem; color: var(--gold); margin-bottom: 1rem;">Sổ Lưu Bút</p>
        <div class="divider"></div>
        <div class="card">
            @php
                // Avoid N+1: use pre-loaded relationship or limit in-view query
                $guestbookEntries = $invitation->guestbookEntries->where('is_approved', true)->sortByDesc('created_at')->take(5);
            @endphp
            @foreach($guestbookEntries as $entry)
            <div style="border-bottom: 1px solid rgba(212,175,55,0.2); padding: 1rem 0; text-align: left;">
                <p style="color: var(--gold);">{{ $entry->author_name }}</p>
                <p style="opacity: 0.8;">{{ $entry->message }}</p>
            </div>
            @endforeach
            <form action="{{ route('invitation.guestbook.store', $invitation->slug) }}" method="POST" style="margin-top: 2rem;">
                @csrf
                <input type="text" name="author_name" required placeholder="Tên của bạn" maxlength="255">
                <textarea name="message" rows="3" required placeholder="Lời chúc..." maxlength="1000"></textarea>
                <button type="submit" class="btn" style="width: 100%;">Gửi lời chúc</button>
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
        <div class="frame"></div>
        <p class="font-serif" style="font-size: 2rem; color: var(--gold); margin-bottom: 1rem;">Album Ảnh</p>
        <div class="divider"></div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 0.5rem; max-width: 500px; width: 100%;">
            @foreach($albumPhotos as $photo)
            <div style="aspect-ratio: 1; overflow: hidden; border: 1px solid rgba(212,175,55,0.3);">
                <img src="{{ $photo }}" alt="Album" style="width: 100%; height: 100%; object-fit: cover; cursor: pointer;" class="album-photo" data-photo="{{ e($photo) }}">
            </div>
            @endforeach
        </div>
    </section>
    @endif
    @endif

    {{-- ========== VIETQR ========== --}}
    @if(in_array('vietqr', $widgets) && !empty($content['bank_code']) && !empty($content['bank_account']))
    <section id="vietqr">
        <div class="frame"></div>
        <p class="font-serif" style="font-size: 2rem; color: var(--gold); margin-bottom: 1rem;">Mừng Cưới</p>
        <div class="divider"></div>
        <div class="card" style="text-align: center;">
            <p style="opacity: 0.7; margin-bottom: 1rem;">Nếu không tiện đến tham dự, bạn có thể mừng cưới qua QR Code</p>
            @php
                $bankCode = $content['bank_code'];
                $accountNumber = $content['bank_account'];
                $accountName = urlencode($content['bank_account_name'] ?? 'NGUYEN VAN A');
                $addInfo = urlencode("Mung cuoi " . ($content['groom_name'] ?? '') . " " . ($content['bride_name'] ?? ''));
                $qrUrl = "https://img.vietqr.io/image/{$bankCode}-{$accountNumber}-compact.jpg?accountName={$accountName}&addInfo={$addInfo}";
            @endphp
            <div style="background: white; padding: 0.5rem; display: inline-block; border-radius: 4px;">
                <img src="{{ $qrUrl }}" alt="VietQR" style="max-width: 180px;" loading="lazy">
            </div>
            <p style="margin-top: 1rem; color: var(--gold);">{{ $content['bank_account_name'] ?? '' }}</p>
            <p style="opacity: 0.7;">{{ $content['bank_account'] ?? '' }}</p>
        </div>
    </section>
    @endif

    {{-- Music Button --}}
    @if(in_array('music', $widgets) && !empty($content['music_url']))
    <button style="position: fixed; top: 20px; right: 20px; width: 50px; height: 50px; background: var(--gold); color: var(--dark); border: none; border-radius: 50%; cursor: pointer; z-index: 100;" id="musicBtn" onclick="toggleMusic()">
        <i class="fa-solid fa-music" id="musicIcon"></i>
    </button>
    <audio id="bgMusic" loop>
        <source src="{{ $content['music_url'] }}" type="audio/mpeg">
    </audio>
    @endif

    <section style="min-height: auto; padding: 40px;">
        <p style="opacity: 0.5; font-size: 0.8rem;">Made with ❤️ by <a href="https://moiban.vn" style="color: var(--gold);">moiban.vn</a></p>
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
        
        // Album photo click handler (XSS-safe)
        document.querySelectorAll('.album-photo').forEach(img => {
            img.addEventListener('click', function() {
                const url = this.dataset.photo;
                if (url) window.open(url, '_blank');
            });
        });
    </script>
</body>
</html>
