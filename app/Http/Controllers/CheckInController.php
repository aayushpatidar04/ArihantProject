<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use App\Models\QrCode;
use App\Services\SeatAllocationService;
use App\Services\WhatsAppService;
use App\Services\EmailService;
use App\Services\LeadScoringService;
use Illuminate\Http\Request;

class CheckInController extends Controller
{
    public function __construct(
        protected SeatAllocationService $seats,
        protected WhatsAppService $whatsapp,
        protected EmailService $email,
        protected LeadScoringService $leadScore,
    ) {
    }

    public function showVenueLogin()
    {
        return view('checkin.venue_login');
    }

    public function venueLogin(Request $request)
    {
        $request->validate(['pin' => 'required|string']);

        if ($request->pin === config('event.venue_pin')) {
            session(['venue_authenticated' => true]);
            return redirect()->route('checkin.scanner');
        }

        return back()->withErrors(['pin' => 'Invalid PIN']);
    }
    /**
     * Show scanner interface (for venue staff).
     */
    public function scanner()
    {
        return view('checkin.scanner');
    }

    /**
     * API: Validate QR and allocate seat.
     */
    public function validateQr(Request $request)
    {
        $request->validate(['code' => 'required|string|size:32']);
        $qr = QrCode::where('code', $request->code)
            ->where('purpose', 'entry')
            ->where('is_used', false)
            ->with('registration')
            ->first();

        if (!$qr) {
            return response()->json(['valid' => false, 'message' => 'Invalid or already used QR code.'], 404);
        }

        $reg = $qr->registration;
        if ($reg->status !== 'paid') {
            return response()->json(['valid' => false, 'message' => 'Payment not completed.'], 403);
        }

        return response()->json([
            'valid' => true,
            'registration_id' => $reg->id,
            'name' => $reg->full_name,
            'email' => $reg->email,
            'phone' => $reg->phone,
            'city' => $reg->city,
            'registration_number' => $reg->registration_number,
            'type' => $reg->type,
            'is_existing_client' => $reg->is_existing_client,
            'qr_code' => $qr->code,
            'message' => 'Participant found. Ready to allocate seat.',
        ]);
    }

    /**
     * Step 2: Actually allocate seat after staff confirmation.
     */
    public function allocateSeat(Request $request)
    {
        $request->validate(['code' => 'required|string|size:32']);

        $qr = QrCode::where('code', $request->code)
            ->where('purpose', 'entry')
            ->where('is_used', false)
            ->with('registration')
            ->first();

        if (!$qr) {
            return response()->json(['success' => false, 'message' => 'QR code already used or invalid.'], 404);
        }

        $reg = $qr->registration;
        if ($reg->status !== 'paid') {
            return response()->json(['success' => false, 'message' => 'Payment not completed.'], 403);
        }

        // Allocate seat
        $seat = $this->seats->allocate($reg);
        if (!$seat) {
            return response()->json(['success' => false, 'message' => 'No seats available.'], 200);
        }

        // Mark QR as used
        $qr->update(['is_used' => true, 'used_at' => now()]);

        // Send confirmations
        $this->whatsapp->sendSeatConfirmation($reg, $seat->seat_number);
        $this->email->sendSeatConfirmation($reg, $seat->seat_number);
        $this->leadScore->calculateScore($reg);

        return response()->json([
            'success' => true,
            'name' => $reg->full_name,
            'seat' => $seat->seat_number,
            'section' => $seat->section,
            'message' => 'Seat allocated successfully.',
        ]);
    }

    /**
     * Show mobile confirmation page (for participant).
     */
    public function mobileConfirmation(Request $request)
    {
        $request->validate(['reg' => 'required|string']);
        $reg = EventRegistration::where('registration_number', $request->reg)->firstOrFail();
        $seat = $reg->seat;
        return view('checkin.confirmation', compact('reg', 'seat'));
    }
}
