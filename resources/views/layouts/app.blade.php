<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mời Bạn - Thiệp Cưới Online')</title>
    <meta name="description" content="@yield('description', 'Tạo thiệp cưới online miễn phí, đẹp, chuyên nghiệp. Chia sẻ ngày vui của bạn với mọi người.')">
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    <!-- Font Stack: Vietnamese + English -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&family=Be+Vietnam+Pro:wght@300;400;500;600;700;800&family=Great+Vibes&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <style>
        :root {
            /* ========== COLOR PALETTE SYSTEM ========== */
            /* Primary Colors (Rose Gold for Wedding Theme) */
            --color-primary-50: #fdf2f8;
            --color-primary-100: #fce7f3;
            --color-primary-200: #fbcfe8;
            --color-primary-300: #f9a8d4;
            --color-primary-400: #f472b6;
            --color-primary-500: #b76e79;
            --color-primary-600: #a25d67;
            --color-primary-700: #8a4f58;
            --color-primary-800: #723f47;
            --color-primary-900: #5a333a;
            
            /* Accent Colors */
            --color-accent-champagne: #f7e7ce;
            --color-accent-gold: #d4af37;
            --color-accent-pink: #ec4899;
            --color-accent-violet: #8b5cf6;
            
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
            --font-vietnamese: 'Be Vietnam Pro', 'Inter', system-ui, sans-serif;
            --font-english: 'Outfit', 'Inter', system-ui, sans-serif;
            --font-default: var(--font-vietnamese);
            --font-heading: var(--font-english);
            --font-script: 'Great Vibes', cursive;
            
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
            --z-sticky-nav: 50;
            --z-dropdown: 100;
            --z-modal: 999;
            --z-toast: 1000;
            
            /* ========== SHADOWS ========== */
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.3);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.4);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.4);
            --shadow-xl: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            --shadow-glow-primary: 0 0 30px rgba(183, 110, 121, 0.3);
            --shadow-glow-gold: 0 0 30px rgba(212, 175, 55, 0.3);
            
            /* ========== TRANSITIONS ========== */
            --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-base: 300ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: 500ms cubic-bezier(0.4, 0, 0.2, 1);
            
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
            background: linear-gradient(135deg, var(--color-surface-base) 0%, #1e1b4b 50%, var(--color-surface-base) 100%);
            color: var(--color-text-primary);
            line-height: 1.6;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ========== ACCESSIBILITY FOCUS ========== */
        *:focus-visible {
            outline: 2px solid var(--color-primary-500);
            outline-offset: 2px;
        }

        /* ========== RESPONSIVE CONTAINER ========== */
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

        /* ========== GLASS CARD ========== */
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

        /* ========== TYPOGRAPHY CLASSES ========== */
        .font-vietnamese { font-family: var(--font-vietnamese); }
        .font-english { font-family: var(--font-english); }
        .font-heading { font-family: var(--font-heading); font-weight: 700; letter-spacing: -0.02em; }
        .font-script { font-family: var(--font-script); }
        
        .text-gradient {
            background: linear-gradient(135deg, var(--color-accent-champagne), var(--color-primary-500));
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

        /* ========== BUTTON SYSTEM ========== */
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
            text-decoration: none;
        }

        /* Button Sizes */
        .glass-btn-sm { padding: var(--space-2) var(--space-4); font-size: var(--text-xs); }
        .glass-btn-lg { padding: var(--space-4) var(--space-8); font-size: var(--text-base); }
        .glass-btn-full { width: 100%; }

        /* Button Primary */
        .glass-btn-primary, .glass-btn {
            background: linear-gradient(135deg, var(--color-primary-500), var(--color-accent-pink));
            color: white;
            box-shadow: var(--shadow-md), var(--shadow-glow-primary);
        }
        .glass-btn-primary:hover, .glass-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg), 0 0 30px rgba(183, 110, 121, 0.4);
        }

        /* Button Secondary */
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

        /* Button Ghost */
        .glass-btn-ghost {
            background: transparent;
            color: var(--color-text-secondary);
        }
        .glass-btn-ghost:hover {
            background: var(--color-surface-glass);
            color: var(--color-text-primary);
        }

        /* Button States */
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

        /* ========== GLASS INPUT ========== */
        .glass-input {
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid var(--color-border-subtle);
            border-radius: var(--radius-xl);
            padding: var(--space-3) var(--space-5);
            color: var(--color-text-primary);
            width: 100%;
            font-size: var(--text-base);
            transition: all var(--transition-base);
        }
        @media (min-width: 768px) { 
            .glass-input { padding: var(--space-4) var(--space-5); } 
        }
        .glass-input:hover, .glass-input:focus {
            background: var(--color-surface-glass-hover);
            border-color: var(--color-primary-500);
            outline: none;
            box-shadow: 0 0 0 4px rgba(183, 110, 121, 0.1);
        }
        .glass-input::placeholder {
            color: var(--color-text-muted);
        }

        /* Input States */
        .input-error {
            border-color: var(--color-error) !important;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
        }
        @keyframes shake {
            10%, 90% { transform: translate3d(-1px, 0, 0); }
            20%, 80% { transform: translate3d(2px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
            40%, 60% { transform: translate3d(4px, 0, 0); }
        }

        /* ========== NAVIGATION ========== */
        .nav-glass {
            background: var(--color-surface-overlay);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--color-border-subtle);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: var(--z-sticky-nav);
        }
        .nav-link {
            color: var(--color-text-secondary);
            transition: color var(--transition-fast);
            padding: var(--space-2) var(--space-3);
            border-radius: var(--radius-md);
        }
        .nav-link:hover, .nav-link:focus {
            color: var(--color-text-primary);
            background: var(--color-surface-glass);
        }

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

        /* ========== SKELETON LOADER ========== */
        .skeleton-loader {
            background: linear-gradient(90deg, rgba(255,255,255,0.05) 25%, rgba(255,255,255,0.1) 50%, rgba(255,255,255,0.05) 75%);
            background-size: 200% 100%;
            animation: skeleton-shimmer 1.5s infinite;
            border-radius: var(--radius-md);
        }
        @keyframes skeleton-shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }

        /* ========== ANIMATIONS ========== */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }

        /* ========== RESPONSIVE UTILITIES ========== */
        .hidden-mobile { display: none; }
        @media (min-width: 768px) { .hidden-mobile { display: block; } }
        
        .hidden-desktop { display: block; }
        @media (min-width: 768px) { .hidden-desktop { display: none; } }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Skip Link for Accessibility -->
    <a href="#main-content" class="skip-link sr-only focus:not-sr-only focus:absolute focus:top-0 focus:left-0 focus:z-50 focus:p-4 focus:bg-primary-600 focus:text-white">
        Bỏ qua đến nội dung chính
    </a>

    <!-- Navigation -->
    <nav class="nav-glass" role="navigation" aria-label="Main navigation">
        <div class="container">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-2" aria-label="Mời Bạn - Trang chủ">
                    <span class="text-2xl font-script text-gradient">Mời Bạn</span>
                </a>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('templates') }}" class="nav-link">Mẫu thiệp</a>
                    <a href="{{ route('pricing') }}" class="nav-link">Bảng giá</a>
                    
                    @auth
                        <a href="{{ route('user.invitations.create') }}" class="glass-btn glass-btn-sm">
                            <i class="fa-solid fa-plus"></i> Tạo thiệp
                        </a>
                        
                        <!-- User Dropdown -->
                        <div class="relative" id="user-dropdown">
                            <button type="button" class="flex items-center gap-2 p-2 rounded-lg hover:bg-white/10 transition" id="user-dropdown-btn">
                                <div class="w-8 h-8 rounded-full bg-primary-500/30 flex items-center justify-center">
                                    <i class="fa-solid fa-user text-sm text-primary-400"></i>
                                </div>
                                <span class="text-sm">{{ Str::limit(Auth::user()->name, 12) }}</span>
                                <i class="fa-solid fa-chevron-down text-xs text-white/50"></i>
                            </button>
                            
                            <div id="user-dropdown-menu" class="hidden absolute right-0 mt-2 w-56 rounded-xl bg-slate-900/95 backdrop-blur border border-white/10 shadow-xl py-2 z-50">
                                <div class="px-4 py-2 border-b border-white/10">
                                    <p class="font-medium text-sm">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-white/50">{{ Auth::user()->email }}</p>
                                </div>
                                
                                <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-white/5 transition">
                                    <i class="fa-solid fa-chart-pie w-4 text-white/50"></i> Dashboard
                                </a>
                                <a href="{{ route('user.invitations.index') }}" class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-white/5 transition">
                                    <i class="fa-solid fa-envelope w-4 text-white/50"></i> Thiệp của tôi
                                </a>
                                <a href="{{ route('user.wallet') }}" class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-white/5 transition">
                                    <i class="fa-solid fa-wallet w-4 text-white/50"></i> Ví ({{ number_format(Auth::user()->wallet->balance ?? 0, 0, ',', '.') }}đ)
                                </a>
                                <a href="{{ route('user.profile') }}" class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-white/5 transition">
                                    <i class="fa-solid fa-user-gear w-4 text-white/50"></i> Tài khoản
                                </a>
                                
                                @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-amber-400 hover:bg-white/5 transition">
                                    <i class="fa-solid fa-shield w-4"></i> Admin Panel
                                </a>
                                @endif
                                
                                <div class="border-t border-white/10 mt-2 pt-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-3 px-4 py-2 text-sm text-red-400 hover:bg-white/5 transition w-full text-left">
                                            <i class="fa-solid fa-sign-out-alt w-4"></i> Đăng xuất
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="nav-link">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="glass-btn glass-btn-sm">Đăng ký</a>
                    @endauth
                </div>
                
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg hover:bg-white/10 transition" 
                        aria-label="Toggle menu" aria-expanded="false" aria-controls="mobile-menu">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-white/10" role="menu">
            <div class="container py-4 space-y-3">
                <a href="{{ route('templates') }}" class="block nav-link" role="menuitem">Mẫu thiệp</a>
                <a href="{{ route('pricing') }}" class="block nav-link" role="menuitem">Bảng giá</a>
                @auth
                    <div class="border-t border-white/10 my-3 pt-3">
                        <p class="text-xs text-white/40 uppercase tracking-wider mb-2">Tài khoản</p>
                    </div>
                    <a href="{{ route('user.dashboard') }}" class="block nav-link" role="menuitem">
                        <i class="fa-solid fa-chart-pie w-5"></i> Dashboard
                    </a>
                    <a href="{{ route('user.invitations.index') }}" class="block nav-link" role="menuitem">
                        <i class="fa-solid fa-envelope w-5"></i> Thiệp của tôi
                    </a>
                    <a href="{{ route('user.wallet') }}" class="block nav-link" role="menuitem">
                        <i class="fa-solid fa-wallet w-5"></i> Ví ({{ number_format(Auth::user()->wallet->balance ?? 0, 0, ',', '.') }}đ)
                    </a>
                    <a href="{{ route('user.profile') }}" class="block nav-link" role="menuitem">
                        <i class="fa-solid fa-user-gear w-5"></i> Tài khoản
                    </a>
                    @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="block nav-link text-amber-400" role="menuitem">
                        <i class="fa-solid fa-shield w-5"></i> Admin Panel
                    </a>
                    @endif
                    <a href="{{ route('user.invitations.create') }}" class="block glass-btn glass-btn-full text-center mt-4" role="menuitem">
                        <i class="fa-solid fa-plus"></i> Tạo thiệp mới
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="block nav-link text-red-400 w-full text-left">
                            <i class="fa-solid fa-sign-out-alt w-5"></i> Đăng xuất
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block nav-link" role="menuitem">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="block glass-btn glass-btn-full text-center" role="menuitem">Đăng ký</a>
                @endauth
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main id="main-content" class="pt-16" role="main">
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="border-t border-white/10 mt-20" role="contentinfo">
        <div class="container py-12">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-2xl font-script text-gradient mb-4">Mời Bạn</h3>
                    <p class="text-white/60 text-sm">Tạo thiệp cưới online đẹp, chuyên nghiệp. Chia sẻ ngày vui của bạn với mọi người.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Liên kết</h4>
                    <ul class="space-y-2 text-sm text-white/60">
                        <li><a href="{{ route('templates') }}" class="hover:text-white transition">Mẫu thiệp</a></li>
                        <li><a href="{{ route('pricing') }}" class="hover:text-white transition">Bảng giá</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Hỗ trợ</h4>
                    <ul class="space-y-2 text-sm text-white/60">
                        <li><a href="#" class="hover:text-white transition">Hướng dẫn</a></li>
                        <li><a href="#" class="hover:text-white transition">Liên hệ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Kết nối</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-white/60 hover:text-white transition" aria-label="Facebook">
                            <i class="fa-brands fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-white/60 hover:text-white transition" aria-label="Instagram">
                            <i class="fa-brands fa-instagram text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-white/10 mt-8 pt-8 text-center text-sm text-white/40">
                © {{ date('Y') }} moiban.vn - All rights reserved.
            </div>
        </div>
    </footer>
    
    <!-- Toast Container -->
    <div id="toast-container" class="toast-container" role="alert" aria-live="polite"></div>
    
    <!-- Scripts -->
    <script>
        $(document).ready(function() {
            // Mobile menu toggle with ARIA
            const $menuBtn = $('#mobile-menu-btn');
            const $menu = $('#mobile-menu');
            
            $menuBtn.on('click', function() {
                const isExpanded = $menu.is(':visible');
                $menu.toggleClass('hidden');
                $menuBtn.attr('aria-expanded', !isExpanded);
            });
            
            // User dropdown toggle
            const $dropdownBtn = $('#user-dropdown-btn');
            const $dropdownMenu = $('#user-dropdown-menu');
            
            $dropdownBtn.on('click', function(e) {
                e.stopPropagation();
                $dropdownMenu.toggleClass('hidden');
            });
            
            // Close dropdown on click outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#user-dropdown').length) {
                    $dropdownMenu.addClass('hidden');
                }
            });
            
            // Close menu and dropdown on escape
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (!$menu.hasClass('hidden')) {
                        $menu.addClass('hidden');
                        $menuBtn.attr('aria-expanded', 'false').focus();
                    }
                    if (!$dropdownMenu.hasClass('hidden')) {
                        $dropdownMenu.addClass('hidden');
                    }
                }
            });
        });
        
        // Flash messages
        @if(session('success'))
            showToast('{{ session('success') }}', 'success');
        @endif
        @if(session('error'))
            showToast('{{ session('error') }}', 'error');
        @endif
        
        function showToast(message, type = 'info') {
            const $container = $('#toast-container');
            const $toast = $(`
                <div class="toast ${type}" role="status">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid ${type === 'success' ? 'fa-check-circle text-green-400' : type === 'error' ? 'fa-times-circle text-red-400' : 'fa-info-circle text-blue-400'}"></i>
                        <span>${message}</span>
                    </div>
                </div>
            `);
            
            $container.append($toast);
            setTimeout(() => $toast.fadeOut(300, () => $toast.remove()), 5000);
        }
    </script>
    
    @stack('scripts')
</body>
</html>
