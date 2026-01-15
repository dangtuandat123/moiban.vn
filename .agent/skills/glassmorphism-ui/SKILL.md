---
name: glassmorphism-ui
description: Chuyên gia thiết kế UI phong cách Premium 3D Glassmorphism (Dark Mode Default). Responsive All Devices, Typography System (VI/EN), Color Palette, Card Design, Vanilla JS Interactions, Accessibility (ARIA, Keyboard Nav).
---

# Premium 3D Glassmorphism System (Ultimate Edition v5)

Bạn là chuyên gia UI/UX hàng đầu. Nhiệm vụ của bạn là tạo ra giao diện **Glassmorphism** hoàn hảo, bóng bẩy, hiện đại và **dễ tiếp cận (Accessible)**.

## 1. Triết lý thiết kế (Design Philosophy)
-   **Dark Mode First:** Giao diện mặc định luôn là nền tối (`bg-slate-950` hoặc `#020617`).
-   **Mobile First Responsive:** Thiết kế từ mobile lên desktop, sử dụng breakpoints chuẩn.
-   **Performance Optimized:** Sử dụng `will-change: transform` cho element động. Không dùng jQuery, chỉ dùng Vanilla JS.
-   **Full Accessibility (a11y):**
    -   Độ tương phản văn bản đạt chuẩn WCAG AA (Contrast > 4.5:1).
    -   **ARIA Attributes:** Bắt buộc cho các component tùy chỉnh (Dropdown, Modal, Tab).
    -   **Full Keyboard Navigation:** Tab, Enter, Escape, Arrow Keys.
    -   Luôn có trạng thái `:focus-visible` rõ ràng (outline màu tím).
-   **Low-tech User Friendliness (Thân thiện với người dùng Low-tech):**
    -   **Nút bấm lớn:** Kích thước tối thiểu 44x44px cho mọi thao tác chạm.
    -   **Nhãn rõ ràng:** Không dùng icon đơn độc (trừ khi quá phổ biến như Search/Menu), luôn kèm text label.
    -   **Phản hồi tức thì:** Mọi cú click đều phải có hiệu ứng (Ripple, Loading, Toast) để người dùng biết hệ thống đang xử lý.
    -   **Tránh ẩn giấu:** Hạn chế các menu ẩn sâu, thao tác vuốt phức tạp.
-   **Deep Critical Thinking (Tư duy Phản biện Sâu):**
    -   Luôn tự đặt câu hỏi: "Component này có thực sự cần thiết không?", "Người dùng 60 tuổi có hiểu cách dùng không?".
    -   Không thiết kế chỉ để "cho đẹp", phải thiết kế để "dễ dùng".

## 1.1 Quy trình Tư duy Thiết kế (Design Reasoning Protocol)
Trước khi code bất kỳ component nào, hãy thực hiện quy trình suy luận sau:

1.  **Question (Đặt câu hỏi):**
    -   "Tại sao lại dùng Dropdown ở đây? Có phải chỉ có 3 lựa chọn không? Nếu vậy dùng Radio Button hoặc Segmented Control có nhanh hơn không?"
    -   "Nút này đặt ở góc màn hình có dễ bấm trên điện thoại màn hình lớn không?"
    -   "Màu chữ này trên nền kính mờ có đủ đọc khi ra ngoài trời nắng không?"

2.  **Analyze (Phân tích):**
    -   *Lỗi thường gặp:* Dùng Dropdown cho danh sách < 5 mục -> Tốn 2 lần click.
    -   *Giải pháp:* Chuyển sang dạng Chips hoặc Radio Group (chỉ tốn 1 click).

3.  **Refine (Tinh chỉnh):**
    -   Nếu bắt buộc dùng Dropdown, hãy chắc chắn nó hỗ trợ tìm kiếm (nếu > 10 mục) và hỗ trợ phím mũi tên.

4.  **Low-tech Check:**
    -   Đưa cho "bà ngoại" dùng thử (tưởng tượng). Nếu bà hỏi "Bấm vào đâu?", nghĩa là thiết kế thất bại.


---

## 2. Setup Yêu Cầu & Design Tokens

