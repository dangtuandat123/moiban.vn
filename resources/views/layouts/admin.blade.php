<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - Mời Bạn')</title>
    
    <!-- Font Stack -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&family=Be+Vietnam+Pro:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <style>
        :root {
            /* ========== COLOR PALETTE ========== */
            --color-primary-500: #b76e79;
            --color-accent-pink: #ec4899;
            --color-surface-base: #020617;
            --color-surface-elevated: #0f172a;
            --color-surface-glass: rgba(255, 255, 255, 0.05);
            --color-surface-glass-hover: rgba(255, 255, 255, 0.08);
            --color-text-primary: #ffffff;
            --color-text-secondary: rgba(255, 255, 255, 0.7);
            --color-text-muted: rgba(255, 255, 255, 0.5);
            --color-border-subtle: rgba(255, 255, 255, 0.1);
            --color-border-default: rgba(255, 255, 255, 0.2);
            --color-success: #22c55e;
            --color-warning: #f59e0b;
            --color-error: #ef4444;
            
            /* ========== TYPOGRAPHY ========== */
            --font-vietnamese: 'Be Vietnam Pro', 'Inter', system-ui, sans-serif;
            --font-heading: 'Outfit', 'Inter', system-ui, sans-serif;
            
            /* ========== SPACING ========== */
            --space-1: 0.25rem;
            --space-2: 0.5rem;
            --space-3: 0.75rem;
            --space-4: 1rem;
            --space-5: 1.25rem;
            --space-6: 1.5rem;
            --space-8: 2rem;
            
            /* ========== RADIUS ========== */
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --radius-2xl: 1.5rem;
            
            /* ========== TRANSITIONS ========== */
            --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-base: 300ms cubic-bezier(0.4, 0, 0.2, 1);
            
            /* ========== SHADOWS ========== */
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.4);
            --shadow-glow-primary: 0 0 30px rgba(183, 110, 121, 0.3);
        }

        *, *::before, *::after { box-sizing: border-box; }
        
        body { 
            font-family: var(--font-vietnamese);
            background: var(--color-surface-base);
            color: var(--color-text-primary);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        *:focus-visible {
            outline: 2px solid var(--color-primary-500);
            outline-offset: 2px;
        }

        /* ========== GLASS CLASSES ========== */
        .glass-card {
            background: var(--color-surface-glass);
            backdrop-filter: blur(20px);
            border: 1px solid var(--color-border-subtle);
            border-radius: var(--radius-2xl);
            transition: all var(--transition-base);
        }
        .glass-card:hover {
            border-color: var(--color-border-default);
        }

        .glass-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-2);
            padding: var(--space-3) var(--space-5);
            font-weight: 600;
            border-radius: var(--radius-xl);
            cursor: pointer;
            transition: all var(--transition-base);
            text-decoration: none;
            background: linear-gradient(135deg, var(--color-primary-500), var(--color-accent-pink));
            color: white;
            border: none;
            font-size: 0.875rem;
        }
        .glass-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg), var(--shadow-glow-primary);
        }

        .glass-btn-secondary {
            background: var(--color-surface-glass);
            border: 1px solid var(--color-border-default);
        }
        .glass-btn-secondary:hover {
            background: var(--color-surface-glass-hover);
        }

        .glass-btn-danger {
            background: linear-gradient(135deg, #dc2626, #ef4444);
        }

        .glass-input {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid var(--color-border-subtle);
            border-radius: var(--radius-lg);
            padding: var(--space-3) var(--space-4);
            color: var(--color-text-primary);
            width: 100%;
            font-size: 0.875rem;
            transition: all var(--transition-base);
        }
        .glass-input:hover, .glass-input:focus {
            border-color: var(--color-primary-500);
            outline: none;
        }

        /* Text gradient */
        .text-gradient {
            background: linear-gradient(135deg, #f7e7ce, #b76e79);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Status badges */
        .badge-active { background: rgba(34, 197, 94, 0.2); color: #4ade80; }
        .badge-trial { background: rgba(251, 191, 36, 0.2); color: #fbbf24; }
        .badge-locked { background: rgba(239, 68, 68, 0.2); color: #f87171; }
        .badge-expired { background: rgba(107, 114, 128, 0.2); color: #9ca3af; }

        /* Sidebar */
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-3) var(--space-4);
            border-radius: var(--radius-lg);
            color: var(--color-text-secondary);
            transition: all var(--transition-fast);
        }
        .sidebar-link:hover, .sidebar-link.active {
            background: var(--color-surface-glass);
            color: var(--color-text-primary);
        }
        .sidebar-link.active {
            border-left: 3px solid var(--color-primary-500);
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 border-r border-white/10 p-4 flex flex-col">
            <!-- Logo -->
            <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold text-gradient mb-8 block">
                Mời Bạn <span class="text-xs text-white/40 font-normal">Admin</span>
            </a>
            
            <!-- Navigation -->
            <nav class="flex-1 space-y-1" role="navigation" aria-label="Admin navigation">
                <a href="{{ route('admin.dashboard') }}" 
                   class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie w-5"></i>
                    Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}" 
                   class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users w-5"></i>
                    Người dùng
                </a>
                <a href="{{ route('admin.invitations.index') }}" 
                   class="sidebar-link {{ request()->routeIs('admin.invitations.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-envelope w-5"></i>
                    Thiệp
                </a>
                <a href="{{ route('admin.templates.index') }}" 
                   class="sidebar-link {{ request()->routeIs('admin.templates.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-palette w-5"></i>
                    Templates
                </a>
                <a href="{{ route('admin.packages.index') }}" 
                   class="sidebar-link {{ request()->routeIs('admin.packages.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-tags w-5"></i>
                    Gói dịch vụ
                </a>
                <a href="{{ route('admin.settings') }}" 
                   class="sidebar-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <i class="fa-solid fa-cog w-5"></i>
                    Cài đặt
                </a>
            </nav>
            
            <!-- User -->
            <div class="border-t border-white/10 pt-4 mt-4">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-primary-500/20 flex items-center justify-center">
                        <i class="fa-solid fa-user text-primary-400"></i>
                    </div>
                    <div>
                        <p class="font-medium text-sm">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-white/50">Admin</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-link w-full text-left text-red-400 hover:text-red-300">
                        <i class="fa-solid fa-sign-out-alt w-5"></i>
                        Đăng xuất
                    </button>
                </form>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 p-6 overflow-auto" role="main">
            @yield('content')
        </main>
    </div>
    
    <!-- Toast Container -->
    <div id="toast-container" class="fixed bottom-4 right-4 z-50 space-y-2" role="alert" aria-live="polite"></div>
    
    <script>
        @if(session('success'))
            showToast('{{ session('success') }}', 'success');
        @endif
        @if(session('error'))
            showToast('{{ session('error') }}', 'error');
        @endif
        
        function showToast(message, type = 'info') {
            const colors = {
                success: 'border-l-4 border-green-500',
                error: 'border-l-4 border-red-500',
                info: 'border-l-4 border-blue-500'
            };
            const $toast = $(`
                <div class="p-4 rounded-xl bg-slate-900/95 backdrop-blur border border-white/10 ${colors[type]} shadow-lg animate-slide-in">
                    ${message}
                </div>
            `);
            $('#toast-container').append($toast);
            setTimeout(() => $toast.fadeOut(300, () => $toast.remove()), 5000);
        }
    </script>
    
    @stack('scripts')
</body>
</html>
