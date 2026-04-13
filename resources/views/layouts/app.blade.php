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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

            <!-- Right: Update Info -->
            <div class="navbar-right">
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

    <div class="app-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <button class="sidebar-close-btn" id="sidebarCloseBtn" title="Close sidebar" style="display: none; position: absolute; top: 0.75rem; right: 0.75rem; z-index: 10;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
            </button>

            <nav class="sidebar-nav">
                <a href="{{ route('dashboard', ['view' => 'fleet-overview']) }}" class="sidebar-nav-item {{ request()->query('view') === 'fleet-overview' || !request()->query('view') ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    <span>Fleet Overview</span>
                </a>
                <a href="{{ route('dashboard', ['view' => 'life-vest-summary']) }}" class="sidebar-nav-item {{ request()->query('view') === 'life-vest-summary' ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    <span>Life Vest Summary</span>
                </a>
                <a href="{{ route('dashboard', ['view' => 'monthly-plan']) }}" class="sidebar-nav-item {{ request()->query('view') === 'monthly-plan' ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                    <span>Monthly Plan</span>
                </a>
                <a href="{{ route('fleet.index') }}" class="sidebar-nav-item {{ request()->routeIs('fleet.*') ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 17v-8c0-1.105-.895-2-2-2H7c-1.105 0-2 .895-2 2v8M9 8V6c0-1.105.895-2 2-2h2c1.105 0 2 .895 2 2v2m-11 0h14m-7 6v4m-4-4v4"/></svg>
                    <span>Fleet Management</span>
                </a>
                <a href="{{ route('reports.excel') }}" class="sidebar-nav-item" title="Download Replacement Plan Excel">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
                    <span>Export Report</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="sidebar-divider"></div>
                <label class="sidebar-theme-switch" title="Toggle Theme">
                    <span class="theme-label">Theme</span>
                    <input type="checkbox" id="theme-toggle-sidebar">
                    <span class="theme-slider"></span>
                </label>
            </div>
        </aside>

        <!-- Sidebar Overlay (for mobile) -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Sidebar Toggle Button (mobile) -->
        <button class="sidebar-toggle-btn" id="sidebarToggleBtn" title="Open sidebar">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>

        <div class="app-container">
            <!-- Main Content -->
            <main class="main-content">
                @yield('content')
            </main>
        </div>
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
            const toggleSidebar = document.getElementById('theme-toggle-sidebar');
            const html = document.documentElement;
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
            const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');

            // Theme Toggle (only in sidebar)
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'light') {
                html.setAttribute('data-theme', 'light');
                if (toggleSidebar) toggleSidebar.checked = true;
            } else {
                if (toggleSidebar) toggleSidebar.checked = false;
            }

            const handleThemeChange = () => {
                if (toggleSidebar.checked) {
                    html.setAttribute('data-theme', 'light');
                    localStorage.setItem('theme', 'light');
                } else {
                    html.removeAttribute('data-theme');
                    localStorage.setItem('theme', 'dark');
                }
            };

            if (toggleSidebar) toggleSidebar.addEventListener('change', handleThemeChange);

            // Sidebar Mobile Toggle
            sidebarToggleBtn?.addEventListener('click', () => {
                sidebar.classList.add('open');
                sidebarOverlay.classList.add('show');
                document.body.style.overflow = 'hidden';
            });

            sidebarCloseBtn?.addEventListener('click', () => {
                sidebar.classList.remove('open');
                sidebarOverlay.classList.remove('show');
                document.body.style.overflow = '';
            });

            sidebarOverlay?.addEventListener('click', () => {
                sidebar.classList.remove('open');
                sidebarOverlay.classList.remove('show');
                document.body.style.overflow = '';
            });

            // Close sidebar on nav item click (mobile)
            document.querySelectorAll('.sidebar-nav-item').forEach(item => {
                item.addEventListener('click', () => {
                    if (window.innerWidth < 768) {
                        sidebar.classList.remove('open');
                        sidebarOverlay.classList.remove('show');
                        document.body.style.overflow = '';
                    }
                });
            });
        });
    </script>
</body>

</html>