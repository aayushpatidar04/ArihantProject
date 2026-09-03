<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use App\Models\QrCode;
use Illuminate\Http\Request;

class CheckOutController extends Controller
{
    /**
     * Show checkout scanner interface (for venue staff).
     */
    public function scanner()
    {
        return view('checkout.scanner');
    }

    /**
     * API: Validate QR for checkout.
     */
    public function validateQr(Request $request)
    {
        $request->validate(['code' => 'required|string|size:32']);

        $qr = QrCode::where('code', $request->code)
            ->where('purpose', 'entry')
            ->with('registration')
            ->first();

        if (!$qr) {
            return response()->json(['valid' => false, 'message' => 'Invalid QR code.'], 404);
        }

        $reg = $qr->registration;

        // Must be checked in to check out
        if (!$reg->checked_in_at) {
            return response()->json([
                'valid' => false,
                'message' => 'This participant has not checked in yet.',
                'checked_in' => false,
            ], 403);
        }

        // Already checked out
        if ($reg->checked_out_at) {
            return response()->json([
                'valid' => false,
                'message' => 'This participant has already checked out.',
                'checked_in' => true,
                'checked_out' => true,
                'name' => $reg->full_name,
                'registration_number' => $reg->registration_number,
                'checked_out_at' => $reg->checked_out_at->format('M d, Y h:i A'),
            ], 200);
        }

        return response()->json([
            'valid' => true,
            'registration_id' => $reg->id,
            'name' => $reg->full_name,
            'email' => $reg->email,
            'phone' => $reg->phone,
            'registration_number' => $reg->registration_number,
            'checked_in_at' => $reg->checked_in_at->format('M d, Y h:i A'),
            'message' => 'Participant is checked in. Ready to check out.',
        ]);
    }

    /**
     * Process checkout — mark checked_out_at.
     */
    public function checkOut(Request $request)
    {
        $request->validate(['code' => 'required|string|size:32']);

        $qr = QrCode::where('code', $request->code)
            ->where('purpose', 'entry')
            ->with('registration')
            ->first();

        if (!$qr) {
            return response()->json(['success' => false, 'message' => 'Invalid QR code.'], 404);
        }

        $reg = $qr->registration;

        if (!$reg->checked_in_at) {
            return response()->json(['success' => false, 'message' => 'Participant has not checked in.'], 403);
        }

        if ($reg->checked_out_at) {
            return response()->json([
                'success' => false,
                'message' => 'Already checked out at ' . $reg->checked_out_at->format('M d, Y h:i A') . '.',
            ], 200);
        }

        $reg->update(['checked_out_at' => now()]);

        return response()->json([
            'success' => true,
            'name' => $reg->full_name,
            'registration_number' => $reg->registration_number,
            'checked_out_at' => $reg->checked_out_at->format('M d, Y h:i A'),
            'message' => 'Checkout successful.',
        ]);
    }
}
