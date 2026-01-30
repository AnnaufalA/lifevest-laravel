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

<!-- Attendant Door 1 -->
<section class="cabin-section">
    <h2>Attendant Door 1</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-2-2">
            <span class="col-label col-header">L</span>
            <span class="col-label col-header">CL</span>
            <span class="row-label"></span>
            <span class="col-label col-header">CR</span>
            <span class="col-label col-header">R</span>
        </div>
        <div class="seat-row grid-row-2-2">
            @foreach(['L', 'CL'] as $col)
                @php $seatId = 'att/d1-' . $col;
                    $seat = $seats[$seatId] ?? null;
                $status = $seat?->status ?? 'no-data'; @endphp
                <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                    <div class="seat-id">D1-{{ $col }}</div>
                    <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                </div>
            @endforeach
            <div class="row-number">D1</div>
            @foreach(['CR', 'R'] as $col)
                @php $seatId = 'att/d1-' . $col;
                    $seat = $seats[$seatId] ?? null;
                $status = $seat?->status ?? 'no-data'; @endphp
                <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                    <div class="seat-id">D1-{{ $col }}</div>
                    <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- First Class - Rows 1-2 -->
<section class="cabin-section">
    <h2>First Class - Rows 1-2</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-2-2">
            <span class="col-label col-header">A</span>
            <span class="col-label col-header">D</span>
            <span class="row-label"></span>
            <span class="col-label col-header">G</span>
            <span class="col-label col-header">K</span>
        </div>
        @foreach([1, 2] as $row)
            <div class="seat-row grid-row-2-2" data-row="{{ $row }}">
                @foreach(['A', 'D'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => ['A', 'D', 'G', 'K'], 'seats' => $seats])
                @endforeach
                <div class="row-number">{{ $row }}</div>
                @foreach(['G', 'K'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => ['A', 'D', 'G', 'K'], 'seats' => $seats])
                @endforeach
            </div>
        @endforeach
    </div>
</section>

<!-- Business Class - Rows 6-8 -->
<section class="cabin-section">
    <h2>Business Class - Rows 6-8</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-2-2-2">
            <span class="col-label col-header">A/C</span>
            <span class="col-label col-header">D/E</span>
            <span class="row-label"></span>
            <span class="col-label col-header">G/F</span>
            <span class="col-label col-header">K/H</span>
        </div>
        @php $staggeredPattern1 = [6 => ['A', 'E', 'F', 'K'], 7 => ['C', 'D', 'G', 'H'], 8 => ['A', 'K']]; @endphp
        @foreach($staggeredPattern1 as $row => $cols)
            <div class="seat-row" style="text-align: center;">
                @if(count($cols) == 4)
                    @foreach(array_slice($cols, 0, 2) as $col)
                        @php $seat = $seats["$row$col"] ?? null; @endphp
                        <div class="seat-card status-{{ $seat->status ?? 'no-data' }}">
                            <div class="seat-id">{{ $row }}{{ $col }}</div>
                            <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                        </div>
                    @endforeach
                    <div class="row-number">{{ $row }}</div>
                    @foreach(array_slice($cols, 2, 2) as $col)
                         @php $seat = $seats["$row$col"] ?? null; @endphp
                        <div class="seat-card status-{{ $seat->status ?? 'no-data' }}">
                            <div class="seat-id">{{ $row }}{{ $col }}</div>
                            <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                        </div>
                    @endforeach
                @else
                    {{-- Row 8 --}}
                    @php $seatA = $seats["{$row}A"] ?? null; $seatK = $seats["{$row}K"] ?? null; @endphp
                    <div class="seat-card status-{{ $seatA->status ?? 'no-data' }}">
                        <div class="seat-id">{{ $row }}A</div>
                        <div class="seat-date">{{ $seatA?->expiry_date?->format('j M Y') ?? '-' }}</div>
                    </div>
                    <div class="seat-placeholder" style="width: 50px;"></div>
                    <div class="row-number">{{ $row }}</div>
                    <div class="seat-placeholder" style="width: 50px;"></div>
                    <div class="seat-card status-{{ $seatK->status ?? 'no-data' }}">
                        <div class="seat-id">{{ $row }}K</div>
                        <div class="seat-date">{{ $seatK?->expiry_date?->format('j M Y') ?? '-' }}</div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</section>

<!-- Attendant Door 2 -->
<section class="cabin-section">
    <h2>Attendant Door 2</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-2-2">
            <span class="col-label col-header">L</span>
            <span class="seat-placeholder"></span>
            <span class="row-label"></span>
            <span class="seat-placeholder"></span>
            <span class="col-label col-header">R</span>
        </div>
        <div class="seat-row grid-row-2-2">
            @php $seatId = 'att/d2-L';
                $seat = $seats[$seatId] ?? null;
            $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-id">D2-L</div>
                <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
            </div>
            <div class="seat-placeholder"></div>
            <div class="row-number">D2</div>
            <div class="seat-placeholder"></div>
            @php $seatId = 'att/d2-R';
                $seat = $seats[$seatId] ?? null;
            $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-id">D2-R</div>
                <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
            </div>
        </div>
    </div>
