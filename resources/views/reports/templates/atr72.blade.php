<!-- Cockpit Section -->
<section class="cockpit-section avoid-break">
    <h2>Cockpit</h2>
    <div class="cockpit-grid">
        @foreach(['captain', 'observer1', 'observer2', 'copilot'] as $seatId)
            @php $seat = $seats[$seatId] ?? null; $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card cockpit-seat status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-label">{{ ucfirst(str_replace(['1', '2'], [' 1', ' 2'], $seatId)) }}</div>
                <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
            </div>
        @endforeach
    </div>
</section>

<!-- Attendant FWD (Just L) -->
<section class="cabin-section avoid-break">
    <h2>Attendant FWD</h2>
    <div class="seat-grid" style="text-align: center; margin: 0 auto;">
        <div style="display: inline-block; vertical-align: top; margin: 0 10px;">
            @php $seatId = 'att/fwd-L';
                $seat = $seats[$seatId] ?? null;
            $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-id">FWD-L</div>
                <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
            </div>
        </div>
    </div>
</section>

<!-- Economy Class - Rows 21-39 -->
<section class="cabin-section">
    <h2>Economy Class - Rows 21-39</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-2-2">
            <span class="col-label col-header">A</span><span class="col-label col-header">C</span>
            <span class="row-label"></span>
            <span class="col-label col-header">H</span><span class="col-label col-header">K</span>
        </div>
        @php $exceptions = [39 => ['A', 'C']]; @endphp
        @foreach(range(21, 39) as $row)
            @if($row == 24) @continue @endif
            @php $rowCols = $exceptions[$row] ?? ['A', 'C', 'H', 'K']; @endphp
            <div class="seat-row grid-row-2-2">
                @foreach(['A', 'C'] as $col)
                    @if(in_array($col, $rowCols))
                        @php $seatId = $row . $col;
                            $seat = $seats[$seatId] ?? null;
                        $status = $seat?->status ?? 'no-data'; @endphp
                        <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                            <div class="seat-id">{{ $seatId }}</div>
                            <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                        </div>
                    @else
                        <!-- Spacer? Or just nothing -->
                        <div class="seat-placeholder"></div>
                    @endif
                @endforeach
                <div class="row-number">{{ $row }}</div>
                @foreach(['H', 'K'] as $col)
                    @if(in_array($col, $rowCols))
                        @php $seatId = $row . $col;
                            $seat = $seats[$seatId] ?? null;
                        $status = $seat?->status ?? 'no-data'; @endphp
                        <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                            <div class="seat-id">{{ $seatId }}</div>
                            <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                        </div>
                    @else
                        <div class="seat-placeholder"></div>
                    @endif
                @endforeach
            </div>
        @endforeach
    </div>
</section>

<!-- Attendant AFT (Just L) -->
<section class="cabin-section avoid-break">
    <h2>Attendant AFT</h2>
    <div class="seat-grid" style="text-align: center; margin: 0 auto;">
        <div style="display: inline-block; vertical-align: top; margin: 0 10px;">
            @php $seatId = 'att/aft-L';
                $seat = $seats[$seatId] ?? null;
            $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-id">AFT-L</div>
                <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
            </div>
        </div>
    </div>
</section>

<!-- Spare Section -->
<section class="cabin-section avoid-break">
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