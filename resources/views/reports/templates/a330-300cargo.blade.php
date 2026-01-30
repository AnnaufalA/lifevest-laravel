<!-- Cockpit Section -->
<section class="cockpit-section">
    <h2>Cockpit</h2>
    <div class="cockpit-grid">
        @foreach(['captain', 'observer1', 'observer2', 'copilot'] as $seatId)
            @php
                $seat = $seats[$seatId] ?? null;
                $status = $seat?->status ?? 'no-data';
                $expiryDate = $seat?->expiry_date?->format('j M Y') ?? '-';
            @endphp
            <div class="seat-card cockpit-seat status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-label">{{ ucfirst(str_replace(['1', '2'], [' 1', ' 2'], $seatId)) }}</div>
                <div class="seat-date">{{ $expiryDate }}</div>
            </div>
        @endforeach
    </div>
</section>

<!-- Attendant D11 & D21 -->
<section class="cabin-section">
    <h2>Attendant D11 & D21</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-2-2">
            <span class="col-label col-header">LL</span>
            <span class="col-label col-header">LR</span>
            <span class="row-label"></span>
            <span class="seat-placeholder"></span>
            <span class="col-label col-header">R</span>
        </div>
        <!-- Row 1 -->
        <div class="seat-row grid-row-2-2">
            @php $seatId = 'att/d11-LL1';
                $seat = $seats[$seatId] ?? null;
            $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-id">D11-LL1</div>
                <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
            </div>
            <div class="seat-placeholder"></div>
            <div class="row-number">D11/D21</div>
            <div class="seat-placeholder"></div>
            @php $seatId = 'att/d21-R';
                $seat = $seats[$seatId] ?? null;
            $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-id">D21-R</div>
                <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
            </div>
        </div>
        <!-- Row 2 -->
        <div class="seat-row grid-row-2-2">
            @php $seatId = 'att/d11-LL2';
                $seat = $seats[$seatId] ?? null;
            $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-id">D11-LL2</div>
                <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
            </div>
            @php $seatId = 'att/d11-LR';
                $seat = $seats[$seatId] ?? null;
            $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-id">D11-LR</div>
                <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
            </div>
            <div class="row-number"></div>
            <div class="seat-placeholder"></div>
            <div class="seat-placeholder"></div>
        </div>
    </div>
</section>

<!-- Cargo Forward (Visual) -->
<section class="cabin-section cargo-section"
    style="border: 2px dashed #ccc; padding: 1rem; text-align: center; margin: 1rem 0; background: #f9fafb;">
    <h2 style="margin:0; font-size: 1rem; color: #666;">Cargo Area (Forward)</h2>
    <p style="margin:0.5rem 0 0; font-size: 0.8rem; color: #888;">Forward Cargo Compartment</p>
</section>

<!-- Attendant D12 & D22 -->
<section class="cabin-section">
    <h2>Attendant D12 & D22</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-2-2">
            <span class="col-label col-header">L</span>
            <span class="seat-placeholder"></span>
            <span class="row-label"></span>
            <span class="col-label col-header">RL</span>
            <span class="col-label col-header">RR</span>
        </div>
        <div class="seat-row grid-row-2-2">
            @php $seatId = 'att/d12-L';
                $seat = $seats[$seatId] ?? null;
            $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-id">D12-L</div>
                <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
            </div>
            <div class="seat-placeholder"></div>
            <div class="row-number">D12/D22</div>
            @php $seatId = 'att/d22-RL';
                $seat = $seats[$seatId] ?? null;
            $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-id">D22-RL</div>
                <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
            </div>
            @php $seatId = 'att/d22-RR';
                $seat = $seats[$seatId] ?? null;
            $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-id">D22-RR</div>
                <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
            </div>
        </div>
    </div>
</section>

<!-- Cargo Main (Visual) -->
<section class="cabin-section cargo-section"
    style="border: 2px dashed #ccc; padding: 1rem; text-align: center; margin: 1rem 0; background: #f9fafb;">
    <h2 style="margin:0; font-size: 1rem; color: #666;">Cargo Area (Main Deck)</h2>
    <p style="margin:0.5rem 0 0; font-size: 0.8rem; color: #888;">Main Deck Cargo</p>
