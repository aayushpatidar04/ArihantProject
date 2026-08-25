<?php

namespace App\Http\Controllers;

use App\Mail\ReferralInviteMail;
use App\Models\EventRegistration;
use App\Models\Referral;
use App\Services\LeadScoringService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ReferralController extends Controller
{
    public function __construct(protected LeadScoringService $leadScore) {}

    /**
     * Show referral page with user's code and stats.
     */
    public function index()
    {
        $reg = $this->getCurrentRegistration();
        if (!$reg) {
            return redirect()->route('registration.form');
        }

        // Paginated list of your referrals
        $referrals = $reg->referralsMade()->with('referred')->latest()->paginate(10);

        // Stats (independent of pagination)
        $totalInvited = $reg->referralsMade()->count();
        $totalConverted = $reg->referralsMade()->where('status', 'paid')->count();
        $totalPoints = $reg->referralsMade()->sum('points_awarded');

        return view('referral.index', compact('reg', 'referrals', 'totalInvited', 'totalConverted', 'totalPoints'));
    }

    /**
     * Send referral invitation.
     */
    public function invite(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $reg = $this->getCurrentRegistration();
        if (!$reg) {
            return redirect()->route('registration.form');
        }

        $email = Str::lower(trim($request->email));
        $phone = $request->filled('phone')
            ? preg_replace('/\D+/', '', $request->phone)
            : null;

        $alreadyReferred = Referral::where('referred_email', $email)
            ->orWhere(function ($query) use ($phone) {
                $query->whereNotNull('referred_phone')
                    ->where('referred_phone', $phone);
            })
            ->exists();

        if ($alreadyReferred) {
            return back()->with('success', 'This person has already been referred. The original referrer was retained.');
        }

        Referral::create([
            'referrer_id' => $reg->id,
            'referred_email' => $email,
            'referred_phone' => $phone,
            'status' => 'invited',
        ]);

        // Send invite email
        try {
            $referralLink = route('registration.form', ['ref' => $reg->referral_code]);
            Mail::to($email)->send(new ReferralInviteMail($reg, $request->name, $referralLink));
        } catch (\Exception $e) {
            Log::error('Referral invite email failed: ' . $e->getMessage(), [
                'referrer_id' => $reg->id,
                'referred_email' => $email,
            ]);
        }

        return back()->with('success', 'Invitation sent to ' . $request->email);
    }

    protected function getCurrentRegistration(): ?EventRegistration
    {
        if (!Auth::check()) return null;
        return EventRegistration::where('user_id', Auth::id())->latest()->first();
    }
}
