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

<!-- Attendant D11 & D21 -->
<section class="cabin-section">
    <h2>Attendant D11 & D21</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-2-2">
            <span class="col-label col-header" data-col="att/d11-LL1">LL</span>
            <span class="col-label col-header" data-col="att/d11-LR">LR</span>
            <span class="row-label"></span>
            <span class="seat-placeholder"></span>
            <span class="col-label col-header" data-col="att/d21-R">R</span>
        </div>
        <!-- Row 1 -->
        <div class="seat-row grid-row-2-2">
            @php
                $seatId = 'att/d11-LL1';
                $seat = $seats[$seatId] ?? null;
                $status = $seat?->status ?? 'no-data';
                $expiryDate = $seat?->expiry_date?->format('j M Y') ?? '-';
            @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}" data-col="LL1">
                <div class="seat-id">D11-LL1</div>
                <div class="seat-date">{{ $expiryDate }}</div>
            </div>
            <div class="seat-placeholder"></div>
            <div class="row-number">D11/D21</div>
            <div class="seat-placeholder"></div>
            @php
                $seatId = 'att/d21-R';
                $seat = $seats[$seatId] ?? null;
                $status = $seat?->status ?? 'no-data';
                $expiryDate = $seat?->expiry_date?->format('j M Y') ?? '-';
            @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}" data-col="R">
                <div class="seat-id">D21-R</div>
                <div class="seat-date">{{ $expiryDate }}</div>
            </div>
        </div>
        <!-- Row 2 -->
        <div class="seat-row grid-row-2-2">
            @php
                $seatId = 'att/d11-LL2';
                $seat = $seats[$seatId] ?? null;
                $status = $seat?->status ?? 'no-data';
                $expiryDate = $seat?->expiry_date?->format('j M Y') ?? '-';
            @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}" data-col="LL2">
                <div class="seat-id">D11-LL2</div>
                <div class="seat-date">{{ $expiryDate }}</div>
            </div>
            @php
                $seatId = 'att/d11-LR';
                $seat = $seats[$seatId] ?? null;
                $status = $seat?->status ?? 'no-data';
                $expiryDate = $seat?->expiry_date?->format('j M Y') ?? '-';
            @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}" data-col="LR">
                <div class="seat-id">D11-LR</div>
                <div class="seat-date">{{ $expiryDate }}</div>
            </div>
            <div class="row-number"></div>
            <div class="seat-placeholder"></div>
            <div class="seat-placeholder"></div>
        </div>
    </div>
</section>

<!-- Business Class - Rows 6-11 -->
<section class="cabin-section">
    <h2>Business Class - Rows 6-11</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-2-2-2">
            <span class="col-label col-header">A</span>
            <span class="seat-placeholder"></span>
            <span class="col-label col-header">D</span>
            <span class="col-label row-label">Row</span>
            <span class="col-label col-header">G</span>
            <span class="seat-placeholder"></span>
            <span class="col-label col-header">K</span>
        </div>
        @foreach([6, 7, 8, 9, 10, 11] as $row)
            <div class="seat-row-business" data-row="{{ $row }}"
                style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 0.5rem; margin-bottom: 0.5rem; justify-items: center;">
                @php $col = 'A';
                    $seat = $seats["{$row}{$col}"] ?? null;
                $status = $seat?->status ?? 'no-data'; @endphp
                <div class="seat-card status-{{ $status }}" data-seat="{{ $row }}{{ $col }}">
                    <div class="seat-id">{{ $row }}{{ $col }}</div>
                    <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                </div>
                <div class="seat-placeholder"></div>
                @php $col = 'D';
                    $seat = $seats["{$row}{$col}"] ?? null;
                $status = $seat?->status ?? 'no-data'; @endphp
                <div class="seat-card status-{{ $status }}" data-seat="{{ $row }}{{ $col }}">
                    <div class="seat-id">{{ $row }}{{ $col }}</div>
                    <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                </div>
                <div class="row-number">{{ $row }}</div>
                @php $col = 'G';
                    $seat = $seats["{$row}{$col}"] ?? null;
                $status = $seat?->status ?? 'no-data'; @endphp
                <div class="seat-card status-{{ $status }}" data-seat="{{ $row }}{{ $col }}">
                    <div class="seat-id">{{ $row }}{{ $col }}</div>
                    <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                </div>
                <div class="seat-placeholder"></div>
                @php $col = 'K';
                    $seat = $seats["{$row}{$col}"] ?? null;
                $status = $seat?->status ?? 'no-data'; @endphp
                <div class="seat-card status-{{ $status }}" data-seat="{{ $row }}{{ $col }}">
                    <div class="seat-id">{{ $row }}{{ $col }}</div>
                    <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- Attendant D12 & D22 -->