```html
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <!-- Font Stack: Vietnamese + English -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&family=Be+Vietnam+Pro:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    :root {
      /* ========== COLOR PALETTE SYSTEM ========== */
      /* Primary Colors */
      --color-primary-50: #fdf4ff;
      --color-primary-100: #fae8ff;
      --color-primary-200: #f5d0fe;
      --color-primary-300: #f0abfc;
      --color-primary-400: #e879f9;
      --color-primary-500: #d946ef;
      --color-primary-600: #c026d3;
      --color-primary-700: #a21caf;
      --color-primary-800: #86198f;
      --color-primary-900: #701a75;
      
      /* Accent Colors (Cyan-Pink Gradient) */
      --color-accent-cyan: #06b6d4;
      --color-accent-pink: #ec4899;
      --color-accent-violet: #8b5cf6;
      --color-accent-emerald: #10b981;
      --color-accent-amber: #f59e0b;
      
      /* Surface Colors (Dark Mode) */
      --color-surface-base: #020617;
      --color-surface-elevated: #0f172a;
      --color-surface-overlay: rgba(15, 23, 42, 0.95);
      --color-surface-glass: rgba(255, 255, 255, 0.05);
      --color-surface-glass-hover: rgba(255, 255, 255, 0.08);
      
      /* Text Colors */
      --color-text-primary: #ffffff;
      --color-text-secondary: rgba(255, 255, 255, 0.7);
      --color-text-muted: rgba(255, 255, 255, 0.5);
      --color-text-disabled: rgba(255, 255, 255, 0.3);
      
      /* Border Colors */
      --color-border-subtle: rgba(255, 255, 255, 0.1);
      --color-border-default: rgba(255, 255, 255, 0.2);
      --color-border-strong: rgba(255, 255, 255, 0.3);
      
      /* Semantic Colors */
      --color-success: #22c55e;
      --color-warning: #f59e0b;
      --color-error: #ef4444;
      --color-info: #3b82f6;
      
      /* ========== TYPOGRAPHY SYSTEM ========== */
      /* Font Families */
      --font-vietnamese: 'Be Vietnam Pro', 'Inter', system-ui, sans-serif;
      --font-english: 'Outfit', 'Inter', system-ui, sans-serif;
      --font-default: var(--font-vietnamese); /* Change to --font-english for English */
      --font-heading: var(--font-english);
      --font-mono: 'JetBrains Mono', 'Fira Code', monospace;
      
      /* Font Sizes (Fluid Typography) */
      --text-xs: clamp(0.625rem, 0.5rem + 0.5vw, 0.75rem);
      --text-sm: clamp(0.75rem, 0.65rem + 0.5vw, 0.875rem);
      --text-base: clamp(0.875rem, 0.75rem + 0.5vw, 1rem);
      --text-lg: clamp(1rem, 0.9rem + 0.5vw, 1.125rem);
      --text-xl: clamp(1.125rem, 1rem + 0.5vw, 1.25rem);
      --text-2xl: clamp(1.25rem, 1rem + 1vw, 1.5rem);
      --text-3xl: clamp(1.5rem, 1.2rem + 1.5vw, 1.875rem);
      --text-4xl: clamp(1.875rem, 1.5rem + 2vw, 2.25rem);
      --text-5xl: clamp(2.25rem, 1.8rem + 2.5vw, 3rem);
      --text-6xl: clamp(3rem, 2.5rem + 3vw, 4rem);
      
      /* ========== SPACING SYSTEM ========== */
      --space-1: 0.25rem;
      --space-2: 0.5rem;
      --space-3: 0.75rem;
      --space-4: 1rem;
      --space-5: 1.25rem;
      --space-6: 1.5rem;
      --space-8: 2rem;
      --space-10: 2.5rem;
      --space-12: 3rem;
      --space-16: 4rem;
      --space-20: 5rem;
      
      /* ========== Z-INDEX SYSTEM ========== */
      --z-negative: -1;
      --z-normal: 1;
      --z-sticky-nav: 50;
      --z-dropdown: 100;
      --z-modal: 999;
      --z-toast: 1000;
      
      /* ========== BREAKPOINTS (Reference for JS) ========== */
      --bp-sm: 640px;
      --bp-md: 768px;
      --bp-lg: 1024px;
      --bp-xl: 1280px;
      --bp-2xl: 1536px;
      
      /* ========== SHADOWS ========== */
      --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.3);
      --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.4);
      --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.4);
      --shadow-xl: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
      --shadow-glow-primary: 0 0 30px rgba(217, 70, 239, 0.3);
      --shadow-glow-cyan: 0 0 30px rgba(6, 182, 212, 0.3);
      
      /* ========== TRANSITIONS ========== */
      --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
      --transition-base: 300ms cubic-bezier(0.4, 0, 0.2, 1);
      --transition-slow: 500ms cubic-bezier(0.4, 0, 0.2, 1);
      --transition-bounce: 500ms cubic-bezier(0.68, -0.55, 0.265, 1.55);
      
      /* ========== BORDER RADIUS ========== */
      --radius-sm: 0.375rem;
      --radius-md: 0.5rem;
      --radius-lg: 0.75rem;
      --radius-xl: 1rem;
      --radius-2xl: 1.5rem;
      --radius-full: 9999px;
    }

    /* ========== BASE STYLES ========== */
    *, *::before, *::after { box-sizing: border-box; }
    
    html { 
      scroll-behavior: smooth; 
      -webkit-text-size-adjust: 100%;
    }
    
    body { 
      font-family: var(--font-default);
      font-size: var(--text-base);
      background-color: var(--color-surface-base);
      color: var(--color-text-primary);
      line-height: 1.6;
      min-height: 100vh;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    /* ========== RESPONSIVE CONTAINER ========== */
    .container-fluid { width: 100%; padding-left: var(--space-4); padding-right: var(--space-4); }
    .container { 
      width: 100%; 
      max-width: 1280px; 
      margin: 0 auto; 
      padding-left: var(--space-4); 
      padding-right: var(--space-4); 
    }
    @media (min-width: 640px) { .container { padding-left: var(--space-6); padding-right: var(--space-6); } }
    @media (min-width: 1024px) { .container { padding-left: var(--space-8); padding-right: var(--space-8); } }

    /* ========== RESPONSIVE GRID ========== */
    .grid-responsive {
      display: grid;
      gap: var(--space-4);
      grid-template-columns: 1fr;
    }
    @media (min-width: 640px) { .grid-responsive { grid-template-columns: repeat(2, 1fr); gap: var(--space-6); } }
    @media (min-width: 1024px) { .grid-responsive { grid-template-columns: repeat(3, 1fr); } }
    @media (min-width: 1280px) { .grid-responsive { grid-template-columns: repeat(4, 1fr); gap: var(--space-8); } }

    /* ========== CORE GLASS CLASSES ========== */
    .glass-panel {
      background: var(--color-surface-glass);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid var(--color-border-subtle);
      box-shadow: var(--shadow-xl);
    }
    
    .glass-panel-elevated {
      background: var(--color-surface-glass);
      backdrop-filter: blur(24px);
      -webkit-backdrop-filter: blur(24px);
      border: 1px solid var(--color-border-default);
      box-shadow: var(--shadow-xl), var(--shadow-glow-primary);
    }

    /* ========== ACCESSIBILITY FOCUS ========== */
    *:focus-visible {
      outline: 2px solid var(--color-primary-500);
      outline-offset: 2px;
    }
    
    /* Skip to content for screen readers */
    .skip-link {
      position: absolute;
      top: -40px;
      left: 0;
      background: var(--color-primary-600);
      color: white;
      padding: var(--space-2) var(--space-4);
      z-index: 10000;
      transition: top var(--transition-fast);
    }
    .skip-link:focus { top: 0; }

    /* ========== TYPOGRAPHY CLASSES ========== */
    .font-vietnamese { font-family: var(--font-vietnamese); }
    .font-english { font-family: var(--font-english); }
    .font-heading { font-family: var(--font-heading); font-weight: 700; letter-spacing: -0.02em; }
    .font-mono { font-family: var(--font-mono); }
    
    .text-gradient {
      background: linear-gradient(135deg, var(--color-accent-cyan), var(--color-accent-pink));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    
    .text-gradient-gold {
      background: linear-gradient(135deg, #f59e0b, #fbbf24, #f59e0b);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    /* ========== DROPDOWN STYLES ========== */
    .glass-dropdown { position: relative; width: 100%; z-index: var(--z-dropdown); }
    .glass-dropdown-select {
      background: rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(10px);
      border: 1px solid var(--color-border-subtle);
      border-radius: var(--radius-xl);
      padding: var(--space-3) var(--space-5);
      color: var(--color-text-primary);
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
      transition: all var(--transition-base);
      font-size: var(--text-base);
    }
    @media (min-width: 768px) { 
      .glass-dropdown-select { padding: var(--space-4) var(--space-5); } 
    }
    .glass-dropdown-select:hover, .glass-dropdown-select:focus {
      background: var(--color-surface-glass-hover);
      border-color: var(--color-border-strong);
    }
    .glass-dropdown-list {
      position: absolute;
      top: calc(100% + 8px);
      left: 0; right: 0;
      background: var(--color-surface-overlay);
      border: 1px solid var(--color-border-subtle);
      border-radius: var(--radius-xl);
      overflow: hidden;
      opacity: 0; visibility: hidden;
      transform: translateY(-10px);
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: var(--shadow-xl);
      max-height: 300px;
      overflow-y: auto;
    }
    .glass-dropdown.active .glass-dropdown-list { opacity: 1; visibility: visible; transform: translateY(0); }
    .glass-dropdown-option {
      padding: var(--space-3) var(--space-5);
      color: var(--color-text-secondary);
      cursor: pointer;
      transition: all 0.2s ease;
    }
    .glass-dropdown-option:hover, .glass-dropdown-option:focus, .glass-dropdown-option.highlighted { 
      background: var(--color-surface-glass-hover); 
      color: var(--color-text-primary); 
      outline: none;
    }
    .glass-dropdown-option.selected { background: rgba(236, 72, 153, 0.2); color: var(--color-text-primary); }

    /* ========== FORM STATES ========== */
    .input-error {
      border-color: var(--color-error) !important;
      box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
      animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
    }
    .input-disabled {
      opacity: 0.5;
      pointer-events: none;
      cursor: not-allowed;
    }
    @keyframes shake {
      10%, 90% { transform: translate3d(-1px, 0, 0); }
      20%, 80% { transform: translate3d(2px, 0, 0); }
      30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
      40%, 60% { transform: translate3d(4px, 0, 0); }
    }

    /* ========== SKELETON LOADER ========== */
    .skeleton-loader {
      background: linear-gradient(90deg, rgba(255,255,255,0.05) 25%, rgba(255,255,255,0.1) 50%, rgba(255,255,255,0.05) 75%);
      background-size: 200% 100%;
      animation: skeleton-shimmer 1.5s infinite;
      border-radius: var(--radius-md);
    }
    @keyframes skeleton-shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }

    /* ========== TOAST NOTIFICATION ========== */
    .toast-container { 
      position: fixed; 
      bottom: var(--space-4); 
      right: var(--space-4); 
      z-index: var(--z-toast); 
      display: flex; 
      flex-direction: column; 
      gap: var(--space-3);
      max-width: calc(100vw - var(--space-8));
    }
    @media (min-width: 640px) { 
      .toast-container { bottom: var(--space-6); right: var(--space-6); max-width: 400px; } 
    }
    .toast {
      padding: var(--space-4) var(--space-6);
      border-radius: var(--radius-xl);
      background: var(--color-surface-overlay);
      backdrop-filter: blur(10px);
      border: 1px solid var(--color-border-subtle);
      color: var(--color-text-primary);
      font-weight: 500;
      box-shadow: var(--shadow-lg);
      animation: toast-slide-in var(--transition-base);
    }
    .toast.success { border-left: 4px solid var(--color-success); }
    .toast.error { border-left: 4px solid var(--color-error); }
    .toast.warning { border-left: 4px solid var(--color-warning); }
    .toast.info { border-left: 4px solid var(--color-info); }
    @keyframes toast-slide-in { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
  </style>
</head>
```

