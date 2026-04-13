<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Life Vest Tracker' }} - GMF AeroAsia</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS & JS -->
    @vite(['resources/css/app.css', 'resources/css/style.css', 'resources/css/dashboard.css', 'resources/js/app.js'])
</head>

<body>
    <!-- Sticky Navbar -->
    <nav class="navbar" id="navbar">
        <div class="navbar-container">
            <!-- Left: Logo & Back Button -->
            <div class="navbar-left">
                @if(!request()->routeIs('dashboard'))
                    <a href="{{ route('dashboard') }}" class="btn-back" title="Back to Dashboard">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
                    </a>
                @endif
                
                <a href="{{ route('dashboard') }}" class="navbar-brand">
                    <div class="navbar-logo-wrap">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L3 7L12 12L21 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                            <path d="M3 12L12 17L21 12" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                            <path d="M3 17L12 22L21 17" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <span class="navbar-title">Life Vest Tracker</span>
                </a>
                <span class="navbar-badge">GMF AeroAsia</span>
            </div>

            <!-- Center: Header area -->
            <div class="navbar-center">
                @yield('header-right')
            </div>

            <!-- Right: Admin & Update -->
            <div class="navbar-right">
                <!-- Theme Toggle Switch -->
                <label class="theme-switch" title="Toggle Theme">
                    <input type="checkbox" id="theme-toggle-checkbox">
                    <span class="slider"></span>
                </label>

                @if(request()->routeIs('dashboard'))
                    <a href="{{ route('fleet.index') }}" class="btn btn-sm btn-secondary nav-manage-btn">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/><path d="M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
                        Manage Fleet
                    </a>
                @endif

                @if(isset($lastUpdate))
                    <div class="navbar-update">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <span class="update-value">{{ $lastUpdate->format('d M Y, H:i') }}</span>
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <!-- Spacer for fixed navbar -->
    <div class="navbar-spacer"></div>

    <div class="app-container">
        <!-- Main Content -->
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <!-- Toast -->
    <div class="toast" id="toast">
        <span class="toast-icon">✓</span>
        <span class="toast-message">Success!</span>
    </div>

    <!-- SheetJS for Excel Export -->
    <script src="https://cdn.sheetjs.com/xlsx-0.20.3/package/dist/xlsx.full.min.js"></script>

    @stack('scripts')
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleCheckbox = document.getElementById('theme-toggle-checkbox');
            const html = document.documentElement;

            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'light') {
                html.setAttribute('data-theme', 'light');
                toggleCheckbox.checked = true;
            } else {
                toggleCheckbox.checked = false;
            }

            toggleCheckbox.addEventListener('change', () => {
                if (toggleCheckbox.checked) {
                    html.setAttribute('data-theme', 'light');
                    localStorage.setItem('theme', 'light');
                } else {
                    html.removeAttribute('data-theme');
                    localStorage.setItem('theme', 'dark');
                }
            });
        });
    </script>
</body>

</html>