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
                <div class="seat-date" data-date="{{ $seat?->expiry_date?->format('Y-m-d') ?? '' }}">
                    {{ $expiryDate }}
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- Attendant D11 -->
<section class="cabin-section">
    <h2>Attendant D11</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-3-3">
            <span class="col-label col-header" data-col="att/d11-LL">LL</span>
            <span class="col-label col-header" data-col="att/d11-LR">LR</span>
            <span class="seat-placeholder"></span>
            <span class="row-label"></span>
            <span class="seat-placeholder"></span>
            <span class="seat-placeholder"></span>
            <span class="seat-placeholder"></span>
        </div>
        <div class="seat-row grid-row-3-3">
            @php
                $seatId = 'att/d11-LL';
                $seat = $seats[$seatId] ?? null;
                $status = $seat?->status ?? 'no-data';
                $expiryDate = $seat?->expiry_date?->format('j M Y') ?? '-';
            @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}" data-col="LL">
                <div class="seat-id">D11-LL</div>
                <div class="seat-date" data-date="{{ $seat?->expiry_date?->format('Y-m-d') ?? '' }}">
                    {{ $expiryDate }}
                </div>
            </div>
            @php
                $seatId = 'att/d11-LR';
                $seat = $seats[$seatId] ?? null;
                $status = $seat?->status ?? 'no-data';
                $expiryDate = $seat?->expiry_date?->format('j M Y') ?? '-';
            @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}" data-col="LR">
                <div class="seat-id">D11-LR</div>
                <div class="seat-date" data-date="{{ $seat?->expiry_date?->format('Y-m-d') ?? '' }}">
                    {{ $expiryDate }}
                </div>
            </div>
            <div class="seat-placeholder"></div>
            <div class="row-number">D11</div>
            <div class="seat-placeholder"></div>
            <div class="seat-placeholder"></div>
            <div class="seat-placeholder"></div>
        </div>
    </div>
</section>

<!-- Business Class -->
<section class="cabin-section">
    <h2>Business Class - Rows 1-6</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-2-2-2">
            <span class="col-label col-header" data-col="A">A</span>
            <span class="col-label col-header" data-col="C">C</span>
            <span class="col-label col-header" data-col="D">D</span>
            <span class="row-label">Row</span>
            <span class="col-label col-header" data-col="F">F</span>
            <span class="col-label col-header" data-col="H">H</span>
            <span class="col-label col-header" data-col="K">K</span>
        </div>
        @foreach(range(1, 6) as $row)
            @php
                $rowCols = ['A', 'C', 'D', 'F', 'H', 'K'];
            @endphp
            <div class="seat-row grid-row-2-2-2" data-row="{{ $row }}">
                @foreach(['A', 'C'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => $rowCols, 'seats' => $seats])
                @endforeach
                @foreach(['D'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => $rowCols, 'seats' => $seats])
                @endforeach
                <div class="row-number" data-row="{{ $row }}">{{ $row }}</div>
                @foreach(['F'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => $rowCols, 'seats' => $seats])
                @endforeach
                @foreach(['H', 'K'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => $rowCols, 'seats' => $seats])
                @endforeach
            </div>
        @endforeach
    </div>
</section>

<!-- Economy Class -->
<section class="cabin-section">
    <h2>Economy Class - Rows 21-50</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-2-4-2">
            <span class="col-label col-header" data-col="A">A</span>
            <span class="col-label col-header" data-col="C">C</span>
            <span class="row-label">Row</span>
            <span class="col-label col-header" data-col="D">D</span>
            <span class="col-label col-header" data-col="E">E</span>
            <span class="col-label col-header" data-col="F">F</span>
            <span class="col-label col-header" data-col="G">G</span>
            <span class="row-label">Row</span>
            <span class="col-label col-header" data-col="H">H</span>
            <span class="col-label col-header" data-col="K">K</span>
        </div>
        @foreach(range(21, 50) as $row)
            @php
                $rowCols = ['A', 'C', 'D', 'E', 'F', 'G', 'H', 'K'];
            @endphp
            <div class="seat-row grid-row-2-4-2" data-row="{{ $row }}">
                @foreach(['A', 'C'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => $rowCols, 'seats' => $seats])
                @endforeach
                <div class="row-number" data-row="{{ $row }}">{{ $row }}</div>
                @foreach(['D', 'E', 'F', 'G'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => $rowCols, 'seats' => $seats])
                @endforeach
                <div class="row-number" data-row="{{ $row }}">{{ $row }}</div>
                @foreach(['H', 'K'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => $rowCols, 'seats' => $seats])
                @endforeach
            </div>
        @endforeach
    </div>
</section>

<!-- Attendant Door 2, 3, 4 -->
<!-- Same attendant sections as 200a mostly, simplified for PDF -->
<section class="cabin-section">
    <h2>Attendant Seats</h2>
    <div class="seat-grid">
        <!-- Placeholder for attendants -->
        <div class="grid-header grid-row-2-2">
            <span class="col-label col-header">L</span>
            <span class="col-label col-header">R</span>
        </div>
        <div class="seat-row grid-row-2-2">
            <!-- D2/D3/D4 Simplified -->
            @foreach(['att/d2-L', 'att/d2-R'] as $seatId)
                @php
                    $seat = $seats[$seatId] ?? null;
                    $status = $seat?->status ?? 'no-data';
                    $expiryDate = $seat?->expiry_date?->format('j M Y') ?? '-';
                @endphp
                <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                    <div class="seat-id">{{ str_replace('att/', '', $seatId) }}</div>
                    <div class="seat-date">{{ $expiryDate }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Spare Section -->
<section class="cabin-section">
    <h2>Spare</h2>
    <!-- Same spare logic -->
    <div class="spare-grid">
        <div class="spare-column">
            <h3>PAX</h3>
            <div class="spare-items">
                @php $paxSeats = collect($seats)->filter(fn($s, $id) => str_starts_with($id, 'pax-')); @endphp
                @forelse($paxSeats as $seatId => $seat)
                    @php $status = $seat?->status ?? 'no-data';
                    $expiryDate = $seat?->expiry_date?->format('j M Y') ?? '-'; @endphp
                    <div class="seat-card spare-card status-{{ $status }}">
                        <div class="seat-id">{{ str_replace('pax-', '', $seatId) }}</div>
                        <div class="seat-date">{{ $expiryDate }}</div>
                    </div>
                @empty <p>No PAX</p> @endforelse
            </div>
        </div>
        <div class="spare-column">
            <h3>INF</h3>
            <div class="spare-items">
                @php $infSeats = collect($seats)->filter(fn($s, $id) => str_starts_with($id, 'inf-')); @endphp
                @forelse($infSeats as $seatId => $seat)
                    @php $status = $seat?->status ?? 'no-data';
                    $expiryDate = $seat?->expiry_date?->format('j M Y') ?? '-'; @endphp
                    <div class="seat-card spare-card status-{{ $status }}">
                        <div class="seat-id">{{ str_replace('inf-', '', $seatId) }}</div>
                        <div class="seat-date">{{ $expiryDate }}</div>
                    </div>
                @empty <p>No INF</p> @endforelse
            </div>
        </div>
    </div>
</section>