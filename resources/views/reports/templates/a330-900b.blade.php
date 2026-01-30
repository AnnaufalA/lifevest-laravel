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

<!-- Economy Premium - Rows 21-27 -->
<section class="cabin-section">
    <h2>Economy Premium - Rows 21-27</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-2-3-2">
            <span class="col-label col-header">A</span>
            <span class="col-label col-header">C</span>
            <span class="row-label"></span>
            <span class="col-label col-header">D</span>
            <span class="col-label col-header">F</span>
            <span class="col-label col-header">G</span>
            <span class="row-label"></span>
            <span class="col-label col-header">H</span>
            <span class="col-label col-header">K</span>
        </div>
        @foreach(range(21, 27) as $row)
            @if($row == 24) @continue @endif
            @php $rowCols = ['A', 'C', 'D', 'F', 'G', 'H', 'K']; @endphp
            <div class="seat-row grid-row-2-3-2" data-row="{{ $row }}">
                @foreach(['A', 'C'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => $rowCols, 'seats' => $seats])
                @endforeach
                <div class="row-number">{{ $row }}</div>
                @foreach(['D', 'F', 'G'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => $rowCols, 'seats' => $seats])
                @endforeach
                <div class="row-number">{{ $row }}</div>
                @foreach(['H', 'K'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => $rowCols, 'seats' => $seats])
                @endforeach
            </div>
        @endforeach
    </div>
</section>

<!-- Economy Class - Rows 28-51 -->
<section class="cabin-section">
    <h2>Economy Class - Rows 28-51</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-2-4-2">
            <span class="col-label col-header">A</span>
            <span class="col-label col-header">C</span>
            <span class="row-label"></span>
            <span class="col-label col-header">D</span>
            <span class="col-label col-header">E</span>
            <span class="col-label col-header">F</span>
            <span class="col-label col-header">G</span>
            <span class="row-label"></span>
            <span class="col-label col-header">H</span>
            <span class="col-label col-header">K</span>
        </div>
        @foreach(range(28, 51) as $row)
            @php $rowCols = ($row == 31) ? ['D', 'E', 'F', 'G'] : ['A', 'C', 'D', 'E', 'F', 'G', 'H', 'K']; @endphp
            <div class="seat-row grid-row-2-4-2" data-row="{{ $row }}">
                @foreach(['A', 'C'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => $rowCols, 'seats' => $seats])
                @endforeach
                <div class="row-number">{{ $row }}</div>
                @foreach(['D', 'E', 'F', 'G'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => $rowCols, 'seats' => $seats])
                @endforeach
                <div class="row-number">{{ $row }}</div>
                @foreach(['H', 'K'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => $rowCols, 'seats' => $seats])
                @endforeach
            </div>
        @endforeach
    </div>
</section>

<!-- Economy Class - Rows 52-69 -->
<section class="cabin-section">
    <h2>Economy Class - Rows 52-69</h2>
    <div class="seat-grid">
        <div class="grid-header grid-row-2-4-2">
            <span class="col-label col-header">A</span>
            <span class="col-label col-header">C</span>
            <span class="row-label"></span>
            <span class="col-label col-header">D</span>
            <span class="col-label col-header">E</span>
            <span class="col-label col-header">F</span>
            <span class="col-label col-header">G</span>
            <span class="row-label"></span>
            <span class="col-label col-header">H</span>
            <span class="col-label col-header">K</span>
        </div>
        @foreach(range(52, 69) as $row)
            @php
                if ($row >= 65 && $row <= 68)
                    $rowCols = ['A', 'C', 'D', 'F', 'G', 'H', 'K'];
                elseif ($row == 69)
                    $rowCols = ['D', 'F', 'G'];
                else
                    $rowCols = ['A', 'C', 'D', 'E', 'F', 'G', 'H', 'K'];
             @endphp
            <div class="seat-row grid-row-2-4-2" data-row="{{ $row }}">
                @foreach(['A', 'C'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => $rowCols, 'seats' => $seats])
                @endforeach
                <div class="row-number">{{ $row }}</div>
                @foreach(['D', 'E', 'F', 'G'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => $rowCols, 'seats' => $seats])
                @endforeach
                <div class="row-number">{{ $row }}</div>
                @foreach(['H', 'K'] as $col)
                    @include('components.seat-cell', ['row' => $row, 'col' => $col, 'rowCols' => $rowCols, 'seats' => $seats])
                @endforeach
            </div>
        @endforeach
    </div>
</section>

<!-- Note: Original 900b view had no Attendant or Spare sections. Adding Spare just in case. -->
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