<section class="cabin-section">
    <h2>Attendant D12 & D22</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-2-2">
            <span class="col-label col-header" data-col="att/d12-L">L</span>
            <span class="seat-placeholder"></span>
            <span class="row-label"></span>
            <span class="seat-placeholder"></span>
            <span class="col-label col-header" data-col="att/d22-R">R</span>
        </div>
        <div class="seat-row grid-row-2-2">
            @php
                $seatId = 'att/d12-L';
                $seat = $seats[$seatId] ?? null;
                $status = $seat?->status ?? 'no-data';
                $expiryDate = $seat?->expiry_date?->format('j M Y') ?? '-';
            @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}" data-col="L">
                <div class="seat-id">D12-L</div>
                <div class="seat-date">{{ $expiryDate }}</div>
            </div>
            <div class="seat-placeholder"></div>
            <div class="row-number">D12/D22</div>
            <div class="seat-placeholder"></div>
            @php
                $seatId = 'att/d22-R';
                $seat = $seats[$seatId] ?? null;
                $status = $seat?->status ?? 'no-data';
                $expiryDate = $seat?->expiry_date?->format('j M Y') ?? '-';
            @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}" data-col="R">
                <div class="seat-id">D22-R</div>
                <div class="seat-date">{{ $expiryDate }}</div>
            </div>
        </div>
    </div>
</section>

<!-- Economy Class - Rows 21-39 -->
<section class="cabin-section">
    <h2>Economy Class - Rows 21-39</h2>
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
        @foreach(range(21, 39) as $row)
            @if($row == 24) @continue @endif
            @php $rowCols = ['A', 'C', 'D', 'E', 'F', 'G', 'H', 'K']; @endphp
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

<!-- Attendant D13 & D23 -->
<section class="cabin-section">
    <h2>Attendant D13 & D23</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-2-2">
            <span class="col-label col-header" data-col="att/d13-L">L</span>
            <span class="seat-placeholder"></span>
            <span class="row-label"></span>
            <span class="seat-placeholder"></span>
            <span class="col-label col-header" data-col="att/d23-R">R</span>
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

<!-- Economy Class - Rows 40-55 -->
<section class="cabin-section">
    <h2>Economy Class - Rows 40-55</h2>
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
        @foreach(range(40, 55) as $row)
            @php
                if ($row == 55) {
                    $rowCols = ['D', 'F', 'G'];
                } elseif ($row >= 51 && $row <= 54) {
                    $rowCols = ['A', 'C', 'D', 'F', 'G', 'H', 'K'];
                } else {
                    $rowCols = ['A', 'C', 'D', 'E', 'F', 'G', 'H', 'K'];
                }
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

<!-- Attendant D14 & D24 + Aft Galley -->
<section class="cabin-section">
    <h2>Attendant D14 & D24 + Aft Galley</h2>
    <div class="seat-grid" style="text-align: center; max-width: 600px; margin: 0 auto;">
        <!-- D14 -->
        <div style="display: inline-block; vertical-align: top; margin: 0 10px;">
            @php $seatId = 'att/d14-L';
                $seat = $seats[$seatId] ?? null;
            $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-id">D14-L</div>
                <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
            </div>
        </div>
        <!-- Galley -->
        <div style="display: inline-block; vertical-align: top; margin: 0 10px;">
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
        <!-- D24 -->
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