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

<!-- Attendant D11 -->
<section class="cabin-section">
    <h2>Attendant D11</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-2-2">
            <span class="col-label col-header">LL</span>
            <span class="col-label col-header">LR</span>
            <span class="row-label"></span>
            <span class="seat-placeholder"></span>
            <span class="seat-placeholder"></span>
        </div>
        <div class="seat-row grid-row-2-2">
            @foreach(['LL', 'LR'] as $col)
                @php $seatId = 'att/d11-' . $col;
                    $seat = $seats[$seatId] ?? null;
                $status = $seat?->status ?? 'no-data'; @endphp
                <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                    <div class="seat-id">D11-{{ $col }}</div>
                    <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                </div>
            @endforeach
            <div class="row-number">D11</div>
            <div class="seat-placeholder"></div>
            <div class="seat-placeholder"></div>
        </div>
    </div>
</section>

<!-- Business Class - Rows 6-7 -->
<section class="cabin-section">
    <h2>Business Class - Rows 6-7</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-2-2">
            <span class="col-label col-header">A</span>
            <span class="col-label col-header">C</span>
            <span class="row-label"></span>
            <span class="col-label col-header">H</span>
            <span class="col-label col-header">K</span>
        </div>
        @foreach([6, 7] as $row)
            <div class="seat-row grid-row-2-2" data-row="{{ $row }}">
                @foreach(['A', 'C'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => ['A', 'C', 'H', 'K'], 'seats' => $seats])
                @endforeach
                <div class="row-number">{{ $row }}</div>
                @foreach(['H', 'K'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => ['A', 'C', 'H', 'K'], 'seats' => $seats])
                @endforeach
            </div>
        @endforeach
    </div>
</section>

<!-- Economy Class - Rows 21-48 -->
<section class="cabin-section">
    <h2>Economy Class - Rows 21-48</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-3-3">
            <span class="col-label col-header">A</span>
            <span class="col-label col-header">B</span>
            <span class="col-label col-header">C</span>
            <span class="row-label"></span>
            <span class="col-label col-header">H</span>
            <span class="col-label col-header">J</span>
            <span class="col-label col-header">K</span>
        </div>
        @foreach(range(21, 48) as $row)
            @if($row == 24) @continue @endif
            <div class="seat-row grid-row-3-3" data-row="{{ $row }}">
                @foreach(['A', 'B', 'C'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => ['A', 'B', 'C', 'H', 'J', 'K'], 'seats' => $seats])
                @endforeach
                <div class="row-number">{{ $row }}</div>
                @foreach(['H', 'J', 'K'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => ['A', 'B', 'C', 'H', 'J', 'K'], 'seats' => $seats])
                @endforeach
            </div>
        @endforeach
    </div>
</section>

<!-- Attendant D12 & D22 -->
<section class="cabin-section">
    <h2>Attendant D12 & D22</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-2-2">
            <span class="col-label col-header">LL</span>
            <span class="col-label col-header">LR</span>
            <span class="row-label"></span>
            <span class="col-label col-header">RL</span>
            <span class="col-label col-header">RR</span>
        </div>
        <div class="seat-row grid-row-2-2">
            @foreach(['LL', 'LR'] as $col)
                @php $seatId = 'att/d12-' . $col;
                    $seat = $seats[$seatId] ?? null;
                $status = $seat?->status ?? 'no-data'; @endphp
                <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                    <div class="seat-id">D12-{{ $col }}</div>
                    <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                </div>
            @endforeach
            <div class="row-number">D12/D22</div>
            @foreach(['RL', 'RR'] as $col)
                @php $seatId = 'att/d22-' . $col;
                    $seat = $seats[$seatId] ?? null;
                $status = $seat?->status ?? 'no-data'; @endphp
                <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                    <div class="seat-id">D22-{{ $col }}</div>
                    <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                </div>
            @endforeach
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