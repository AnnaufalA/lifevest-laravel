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
</div>