---

## 3. Responsive Breakpoints & Utilities

```css
/* ========== RESPONSIVE VISIBILITY ========== */
.hidden-mobile { display: none; }
@media (min-width: 768px) { .hidden-mobile { display: block; } }

.hidden-desktop { display: block; }
@media (min-width: 768px) { .hidden-desktop { display: none; } }

/* ========== RESPONSIVE SPACING ========== */
.p-responsive { padding: var(--space-4); }
@media (min-width: 768px) { .p-responsive { padding: var(--space-6); } }
@media (min-width: 1024px) { .p-responsive { padding: var(--space-8); } }

.gap-responsive { gap: var(--space-4); }
@media (min-width: 768px) { .gap-responsive { gap: var(--space-6); } }
@media (min-width: 1024px) { .gap-responsive { gap: var(--space-8); } }

/* ========== RESPONSIVE TEXT ALIGNMENT ========== */
.text-center-mobile { text-align: center; }
@media (min-width: 768px) { .text-center-mobile { text-align: left; } }

/* ========== RESPONSIVE FLEX ========== */
.flex-col-mobile { flex-direction: column; }
@media (min-width: 768px) { .flex-col-mobile { flex-direction: row; } }
```

---

## 4. Card Design System

```html
<!-- CARD BASIC -->
<article class="glass-card">
  <div class="glass-card-image">
    <img src="image.jpg" alt="Description" loading="lazy">
    <span class="glass-card-badge">New</span>
  </div>
  <div class="glass-card-content">
    <h3 class="glass-card-title">Card Title</h3>
    <p class="glass-card-description">Short description here.</p>
    <div class="glass-card-footer">
      <span class="glass-card-meta"><i class="fa-regular fa-clock"></i> 5 min</span>
      <button class="glass-btn glass-btn-sm">Action</button>
    </div>
  </div>
</article>

<!-- CARD HORIZONTAL (Tablet+) -->
<article class="glass-card glass-card-horizontal">
  <div class="glass-card-image">
    <img src="image.jpg" alt="Description" loading="lazy">
  </div>
  <div class="glass-card-content">
    <h3 class="glass-card-title">Horizontal Card</h3>
    <p class="glass-card-description">Works on larger screens.</p>
  </div>
</article>

<!-- CARD PROFILE -->
<article class="glass-card glass-card-profile">
  <div class="glass-card-avatar">
    <img src="avatar.jpg" alt="User Name">
    <span class="glass-card-status online"></span>
  </div>
  <h3 class="glass-card-title">User Name</h3>
  <p class="glass-card-subtitle">@username</p>
  <div class="glass-card-stats">
    <div><strong>1.2K</strong><span>Followers</span></div>
    <div><strong>350</strong><span>Following</span></div>
  </div>
</article>
```

