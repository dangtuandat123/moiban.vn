<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Editor - Mời Bạn')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Be+Vietnam+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <style>
        :root {
            --color-primary: #b76e79;
            --color-primary-light: #d4a5ad;
            --color-surface: #0f172a;
            --color-surface-dark: #020617;
            --color-border: rgba(255, 255, 255, 0.1);
            --color-text: #ffffff;
            --color-text-muted: rgba(255, 255, 255, 0.6);
        }
        
        *, *::before, *::after { box-sizing: border-box; }
        
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }
        
        body {
            font-family: 'Be Vietnam Pro', 'Inter', system-ui, sans-serif;
            background: var(--color-surface-dark);
            color: var(--color-text);
            -webkit-font-smoothing: antialiased;
        }
        
        /* Editor App Container */
        .editor-app {
            display: flex;
            flex-direction: column;
            height: 100vh;
            height: 100dvh;
        }
        
        /* ========== TOOLBAR ========== */
        .editor-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            background: var(--color-surface);
            border-bottom: 1px solid var(--color-border);
            flex-shrink: 0;
            z-index: 100;
        }
        
        .toolbar-left, .toolbar-right {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .toolbar-title {
            font-weight: 600;
            font-size: 0.9rem;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .toolbar-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            text-decoration: none;
        }
        
        .toolbar-btn-icon {
            padding: 0.5rem;
            width: 2.25rem;
            height: 2.25rem;
        }
        
        .toolbar-btn-ghost {
            background: transparent;
            color: var(--color-text-muted);
        }
        .toolbar-btn-ghost:hover {
            background: rgba(255,255,255,0.1);
            color: var(--color-text);
        }
        
        .toolbar-btn-primary {
            background: linear-gradient(135deg, var(--color-primary), #ec4899);
            color: white;
        }
        .toolbar-btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }
        
        .toolbar-btn-secondary {
            background: rgba(255,255,255,0.1);
            color: var(--color-text);
            border: 1px solid var(--color-border);
        }
        .toolbar-btn-secondary:hover {
            background: rgba(255,255,255,0.15);
        }
        
        /* Auto-save indicator */
        .autosave-indicator {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            font-size: 0.75rem;
            color: var(--color-text-muted);
        }
        .autosave-indicator.saving { color: #fbbf24; }
        .autosave-indicator.saved { color: #22c55e; }
        
        /* ========== MAIN LAYOUT ========== */
        .editor-main {
            display: flex;
            flex: 1;
            overflow: hidden;
        }
        
        /* ========== SIDEBAR ========== */
        .editor-sidebar {
            width: 360px;
            background: var(--color-surface);
            border-right: 1px solid var(--color-border);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        
        .sidebar-tabs {
            display: flex;
            border-bottom: 1px solid var(--color-border);
            padding: 0 1rem;
            flex-shrink: 0;
        }
        
        .sidebar-tab {
            flex: 1;
            padding: 0.875rem 0.5rem;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--color-text-muted);
            background: transparent;
            border: none;
            border-bottom: 2px solid transparent;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.375rem;
        }
        .sidebar-tab:hover { color: var(--color-text); }
        .sidebar-tab.active {
            color: var(--color-text);
            border-bottom-color: var(--color-primary);
        }
        
        .sidebar-content {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
        }
        
        /* ========== FORM STYLES ========== */
        .form-section {
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--color-border);
        }
        .form-section:last-child {
            border-bottom: none;
        }
        
        .section-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--color-primary);
            margin-bottom: 1rem;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--color-text-muted);
            margin-bottom: 0.5rem;
        }
        .form-label .optional {
            font-weight: 400;
            color: rgba(255,255,255,0.4);
        }
        
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            background: rgba(0,0,0,0.3);
            border: 1px solid var(--color-border);
            border-radius: 0.5rem;
            color: var(--color-text);
            transition: all 0.2s;
        }
        .form-input:hover { border-color: rgba(255,255,255,0.2); }
        .form-input:focus { 
            border-color: var(--color-primary); 
            outline: none;
            box-shadow: 0 0 0 3px rgba(183,110,121,0.2);
        }
        .form-input::placeholder { color: rgba(255,255,255,0.3); }
        
        .form-hint {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.4);
            margin-top: 0.375rem;
        }
        
        /* Grid helper */
        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }
        
        /* Color picker */
        .color-picker-row {
            display: flex;
            gap: 0.75rem;
            align-items: center;
        }
        .color-picker-input {
            width: 3rem;
            height: 3rem;
            padding: 0.25rem;
            background: transparent;
            border: 2px solid var(--color-border);
            border-radius: 0.5rem;
            cursor: pointer;
        }
        .color-presets {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }
        .color-preset {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            border: 2px solid transparent;
            cursor: pointer;
            transition: all 0.2s;
        }
        .color-preset:hover, .color-preset.active {
            border-color: white;
            transform: scale(1.1);
        }
        
        /* Widget toggle */
        .widget-list {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .widget-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.875rem 1rem;
            background: rgba(0,0,0,0.2);
            border-radius: 0.75rem;
            transition: background 0.2s;
        }
        .widget-item:hover { background: rgba(0,0,0,0.3); }
        
        .widget-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .widget-icon {
            width: 2.25rem;
            height: 2.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(183,110,121,0.2);
            border-radius: 0.5rem;
            color: var(--color-primary);
        }
        .widget-name { font-weight: 500; font-size: 0.9rem; }
        
        /* Toggle switch */
        .toggle-switch {
            position: relative;
            width: 2.75rem;
            height: 1.5rem;
        }
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .toggle-slider {
            position: absolute;
            inset: 0;
            background: rgba(255,255,255,0.2);
            border-radius: 9999px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .toggle-slider::before {
            content: '';
            position: absolute;
            height: 1.125rem;
            width: 1.125rem;
            left: 0.1875rem;
            bottom: 0.1875rem;
            background: white;
            border-radius: 50%;
            transition: transform 0.3s;
        }
        .toggle-switch input:checked + .toggle-slider {
            background: var(--color-primary);
        }
        .toggle-switch input:checked + .toggle-slider::before {
            transform: translateX(1.25rem);
        }
        
        /* Upload zone */
        .upload-zone {
            border: 2px dashed var(--color-border);
            border-radius: 0.75rem;
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        .upload-zone:hover {
            border-color: var(--color-primary);
            background: rgba(183,110,121,0.05);
        }
        .upload-zone i {
            font-size: 2rem;
            color: var(--color-primary);
            margin-bottom: 0.5rem;
        }
        .upload-zone p {
            font-size: 0.875rem;
            color: var(--color-text-muted);
            margin: 0.25rem 0;
        }
        
        .album-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.5rem;
            margin-top: 1rem;
        }
        .album-item {
            position: relative;
            aspect-ratio: 1;
            border-radius: 0.5rem;
            overflow: hidden;
        }
        .album-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .album-item-remove {
            position: absolute;
            top: 0.25rem;
            right: 0.25rem;
            width: 1.5rem;
            height: 1.5rem;
            background: rgba(0,0,0,0.7);
            border: none;
            border-radius: 50%;
            color: white;
            font-size: 0.75rem;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.2s;
        }
        .album-item:hover .album-item-remove { opacity: 1; }
        
        /* Music presets */
        .music-presets {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.75rem;
        }
        .music-preset {
            padding: 0.5rem 0.75rem;
            font-size: 0.8rem;
            background: rgba(0,0,0,0.3);
            border: 1px solid var(--color-border);
            border-radius: 9999px;
            color: var(--color-text-muted);
            cursor: pointer;
            transition: all 0.2s;
        }
        .music-preset:hover, .music-preset.active {
            background: var(--color-primary);
            border-color: var(--color-primary);
            color: white;
        }
        
        /* ========== PREVIEW PANEL ========== */
        .editor-preview {
            flex: 1;
            background: var(--color-surface-dark);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        
        .preview-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--color-border);
            flex-shrink: 0;
        }
        
        .device-switcher {
            display: flex;
            background: rgba(255,255,255,0.1);
            border-radius: 0.5rem;
            padding: 0.25rem;
        }
        .device-btn {
            padding: 0.375rem 0.625rem;
            border: none;
            background: transparent;
            border-radius: 0.375rem;
            color: var(--color-text-muted);
            cursor: pointer;
            transition: all 0.2s;
        }
        .device-btn:hover { color: var(--color-text); }
        .device-btn.active {
            background: rgba(255,255,255,0.2);
            color: var(--color-text);
        }
        
        .preview-container {
            flex: 1;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 1rem;
            overflow: auto;
        }
        
        .preview-frame {
            background: white;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0,0,0,0.5);
            transition: all 0.3s ease;
        }
        
        .preview-frame-mobile { width: 375px; height: 667px; }
        .preview-frame-tablet { width: 768px; height: 600px; }
        .preview-frame-desktop { width: 100%; max-width: 1200px; height: calc(100vh - 200px); }
        
        .preview-frame iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
        
        /* ========== MOBILE LAYOUT ========== */
        @media (max-width: 1023px) {
            .editor-sidebar { display: none; }
            .editor-sidebar.active { display: flex; }
            
            .editor-preview { display: none; }
            .editor-preview.active { display: flex; }
            
            .editor-sidebar, .editor-preview {
                position: absolute;
                inset: 0;
                top: 56px;
                width: 100%;
            }
            
            .editor-main {
                position: relative;
            }
            
            .preview-frame-mobile {
                width: 100%;
                max-width: 100%;
                height: calc(100vh - 120px);
                border-radius: 0;
            }
            
            .preview-container {
                padding: 0;
            }
            
            .preview-frame {
                border-radius: 0;
            }
        }
        
        /* Mobile toggle tabs */
        .mobile-toggle {
            display: none;
        }
        @media (max-width: 1023px) {
            .mobile-toggle {
                display: flex;
                border-top: 1px solid var(--color-border);
            }
            .mobile-toggle-btn {
                flex: 1;
                padding: 0.875rem;
                font-size: 0.8rem;
                font-weight: 500;
                background: var(--color-surface);
                border: none;
                color: var(--color-text-muted);
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
            }
            .mobile-toggle-btn.active {
                color: var(--color-text);
                background: var(--color-surface-dark);
            }
        }
        
        /* Toast */
        .toast-container {
            position: fixed;
            bottom: 80px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
        }
        .toast {
            padding: 0.75rem 1.25rem;
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: 0.75rem;
            color: var(--color-text);
            font-size: 0.875rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            animation: toast-in 0.3s ease;
        }
        .toast.success { border-left: 3px solid #22c55e; }
        .toast.error { border-left: 3px solid #ef4444; }
        @keyframes toast-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    @yield('content')
    
    <!-- Toast Container -->
    <div class="toast-container" id="toast-container"></div>
    
    <script>
        // Toast function
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.textContent = message;
            container.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }
        
        // Flash messages
        @if(session('success'))
            showToast('{{ session('success') }}', 'success');
        @endif
        @if(session('error'))
            showToast('{{ session('error') }}', 'error');
        @endif
    </script>
    
    @stack('scripts')
</body>
</html>
