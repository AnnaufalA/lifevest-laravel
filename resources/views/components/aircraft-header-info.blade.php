@props(['aircraft', 'registration'])

<div class="header-right-content" style="display: flex; align-items: center; gap: 1.5rem;">
    <div class="aircraft-info">
        <label>Tipe:</label>
        <span class="info-value">
            {{ $aircraft->type }}
            <span class="status-badge {{ $aircraft['status'] ?? 'active' }}">
                {{ strtoupper($aircraft['status'] ?? 'active') }}
            </span>
        </span>
    </div>

    <div class="aircraft-info">
        <label>Registrasi:</label>
        <span class="info-value">{{ $registration }}</span>
    </div>

    @if(Route::has('reports.pdf'))
        <a href="{{ route('reports.pdf', $registration) }}" target="_blank" class="btn"
            style="background: #e53e3e; color: white; text-decoration: none; padding: 0.5rem 1rem; border-radius: 6px; font-weight: bold; display: flex; align-items: center; gap: 0.5rem;">
            <span>📄</span> Export PDF
        </a>
    @endif
</div>