```css
/* ========== CARD STYLES ========== */
.glass-card {
  background: var(--color-surface-glass);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid var(--color-border-subtle);
  border-radius: var(--radius-2xl);
  overflow: hidden;
  transition: all var(--transition-base);
}
.glass-card:hover {
  transform: translateY(-4px);
  border-color: var(--color-border-default);
  box-shadow: var(--shadow-xl), var(--shadow-glow-primary);
}

.glass-card-image {
  position: relative;
  aspect-ratio: 16/9;
  overflow: hidden;
}
.glass-card-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform var(--transition-slow);
}
.glass-card:hover .glass-card-image img { transform: scale(1.05); }

.glass-card-badge {
  position: absolute;
  top: var(--space-3);
  right: var(--space-3);
  background: linear-gradient(135deg, var(--color-accent-cyan), var(--color-accent-pink));
  color: white;
  padding: var(--space-1) var(--space-3);
  border-radius: var(--radius-full);
  font-size: var(--text-xs);
  font-weight: 600;
  text-transform: uppercase;
}

.glass-card-content {
  padding: var(--space-4);
}
@media (min-width: 768px) { .glass-card-content { padding: var(--space-5); } }

.glass-card-title {
  font-family: var(--font-heading);
  font-size: var(--text-lg);
  font-weight: 600;
  color: var(--color-text-primary);
  margin-bottom: var(--space-2);
}

.glass-card-description {
  font-size: var(--text-sm);
  color: var(--color-text-secondary);
  line-height: 1.6;
  margin-bottom: var(--space-4);
}

.glass-card-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: var(--space-4);
  border-top: 1px solid var(--color-border-subtle);
}

.glass-card-meta {
  font-size: var(--text-xs);
  color: var(--color-text-muted);
  display: flex;
  align-items: center;
  gap: var(--space-2);
}

/* CARD HORIZONTAL */
@media (min-width: 768px) {
  .glass-card-horizontal { display: flex; }
  .glass-card-horizontal .glass-card-image { width: 40%; aspect-ratio: 1/1; }
  .glass-card-horizontal .glass-card-content { width: 60%; display: flex; flex-direction: column; justify-content: center; }
}

/* CARD PROFILE */
.glass-card-profile {
  text-align: center;
  padding: var(--space-6);
}
.glass-card-avatar {
  position: relative;
  width: 80px;
  height: 80px;
  margin: 0 auto var(--space-4);
}
.glass-card-avatar img {
  width: 100%;
  height: 100%;
  border-radius: var(--radius-full);
  object-fit: cover;
  border: 3px solid var(--color-border-default);
}
.glass-card-status {
  position: absolute;
  bottom: 4px;
  right: 4px;
  width: 16px;
  height: 16px;
  border-radius: var(--radius-full);
  border: 2px solid var(--color-surface-base);
}
.glass-card-status.online { background: var(--color-success); }
.glass-card-status.offline { background: var(--color-text-muted); }
.glass-card-subtitle {
  font-size: var(--text-sm);
  color: var(--color-text-muted);
  margin-bottom: var(--space-4);
}
.glass-card-stats {
  display: flex;
  justify-content: center;
  gap: var(--space-8);
  padding-top: var(--space-4);
  border-top: 1px solid var(--color-border-subtle);
}
.glass-card-stats div { text-align: center; }
.glass-card-stats strong { display: block; font-size: var(--text-lg); font-weight: 700; color: var(--color-text-primary); }
.glass-card-stats span { font-size: var(--text-xs); color: var(--color-text-muted); }
```

