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
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700&family=Great+Vibes&display=swap" rel="stylesheet">
    
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
                        'script': ['Great Vibes', 'cursive'],
                    }
                }
            }
        }
    </script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <style>
        :root {
            --color-primary: #b76e79;
            --color-secondary: #f7e7ce;
            --color-surface: rgba(15, 23, 42, 0.95);
            --color-glass: rgba(255, 255, 255, 0.05);
            --color-border: rgba(255, 255, 255, 0.1);
        }
        
        * { box-sizing: border-box; }
        
        body {
            font-family: 'Be Vietnam Pro', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%);
            min-height: 100vh;
            color: #fff;
            -webkit-font-smoothing: antialiased;
        }
        
        /* Glassmorphism Card */
        .glass-card {
            background: var(--color-glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--color-border);
            border-radius: 1rem;
        }
        
        /* Glassmorphism Button */
        .glass-btn {
            background: linear-gradient(135deg, var(--color-primary), #d946ef);
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 0 20px rgba(183, 110, 121, 0.3);
        }
        .glass-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 30px rgba(183, 110, 121, 0.5);
        }
        
        /* Glassmorphism Input */
        .glass-input {
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid var(--color-border);
            border-radius: 0.75rem;
            padding: 0.875rem 1rem;
            color: #fff;
            width: 100%;
            transition: all 0.3s ease;
        }
        .glass-input:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 4px rgba(183, 110, 121, 0.1);
        }
        .glass-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        
        /* Gradient Text */
        .text-gradient {
            background: linear-gradient(135deg, #f7e7ce, #b76e79);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Navigation */
        .nav-glass {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--color-border);
        }
        
        /* Animation */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="nav-glass fixed top-0 left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <span class="text-2xl font-script text-gradient">Mời Bạn</span>
                </a>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('templates') }}" class="text-white/70 hover:text-white transition">Mẫu thiệp</a>
                    <a href="{{ route('pricing') }}" class="text-white/70 hover:text-white transition">Bảng giá</a>
                    
                    @auth
                        <a href="{{ route('user.dashboard') }}" class="text-white/70 hover:text-white transition">Dashboard</a>
                        <a href="{{ route('user.invitations.create') }}" class="glass-btn text-sm">Tạo thiệp</a>
                    @else
                        <a href="{{ route('login') }}" class="text-white/70 hover:text-white transition">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="glass-btn text-sm">Đăng ký</a>
                    @endauth
                </div>
                
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden text-white p-2">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-white/10">
            <div class="px-4 py-4 space-y-3">
                <a href="{{ route('templates') }}" class="block text-white/70 hover:text-white">Mẫu thiệp</a>
                <a href="{{ route('pricing') }}" class="block text-white/70 hover:text-white">Bảng giá</a>
                @auth
                    <a href="{{ route('user.dashboard') }}" class="block text-white/70 hover:text-white">Dashboard</a>
                    <a href="{{ route('user.invitations.create') }}" class="block glass-btn text-center">Tạo thiệp</a>
                @else
                    <a href="{{ route('login') }}" class="block text-white/70 hover:text-white">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="block glass-btn text-center">Đăng ký</a>
                @endauth
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main class="pt-16">
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="border-t border-white/10 mt-20">
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-2xl font-script text-gradient mb-4">Mời Bạn</h3>
                    <p class="text-white/60 text-sm">Tạo thiệp cưới online đẹp, chuyên nghiệp. Chia sẻ ngày vui của bạn với mọi người.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Liên kết</h4>
                    <ul class="space-y-2 text-sm text-white/60">
                        <li><a href="{{ route('templates') }}" class="hover:text-white">Mẫu thiệp</a></li>
                        <li><a href="{{ route('pricing') }}" class="hover:text-white">Bảng giá</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Hỗ trợ</h4>
                    <ul class="space-y-2 text-sm text-white/60">
                        <li><a href="#" class="hover:text-white">Hướng dẫn</a></li>
                        <li><a href="#" class="hover:text-white">Liên hệ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Kết nối</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-white/60 hover:text-white"><i class="fa-brands fa-facebook text-xl"></i></a>
                        <a href="#" class="text-white/60 hover:text-white"><i class="fa-brands fa-instagram text-xl"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-white/10 mt-8 pt-8 text-center text-sm text-white/40">
                © {{ date('Y') }} moiban.vn - All rights reserved.
            </div>
        </div>
    </footer>
    
    <!-- Toast Container -->
    <div id="toast-container" class="fixed bottom-4 right-4 z-50 space-y-2"></div>
    
    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        $('#mobile-menu-btn').on('click', function() {
            $('#mobile-menu').toggleClass('hidden');
        });
        
        // Flash messages
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
                info: 'border-l-4 border-blue-500',
            };
            
            const toast = $(`
                <div class="glass-card p-4 ${colors[type]} animate-slide-in">
                    <p class="text-sm">${message}</p>
                </div>
            `);
            
            $('#toast-container').append(toast);
            setTimeout(() => toast.fadeOut(300, () => toast.remove()), 5000);
        }
    </script>
    
    @stack('scripts')
</body>
</html>
