<?php

namespace App\Http\Controllers;

use App\Models\Seat;
use App\Models\Aircraft;
use App\Models\Airline;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
        // Load from Database (All status: active & prolong) with airline relationship
        $aircrafts = Aircraft::with('airline')->get();

        $fleet = [];
        $totalStats = [
            'safe' => 0,
            'warning' => 0,
            'critical' => 0,
            'expired' => 0,
            'no_data' => 0,
        ];

        foreach ($aircrafts as $aircraft) {
            $registration = $aircraft->registration;
            $seats = Seat::where('registration', $registration)->get();

            $stats = [
                'safe' => 0,
                'warning' => 0,
                'critical' => 0,
                'expired' => 0,
                'no_data' => 0,
            ];

            foreach ($seats as $seat) {
                $status = $seat->status;
                $key = $status === 'no-data' ? 'no_data' : $status;
                $stats[$key]++;
                $totalStats[$key]++;
            }

            $total = array_sum($stats) ?: 1;
            $healthPercent = round(($stats['safe'] / $total) * 100);

            $fleet[$registration] = [
                'type' => $aircraft->type,
                'registration' => $registration,
                'icon' => $aircraft->icon ?? '✈️',
                'status' => $aircraft->status,
                'stats' => $stats,
                'health' => $healthPercent,
                'airline_id' => $aircraft->airline_id,
                'airline_name' => $aircraft->airline?->name ?? 'Unknown',
                'airline_icon' => $aircraft->airline?->icon ?? '🏢',
            ];
        }

        // Get global last update time
        $lastUpdate = Seat::max('updated_at');

        // Get all airlines for grouping
        $airlines = Airline::all();

        // Group fleet by Airline -> then by Aircraft Type
        $fleetByAirline = [];
        foreach ($airlines as $airline) {
            $airlineFleet = collect($fleet)->filter(fn($a) => $a['airline_id'] === $airline->id);

            if ($airlineFleet->isEmpty()) {
                continue; // Skip airlines with no aircraft
            }

            // Group by aircraft type within this airline
            $byType = [];
            foreach ($airlineFleet as $registration => $aircraft) {
                // Extract base type (B737, B777, A330, ATR72)
                preg_match('/^([A-Z]+\d+)/', $aircraft['type'], $matches);
                $baseType = $matches[1] ?? $aircraft['type'];

                if (!isset($byType[$baseType])) {
                    $byType[$baseType] = [
                        'name' => $baseType . ' Fleet',
                        'icon' => $aircraft['icon'],
                        'aircraft' => [],
                    ];
                }
                $byType[$baseType]['aircraft'][$registration] = $aircraft;
            }

            $fleetByAirline[$airline->id] = [
                'name' => $airline->name,
                'icon' => $airline->icon,
                'code' => $airline->code,
                'types' => $byType,
                'aircraft_count' => $airlineFleet->count(),
            ];
        }

        return view('dashboard', [
            'fleet' => $fleet,
            'fleetByAirline' => $fleetByAirline,
            'totalStats' => $totalStats,
            'lastUpdate' => $lastUpdate ? \Carbon\Carbon::parse($lastUpdate) : null,
        ]);
    }
}
