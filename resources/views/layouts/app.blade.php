<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Life Vest Tracker' }} - GMF AeroAsia</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="app-container">
        <!-- Header -->
        <header class="header">
            <div class="header-left">
                <a href="{{ route('dashboard') }}" class="logo">
                    <h1>🛡️ Life Vest Tracker</h1>
                </a>
                <span class="badge">GMF AeroAsia</span>
                @if(isset($registration))
                    <a href="{{ route('dashboard') }}" class="btn btn-sm">📊 Dashboard</a>
                @endif
            </div>
            <div class="header-right">
                @if(isset($lastUpdate))
                    <div class="last-update">
                        <span class="last-update-label">🕐 Last Update:</span>
                        <span class="last-update-value">{{ $lastUpdate->format('d M Y, H:i') }}</span>
                    </div>
                @endif
                @yield('header-right')
            </div>
        </header>

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

    @stack('scripts')
</body>

</html>