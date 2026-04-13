@props(['registration' => null])

<!-- Toolbar Component -->
<div class="toolbar">
    <div class="toolbar-left">
        <button class="btn-jump-pn" id="btnSetDate" disabled>
            Set Date
        </button>
        <div class="divider"></div>
        <button class="btn-jump-secondary" id="btnClearSelection" style="border: none; background: transparent; padding-left: 0;">
             Clear Selection
        </button>
        <div class="divider"></div>
        <span class="selection-info" id="selectionInfo">No seats selected</span>
    </div>
    <div class="toolbar-right">
        <p class="toolbar-hint">Klik nomor baris atau huruf kolom untuk select cepat</p>
        @if($registration && Route::has('reports.pdf'))
            <div class="divider"></div>
            <a href="{{ route('reports.pdf', $registration) }}" target="_blank" class="btn-jump-danger">
                Export PDF
            </a>
        @endif
        @if($registration && Route::has('reports.blank'))
            <a href="{{ route('reports.blank', $registration) }}" target="_blank" class="btn-jump-secondary">
                Blank Form
            </a>
        @endif
        @if($registration && Route::has('aircraft.batchInput'))
            <a href="{{ route('aircraft.batchInput', $registration) }}" class="btn-jump-warning">
                Batch Input
            </a>
        @endif
    </div>
</div>