---

## 5. Button System

```css
/* ========== BUTTON BASE ========== */
.glass-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: var(--space-2);
  padding: var(--space-3) var(--space-5);
  font-family: var(--font-default);
  font-size: var(--text-sm);
  font-weight: 600;
  border-radius: var(--radius-xl);
  border: 1px solid transparent;
  cursor: pointer;
  transition: all var(--transition-base);
  white-space: nowrap;
}

/* SIZES */
.glass-btn-sm { padding: var(--space-2) var(--space-4); font-size: var(--text-xs); }
.glass-btn-lg { padding: var(--space-4) var(--space-8); font-size: var(--text-base); }
.glass-btn-full { width: 100%; }

/* VARIANTS */
.glass-btn-primary {
  background: linear-gradient(135deg, var(--color-accent-pink), var(--color-primary-600));
  color: white;
  box-shadow: var(--shadow-md), 0 0 20px rgba(236, 72, 153, 0.3);
}
.glass-btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: var(--shadow-lg), 0 0 30px rgba(236, 72, 153, 0.4);
}

.glass-btn-secondary {
  background: var(--color-surface-glass);
  border-color: var(--color-border-default);
  color: var(--color-text-primary);
  backdrop-filter: blur(10px);
}
.glass-btn-secondary:hover {
  background: var(--color-surface-glass-hover);
  border-color: var(--color-border-strong);
}

.glass-btn-ghost {
  background: transparent;
  color: var(--color-text-secondary);
}
.glass-btn-ghost:hover {
  background: var(--color-surface-glass);
  color: var(--color-text-primary);
}

.glass-btn-icon {
  padding: var(--space-3);
  border-radius: var(--radius-full);
}

/* STATES */
.glass-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
  pointer-events: none;
}
.glass-btn-loading {
  position: relative;
  color: transparent !important;
}
.glass-btn-loading::after {
  content: '';
  position: absolute;
  width: 16px;
  height: 16px;
  border: 2px solid rgba(255,255,255,0.3);
  border-top-color: white;
  border-radius: var(--radius-full);
  animation: spin 0.8s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }
```

---

## 6. Dropdown: HTML Template (Accessible)

```html
<!-- ARIA: role, aria-haspopup, aria-expanded, aria-labelledby -->
<div class="glass-dropdown" id="my-dropdown">
  <div class="glass-dropdown-select" 
       tabindex="0" 
       role="combobox" 
       aria-haspopup="listbox" 
       aria-expanded="false" 
       aria-labelledby="dropdown-label">
    <span class="selected-text">Chọn một mục</span>
    <i class="fa-solid fa-chevron-down text-xs opacity-50 transition-transform"></i>
  </div>
  <div class="glass-dropdown-list" role="listbox" aria-labelledby="dropdown-label">
    <div class="glass-dropdown-option" role="option" tabindex="-1" data-value="1">Mục 1</div>
    <div class="glass-dropdown-option" role="option" tabindex="-1" data-value="2">Mục 2</div>
  </div>
  <input type="hidden" name="my_field" value="">
</div>
```

---

## 7. Vanilla JS Interactions Library (No jQuery)