</section>

<!-- Business Class - Rows 9-16 -->
<section class="cabin-section">
    <h2>Business Class - Rows 9-16</h2>
    <div class="seat-grid">
        @php
            $staggeredPattern2 = [
                9 => ['A', 'E', 'F', 'K'],
                10 => ['C', 'D', 'G', 'H'],
                11 => ['A', 'E', 'F', 'K'],
                12 => ['C', 'D', 'G', 'H'],
                14 => ['A', 'E', 'F', 'K'],
                15 => ['C', 'D', 'G', 'H'],
                16 => ['A', 'E', 'F', 'K'],
            ];
        @endphp
        @foreach($staggeredPattern2 as $row => $cols)
            <div class="seat-row" style="text-align: center;">
                @foreach(array_slice($cols, 0, 2) as $col)
                    @php $seat = $seats["$row$col"] ?? null; @endphp
                    <div class="seat-card status-{{ $seat->status ?? 'no-data' }}">
                        <div class="seat-id">{{ $row }}{{ $col }}</div>
                        <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                    </div>
                @endforeach
                <div class="row-number">{{ $row }}</div>
                @foreach(array_slice($cols, 2, 2) as $col)
                    @php $seat = $seats["$row$col"] ?? null; @endphp
                    <div class="seat-card status-{{ $seat->status ?? 'no-data' }}">
                        <div class="seat-id">{{ $row }}{{ $col }}</div>
                        <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</section>

<!-- Economy Class - Rows 21-25 -->
<section class="cabin-section">
    <h2>Economy Class - Rows 21-25</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-3-3-3">
            <span class="col-label col-header">A</span>
            <span class="col-label col-header">B</span>
            <span class="col-label col-header">C</span>
            <span class="row-label"></span>
            <span class="col-label col-header">D</span>
            <span class="col-label col-header">F</span>
            <span class="col-label col-header">G</span>
            <span class="row-label"></span>
            <span class="col-label col-header">H</span>
            <span class="col-label col-header">J</span>
            <span class="col-label col-header">K</span>
        </div>
        @for($row = 21; $row <= 25; $row++)
            @if($row == 24) @continue @endif
            @php
                if ($row == 25)
                    $rowCols = ['D', 'F', 'G'];
                else
                    $rowCols = ['A', 'B', 'C', 'D', 'F', 'G', 'H', 'J', 'K'];
             @endphp
            <div class="seat-row grid-row-3-3-3" data-row="{{ $row }}">
                @foreach(['A', 'B', 'C'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => $rowCols, 'seats' => $seats])
                @endforeach
                <div class="row-number">{{ $row }}</div>
                @foreach(['D', 'F', 'G'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => $rowCols, 'seats' => $seats])
                @endforeach
                <div class="row-number">{{ $row }}</div>
                @foreach(['H', 'J', 'K'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => $rowCols, 'seats' => $seats])
                @endforeach
            </div>
        @endfor
    </div>
</section>

<!-- Attendant Door 3 -->
<section class="cabin-section">
    <h2>Attendant Door 3</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-2-2">
            <span class="col-label col-header">L</span>
            <span class="seat-placeholder"></span>
            <span class="row-label"></span>
            <span class="seat-placeholder"></span>
            <span class="col-label col-header">R</span>
        </div>
        <div class="seat-row grid-row-2-2">
            @php $seatId = 'att/d3-L';
                $seat = $seats[$seatId] ?? null;
            $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-id">D3-L</div>
                <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
            </div>
            <div class="seat-placeholder"></div>
            <div class="row-number">D3</div>
            <div class="seat-placeholder"></div>
            @php $seatId = 'att/d3-R';
                $seat = $seats[$seatId] ?? null;
            $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-id">D3-R</div>
                <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
            </div>
        </div>
    </div>
</section>

