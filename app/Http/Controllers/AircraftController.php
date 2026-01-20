<?php

namespace App\Http\Controllers;

use App\Models\Seat;
use Illuminate\Http\Request;

class AircraftController extends Controller
{
    /**
     * Show aircraft seat map
     */
    public function show(string $registration)
    {
        $layout = config("aircraft_layouts.{$registration}");

        if (!$layout) {
            abort(404, 'Aircraft not found');
        }

        // Get all seats for this registration
        $seats = Seat::where('registration', $registration)
            ->get()
            ->keyBy('seat_id');

        // Determine template based on aircraft type
        $template = match ($registration) {
            'PK-GFD' => 'aircraft.b737',
            'PK-GIA' => 'aircraft.b777-gia',
            'PK-GIF' => 'aircraft.b777-gif',
            'PK-GHE' => 'aircraft.a330',
            'PK-GPZ' => 'aircraft.a330-gpz',
            default => 'aircraft.show',
        };

        // Get last update time for this aircraft
        $lastUpdate = Seat::where('registration', $registration)->max('updated_at');

        return view($template, [
            'registration' => $registration,
            'layout' => $layout,
            'seats' => $seats,
            'lastUpdate' => $lastUpdate ? \Carbon\Carbon::parse($lastUpdate) : null,
        ]);
    }

    /**
     * Update seat expiry dates
     */
    public function updateSeats(Request $request, string $registration)
    {
        $request->validate([
            'seat_ids' => 'required|array',
            'seat_ids.*' => 'required|string',
            'expiry_date' => 'required|date',
        ]);

        $seatIds = $request->input('seat_ids');
        $expiryDate = $request->input('expiry_date');

        foreach ($seatIds as $seatId) {
            // Parse row and column from seat_id
            preg_match('/^(\d+)?(.+)$/', $seatId, $matches);
            $row = $matches[1] ?: null;
            $col = $matches[2] ?: $seatId;

            // Determine class type
            $classType = 'economy';
            if (in_array($seatId, ['captain', 'copilot', 'observer1', 'observer2'])) {
                $classType = 'cockpit';
            }

            Seat::updateOrCreate(
                [
                    'registration' => $registration,
                    'seat_id' => $seatId,
                ],
                [
                    'row' => $row,
                    'col' => $col,
                    'class_type' => $classType,
                    'expiry_date' => $expiryDate,
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => count($seatIds) . ' seat(s) updated',
        ]);
    }
}
