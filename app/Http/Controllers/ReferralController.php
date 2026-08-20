<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use App\Models\Referral;
use App\Services\LeadScoringService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $referrals = $reg->referralsMade()->with('referred')->latest()->get();
        $totalPoints = $referrals->sum('points_awarded');
        $leaderboard = EventRegistration::selectRaw('event_registrations.id, event_registrations.full_name, event_registrations.referral_code, SUM(referrals.points_awarded) as total_points')
            ->leftJoin('referrals', 'event_registrations.id', '=', 'referrals.referrer_id')
            ->groupBy('event_registrations.id')
            ->orderByDesc('total_points')
            ->limit(10)
            ->get();

        return view('referral.index', compact('reg', 'referrals', 'totalPoints', 'leaderboard'));
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

        Referral::create([
            'referrer_id' => $reg->id,
            'referred_email' => $request->email,
            'referred_phone' => $request->phone,
            'status' => 'invited',
        ]);

        // TODO: Send invite email/WhatsApp with referral link
        // link: route('registration.form') . '?ref=' . $reg->referral_code

        return back()->with('success', 'Invitation sent to ' . $request->email);
    }

    protected function getCurrentRegistration(): ?EventRegistration
    {
        if (!Auth::check()) return null;
        return EventRegistration::where('user_id', Auth::id())->latest()->first();
    }
}