</section>

<!-- Attendant D13 & D23 -->
<section class="cabin-section">
    <h2>Attendant D13 & D23</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-2-2">
            <span class="col-label col-header">L</span>
            <span class="seat-placeholder"></span>
            <span class="row-label"></span>
            <span class="seat-placeholder"></span>
            <span class="col-label col-header">R</span>
        </div>
        <div class="seat-row grid-row-2-2">
            @php $seatId = 'att/d13-L';
                $seat = $seats[$seatId] ?? null;
            $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-id">D13-L</div>
                <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
            </div>
            <div class="seat-placeholder"></div>
            <div class="row-number">D13/D23</div>
            <div class="seat-placeholder"></div>
            @php $seatId = 'att/d23-R';
                $seat = $seats[$seatId] ?? null;
            $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-id">D23-R</div>
                <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
            </div>
        </div>
    </div>
</section>

<!-- Cargo Lower (Visual) -->
<section class="cabin-section cargo-section"
    style="border: 2px dashed #ccc; padding: 1rem; text-align: center; margin: 1rem 0; background: #f9fafb;">
    <h2 style="margin:0; font-size: 1rem; color: #666;">Cargo Area (Lower Deck)</h2>
    <p style="margin:0.5rem 0 0; font-size: 0.8rem; color: #888;">Lower Deck Cargo</p>
</section>

<!-- Attendant D14 & D24 + Aft Galley -->
<section class="cabin-section">
    <h2>Attendant D14 & D24 + Aft Galley</h2>
    <div class="seat-grid" style="display: flex; justify-content: space-between; max-width: 600px; margin: 0 auto;">
        <!-- D14 (2 seats) -->
        <div style="display: flex; gap: 0.5rem;">
            @php $seatId = 'att/d14-LL';
                $seat = $seats[$seatId] ?? null;
            $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-id">D14-LL</div>
                <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
            </div>
            @php $seatId = 'att/d14-LR';
                $seat = $seats[$seatId] ?? null;
            $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-id">D14-LR</div>
                <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
            </div>
        </div>
        <!-- Galley (2 seats) -->
        <div style="display: flex; gap: 0.5rem;">
            @php $seatId = 'att/aft-LC';
                $seat = $seats[$seatId] ?? null;
            $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-id">Aft-LC</div>
                <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
            </div>
            @php $seatId = 'att/aft-RC';
                $seat = $seats[$seatId] ?? null;
            $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-id">Aft-RC</div>
                <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
            </div>
        </div>
        <!-- D24 (2 seats) -->
        <div style="display: flex; gap: 0.5rem;">
            @php $seatId = 'att/d24-RL';
                $seat = $seats[$seatId] ?? null;
            $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-id">D24-RL</div>
                <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
            </div>
            @php $seatId = 'att/d24-RR';
                $seat = $seats[$seatId] ?? null;
            $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-id">D24-RR</div>
                <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
            </div>
        </div>
    </div>
</section>

<!-- Spare Section -->
<section class="cabin-section">
    <h2>Spare</h2>
    <div class="spare-grid">
        <div class="spare-column">
            <h3>PAX</h3>
            <div class="spare-items">
                @forelse(collect($seats)->filter(fn($s, $id) => str_starts_with($id, 'pax-')) as $seatId => $seat)
                    <div class="seat-card spare-card status-{{ $seat?->status ?? 'no-data' }}">
                        <div class="seat-id">{{ str_replace('pax-', '', $seatId) }}</div>
                        <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                    </div>
                @empty <p>No PAX</p> @endforelse
            </div>
        </div>
        <div class="spare-column">
            <h3>INF</h3>
            <div class="spare-items">
                @forelse(collect($seats)->filter(fn($s, $id) => str_starts_with($id, 'inf-')) as $seatId => $seat)
                    <div class="seat-card spare-card status-{{ $seat?->status ?? 'no-data' }}">
                        <div class="seat-id">{{ str_replace('inf-', '', $seatId) }}</div>
                        <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                    </div>
                @empty <p>No INF</p> @endforelse
            </div>
        </div>
    </div>
</section>