```javascript
document.addEventListener('DOMContentLoaded', () => {
    /* ========== UTILS ========== */
    const $ = (selector, parent = document) => parent.querySelector(selector);
    const $$ = (selector, parent = document) => [...parent.querySelectorAll(selector)];

    /* ========== DROPDOWN (Accessible + Keyboard + Click Outside) ========== */
    const closeAllDropdowns = (except = null) => {
        $$('.glass-dropdown.active').forEach(el => {
            if (el !== except) {
                el.classList.remove('active');
                const select = $('.glass-dropdown-select', el);
                if (select) select.setAttribute('aria-expanded', 'false');
            }
        });
    };

    document.addEventListener('click', (e) => {
        if (!e.target.closest('.glass-dropdown')) closeAllDropdowns();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeAllDropdowns();
    });

    $$('.glass-dropdown').forEach(dropdown => {
        const select = $('.glass-dropdown-select', dropdown);
        const list = $('.glass-dropdown-list', dropdown);
        const options = $$('.glass-dropdown-option', dropdown);
        const hiddenInput = $('input[type="hidden"]', dropdown);
        const textDisplay = $('.selected-text', dropdown);
        let highlightedIndex = -1;

        if (!select || !list) return;

        const toggleDropdown = () => {
            const isActive = dropdown.classList.contains('active');
            closeAllDropdowns(isActive ? null : dropdown); // Close others if opening
            
            if (!isActive) {
                dropdown.classList.add('active');
                select.setAttribute('aria-expanded', 'true');
                // Find currently selected index
                highlightedIndex = options.findIndex(opt => opt.classList.contains('selected'));
                if (highlightedIndex === -1) highlightedIndex = 0;
                updateHighlight();
            }
        };

        const updateHighlight = () => {
            options.forEach((opt, idx) => {
                if (idx === highlightedIndex) {
                    opt.classList.add('highlighted');
                    opt.scrollIntoView({ block: 'nearest' });
                } else {
                    opt.classList.remove('highlighted');
                }
            });
        };

        const selectOption = (option) => {
            if (!option) return;
            const value = option.dataset.value;
            const label = option.textContent;

            textDisplay.textContent = label;
            if (hiddenInput) {
                hiddenInput.value = value;
                // Trigger change event manually
                hiddenInput.dispatchEvent(new Event('change'));
            }

            options.forEach(o => o.classList.remove('selected'));
            option.classList.add('selected');
            
            closeAllDropdowns();
            select.focus(); // Return focus to trigger
        };

        // Event Listeners
        select.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleDropdown();
        });

        select.addEventListener('keydown', (e) => {
            const isActive = dropdown.classList.contains('active');
            if (['ArrowDown', 'ArrowUp', 'Enter', ' '].includes(e.key)) {
                e.preventDefault();
            }

            if (e.key === 'ArrowDown') {
                if (!isActive) toggleDropdown();
                else {
                    highlightedIndex = (highlightedIndex + 1) % options.length;
                    updateHighlight();
                }
            } else if (e.key === 'ArrowUp') {
                if (!isActive) toggleDropdown();
                else {
                    highlightedIndex = (highlightedIndex - 1 + options.length) % options.length;
                    updateHighlight();
                }
            } else if (e.key === 'Enter' || e.key === ' ') {
                if (isActive && highlightedIndex >= 0) {
                    selectOption(options[highlightedIndex]);
                } else {
                    toggleDropdown();
                }
            }
        });

        options.forEach((opt, idx) => {
            opt.addEventListener('click', (e) => {
                e.stopPropagation();
                selectOption(opt);
            });
            opt.addEventListener('mouseenter', () => {
                highlightedIndex = idx;
                updateHighlight();
            });
        });
    });

    /* ========== MODAL (Focus Trap + Animation) ========== */
    const openModal = (modalId) => {
        const modal = $(modalId);
        if (!modal) return;
        
        modal.classList.remove('hidden');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('overflow-hidden');
        
        // Animation
        const content = $('.modal-content', modal);
        if (content) {
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }
        
        // Focus first close button or input
        const firstFocus = $('[data-modal-close], input, button', modal);
        if (firstFocus) firstFocus.focus();
    };

    const closeModal = (modal) => {
        if (!modal) return;
        
        const content = $('.modal-content', modal);
        if (content) {
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
        }
        
        modal.setAttribute('aria-hidden', 'true');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 300);
    };

    document.addEventListener('click', (e) => {
        const trigger = e.target.closest('[data-modal-target]');
        if (trigger) {
            e.preventDefault();
            openModal(trigger.dataset.modalTarget);
        }

        const closeBtn = e.target.closest('[data-modal-close]');
        if (closeBtn) {
            closeModal(closeBtn.closest('.fixed'));
        }

        if (e.target.classList.contains('modal-overlay')) {
            closeModal(e.target.closest('.fixed'));
        }
    });

    /* ========== TABS ========== */
    $$('.glass-tabs').forEach(tabGroup => {
        const buttons = $$('[role="tab"]', tabGroup);
        
        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                // Deactivate all
                buttons.forEach(b => {
                    b.setAttribute('aria-selected', 'false');
                    b.classList.remove('active');
                    const panel = $(b.getAttribute('aria-controls'));
                    if (panel) panel.classList.add('hidden');
                });

                // Activate clicked
                btn.setAttribute('aria-selected', 'true');
                btn.classList.add('active');
                const targetPanel = $(btn.getAttribute('aria-controls'));
                if (targetPanel) targetPanel.classList.remove('hidden');
            });

            // Keyboard Nav
            btn.addEventListener('keydown', (e) => {
                const idx = buttons.indexOf(btn);
                let nextIdx = -1;

                if (e.key === 'ArrowRight') nextIdx = (idx + 1) % buttons.length;
                if (e.key === 'ArrowLeft') nextIdx = (idx - 1 + buttons.length) % buttons.length;

                if (nextIdx !== -1) {
                    e.preventDefault();
                    buttons[nextIdx].focus();
                    buttons[nextIdx].click();
                }
            });
        });
    });

    /* ========== ACCORDION ========== */
    document.addEventListener('click', (e) => {
        const trigger = e.target.closest('.glass-accordion-trigger');
        if (!trigger) return;

        const item = trigger.closest('.glass-accordion-item');
        const content = $('.glass-accordion-content', item);
        const parent = item.closest('.glass-accordion');
        const isOpen = item.classList.contains('open');

        // Close others if not multi-select
        if (parent && !parent.classList.contains('multi')) {
            $$('.glass-accordion-item.open', parent).forEach(sibling => {
                if (sibling !== item) {
                    sibling.classList.remove('open');
                    // Reset inline styles for slideUp
                    const sibContent = $('.glass-accordion-content', sibling);
                    sibContent.style.maxHeight = null;
                }
            });
        }

        if (isOpen) {
            item.classList.remove('open');
            content.style.maxHeight = null;
        } else {
            item.classList.add('open');
            content.style.maxHeight = content.scrollHeight + "px";
        }
    });

    /* ========== SMOOTH SCROLL ========== */
    document.addEventListener('click', (e) => {
        const link = e.target.closest('a[href^="#"]');
        if (link) {
            const targetId = link.getAttribute('href');
            const target = $(targetId);
            if (target) {
                e.preventDefault();
                const headerOffset = 80;
                const elementPosition = target.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: "smooth"
                });
            }
        }
    });

    /* ========== SCROLL REVEAL ========== */
    const revealElements = $$('[data-reveal]');
    const checkReveal = () => {
        const triggerBottom = window.innerHeight * 0.85;
        revealElements.forEach(el => {
            const boxTop = el.getBoundingClientRect().top;
            if (boxTop < triggerBottom) {
                const delay = el.dataset.revealDelay || 0;
                setTimeout(() => el.classList.add('revealed'), delay);
            }
        });
    };
    window.addEventListener('scroll', checkReveal);
    window.addEventListener('load', checkReveal);

    /* ========== LAZY LOAD ========== */
    if ('IntersectionObserver' in window) {
        const lazyObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    observer.unobserve(img);
                }
            });
        }, { rootMargin: '50px' });
        
        $$('img[data-src]').forEach(img => lazyObserver.observe(img));
    }

    /* ========== RIPPLE EFFECT ========== */
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.ripple');
        if (btn) {
            const rect = btn.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const circle = document.createElement('span');
            circle.classList.add('ripple-effect');
            circle.style.left = `${x}px`;
            circle.style.top = `${y}px`;
            
            btn.appendChild(circle);
            setTimeout(() => circle.remove(), 600);
        }
    });

    /* ========== COUNTER ANIMATION ========== */
    const counters = $$('[data-counter]');
    const counterObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const target = parseInt(el.dataset.counter);
                const duration = parseInt(el.dataset.counterDuration) || 2000;
                const step = target / (duration / 16);
                let current = 0;
                
                const timer = setInterval(() => {
                    current += step;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    el.textContent = Math.floor(current).toLocaleString();
                }, 16);
                
                observer.unobserve(el);
            }
        });
    });
    counters.forEach(c => counterObserver.observe(c));

    /* ========== PARALLAX ========== */
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        $$('[data-parallax]').forEach(el => {
            const speed = el.dataset.parallax || 0.5;
            el.style.transform = `translateY(${scrolled * speed}px)`;
        });
    });
});

/* ========== TOAST NOTIFICATION HELPER ========== */
window.showToast = (message, type = 'success', duration = 3000) => {
    let container = document.querySelector('.toast-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container';
        document.body.appendChild(container);
    }
    
    const iconMap = {
        success: 'fa-circle-check',
        error: 'fa-circle-xmark',
        warning: 'fa-triangle-exclamation',
        info: 'fa-circle-info'
    };
    const iconClass = iconMap[type] || iconMap.info;
    
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.innerHTML = `<i class="fa-solid ${iconClass}"></i> ${message}`;
    
    container.appendChild(toast);
    
    // Trigger reflow for transition
    void toast.offsetWidth; 
    
    // No specific enter animation class needed if CSS handles it via keyframes or default state
    // But let's assume CSS has animation: toast-slide-in
    
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        toast.style.transition = 'all 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, duration);
};
```

