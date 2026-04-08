<?php

namespace App\Http\Controllers;

use App\Models\Aircraft;
use App\Models\Seat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ExcelReportController extends Controller
{
    // --- Shared Colors ---
    private string $colorHeader    = 'FF1A237E';
    private string $colorSubHeader = 'FF283593';
    private string $colorExpired   = 'FFE1BEE7';
    private string $colorCritical  = 'FFFFCDD2';
    private string $colorWarning   = 'FFFFF9C4';
    private string $colorSafe      = 'FFC8E6C9';
    private string $colorWhite     = 'FFFFFFFF';
    private string $colorLightGray = 'FFF5F5F5';

    /**
     * Export Replacement Plan to Excel
     * 1 button → multiple sheet tabs (1 per month + Summary tab)
     */
    public function exportReplacementPlan()
    {
        $today = now()->startOfDay();
        $sixMonthsAhead = $today->copy()->addMonths(6)->endOfMonth();
        $threeMonthsBoundary = $today->copy()->addMonths(3);

        $aircrafts = Aircraft::with('airline')->get();

        // ============================================================
        // Collect all seats, grouped by month
        // ============================================================
        $monthlyData = []; // monthKey => [rows]
        $allRows = [];

        foreach ($aircrafts as $aircraft) {
            $reg = $aircraft->registration;
            $acType = $aircraft->type;
            $airlineName = $aircraft->airline?->name ?? 'Unknown';

            $pnMap = [
                'adult'  => ['pn' => $aircraft->pn_adult,  'types' => ['business', 'economy', 'first', 'spare-pax']],
                'crew'   => ['pn' => $aircraft->pn_crew,   'types' => ['cockpit', 'attendant']],
                'infant' => ['pn' => $aircraft->pn_infant, 'types' => ['spare-inf']],
            ];

            $seats = Seat::where('registration', $reg)
                ->whereNotNull('expiry_date')
                ->orderBy('expiry_date', 'asc')
                ->get();

            foreach ($seats as $seat) {
                $expiryDate = Carbon::parse($seat->expiry_date);

                if ($expiryDate->gt($sixMonthsAhead)) {
                    continue;
                }

                // Determine P/N
                $seatPn = null;
                $seatCategory = null;
                foreach ($pnMap as $category => $info) {
                    if (in_array($seat->class_type, $info['types'])) {
                        $seatPn = $info['pn'] ?: null;
                        $seatCategory = $category;
                        break;
                    }
                }
                // Skip if no PN or unknown class_type (same as DashboardController)
                if (!$seatPn || !$seatCategory) {
                    continue;
                }

                // Determine status
                $daysRemaining = $today->diffInDays($expiryDate, false);
                if ($daysRemaining < 0) {
                    $status = 'EXPIRED';
                } elseif ($daysRemaining < 90) {
                    $status = 'CRITICAL';
                } elseif ($daysRemaining < 180) {
                    $status = 'WARNING';
                } else {
                    $status = 'SAFE';
                }

                // Determine month key & label
                if ($expiryDate->lt($today)) {
                    $monthKey = '0000-00-Overdue';
                    $monthLabel = 'Overdue';
                    $monthShort = 'Overdue';
                } else {
                    $monthKey = $expiryDate->format('Y-m');
                    $monthLabel = $expiryDate->format('F Y');
                    $monthShort = $expiryDate->format('M Y');
                }

                $rowData = [
                    'airline'    => $airlineName,
                    'reg'        => $reg,
                    'type'       => $acType,
                    'seat_id'    => $seat->seat_id,
                    'class_type' => strtoupper($seat->class_type),
                    'pn'         => $seatPn,
                    'category'   => strtoupper($seatCategory),
                    'expiry'     => $expiryDate->format('d-M-Y'),
                    'expiry_raw' => $expiryDate,
                    'days'       => (int) $daysRemaining,
                    'status'     => $status,
                    'month_key'  => $monthKey,
                    'month_label' => $monthLabel,
                    'month_short' => $monthShort,
                ];

                $allRows[] = $rowData;

                if (!isset($monthlyData[$monthKey])) {
                    $monthlyData[$monthKey] = [
                        'label' => $monthLabel,
                        'short' => $monthShort,
                        'rows'  => [],
                    ];
                }
                $monthlyData[$monthKey]['rows'][] = $rowData;
            }
        }

        // Sort month keys chronologically
        ksort($monthlyData);

        // Sort rows within each month by expiry date
        foreach ($monthlyData as &$mData) {
            usort($mData['rows'], fn($a, $b) => $a['expiry_raw'] <=> $b['expiry_raw']);
        }
        unset($mData);

        // ============================================================
        // Build Excel Workbook
        // ============================================================
        $spreadsheet = new Spreadsheet();
        $spreadsheet->removeSheetByIndex(0); // Remove default empty sheet

        // --- Sheet 1: Summary ---
        $this->buildSummarySheet($spreadsheet, $allRows, $monthlyData, $today, $threeMonthsBoundary);

        // --- Sheet per month ---
        foreach ($monthlyData as $monthKey => $mData) {
            $this->buildMonthSheet($spreadsheet, $monthKey, $mData, $today, $threeMonthsBoundary);
        }

        // Activate first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // ============================================================
        // Output
        // ============================================================
        $filename = 'Replacement_Plan_' . date('Y-m-d_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Sheet 1: Summary overview with monthly breakdown table
     */
    private function buildSummarySheet(Spreadsheet $spreadsheet, array $allRows, array $monthlyData, Carbon $today, Carbon $threeMonthsBoundary): void
    {
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Summary');

        // --- Title ---
        $sheet->mergeCells('A1:H1');
        $sheet->setCellValue('A1', 'LIFE VEST REPLACEMENT PLAN — GMF AeroAsia');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16, 'color' => ['argb' => $this->colorWhite]],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $this->colorHeader]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(40);

        $sheet->mergeCells('A2:H2');
        $sheet->setCellValue('A2', 'Generated: ' . now()->format('d M Y, H:i') . ' | Coverage: Overdue + 6 months ahead');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['italic' => true, 'size' => 10, 'color' => ['argb' => $this->colorWhite]],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $this->colorSubHeader]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(22);

        // --- Status Summary ---
        $row = 4;
        $sheet->setCellValue("A{$row}", 'STATUS SUMMARY');
        $sheet->getStyle("A{$row}")->getFont()->setBold(true)->setSize(12);
        $row++;

        $expiredCount  = count(array_filter($allRows, fn($r) => $r['status'] === 'EXPIRED'));
        $criticalCount = count(array_filter($allRows, fn($r) => $r['status'] === 'CRITICAL'));
        $warningCount  = count(array_filter($allRows, fn($r) => $r['status'] === 'WARNING'));
        $totalCount    = count($allRows);

        $summaryItems = [
            ['Total Life Vests Needing Attention', $totalCount, $this->colorLightGray],
            ['Expired (Past due)', $expiredCount, $this->colorExpired],
            ['Critical (< 3 months)', $criticalCount, $this->colorCritical],
            ['Warning (3-6 months)', $warningCount, $this->colorWarning],
        ];

        foreach ($summaryItems as $item) {
            $sheet->setCellValue("A{$row}", $item[0]);
            $sheet->setCellValue("C{$row}", $item[1]);
            $sheet->getStyle("A{$row}:C{$row}")->applyFromArray([
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $item[2]]],
                'borders' => ['bottom' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFE0E0E0']]],
            ]);
            $sheet->getStyle("C{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $row++;
        }

        // --- Monthly Breakdown Table ---
        $row += 2;
        $sheet->setCellValue("A{$row}", 'MONTHLY BREAKDOWN');
        $sheet->getStyle("A{$row}")->getFont()->setBold(true)->setSize(12);
        $row++;

        // Table header
        $monthHeaders = ['Month', 'Status', 'Total Vests', 'Adult', 'Crew', 'Infant', 'Aircraft Count', 'Sheet Tab'];
        $colWidths = [18, 12, 13, 10, 10, 10, 15, 18];
        foreach ($monthHeaders as $i => $h) {
            $col = chr(65 + $i);
            $sheet->setCellValue("{$col}{$row}", $h);
            $sheet->getColumnDimension($col)->setWidth($colWidths[$i]);
        }
        $sheet->getStyle("A{$row}:H{$row}")->applyFromArray([
            'font' => ['bold' => true, 'color' => ['argb' => $this->colorWhite], 'size' => 10],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $this->colorHeader]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF424242']]],
        ]);
        $sheet->getRowDimension($row)->setRowHeight(25);
        $row++;

        $grandTotal = 0;
        $grandAdult = 0;
        $grandCrew = 0;
        $grandInfant = 0;

        $sheetIndex = 1; // Sheet index for hyperlinks (0 = Summary)

        foreach ($monthlyData as $monthKey => $mData) {
            $rows = $mData['rows'];
            $total = count($rows);
            $adult  = count(array_filter($rows, fn($r) => $r['category'] === 'ADULT'));
            $crew   = count(array_filter($rows, fn($r) => $r['category'] === 'CREW'));
            $infant = count(array_filter($rows, fn($r) => $r['category'] === 'INFANT'));
            $acCount = count(array_unique(array_column($rows, 'reg')));

            // Determine urgency
            if ($monthKey === '0000-00-Overdue') {
                $urgency = 'OVERDUE';
                $bgColor = $this->colorExpired;
            } else {
                $monthDate = Carbon::createFromFormat('Y-m', $monthKey)->startOfMonth();
                if ($monthDate->lt($threeMonthsBoundary)) {
                    $urgency = 'CRITICAL';
                    $bgColor = $this->colorCritical;
                } else {
                    $urgency = 'WARNING';
                    $bgColor = $this->colorWarning;
                }
            }

            $tabName = $this->getSheetName($monthKey, $mData['label']);

            $sheet->setCellValue("A{$row}", $mData['label']);
            $sheet->setCellValue("B{$row}", $urgency);
            $sheet->setCellValue("C{$row}", $total);
            $sheet->setCellValue("D{$row}", $adult);
            $sheet->setCellValue("E{$row}", $crew);
            $sheet->setCellValue("F{$row}", $infant);
            $sheet->setCellValue("G{$row}", $acCount);
            $sheet->setCellValue("H{$row}", '→ ' . $tabName);

            // Hyperlink to the month sheet tab
            $sheet->getCell("H{$row}")->getHyperlink()->setUrl("sheet://'{$tabName}'!A1");
            $sheet->getStyle("H{$row}")->applyFromArray([
                'font' => ['color' => ['argb' => 'FF1565C0'], 'underline' => true],
            ]);

            $sheet->getStyle("A{$row}:H{$row}")->applyFromArray([
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $bgColor]],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFE0E0E0']]],
            ]);

            foreach (['B', 'C', 'D', 'E', 'F', 'G'] as $cl) {
                $sheet->getStyle("{$cl}{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }

            // Bold + colored status
            $urgencyColor = match ($urgency) {
                'OVERDUE'  => 'FF7B1FA2',
                'CRITICAL' => 'FFC62828',
                'WARNING'  => 'FFF57F17',
                default    => 'FF000000',
            };
            $sheet->getStyle("B{$row}")->getFont()->setBold(true);
            $sheet->getStyle("B{$row}")->getFont()->getColor()->setARGB($urgencyColor);

            $grandTotal += $total;
            $grandAdult += $adult;
            $grandCrew  += $crew;
            $grandInfant += $infant;

            $sheetIndex++;
            $row++;
        }

        // Grand total
        $sheet->setCellValue("A{$row}", 'GRAND TOTAL');
        $sheet->setCellValue("C{$row}", $grandTotal);
        $sheet->setCellValue("D{$row}", $grandAdult);
        $sheet->setCellValue("E{$row}", $grandCrew);
        $sheet->setCellValue("F{$row}", $grandInfant);

        $sheet->getStyle("A{$row}:H{$row}")->applyFromArray([
            'font' => ['bold' => true, 'size' => 11],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFE3F2FD']],
            'borders' => [
                'top'    => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['argb' => $this->colorHeader]],
                'bottom' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['argb' => $this->colorHeader]],
            ],
        ]);
        foreach (['C', 'D', 'E', 'F'] as $cl) {
            $sheet->getStyle("{$cl}{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }
        $sheet->getRowDimension($row)->setRowHeight(25);

        // --- Legend ---
        $row += 2;
        $sheet->setCellValue("A{$row}", 'Legend:');
        $sheet->getStyle("A{$row}")->getFont()->setBold(true);
        $row++;
        $legends = [
            ['OVERDUE / EXPIRED', 'Life vest sudah melewati tanggal kadaluarsa', $this->colorExpired],
            ['CRITICAL', 'Life vest tersisa < 3 bulan', $this->colorCritical],
            ['WARNING', 'Life vest tersisa 3-6 bulan', $this->colorWarning],
        ];
        foreach ($legends as $legend) {
            $sheet->setCellValue("A{$row}", $legend[0]);
            $sheet->setCellValue("C{$row}", $legend[1]);
            $sheet->getStyle("A{$row}:B{$row}")->applyFromArray([
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $legend[2]]],
                'font' => ['bold' => true],
            ]);
            $row++;
        }

        // Freeze pane
        $sheet->freezePane('A3');
    }

    /**
     * Build a sheet for a specific month
     */
    private function buildMonthSheet(Spreadsheet $spreadsheet, string $monthKey, array $mData, Carbon $today, Carbon $threeMonthsBoundary): void
    {
        $sheet = $spreadsheet->createSheet();
        $tabName = $this->getSheetName($monthKey, $mData['label']);
        $sheet->setTitle($tabName);

        $rows = $mData['rows'];
        $total = count($rows);

        // Determine urgency & colors
        if ($monthKey === '0000-00-Overdue') {
            $urgency = 'OVERDUE';
            $headerColor = 'FF7B1FA2'; // Purple
            $accentColor = $this->colorExpired;
        } else {
            $monthDate = Carbon::createFromFormat('Y-m', $monthKey)->startOfMonth();
            if ($monthDate->lt($threeMonthsBoundary)) {
                $urgency = 'CRITICAL';
                $headerColor = 'FFC62828'; // Red
                $accentColor = $this->colorCritical;
            } else {
                $urgency = 'WARNING';
                $headerColor = 'FFF57F17'; // Yellow
                $accentColor = $this->colorWarning;
            }
        }

        // --- Title ---
        $sheet->mergeCells('A1:K1');
        $sheet->setCellValue('A1', strtoupper($mData['label']) . ' — REPLACEMENT PLAN');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14, 'color' => ['argb' => $this->colorWhite]],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $headerColor]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(35);

        // --- Sub-header: stats ---
        $adultCount  = count(array_filter($rows, fn($r) => $r['category'] === 'ADULT'));
        $crewCount   = count(array_filter($rows, fn($r) => $r['category'] === 'CREW'));
        $infantCount = count(array_filter($rows, fn($r) => $r['category'] === 'INFANT'));
        $acCount = count(array_unique(array_column($rows, 'reg')));
        $pnCount = count(array_unique(array_column($rows, 'pn')));

        $sheet->mergeCells('A2:K2');
        $sheet->setCellValue('A2', "Status: {$urgency} | Total: {$total} vests | Adult: {$adultCount} | Crew: {$crewCount} | Infant: {$infantCount} | P/N: {$pnCount} | Aircraft: {$acCount}");
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['italic' => true, 'size' => 10, 'color' => ['argb' => $this->colorWhite]],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $this->colorSubHeader]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(22);

        // --- Column headers ---
        $headerRow = 4;
        $headers = ['No', 'Airline', 'Registration', 'Aircraft Type', 'Seat ID', 'Class', 'Part Number', 'Category', 'Expiry Date', 'Days Remaining', 'Status'];
        $colWidths = [6, 20, 14, 14, 10, 14, 18, 10, 14, 16, 12];

        foreach ($headers as $i => $h) {
            $col = chr(65 + $i);
            $sheet->setCellValue("{$col}{$headerRow}", $h);
            $sheet->getColumnDimension($col)->setWidth($colWidths[$i]);
        }

        $sheet->getStyle("A{$headerRow}:K{$headerRow}")->applyFromArray([
            'font' => ['bold' => true, 'color' => ['argb' => $this->colorWhite], 'size' => 10],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $this->colorHeader]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF424242']]],
        ]);
        $sheet->getRowDimension($headerRow)->setRowHeight(25);

        // --- Data rows ---
        $row = $headerRow + 1;
        foreach ($rows as $idx => $data) {
            $sheet->setCellValue("A{$row}", $idx + 1);
            $sheet->setCellValue("B{$row}", $data['airline']);
            $sheet->setCellValue("C{$row}", $data['reg']);
            $sheet->setCellValue("D{$row}", $data['type']);
            $sheet->setCellValue("E{$row}", $data['seat_id']);
            $sheet->setCellValue("F{$row}", $data['class_type']);
            $sheet->setCellValue("G{$row}", $data['pn']);
            $sheet->setCellValue("H{$row}", $data['category']);
            $sheet->setCellValue("I{$row}", $data['expiry']);
            $sheet->setCellValue("J{$row}", $data['days']);
            $sheet->setCellValue("K{$row}", $data['status']);

            // Row color based on status
            $bgColor = match ($data['status']) {
                'EXPIRED'  => $this->colorExpired,
                'CRITICAL' => $this->colorCritical,
                'WARNING'  => $this->colorWarning,
                'SAFE'     => $this->colorSafe,
                default    => $this->colorLightGray,
            };

            $sheet->getStyle("A{$row}:K{$row}")->applyFromArray([
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $bgColor]],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFE0E0E0']]],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
            ]);

            // Center-align specific columns
            foreach (['A', 'E', 'H', 'J', 'K'] as $cl) {
                $sheet->getStyle("{$cl}{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }

            // Bold + colored status text
            $statusFontColor = match ($data['status']) {
                'EXPIRED'  => 'FF7B1FA2',
                'CRITICAL' => 'FFC62828',
                'WARNING'  => 'FFF57F17',
                'SAFE'     => 'FF2E7D32',
                default    => 'FF000000',
            };
            $sheet->getStyle("K{$row}")->getFont()->setBold(true);
            $sheet->getStyle("K{$row}")->getFont()->getColor()->setARGB($statusFontColor);

            $row++;
        }

        $lastDataRow = $row - 1;

        // --- P/N Summary at bottom of each sheet ---
        $row += 2;
        $sheet->setCellValue("A{$row}", 'P/N SUMMARY — ' . strtoupper($mData['label']));
        $sheet->mergeCells("A{$row}:E{$row}");
        $sheet->getStyle("A{$row}")->applyFromArray([
            'font' => ['bold' => true, 'size' => 11, 'color' => ['argb' => $this->colorWhite]],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $this->colorSubHeader]],
        ]);
        $sheet->getRowDimension($row)->setRowHeight(25);
        $row++;

        // P/N summary headers
        $pnHeaders = ['Part Number', 'Category', 'Qty', 'Aircraft Count', 'Aircraft List'];
        foreach ($pnHeaders as $i => $h) {
            $sheet->setCellValue(chr(65 + $i) . $row, $h);
        }
        $sheet->getStyle("A{$row}:E{$row}")->applyFromArray([
            'font' => ['bold' => true, 'color' => ['argb' => $this->colorWhite]],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $this->colorHeader]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ]);
        $row++;

        // Group by P/N
        $pnGroups = [];
        foreach ($rows as $r) {
            $key = $r['pn'] . '|' . $r['category'];
            if (!isset($pnGroups[$key])) {
                $pnGroups[$key] = ['pn' => $r['pn'], 'category' => $r['category'], 'count' => 0, 'aircraft' => []];
            }
            $pnGroups[$key]['count']++;
            $pnGroups[$key]['aircraft'][$r['reg']] = ($pnGroups[$key]['aircraft'][$r['reg']] ?? 0) + 1;
        }

        foreach ($pnGroups as $pg) {
            $acList = collect($pg['aircraft'])->map(fn($cnt, $reg) => "{$reg}({$cnt})")->implode(', ');

            $sheet->setCellValue("A{$row}", $pg['pn']);
            $sheet->setCellValue("B{$row}", $pg['category']);
            $sheet->setCellValue("C{$row}", $pg['count']);
            $sheet->setCellValue("D{$row}", count($pg['aircraft']));
            $sheet->setCellValue("E{$row}", $acList);

            $sheet->getStyle("A{$row}:E{$row}")->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFE0E0E0']]],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $accentColor]],
            ]);
            foreach (['B', 'C', 'D'] as $cl) {
                $sheet->getStyle("{$cl}{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }

            $row++;
        }

        // Auto-filter on data columns
        $sheet->setAutoFilter("A{$headerRow}:K{$lastDataRow}");

        // Freeze pane
        $sheet->freezePane("A" . ($headerRow + 1));

        // Back to Summary link
        $row += 1;
        $sheet->setCellValue("A{$row}", '← Back to Summary');
        $sheet->getCell("A{$row}")->getHyperlink()->setUrl("sheet://'Summary'!A1");
        $sheet->getStyle("A{$row}")->applyFromArray([
            'font' => ['color' => ['argb' => 'FF1565C0'], 'underline' => true, 'bold' => true],
        ]);
    }

    /**
     * Generate valid sheet name (max 31 chars, no special chars)
     */
    private function getSheetName(string $monthKey, string $label): string
    {
        if ($monthKey === '0000-00-Overdue') {
            return 'Overdue';
        }

        // Use short format like "Apr 2026"
        $date = Carbon::createFromFormat('Y-m', $monthKey);
        $name = $date->format('M Y');

        // Excel sheet names max 31 chars, remove invalid chars
        $name = str_replace(['\\', '/', '*', '?', '[', ']', ':'], '', $name);
        return substr($name, 0, 31);
    }
}
