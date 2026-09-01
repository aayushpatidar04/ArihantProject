<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use App\Models\User;
use App\Models\StallVisit;
use App\Models\Referral;
use App\Models\InfluencerPost;
use App\Models\Seat;
use App\Models\Payment;
use App\Models\Communication;
use App\Services\EmailService;
use App\Services\LeadScoringService;
use App\Services\QrCodeService;
use App\Services\SmsService;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function __construct(
        protected QrCodeService $qr,
        protected WhatsAppService $whatsapp,
        protected SmsService $sms,
        protected EmailService $email,
        protected LeadScoringService $leadScore,
    ) {
    }

    public function dashboard()
    {
        $stats = [
            'total_registrations' => EventRegistration::count(),
            'registrations_subbrokers' => EventRegistration::where('is_subbroker', true)->count(),
            'registrations_existing_clients' => EventRegistration::where('is_existing_client', true)->where('is_subbroker', false)->count(),
            'registrations_non_clients' => EventRegistration::where('is_existing_client', false)->where('is_subbroker', false)->count(),

            'paid_registrations' => EventRegistration::where('status', 'paid')->orWhere('status', 'checked_in')->count(),
            'paid_subbrokers' => EventRegistration::whereIn('status', ['paid', 'checked_in'])->where('is_subbroker', true)->count(),
            'paid_existing_clients' => EventRegistration::whereIn('status', ['paid', 'checked_in'])->where('is_existing_client', true)->where('is_subbroker', false)->count(),
            'paid_non_clients' => EventRegistration::whereIn('status', ['paid', 'checked_in'])->where('is_existing_client', false)->where('is_subbroker', false)->count(),

            'checked_in' => EventRegistration::where('status', 'checked_in')->count(),
            'total_seats' => Seat::count(),
            'allocated_seats' => Seat::where('status', 'allocated')->count(),
            'total_stall_visits' => StallVisit::count(),

            'total_referrals' => Referral::count(),
            'referrals_invited' => Referral::where('status', 'invited')->count(),
            'referrals_registered' => Referral::where('status', 'registered')->count(),
            'referrals_paid' => Referral::where('status', 'paid')->count(),

            'pending_posts' => InfluencerPost::where('status', 'pending')->count(),
        ];

        $recentRegistrations = EventRegistration::with('payment')->latest()->limit(10)->get();
        $topReferrers = $this->getTopReferrers();
        $topInfluencers = $this->getTopInfluencers();
        $stallStats = $this->getStallStats();

        return view('admin.dashboard', compact('stats', 'recentRegistrations', 'topReferrers', 'topInfluencers', 'stallStats'));
    }

    public function registrations(Request $request)
    {
        $query = EventRegistration::with(['user', 'payment', 'kyc', 'seat'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('registration_number', 'like', "%{$search}%");
            });
        }

        $registrations = $query->paginate(50);
        return view('admin.registrations', compact('registrations'));
    }

    public function markAsPaid(Request $request)
    {
        $validated = $request->validate([
            'registration_id' => 'required|exists:event_registrations,id',
            'gateway_payment_id' => 'nullable|string|max:255',
            'payment_mode' => 'nullable|string|max:100',
            'referral_code' => 'nullable|string|size:12',
            'note' => 'nullable|string|max:500',
        ]);

        $reg = EventRegistration::with([
            'payment',
            'qrCodes',
        ])->findOrFail($validated['registration_id']);

        if ($reg->status === 'paid') {
            return back()->with(
                'info',
                'Registration is already marked as paid.'
            );
        }

        $isFreeGiveaway = empty($validated['gateway_payment_id']);

        /*
        |--------------------------------------------------------------------------
        | Resolve referral before payment transaction
        |--------------------------------------------------------------------------
        */

        $referrer = null;

        if (!empty($validated['referral_code'])) {
            $referrer = EventRegistration::where(
                'referral_code',
                $validated['referral_code']
            )->first();

            if (!$referrer) {
                return back()
                    ->withErrors([
                        'referral_code' => 'Invalid referral code.',
                    ])
                    ->withInput();
            }

            /*
            |--------------------------------------------------------------------------
            | A participant cannot refer themselves
            |--------------------------------------------------------------------------
            */

            if ($referrer->id === $reg->id) {
                return back()
                    ->withErrors([
                        'referral_code' => 'A participant cannot use their own referral code.',
                    ])
                    ->withInput();
            }
        }

        DB::transaction(function () use ($reg, $validated, $isFreeGiveaway, $referrer) {

            /*
            |--------------------------------------------------------------------------
            | Mark registration as paid
            |--------------------------------------------------------------------------
            */

            $reg->update([
                'status' => 'paid',
                'paid_at' => now(),
                'marked_paid_by' => Auth::id(),
                'marked_paid_at' => now(),

                /*
                 * Keep existing referred_by if admin did not provide
                 * a referral code this time.
                 */
                'referred_by' => $validated['referral_code']
                    ?? $reg->referred_by,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Determine amount
            |--------------------------------------------------------------------------
            */

            $amount = $isFreeGiveaway
                ? '0'
                : ($reg->is_existing_client ? '399' : '599');

            /*
            |--------------------------------------------------------------------------
            | Update existing payment or create new payment
            |--------------------------------------------------------------------------
            */

            if ($reg->payment) {

                $reg->payment->update([
                    'gateway_payment_id' =>
                        $validated['gateway_payment_id']
                        ?? 'FREE-' . strtoupper(Str::random(8)),

                    'status' => 'paid',

                    'amount' => $amount,

                    'paid_at' => now(),

                    'gateway_response' => array_merge(
                        is_array($reg->payment->gateway_response)
                        ? $reg->payment->gateway_response
                        : [],
                        [
                            'admin_marked' => true,
                            'marked_by' => Auth::user()->name,
                            'payment_mode' =>
                                $validated['payment_mode']
                                ?? 'Complimentary',
                            'note' => $validated['note'] ?? null,
                            'is_free_giveaway' => $isFreeGiveaway,
                        ]
                    ),
                ]);

            } else {

                Payment::create([
                    'event_registration_id' => $reg->id,

                    'merch_txn_id' => $isFreeGiveaway
                        ? 'FREE-' . strtoupper(Str::random(8))
                        : 'ADMIN-' . strtoupper(Str::random(8)),

                    'gateway_payment_id' =>
                        $validated['gateway_payment_id']
                        ?? 'FREE-' . strtoupper(Str::random(8)),

                    'amount' => $amount,

                    'status' => 'paid',

                    'paid_at' => now(),

                    'gateway_response' => [
                        'admin_marked' => true,
                        'marked_by' => Auth::user()->name,
                        'payment_mode' =>
                            $validated['payment_mode']
                            ?? 'Complimentary',
                        'note' => $validated['note'] ?? null,
                        'is_free_giveaway' => $isFreeGiveaway,
                    ],
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Referral
            |--------------------------------------------------------------------------
            |
            | Only create a referral if:
            |
            | 1. A valid referral code was supplied
            | 2. This registration does NOT already have a referral record
            |
            */

            if ($referrer) {

                $existingReferral = Referral::where(
                    'referred_id',
                    $reg->id
                )->first();

                if (!$existingReferral) {

                    Referral::create([
                        'referrer_id' => $referrer->id,
                        'referred_id' => $reg->id,
                        'referred_email' => $reg->email,
                        'referred_phone' => $reg->phone,
                        'referred_name' => $reg->full_name,
                        'status' => 'paid',
                        'points_awarded' => 0,
                    ]);

                } else {

                    /*
                     * Referral already existed, so DO NOT create
                     * another row.
                     *
                     * Just connect/update it as paid.
                     */
                    $existingReferral->update([
                        'referrer_id' => $referrer->id,
                        'referred_email' => $reg->email,
                        'referred_phone' => $reg->phone,
                        'referred_name' => $reg->full_name,
                        'status' => 'paid',
                    ]);
                }
            }
        });

        /*
        |--------------------------------------------------------------------------
        | Generate entry QR if missing
        |--------------------------------------------------------------------------
        */

        $existingQr = $reg->qrCodes()
            ->where('purpose', 'entry')
            ->first();

        if (!$existingQr) {

            $qr = $this->qr->generateEntryQr($reg);

            $qrUrl = asset(
                'storage/' . $qr->image_path
            );

            $amount = $isFreeGiveaway
                ? '0'
                : ($reg->is_existing_client ? '399' : '599');

            /*
            |--------------------------------------------------------------------------
            | Paid payment notifications
            |--------------------------------------------------------------------------
            */

            if (!$isFreeGiveaway) {

                $this->whatsapp->sendRegistrationConfirmation(
                    $reg,
                    $validated['gateway_payment_id']
                    ?? 'FREE-' . $reg->registration_number,
                    $amount,
                    $validated['payment_mode']
                    ?? 'Complimentary'
                );

                $this->sms->sendRegistrationConfirmation(
                    $reg->phone,
                    $validated['gateway_payment_id']
                    ?? 'FREE-' . $reg->registration_number,
                    $amount,
                    $validated['payment_mode']
                    ?? 'Complimentary'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | QR Ticket
            |--------------------------------------------------------------------------
            */

            $this->whatsapp->sendQrImage(
                $reg,
                $qrUrl
            );

            /*
            |--------------------------------------------------------------------------
            | Email
            |--------------------------------------------------------------------------
            */

            $this->email->sendConfirmation(
                $reg,
                $qr->image_path
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Lead score
        |--------------------------------------------------------------------------
        */

        $this->leadScore->calculateScore($reg);

        /*
        |--------------------------------------------------------------------------
        | Award referral points
        |--------------------------------------------------------------------------
        |
        | Only process referral points if a referral actually exists.
        |
        */

        $referral = Referral::where(
            'referred_id',
            $reg->id
        )->first();

        if ($referral && $referral->status === 'paid') {
            $this->awardReferralPoints($referral);
        }

        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        $msg = $isFreeGiveaway
            ? 'Registration marked as complimentary (free). QR generated and notifications sent.'
            : 'Registration marked as paid. QR generated and notifications sent.';

        return back()->with('success', $msg);
    }

    public function checkIns()
    {
        $checkIns = EventRegistration::where('status', 'checked_in')
            ->with('seat')
            ->latest('checked_in_at')
            ->paginate(50);
        return view('admin.checkins', compact('checkIns'));
    }

    public function stalls()
    {
        $stalls = \App\Models\Stall::withCount('visits')->get();
        return view('admin.stalls.index', compact('stalls'));
    }

    public function referrals()
    {
        $referrals = Referral::with(['referrer', 'referred'])->latest()->paginate(50);
        return view('admin.referrals', compact('referrals'));
    }

    public function leaderboard()
    {
        $referralLeaderboard = $this->getTopReferrers(20);
        $influencerLeaderboard = $this->getTopInfluencers(20);
        $stallLeaderboard = EventRegistration::select('event_registrations.*')
            ->selectRaw('COUNT(stall_visits.id) as visit_count')
            ->leftJoin('stall_visits', 'event_registrations.id', '=', 'stall_visits.event_registration_id')
            ->groupBy('event_registrations.id')
            ->orderByDesc('visit_count')
            ->limit(20)
            ->get();

        return view('admin.leaderboard', compact('referralLeaderboard', 'influencerLeaderboard', 'stallLeaderboard'));
    }

    public function communications()
    {
        $communications = Communication::with('registration')->latest()->paginate(50);
        return view('admin.communications', compact('communications'));
    }

    protected function getTopReferrers(int $limit = 10)
    {
        return EventRegistration::select('event_registrations.id', 'event_registrations.full_name', 'event_registrations.referral_code')
            ->selectRaw('SUM(referrals.points_awarded) as total_points')
            ->leftJoin('referrals', 'event_registrations.id', '=', 'referrals.referrer_id')
            ->groupBy('event_registrations.id')
            ->orderByDesc('total_points')
            ->limit($limit)
            ->get();
    }

    protected function getTopInfluencers(int $limit = 10)
    {
        return User::select('users.id', 'users.name')
            ->selectRaw('SUM(influencer_posts.points_awarded) as total_points')
            ->leftJoin('influencer_posts', 'users.id', '=', 'influencer_posts.user_id')
            ->where('influencer_posts.status', 'approved')
            ->groupBy('users.id', 'users.name')
            ->havingRaw('SUM(influencer_posts.points_awarded) > 0')
            ->orderByDesc('total_points')
            ->limit($limit)
            ->get();
    }

    protected function getStallStats()
    {
        return \App\Models\Stall::withCount('visits')
            ->select('stalls.*')
            ->selectSub(function ($query) {
                $query->from('stall_visit_feedback as svf')
                    ->join('stall_feedback_questions as sfq', 'sfq.id', '=', 'svf.stall_feedback_question_id')
                    ->join('stall_visits as sv', 'sv.id', '=', 'svf.stall_visit_id')
                    ->whereColumn('sv.stall_id', 'stalls.id')
                    ->where('sfq.type', 'rating')
                    ->selectRaw('AVG(CAST(svf.answer AS DECIMAL(10, 2)))');
            }, 'avg_rating')
            ->get();
    }

    protected function awardReferralPoints(Referral $referral): void
    {
        /*
         * Prevent duplicate points.
         */
        if ($referral->points_awarded > 0) {
            return;
        }

        $referral->update([
            'points_awarded' => 25,
        ]);

        /*
         * Recalculate the referrer's lead score.
         */
        $referrer = EventRegistration::find(
            $referral->referrer_id
        );

        if ($referrer) {
            $this->leadScore->calculateScore($referrer);
        }
    }
}
