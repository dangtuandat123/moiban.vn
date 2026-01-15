# Hướng dẫn Tạo Template Thiệp Cưới - moiban.vn

## 📁 Cấu trúc Thư mục Template

Mỗi template là một folder riêng trong `resources/views/templates/` với cấu trúc:

```
templates/
└── [template-slug]/
    ├── view.blade.php    # File hiển thị giao diện (BẮT BUỘC)
    ├── config.json       # Định nghĩa cấu hình template (BẮT BUỘC)
    └── thumbnail.png     # Ảnh đại diện (Khuyến nghị 600x800px)
```

---

## 📝 File config.json

### Cấu trúc cơ bản:

```json
{
    "name": "Tên Template",
    "slug": "ten-template",
    "description": "Mô tả ngắn",
    "type": "basic|premium",
    "version": "1.0.0",
    "author": "moiban.vn",
    
    "theme": { ... },
    "fields": { ... },
    "widgets": { ... },
    "sections": [ ... ]
}
```

### 1. Theme Configuration

```json
"theme": {
    "primary_color": "#b76e79",
    "secondary_color": "#f7e7ce",
    "background_gradient": ["#fdf2f8", "#fce7f3"],
    "text_color": "#4a3f35",
    "font_heading": "Great Vibes",
    "font_body": "Be Vietnam Pro"
}
```

### 2. Fields Definition

```json
"fields": {
    "couple": {
        "groom_name": {
            "type": "text",
            "label": "Tên chú rể",
            "placeholder": "Minh Anh",
            "required": true,
            "max_length": 50
        },
        "bride_name": {
            "type": "text",
            "label": "Tên cô dâu",
            "required": true
        }
    },
    "event": {
        "event_date": {
            "type": "date",
            "label": "Ngày cưới",
            "required": true
        },
        "venue_name": {
            "type": "text",
            "label": "Địa điểm"
        }
    },
    "style": {
        "primary_color": {
            "type": "color",
            "label": "Màu chủ đạo",
            "default": "#b76e79"
        }
    }
}
```

**Các loại field hỗ trợ:**
| Type | Mô tả |
|------|-------|
| `text` | Input text 1 dòng |
| `textarea` | Textarea nhiều dòng |
| `date` | Date picker |
| `time` | Time picker |
| `color` | Color picker |
| `image` | Image upload |
| `select` | Dropdown select |

### 3. Widgets Configuration

```json
"widgets": {
    "countdown": {"enabled": true, "position": 1},
    "album": {"enabled": true, "position": 2, "max_images": 20},
    "rsvp": {"enabled": true, "position": 3},
    "guestbook": {"enabled": true, "position": 4},
    "maps": {"enabled": true, "position": 5},
    "music": {"enabled": false, "position": 6},
    "vietqr": {"enabled": false, "position": 7}
}
```

### 4. Sections (cho Editor)

```json
"sections": [
    {"id": "hero", "name": "Trang bìa", "required": true},
    {"id": "couple", "name": "Cô dâu & Chú rể", "required": true},
    {"id": "event", "name": "Thông tin sự kiện", "required": true},
    {"id": "countdown", "name": "Đếm ngược", "required": false},
    {"id": "footer", "name": "Chân trang", "required": true}
]
```

---

## 🎨 File view.blade.php

### Variables có sẵn:

```php
$invitation     // Model Invitation
$content        // Array chứa nội dung từ DB (groom_name, bride_name, ...)
$widgets        // Collection các widget đã enable
$template       // Model Template
```

### Template cơ bản:

```blade
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    
    {{-- SEO Meta --}}
    <meta name="description" content="Thiệp cưới của {{ $invitation->couple_name }}">
    <meta property="og:title" content="{{ $invitation->title }}">
    <meta property="og:image" content="{{ route('og-image', $invitation->slug) }}">
    
    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Be+Vietnam+Pro&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: {{ $content['primary_color'] ?? '#b76e79' }};
        }
        /* CSS của bạn */
    </style>
</head>
<body>
    {{-- Watermark Trial --}}
    @if($invitation->shouldShowWatermark())
    <div class="watermark">Thiệp dùng thử - moiban.vn</div>
    @endif
    
    {{-- Hero Section --}}
    <section class="hero">
        <h1>{{ $content['groom_name'] ?? 'Chú rể' }}</h1>
        <span>&</span>
        <h1>{{ $content['bride_name'] ?? 'Cô dâu' }}</h1>
    </section>
    
    {{-- Countdown Widget --}}
    @if($widgets->has('countdown'))
    <section id="countdown" data-date="{{ $content['event_date'] }}">
        <!-- Countdown HTML -->
    </section>
    @endif
    
    {{-- RSVP Widget --}}
    @if($widgets->has('rsvp'))
    <section id="rsvp">
        <form action="{{ route('invitation.rsvp.store', $invitation->slug) }}" method="POST">
            @csrf
            <input name="guest_name" required placeholder="Họ tên">
            <select name="attendees_count">
                <option value="1">1 người</option>
                <option value="2">2 người</option>
            </select>
            <button type="submit">Xác nhận</button>
        </form>
    </section>
    @endif
    
    {{-- Guestbook Widget --}}
    @if($widgets->has('guestbook'))
    <section id="guestbook">
        @foreach($invitation->guestbookEntries()->approved()->get() as $entry)
            <div class="message">
                <strong>{{ $entry->author_name }}</strong>
                <p>{{ $entry->message }}</p>
            </div>
        @endforeach
        
        <form action="{{ route('invitation.guestbook.store', $invitation->slug) }}" method="POST">
            @csrf
            <input name="author_name" required placeholder="Tên">
            <textarea name="message" required placeholder="Lời chúc"></textarea>
            <button type="submit">Gửi</button>
        </form>
    </section>
    @endif
    
    <script>
        // Countdown logic
        const countdownEl = document.getElementById('countdown');
        if (countdownEl) {
            const targetDate = new Date(countdownEl.dataset.date);
            // ... countdown logic
        }
    </script>
</body>
</html>
```

---

## 🚀 Quy trình Upload Template (Admin)

1. **Tạo folder** với cấu trúc đúng
2. **Zip folder** (KHÔNG zip thư mục cha)
3. **Upload qua Admin** → Templates → Upload Template
4. Hệ thống tự động:
   - Giải nén ZIP
   - Đọc config.json
   - Đăng ký template vào database
   - Copy thumbnail

---

## ✅ Checklist Template

- [ ] `view.blade.php` hiển thị đúng
- [ ] `config.json` đầy đủ fields
- [ ] Thumbnail 600x800px
- [ ] Mobile responsive
- [ ] Watermark hiển thị khi trial
- [ ] RSVP form hoạt động
- [ ] Guestbook form hoạt động
- [ ] Countdown đếm ngược đúng
- [ ] SEO meta tags đầy đủ

---

## 📌 Lưu ý quan trọng

1. **Slug** phải unique và không có dấu/space
2. **Primary color** nên cho phép user custom
3. **Font** sử dụng Google Fonts
4. **Image** optimize trước khi hiển thị
5. **CSS** inline hoặc trong file, không dùng external