<!-- Economy Class - Rows 26-38 -->
<section class="cabin-section">
    <h2>Economy Class - Rows 26-38</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-3-3-3">
            <span class="col-label col-header">A</span>
            <span class="col-label col-header">B</span>
            <span class="col-label col-header">C</span>
            <span class="row-label"></span>
            <span class="col-label col-header">D</span>
            <span class="col-label col-header">F</span>
            <span class="col-label col-header">G</span>
            <span class="row-label"></span>
            <span class="col-label col-header">H</span>
            <span class="col-label col-header">J</span>
            <span class="col-label col-header">K</span>
        </div>
        @for($row = 26; $row <= 38; $row++)
            @php
                if ($row == 38)
                    $rowCols = ['A', 'B', 'C', 'H', 'J', 'K'];
                else
                    $rowCols = ['A', 'B', 'C', 'D', 'F', 'G', 'H', 'J', 'K'];
             @endphp
            <div class="seat-row grid-row-3-3-3" data-row="{{ $row }}">
                @foreach(['A', 'B', 'C'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => $rowCols, 'seats' => $seats])
                @endforeach
                <div class="row-number">{{ $row }}</div>
                @foreach(['D', 'F', 'G'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => $rowCols, 'seats' => $seats])
                @endforeach
                <div class="row-number">{{ $row }}</div>
                @foreach(['H', 'J', 'K'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => $rowCols, 'seats' => $seats])
                @endforeach
            </div>
        @endfor
    </div>
</section>

<!-- Attendant Door 4 -->
<section class="cabin-section">
    <h2>Attendant Door 4</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-2-2">
            <span class="col-label col-header">L</span>
            <span class="seat-placeholder"></span>
            <span class="row-label"></span>
            <span class="seat-placeholder"></span>
            <span class="col-label col-header">R</span>
        </div>
        <div class="seat-row grid-row-2-2">
            @php $seatId = 'att/d4-L';
                $seat = $seats[$seatId] ?? null;
            $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-id">D4-L</div>
                <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
            </div>
            <div class="seat-placeholder"></div>
            <div class="row-number">D4</div>
            <div class="seat-placeholder"></div>
            @php $seatId = 'att/d4-R';
                $seat = $seats[$seatId] ?? null;
            $status = $seat?->status ?? 'no-data'; @endphp
            <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                <div class="seat-id">D4-R</div>
                <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
            </div>
        </div>
    </div>
</section>

<!-- Economy Class - Rows 39-52 -->
<section class="cabin-section">
    <h2>Economy Class - Rows 39-52</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-3-3-3">
            <span class="col-label col-header">A</span>
            <span class="col-label col-header">B</span>
            <span class="col-label col-header">C</span>
            <span class="row-label"></span>
            <span class="col-label col-header">D</span>
            <span class="col-label col-header">F</span>
            <span class="col-label col-header">G</span>
            <span class="row-label"></span>
            <span class="col-label col-header">H</span>
            <span class="col-label col-header">J</span>
            <span class="col-label col-header">K</span>
        </div>
        @for($row = 39; $row <= 52; $row++)
            @php
                if ($row == 52)
                    $rowCols = ['A', 'C', 'D', 'F', 'G', 'H', 'K'];
                else
                    $rowCols = ['A', 'B', 'C', 'D', 'F', 'G', 'H', 'J', 'K'];
             @endphp
            <div class="seat-row grid-row-3-3-3" data-row="{{ $row }}">
                @foreach(['A', 'B', 'C'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => $rowCols, 'seats' => $seats])
                @endforeach
                <div class="row-number">{{ $row }}</div>
                @foreach(['D', 'F', 'G'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => $rowCols, 'seats' => $seats])
                @endforeach
                <div class="row-number">{{ $row }}</div>
                @foreach(['H', 'J', 'K'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => $rowCols, 'seats' => $seats])
                @endforeach
            </div>
        @endfor
    </div>
</section>

<!-- Attendant Door 5 -->
<section class="cabin-section">
    <h2>Attendant Door 5</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-3-3">
            <span class="col-label col-header">LL</span>
            <span class="col-label col-header">LC</span>
            <span class="col-label col-header">LR</span>
            <span class="row-label"></span>
            <span class="col-label col-header">RL</span>
            <span class="col-label col-header">RC</span>
            <span class="col-label col-header">RR</span>
        </div>
        <div class="seat-row grid-row-3-3">
            @foreach(['LL', 'LC', 'LR'] as $col)
                @php $seatId = 'att/d5-' . $col;
                    $seat = $seats[$seatId] ?? null;
                $status = $seat?->status ?? 'no-data'; @endphp
                <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                    <div class="seat-id">D5-{{ $col }}</div>
                    <div class="seat-date">{{ $seat?->expiry_date?->format('j M Y') ?? '-' }}</div>
                </div>
            @endforeach
            <div class="row-number">D5</div>
            @foreach(['RL', 'RC', 'RR'] as $col)
                @php $seatId = 'att/d5-' . $col;
                    $seat = $seats[$seatId] ?? null;
                $status = $seat?->status ?? 'no-data'; @endphp
                <div class="seat-card status-{{ $status }}" data-seat="{{ $seatId }}">
                    <div class="seat-id">D5-{{ $col }}</div>
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