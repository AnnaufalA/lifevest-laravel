<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AircraftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Initial Aircraft Data
        $layouts = [
            // B737-800 Fleet
            'PK-GFD' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GFG' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GFI' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GFM' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GFP' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GMA' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GMF' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GMM' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GFF' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GFH' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GFR' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GFU' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GFW' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GFX' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GNA' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GNC' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GNE' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GNF' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GNM' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GNN' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GNQ' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GNR' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GMP' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GMU' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GMV' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GMW' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GMX' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GMY' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GFJ' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GFQ' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GNG' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GNH' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GUA' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GUC' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GUG' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GFS' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GMD' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GMC' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GMI' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GFV' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GUF' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GDC' => ['type' => 'B737 MAX 8', 'icon' => '✈️', 'layout' => 'b737-e46'],
            'PK-GUH' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e48'],
            'PK-GUI' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e48'],
            'PK-GUD' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e47'],
            'PK-GUE' => ['type' => 'B737-800', 'icon' => '✈️', 'layout' => 'b737-e47'],

            // B777
            'PK-GIA' => ['type' => 'B777-300', 'icon' => '🛫', 'layout' => 'b777-2class'],
            'PK-GIC' => ['type' => 'B777-300', 'icon' => '🛫', 'layout' => 'b777-2class'],
            'PK-GIH' => ['type' => 'B777-300', 'icon' => '🛫', 'layout' => 'b777-2class'],
            'PK-GII' => ['type' => 'B777-300', 'icon' => '🛫', 'layout' => 'b777-2class'],
            'PK-GIJ' => ['type' => 'B777-300', 'icon' => '🛫', 'layout' => 'b777-2class'],
            'PK-GIK' => ['type' => 'B777-300', 'icon' => '🛫', 'layout' => 'b777-2class'],
            'PK-GIF' => ['type' => 'B777-300', 'icon' => '🛫', 'layout' => 'b777-3class'],
            'PK-GIG' => ['type' => 'B777-300', 'icon' => '🛫', 'layout' => 'b777-3class'],

            // A330
            'PK-GHE' => ['type' => 'A330-900', 'icon' => '🛩️', 'layout' => 'a330-900a'],
            'PK-GHF' => ['type' => 'A330-900', 'icon' => '🛩️', 'layout' => 'a330-900a'],
            'PK-GHG' => ['type' => 'A330-900', 'icon' => '🛩️', 'layout' => 'a330-900a'],
            'PK-GHH' => ['type' => 'A330-900', 'icon' => '🛩️', 'layout' => 'a330-900b'],
            'PK-GHI' => ['type' => 'A330-900', 'icon' => '🛩️', 'layout' => 'a330-900b'],
            'PK-GPZ' => ['type' => 'A330-300', 'icon' => '🛩️', 'layout' => 'a330-300a'],
            'PK-GHA' => ['type' => 'A330-300', 'icon' => '🛩️', 'layout' => 'a330-300a'],
            'PK-GHC' => ['type' => 'A330-300', 'icon' => '🛩️', 'layout' => 'a330-300a'],
            'PK-GHD' => ['type' => 'A330-300', 'icon' => '🛩️', 'layout' => 'a330-300a'],
            'PK-GPU' => ['type' => 'A330-300', 'icon' => '🛩️', 'layout' => 'a330-300b'],
            'PK-GPV' => ['type' => 'A330-300', 'icon' => '🛩️', 'layout' => 'a330-300b'],
            'PK-GPW' => ['type' => 'A330-300', 'icon' => '🛩️', 'layout' => 'a330-300b'],
            'PK-GPY' => ['type' => 'A330-300', 'icon' => '🛩️', 'layout' => 'a330-300b'],
            'PK-GPR' => ['type' => 'A330-300', 'icon' => '🛩️', 'layout' => 'a330-300b'],
            'PK-GPT' => ['type' => 'A330-300', 'icon' => '🛩️', 'layout' => 'a330-300b'],
            'PK-GPX' => ['type' => 'A330-300', 'icon' => '🛩️', 'layout' => 'a330-300b'],
            'PK-GPC' => ['type' => 'A330-300', 'icon' => '🛩️', 'layout' => 'a330-300c'],
            'PK-GPG' => ['type' => 'A330-300', 'icon' => '🛩️', 'layout' => 'a330-300c'],
            'PK-GPE' => ['type' => 'A330-341', 'icon' => '🛩️', 'layout' => 'a330-300c'],
            'PK-GPF' => ['type' => 'A330-341', 'icon' => '🛩️', 'layout' => 'a330-300c'],
            'PK-GPA' => ['type' => 'A330-300', 'icon' => '📦', 'layout' => 'a330-300cargo'],
            'PK-GPD' => ['type' => 'A330-300', 'icon' => '📦', 'layout' => 'a330-300cargo'],
            'PK-GPO' => ['type' => 'A330-200', 'icon' => '🛩️', 'layout' => 'a330-200a'],
            'PK-GPM' => ['type' => 'A330-200', 'icon' => '🛩️', 'layout' => 'a330-200a'],
            'PK-GPQ' => ['type' => 'A330-200', 'icon' => '🛩️', 'layout' => 'a330-200b'],
            'PK-GPS' => ['type' => 'A330-200', 'icon' => '🛩️', 'layout' => 'a330-200b'],
            'PK-GPL' => ['type' => 'A330-200', 'icon' => '🛩️', 'layout' => 'a330-200b'],

            // ATR
            'PK-GAF' => ['type' => 'ATR72-600', 'icon' => '🛫', 'layout' => 'atr72'],
            'PK-GAI' => ['type' => 'ATR72-600', 'icon' => '🛫', 'layout' => 'atr72'],
            'PK-GAJ' => ['type' => 'ATR72-600', 'icon' => '🛫', 'layout' => 'atr72'],
        ];

        foreach ($layouts as $registration => $data) {
            \App\Models\Aircraft::updateOrCreate(
                ['registration' => $registration],
                [
                    'type' => $data['type'],
                    'icon' => $data['icon'],
                    'layout' => $data['layout'],
                    'status' => 'active', // Default all to active
                ]
            );
        }
    }
}