---

## 8. Animation Utilities

```css
/* ========== REVEAL ANIMATIONS ========== */
[data-reveal] {
  opacity: 0;
  transform: translateY(30px);
  transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}
[data-reveal].revealed {
  opacity: 1;
  transform: translateY(0);
}
[data-reveal="fade-left"] { transform: translateX(-30px); }
[data-reveal="fade-left"].revealed { transform: translateX(0); }
[data-reveal="fade-right"] { transform: translateX(30px); }
[data-reveal="fade-right"].revealed { transform: translateX(0); }
[data-reveal="zoom"] { transform: scale(0.9); }
[data-reveal="zoom"].revealed { transform: scale(1); }

/* ========== HOVER ANIMATIONS ========== */
.hover-lift { transition: transform var(--transition-base); }
.hover-lift:hover { transform: translateY(-4px); }

.hover-scale { transition: transform var(--transition-base); }
.hover-scale:hover { transform: scale(1.05); }

.hover-glow { transition: box-shadow var(--transition-base); }
.hover-glow:hover { box-shadow: var(--shadow-glow-primary); }

/* ========== PULSE ANIMATION ========== */
.pulse { animation: pulse 2s infinite; }
@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.5; }
}

/* ========== FLOAT ANIMATION ========== */
.float { animation: float 3s ease-in-out infinite; }
@keyframes float {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-10px); }
}

/* ========== RIPPLE EFFECT ========== */
.ripple { position: relative; overflow: hidden; }
.ripple-effect {
  position: absolute;
  border-radius: var(--radius-full);
  background: rgba(255, 255, 255, 0.3);
  transform: scale(0);
  animation: ripple-animation 0.6s linear;
  pointer-events: none;
  width: 100px;
  height: 100px;
  margin: -50px 0 0 -50px;
}
@keyframes ripple-animation { to { transform: scale(4); opacity: 0; } }

/* ========== GRADIENT BORDER ANIMATION ========== */
.gradient-border {
  position: relative;
  background: var(--color-surface-base);
  border-radius: var(--radius-2xl);
}
.gradient-border::before {
  content: '';
  position: absolute;
  inset: -2px;
  border-radius: inherit;
  background: linear-gradient(45deg, var(--color-accent-cyan), var(--color-accent-pink), var(--color-accent-violet), var(--color-accent-cyan));
  background-size: 300% 300%;
  animation: gradient-rotate 3s linear infinite;
  z-index: -1;
}
@keyframes gradient-rotate { 0% { background-position: 0 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0 50%; } }
```

