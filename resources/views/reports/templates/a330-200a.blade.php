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

<!-- Attendant Door 1 (Forward - 2 seats left) -->
<section class="cabin-section">
    <h2>Attendant Door 1</h2>
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

<!-- Business Class - Rows 1-6 (2-2-2 layout) -->
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

<!-- Economy Class - Rows 21-50 -->
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

<!-- Attendant Door 2 & 3 -->
<section class="cabin-section">
    <h2>Attendant Door 2 & 3</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-2-2">
            <span class="col-label col-header" data-col="att/d2-L">D2L</span>
            <span class="col-label col-header" data-col="att/d2-R">D2R</span>
            <span class="seat-placeholder"></span>
            <span class="col-label col-header" data-col="att/d3-L">D3L</span>
            <span class="col-label col-header" data-col="att/d3-R">D3R</span>
        </div>
        <div class="seat-row grid-row-2-2">
            @foreach(['L', 'R'] as $col)
                @php
                    $seatId = 'att/d2-' . $col;
                    $seat = $seats[$seatId] ?? null;
                    $status = $seat?->status ?? 'no-data';
                    $expiryDate = $seat?->expiry_date?->format('j M Y') ?? '-';
                @endphp
                <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}" data-col="d2{{ $col }}">
                    <div class="seat-id">D2-{{ $col }}</div>
                    <div class="seat-date" data-date="{{ $seat?->expiry_date?->format('Y-m-d') ?? '' }}">
                        {{ $expiryDate }}
                    </div>
                </div>
            @endforeach
            <div class="seat-placeholder"></div>
            @foreach(['L', 'R'] as $col)
                @php
                    $seatId = 'att/d3-' . $col;
                    $seat = $seats[$seatId] ?? null;
                    $status = $seat?->status ?? 'no-data';
                    $expiryDate = $seat?->expiry_date?->format('j M Y') ?? '-';
                @endphp
                <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}" data-col="d3{{ $col }}">
                    <div class="seat-id">D3-{{ $col }}</div>
                    <div class="seat-date" data-date="{{ $seat?->expiry_date?->format('Y-m-d') ?? '' }}">
                        {{ $expiryDate }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Attendant Door 4 (Rear) -->
<section class="cabin-section">
    <h2>Attendant Door 4</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-2-2">
            <span class="col-label col-header" data-col="att/d4-L">L</span>
            <span class="col-label col-header" data-col="att/d4-R">R</span>
            <span class="seat-placeholder"></span>
            <span class="row-label"></span>
        </div>
        <div class="seat-row grid-row-2-2">
            @foreach(['L', 'R'] as $col)
                @php
                    $seatId = 'att/d4-' . $col;
                    $seat = $seats[$seatId] ?? null;
                    $status = $seat?->status ?? 'no-data';
                    $expiryDate = $seat?->expiry_date?->format('j M Y') ?? '-';
                @endphp
                <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}" data-col="{{ $col }}">
                    <div class="seat-id">D4-{{ $col }}</div>
                    <div class="seat-date" data-date="{{ $seat?->expiry_date?->format('Y-m-d') ?? '' }}">
                        {{ $expiryDate }}
                    </div>
                </div>
            @endforeach
            <div class="seat-placeholder"></div>
            <div class="row-number">D4</div>
        </div>
    </div>
</section>

<!-- Spare Section -->
<section class="cabin-section">
    <h2>Spare</h2>
    <div class="spare-grid">
        <!-- PAX Column -->
        <div class="spare-column" id="pax-column">
            <h3>PAX</h3>
            <div class="spare-items" id="pax-items">
                @php
                    $paxSeats = collect($seats)->filter(fn($s, $id) => str_starts_with($id, 'pax-'))->sortBy(fn($s, $id) => (int) str_replace('pax-', '', $id));
                @endphp
                @forelse($paxSeats as $seatId => $seat)
                    @php
                        $num = str_replace('pax-', '', $seatId);
                        $status = $seat?->status ?? 'no-data';
                        $expiryDate = $seat?->expiry_date?->format('j M Y') ?? '-';
                    @endphp
                    <div class="seat-card spare-card status-{{ $status }}" data-seat="{{ $seatId }}">
                        <div class="seat-id">{{ $num }}</div>
                        <div class="seat-date" data-date="{{ $seat?->expiry_date?->format('Y-m-d') ?? '' }}">
                            {{ $expiryDate }}
                        </div>
                    </div>
                @empty
                    <p class="empty-message">Belum ada data PAX</p>
                @endforelse
            </div>
        </div>

        <!-- INF Column -->
        <div class="spare-column" id="inf-column">
            <h3>INF</h3>
            <div class="spare-items" id="inf-items">
                @php
                    $infSeats = collect($seats)->filter(fn($s, $id) => str_starts_with($id, 'inf-'))->sortBy(fn($s, $id) => (int) str_replace('inf-', '', $id));
                @endphp
                @forelse($infSeats as $seatId => $seat)
                    @php
                        $num = str_replace('inf-', '', $seatId);
                        $status = $seat?->status ?? 'no-data';
                        $expiryDate = $seat?->expiry_date?->format('j M Y') ?? '-';
                    @endphp
                    <div class="seat-card spare-card status-{{ $status }}" data-seat="{{ $seatId }}">
                        <div class="seat-id">{{ $num }}</div>
                        <div class="seat-date" data-date="{{ $seat?->expiry_date?->format('Y-m-d') ?? '' }}">
                            {{ $expiryDate }}
                        </div>
                    </div>
                @empty
                    <p class="empty-message">Belum ada data INF</p>
                @endforelse
            </div>
        </div>
    </div>
</section>