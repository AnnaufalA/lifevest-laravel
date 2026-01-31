<!-- Cockpit Section -->
<section class="cockpit-section avoid-break">
    <h2>Cockpit</h2>
    <div class="cockpit-grid">
        @foreach(['captain', 'observer1', 'observer2', 'copilot'] as $seatId)
            @php $seat = $seats[$seatId] ?? null;
            $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card cockpit-seat status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-label">{{ ucfirst(str_replace(['1', '2'], [' 1', ' 2'], $seatId)) }}</div>
                <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
            </div>
        @endforeach
    </div>
</section>

<!-- Attendant D11 & D21 -->
<section class="cabin-section avoid-break">
    <h2>Attendant D11 & D21</h2>
    <div class="seat-grid" style="text-align: center; margin: 0 auto; white-space: nowrap;">
        <div style="display: inline-block; vertical-align: top; margin: 0 10px;">
            @foreach(['LL', 'LR'] as $col)
                @php $seatId = 'att/d11-' . $col;
                    $seat = $seats[$seatId] ?? null;
                $status = $seat?->status ?? 'no-data'; @endphp
                <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                    <div class="seat-id">D11-{{ $col }}</div>
                    <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                </div>
            @endforeach
        </div>
        <div style="display: inline-block; width: 40px;"></div>
        <div style="display: inline-block; vertical-align: top; margin: 0 10px;">
            @php $seatId = 'att/d21-R';
                $seat = $seats[$seatId] ?? null;
            $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-id">D21-R</div>
                <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
            </div>
        </div>
    </div>
</section>

<!-- Business Class - Rows 6-8 -->
<section class="cabin-section">
    <h2>Business Class - Rows 6-8</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-2-2-2">
            <span class="col-label col-header">A</span><span class="col-label col-header">C</span>
            <span class="row-label"></span>
            <span class="col-label col-header">D</span><span class="col-label col-header">G</span>
            <span class="row-label"></span>
            <span class="col-label col-header">H</span><span class="col-label col-header">K</span>
        </div>
        @foreach(range(6, 8) as $row)
            <div class="seat-row grid-row-2-2-2">
                @foreach(['A', 'C'] as $col)
                    @php $seatId = $row . $col;
                        $seat = $seats[$seatId] ?? null;
                    $status = $seat?->status ?? 'no-data'; @endphp
                    <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                        <div class="seat-id">{{ $seatId }}</div>
                        <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                    </div>
                @endforeach
                <div class="row-number">{{ $row }}</div>
                @foreach(['D', 'G'] as $col)
                    @php $seatId = $row . $col;
                        $seat = $seats[$seatId] ?? null;
                    $status = $seat?->status ?? 'no-data'; @endphp
                    <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                        <div class="seat-id">{{ $seatId }}</div>
                        <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                    </div>
                @endforeach
                <div class="row-number">{{ $row }}</div>
                @foreach(['H', 'K'] as $col)
                    @php $seatId = $row . $col;
                        $seat = $seats[$seatId] ?? null;
                    $status = $seat?->status ?? 'no-data'; @endphp
                    <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                        <div class="seat-id">{{ $seatId }}</div>
                        <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</section>

<!-- Attendant D12 & D22 -->
<section class="cabin-section avoid-break">
    <h2>Attendant D12 & D22</h2>
    <div class="seat-grid" style="text-align: center; margin: 0 auto; white-space: nowrap;">
        <div style="display: inline-block; vertical-align: top; margin: 0 10px;">
            @foreach(['LL', 'LR'] as $col)
                @php $seatId = 'att/d12-' . $col;
                    $seat = $seats[$seatId] ?? null;
                $status = $seat?->status ?? 'no-data'; @endphp
                <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                    <div class="seat-id">D12-{{ $col }}</div>
                    <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                </div>
            @endforeach
        </div>
        <div style="display: inline-block; width: 40px;"></div>
        <div style="display: inline-block; vertical-align: top; margin: 0 10px;">
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

<!-- Business Class - Rows 9-11 -->
<section class="cabin-section">
    <h2>Business Class - Rows 9-11</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-2-2-2">
            <span class="col-label col-header">A</span><span class="col-label col-header">C</span>
            <span class="row-label"></span>
            <span class="col-label col-header">D</span><span class="col-label col-header">G</span>
            <span class="row-label"></span>
            <span class="col-label col-header">H</span><span class="col-label col-header">K</span>
        </div>
        @foreach(range(9, 11) as $row)
            <div class="seat-row grid-row-2-2-2">
                @foreach(['A', 'C'] as $col)
                    @php $seatId = $row . $col;
                        $seat = $seats[$seatId] ?? null;
                    $status = $seat?->status ?? 'no-data'; @endphp
                    <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                        <div class="seat-id">{{ $seatId }}</div>
                        <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                    </div>
                @endforeach
                <div class="row-number">{{ $row }}</div>
                @foreach(['D', 'G'] as $col)
                    @php $seatId = $row . $col;
                        $seat = $seats[$seatId] ?? null;
                    $status = $seat?->status ?? 'no-data'; @endphp
                    <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                        <div class="seat-id">{{ $seatId }}</div>
                        <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                    </div>
                @endforeach
                <div class="row-number">{{ $row }}</div>
                @foreach(['H', 'K'] as $col)
                    @php $seatId = $row . $col;
                        $seat = $seats[$seatId] ?? null;
                    $status = $seat?->status ?? 'no-data'; @endphp
                    <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                        <div class="seat-id">{{ $seatId }}</div>
                        <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</section>