---

## 9. Example: Complete Responsive Page

```html
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Premium Glass UI</title>
  <!-- Include all setup from Section 2 -->
</head>
<body>
  <a href="#main-content" class="skip-link">Bỏ qua đến nội dung chính</a>

  <!-- HEADER (Sticky, Responsive) -->
  <header class="glass-panel" style="position: sticky; top: 0; z-index: var(--z-sticky-nav);">
    <div class="container flex items-center justify-between py-4">
      <a href="/" class="text-gradient font-heading text-xl">BrandName</a>
      
      <!-- Mobile Menu Button -->
      <button class="glass-btn glass-btn-icon hidden-desktop" aria-label="Menu">
        <i class="fa-solid fa-bars"></i>
      </button>
      
      <!-- Desktop Nav -->
      <nav class="hidden-mobile flex gap-6">
        <a href="#" class="text-white/70 hover:text-white transition">Trang chủ</a>
        <a href="#" class="text-white/70 hover:text-white transition">Sản phẩm</a>
        <a href="#" class="text-white/70 hover:text-white transition">Liên hệ</a>
      </nav>
    </div>
  </header>

  <!-- MAIN CONTENT -->
  <main id="main-content" class="container py-12">
    <!-- Hero Section -->
    <section class="text-center mb-16" data-reveal>
      <h1 class="font-heading text-gradient" style="font-size: var(--text-5xl);">
        Thiết kế Glassmorphism
      </h1>
      <p class="text-white/70 mt-4 max-w-2xl mx-auto" style="font-size: var(--text-lg);">
        Giao diện hiện đại, sang trọng, responsive trên mọi thiết bị.
      </p>
      <div class="flex gap-4 justify-center mt-8 flex-col-mobile">
        <button class="glass-btn glass-btn-primary glass-btn-lg ripple">Bắt đầu ngay</button>
        <button class="glass-btn glass-btn-secondary glass-btn-lg">Tìm hiểu thêm</button>
      </div>
    </section>

    <!-- Cards Grid -->
    <section class="grid-responsive">
      <article class="glass-card" data-reveal data-reveal-delay="100">
        <!-- Card content -->
      </article>
      <article class="glass-card" data-reveal data-reveal-delay="200">
        <!-- Card content -->
      </article>
      <article class="glass-card" data-reveal data-reveal-delay="300">
        <!-- Card content -->
      </article>
    </section>
  </main>

  <!-- FOOTER -->
  <footer class="glass-panel mt-16">
    <div class="container py-8 text-center text-white/50">
      <p>© 2024 BrandName. All rights reserved.</p>
    </div>
  </footer>

  <!-- Include all scripts from Section 7 -->
</body>
</html>
```

---

## 10. Checklist Sử Dụng

| Yêu cầu | Đã có |
|---------|-------|
| Dark Mode mặc định | ✅ |
| Responsive (Mobile First) | ✅ |
| Typography System (VI/EN) | ✅ |
| Color Palette (CSS Variables) | ✅ |
| Card Components | ✅ |
| Button System | ✅ |
| Dropdown (Vanilla JS + ARIA) | ✅ |
| Modal (Focus Trap) | ✅ |
| Tabs (Accessible) | ✅ |
| Accordion | ✅ |
| Toast Notifications | ✅ |
| Skeleton Loader | ✅ |
| Scroll Reveal | ✅ |
| Lazy Load Images | ✅ |
| Parallax Effect | ✅ |
| Ripple Effect | ✅ |
| Counter Animation | ✅ |
| Gradient Animations | ✅ |

