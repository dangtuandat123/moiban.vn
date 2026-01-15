<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - Mời Bạn')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'rose-gold': '#b76e79',
                        'champagne': '#f7e7ce',
                    },
                    fontFamily: {
                        'vietnam': ['Be Vietnam Pro', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <style>
        body {
            font-family: 'Be Vietnam Pro', sans-serif;
            background: #0f172a;
            min-height: 100vh;
            color: #fff;
        }
        .sidebar { background: rgba(15, 23, 42, 0.95); }
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
        }
        .glass-btn {
            background: linear-gradient(135deg, #b76e79, #d946ef);
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .glass-btn:hover { opacity: 0.9; }
        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s;
        }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.1); }
    </style>
</head>
<body>
    <div class="flex">
        <!-- Sidebar -->
        <aside class="sidebar fixed left-0 top-0 h-screen w-64 border-r border-white/10 p-4 hidden lg:block">
            <div class="mb-8">
                <h1 class="text-2xl font-bold bg-gradient-to-r from-champagne to-rose-gold bg-clip-text text-transparent">
                    Admin Panel
                </h1>
            </div>
            
            <nav class="space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-gauge-high w-5 mr-3"></i> Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users w-5 mr-3"></i> Người dùng
                </a>
                <a href="{{ route('admin.invitations.index') }}" class="nav-link {{ request()->routeIs('admin.invitations.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-envelope-open-text w-5 mr-3"></i> Thiệp
                </a>
                <a href="{{ route('admin.templates.index') }}" class="nav-link {{ request()->routeIs('admin.templates.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-palette w-5 mr-3"></i> Templates
                </a>
                <a href="{{ route('admin.packages.index') }}" class="nav-link {{ request()->routeIs('admin.packages.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-box w-5 mr-3"></i> Gói dịch vụ
                </a>
                <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <i class="fa-solid fa-gear w-5 mr-3"></i> Cài đặt
                </a>
                
                <div class="border-t border-white/10 my-4"></div>
                
                <a href="{{ route('home') }}" class="nav-link text-white/60">
                    <i class="fa-solid fa-arrow-left w-5 mr-3"></i> Về trang chủ
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link w-full text-left text-red-400">
                        <i class="fa-solid fa-sign-out-alt w-5 mr-3"></i> Đăng xuất
                    </button>
                </form>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 lg:ml-64 min-h-screen">
            <!-- Top Bar -->
            <header class="border-b border-white/10 p-4 flex items-center justify-between">
                <button id="mobile-menu-btn" class="lg:hidden text-white p-2">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-white/60">{{ auth()->user()->name }}</span>
                </div>
            </header>
            
            <!-- Page Content -->
            <div class="p-6">
                @if(session('success'))
                <div class="glass-card p-4 mb-6 border-l-4 border-green-500">
                    <p>{{ session('success') }}</p>
                </div>
                @endif
                
                @if(session('error'))
                <div class="glass-card p-4 mb-6 border-l-4 border-red-500">
                    <p>{{ session('error') }}</p>
                </div>
                @endif
                
                @yield('content')
            </div>
        </main>
    </div>
    
    @stack('scripts')
</body>
</html>