<!-- Economy Class - Rows 21-31 -->
<section class="cabin-section">
    <h2>Economy Class - Rows 21-31</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-2-4-2">
            <span class="col-label col-header">A</span><span class="col-label col-header">C</span>
            <span class="row-label"></span>
            <span class="col-label col-header">D</span><span class="col-label col-header">E</span><span
                class="col-label col-header">F</span><span class="col-label col-header">G</span>
            <span class="row-label"></span>
            <span class="col-label col-header">H</span><span class="col-label col-header">K</span>
        </div>
        @foreach(range(21, 31) as $row)
            @if($row == 24) @continue @endif
            <div class="seat-row grid-row-2-4-2">
                @foreach(['A', 'C'] as $col)
                    @php $seatId = $row . $col;
                        $seat = $seats[$seatId] ?? null;
                    $status = $seat?->status ?? 'no-data'; @endphp
                    <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                        <div class="seat-id">{{ $seatId }}</div>
                        <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                    </div>
                @endforeach
                <div class="row-number">{{ $row }}</div>
                @foreach(['D', 'E', 'F', 'G'] as $col)
                    @php $seatId = $row . $col;
                        $seat = $seats[$seatId] ?? null;
                    $status = $seat?->status ?? 'no-data'; @endphp
                    <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                        <div class="seat-id">{{ $seatId }}</div>
                        <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                    </div>
                @endforeach
                <div class="row-number">{{ $row }}</div>
                @foreach(['H', 'K'] as $col)
                    @php $seatId = $row . $col;
                        $seat = $seats[$seatId] ?? null;
                    $status = $seat?->status ?? 'no-data'; @endphp
                    <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                        <div class="seat-id">{{ $seatId }}</div>
                        <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</section>

<!-- Attendant D13 & D23 -->
<section class="cabin-section avoid-break">
    <h2>Attendant D13 & D23</h2>
    <div class="seat-grid" style="text-align: center; margin: 0 auto; white-space: nowrap;">
        <div style="display: inline-block; vertical-align: top; margin: 0 10px;">
            @php $seatId = 'att/d13-L';
                $seat = $seats[$seatId] ?? null;
            $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-id">D13-L</div>
                <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
            </div>
        </div>
        <div style="display: inline-block; width: 40px;"></div>
        <div style="display: inline-block; vertical-align: top; margin: 0 10px;">
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

<!-- Economy Class - Rows 32-45 -->
<section class="cabin-section">
    <h2>Economy Class - Rows 32-45</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-2-4-2">
            <span class="col-label col-header">A</span><span class="col-label col-header">C</span>
            <span class="row-label"></span>
            <span class="col-label col-header">D</span><span class="col-label col-header">E</span><span
                class="col-label col-header">F</span><span class="col-label col-header">G</span>
            <span class="row-label"></span>
            <span class="col-label col-header">H</span><span class="col-label col-header">K</span>
        </div>
        @php
            $exceptions = [
                42 => ['A', 'C', 'D', 'E', 'G', 'H', 'K'],
                43 => ['A', 'C', 'D', 'E', 'G', 'H', 'K'],
                44 => ['A', 'C', 'D', 'E', 'G', 'H', 'K'],
                45 => ['A', 'C', 'D', 'E', 'G'],
            ];
        @endphp
        @foreach(range(32, 45) as $row)
            @php $rowCols = $exceptions[$row] ?? ['A', 'C', 'D', 'E', 'F', 'G', 'H', 'K']; @endphp
            <div class="seat-row grid-row-2-4-2">
                @if(in_array('A', $rowCols))
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
                            <div class="seat-placeholder"></div>
                        @endif
                    @endforeach
                @endif

                <div class="row-number">{{ $row }}</div>

                @foreach(['D', 'E', 'F', 'G'] as $col)
                    @if(in_array($col, $rowCols))
                        @php $seatId = $row . $col;
                            $seat = $seats[$seatId] ?? null;
                        $status = $seat?->status ?? 'no-data'; @endphp
                        <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                            <div class="seat-id">{{ $seatId }}</div>
                            <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                        </div>
                    @else
                        <!-- Missing E in some rows -->
                    @endif
                @endforeach

                <div class="row-number">{{ $row }}</div>

                @if(in_array('K', $rowCols))
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
                @endif
            </div>
        @endforeach
    </div>
</section>

<!-- Attendant D14 & D24 -->
<section class="cabin-section avoid-break">
    <h2>Attendant D14 & D24</h2>
    <div class="seat-grid" style="text-align: center; margin: 0 auto; white-space: nowrap;">
        <div style="display: inline-block; vertical-align: top; margin: 0 10px;">
            @php $seatId = 'att/d14-L';
                $seat = $seats[$seatId] ?? null;
            $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-id">D14-L</div>
                <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
            </div>
        </div>
        <div style="display: inline-block; width: 40px;"></div>
        <div style="display: inline-block; vertical-align: top; margin: 0 10px;">
            @php $seatId = 'att/d24-R';
                $seat = $seats[$seatId] ?? null;
            $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-id">D24-R</div>
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