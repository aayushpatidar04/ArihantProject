<?php

namespace App\Services;

use App\Models\EventRegistration;
use App\Models\Seat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SeatAllocationService
{
    /**
     * Allocate first available seat using pessimistic locking.
     */
    public function allocate(EventRegistration $registration): ?Seat
    {
        return DB::transaction(function () use ($registration) {
            $seat = Seat::where('status', 'available')
                ->lockForUpdate()
                ->orderBy('id')
                ->first();

            if (!$seat) {
                Log::warning('No seats available for registration ' . $registration->id);
                return null;
            }

            $seat->update([
                'status' => 'allocated',
                'event_registration_id' => $registration->id,
                'allocated_at' => now(),
            ]);

            $registration->update(['status' => 'checked_in', 'checked_in_at' => now()]);

            return $seat;
        });
    }

    /**
     * Pre-seed seats into the database.
     */
    public function seedSeats(int $total = 500): void
    {
        $sections = ['A'];
        $counts = ['A' => 1000];
        $seatNumber = 1;

        foreach ($sections as $section) {
            $rows = ceil($counts[$section] / 20);
            for ($r = 1; $r <= $rows; $r++) {
                for ($s = 1; $s <= 20 && $seatNumber <= $counts[$section]; $s++) {
                    Seat::create([
                        'seat_number' => $section . '-' . $r . '-' . $s,
                        'section' => $section,
                        'row' => $r,
                        'status' => 'available',
                    ]);
                    $seatNumber++;
                }
            }
            $seatNumber = 1;
        }
    }
}
