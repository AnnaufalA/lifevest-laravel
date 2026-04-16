<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Life Vest Tracker' }} - GMF AeroAsia</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">

    <!-- Prevent FOUC & allow correct initial theme evaluation for scripts (ChartJS) -->
    <script>
        (function() {
            try {
                const savedTheme = localStorage.getItem('theme');
                if (savedTheme) {
                    document.documentElement.setAttribute('data-theme', savedTheme);
                } else {
                    document.documentElement.setAttribute('data-theme', 'light');
                }
            } catch (e) {}
        })();
    </script>

    <!-- CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
</head>

<body>
    <!-- Sticky Navbar -->
    <nav class="navbar" id="navbar">
        <div class="navbar-container">
            <!-- Left: Logo & Back Button -->
            <div class="navbar-left">
                <!-- Desktop Sidebar Toggle Button -->
                <button type="button" id="sidebarToggleDesktopBtn" class="sidebar-toggle-desktop" style="background: transparent; border: none; color: var(--text-primary); cursor: pointer; display: flex; align-items: center; justify-content: center; margin-right: 0.5rem; padding: 0.25rem;" title="Toggle Sidebar">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>

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
                <span class="navbar-badge" style="margin-left:auto;">GMF AeroAsia</span>
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
                <a href="{{ route('dashboard', ['view' => 'top-pn-insights']) }}" class="sidebar-nav-item {{ request()->query('view') === 'top-pn-insights' ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                    <span>Top P/N Insights</span>
                </a>
                <div class="sidebar-nav-dropdown">
                    <button type="button" class="sidebar-nav-item dropdown-toggle {{ str_starts_with(request()->query('view', ''), 'replacement-') ? 'active' : '' }}" style="width: 100%; border: none; background: transparent; cursor: pointer;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                        <span style="flex-grow: 1; text-align: left;">Replacement Plan</span>
                        <svg class="dropdown-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="transition: transform 0.2s; transform: {{ str_starts_with(request()->query('view', ''), 'replacement-') ? 'rotate(180deg)' : 'rotate(0deg)' }};"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </button>
                    <div class="dropdown-submenu" style="display: {{ str_starts_with(request()->query('view', ''), 'replacement-') ? 'block' : 'none' }}; padding-left: 28px; margin-top: 4px;">
                        <a href="{{ route('dashboard', ['view' => 'replacement-weekly']) }}" class="sidebar-nav-item submenu-item {{ request()->query('view') === 'replacement-weekly' ? 'active' : '' }}" style="padding: 0.5rem 0.75rem; min-height: unset; font-size: 0.9em; margin-bottom: 2px;">Weekly</a>
                        <a href="{{ route('dashboard', ['view' => 'replacement-monthly']) }}" class="sidebar-nav-item submenu-item {{ request()->query('view') === 'replacement-monthly' ? 'active' : '' }}" style="padding: 0.5rem 0.75rem; min-height: unset; font-size: 0.9em; margin-bottom: 2px;">Monthly</a>
                        <a href="{{ route('dashboard', ['view' => 'replacement-yearly']) }}" class="sidebar-nav-item submenu-item {{ request()->query('view') === 'replacement-yearly' ? 'active' : '' }}" style="padding: 0.5rem 0.75rem; min-height: unset; font-size: 0.9em;">Yearly</a>
                    </div>
                </div>
                <a href="{{ route('fleet.index') }}" class="sidebar-nav-item {{ request()->routeIs('fleet.*') ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 17v-8c0-1.105-.895-2-2-2H7c-1.105 0-2 .895-2 2v8M9 8V6c0-1.105.895-2 2-2h2c1.105 0 2 .895 2 2v2m-11 0h14m-7 6v4m-4-4v4"/></svg>
                    <span>Fleet Management</span>
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

        <!-- Sidebar Toggle Button (mobile only, visible via CSS) -->
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
            const sidebarToggleDesktopBtn = document.getElementById('sidebarToggleDesktopBtn');
            const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');

            // Theme Toggle (only in sidebar)
            const savedTheme = localStorage.getItem('theme') || 'light';
            if (toggleSidebar) toggleSidebar.checked = (savedTheme === 'light');

            const handleThemeChange = () => {
                const currentTheme = toggleSidebar.checked ? 'light' : 'dark';
                html.setAttribute('data-theme', currentTheme);
                localStorage.setItem('theme', currentTheme);
            };

            if (toggleSidebar) toggleSidebar.addEventListener('change', handleThemeChange);

            // Desktop Sidebar Toggle
            const isDesktopSidebarCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
            if (isDesktopSidebarCollapsed) {
                document.body.classList.add('sidebar-collapsed');
            }

            sidebarToggleDesktopBtn?.addEventListener('click', () => {
                document.body.classList.toggle('sidebar-collapsed');
                const isCollapsed = document.body.classList.contains('sidebar-collapsed');
                localStorage.setItem('sidebar-collapsed', isCollapsed);
            });

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
            document.querySelectorAll('.sidebar-nav-item:not(.dropdown-toggle)').forEach(item => {
                item.addEventListener('click', () => {
                    if (window.innerWidth < 768) {
                        sidebar.classList.remove('open');
                        sidebarOverlay.classList.remove('show');
                        document.body.style.overflow = '';
                    }
                });
            });

            // Sidebar Dropdown Toggle
            document.querySelectorAll('.dropdown-toggle').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    const submenu = this.nextElementSibling;
                    const arrow = this.querySelector('.dropdown-arrow');
                    
                    if (submenu.style.display === 'block') {
                        submenu.style.display = 'none';
                        if (arrow) arrow.style.transform = 'rotate(0deg)';
                    } else {
                        submenu.style.display = 'block';
                        if (arrow) arrow.style.transform = 'rotate(180deg)';
                    }
                });
            });
        });
    </script>
</body>

</html>