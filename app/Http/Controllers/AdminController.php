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
use App\Models\EventFeedback;
use App\Models\LeadScore;
use App\Models\WaitlistNumber;
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

    public function waitlist()
    {
        $waitlistNumbers = WaitlistNumber::latest()->paginate(50);

        return view('admin.waitlist', compact('waitlistNumbers'));
    }

    public function exportWaitlist()
    {
        $waitlistNumbers = WaitlistNumber::latest()->get();
        $filename = 'waitlist-numbers-' . now()->format('Y-m-d-H-i-s') . '.csv';

        return response()->streamDownload(function () use ($waitlistNumbers) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['ID', 'Phone Number', 'Joined At']);

            foreach ($waitlistNumbers as $waitlistNumber) {
                fputcsv($handle, [
                    $waitlistNumber->id,
                    $waitlistNumber->phone_number,
                    $waitlistNumber->created_at?->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
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
            if($reg->promo_amount){
                $amount = $reg->promo_amount;
            }
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

    public function eventFeedback()
    {
        $feedback = EventFeedback::with(['registration.leadScore'])
            ->latest()
            ->paginate(50);

        return view('admin.event-feedback', compact('feedback'));
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
        $overallLeaderboard = LeadScore::with('registration')
            ->orderByDesc('total_score')
            ->orderBy('id')
            ->paginate(20, ['*'], 'overall_page');
        $referralLeaderboard = $this->getTopReferrers(20, true);
        $influencerLeaderboard = $this->getTopInfluencers(20, true);
        $stallLeaderboard = EventRegistration::select('event_registrations.*')
            ->selectRaw('COUNT(stall_visits.id) as visit_count')
            ->leftJoin('stall_visits', 'event_registrations.id', '=', 'stall_visits.event_registration_id')
            ->groupBy('event_registrations.id')
            ->orderByDesc('visit_count')
            ->paginate(20, ['*'], 'stalls_page');

        return view('admin.leaderboard', compact(
            'overallLeaderboard',
            'referralLeaderboard',
            'influencerLeaderboard',
            'stallLeaderboard'
        ));
    }

    public function communications()
    {
        $communications = Communication::with('registration')->latest()->paginate(50);
        return view('admin.communications', compact('communications'));
    }

    protected function getTopReferrers(int $limit = 10, bool $paginate = false)
    {
        $query = EventRegistration::select('event_registrations.id', 'event_registrations.full_name', 'event_registrations.referral_code')
            ->selectRaw('SUM(referrals.points_awarded) as total_points')
            ->leftJoin('referrals', 'event_registrations.id', '=', 'referrals.referrer_id')
            ->groupBy('event_registrations.id')
            ->orderByDesc('total_points');

        return $paginate
            ? $query->paginate($limit, ['*'], 'referrers_page')
            : $query->limit($limit)->get();
    }

    protected function getTopInfluencers(int $limit = 10, bool $paginate = false)
    {
        $query = User::select('users.id', 'users.name')
            ->selectRaw('SUM(influencer_posts.points_awarded) as total_points')
            ->leftJoin('influencer_posts', 'users.id', '=', 'influencer_posts.user_id')
            ->where('influencer_posts.status', 'approved')
            ->groupBy('users.id', 'users.name')
            ->havingRaw('SUM(influencer_posts.points_awarded) > 0')
            ->orderByDesc('total_points');

        return $paginate
            ? $query->paginate($limit, ['*'], 'influencers_page')
            : $query->limit($limit)->get();
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

    public function export(Request $request)
    {
        return match ($request->query('type')) {
            'feedback' => $this->exportFeedback(),
            'leadscore' => $this->exportLeadScores(),
            'checkins' => $this->exportCheckIns(),
            'referrals' => $this->exportReferrals(),
            default => $this->exportRegistrations(),
        };
    }

    protected function exportRegistrations()
    {
        $registrations = EventRegistration::with([
            'payment',
            'markedPaidBy',
        ])
            ->latest()
            ->get();

        $filename = 'registrations-' . now()->format('Y-m-d-H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $columns = [
            'Reg #',
            'Referral Code',
            'Name',
            'Client Type',
            'Email',
            'Phone',
            'Branch List',
            'Client List',
            'Type',
            'Status',
            'Platform',
            'Payment Status',
            'Order ID',
            'Payment ID',
            'Marked By',
            'Marked Paid At',
            'Date',
        ];

        return response()->stream(function () use ($registrations, $columns) {

            $handle = fopen('php://output', 'w');

            /*
             * UTF-8 BOM so Excel correctly recognizes
             * UTF-8 characters.
             */
            fwrite($handle, "\xEF\xBB\xBF");

            // Header row
            fputcsv($handle, $columns);

            // Data rows
            foreach ($registrations as $r) {

                $clientType = $r->is_subbroker
                    ? 'Sub-broker'
                    : ($r->is_existing_client
                        ? 'Existing Client'
                        : 'New Client');

                $validationData = is_array($r->client_validation_data)
                    ? $r->client_validation_data
                    : json_decode($r->client_validation_data ?? '{}', true);

                $branchCodes = collect($validationData['branchlist'] ?? [])
                    ->pluck('BranchCode')
                    ->filter()
                    ->unique()
                    ->values()
                    ->implode(', ');

                $clientBranchCodes = collect($validationData['clientlist'] ?? [])
                    ->map(function ($client) {
                        return implode(' — ', array_filter([
                            $client['BranchCode'] ?? null,
                            $client['RegionCode'] ?? null,
                            $client['ZoneCode'] ?? null,
                        ]));
                    })
                    ->filter()
                    ->implode("\n");

                fputcsv($handle, [
                    $r->registration_number,
                    $r->referral_code,
                    $r->full_name,
                    $clientType,
                    $r->email,
                    $r->phone,
                    $branchCodes,
                    $clientBranchCodes,
                    ucfirst($r->type),
                    str_replace('_', ' ', ucfirst($r->status)),
                    $r->platform,

                    $r->payment?->status ?? 'N/A',

                    $r->payment?->gateway_order_id ?? '',

                    $r->payment?->gateway_payment_id ?? '',

                    $r->markedPaidBy?->name ?? '',

                    $r->marked_paid_at
                    ? $r->marked_paid_at->format('d M Y, h:i A')
                    : '',

                    $r->created_at
                    ? $r->created_at->format('d M Y, h:i A')
                    : '',
                ]);
            }

            fclose($handle);

        }, 200, $headers);
    }

    protected function exportFeedback()
    {
        $feedback = EventFeedback::with(['registration.leadScore'])->latest()->get();

        return $this->downloadCsv('event-feedback', [
            'Registration Number', 'Participant', 'Submitted At', 'Experience',
            'Session Quality', 'Content Usefulness', 'Networking', 'Recommendation',
            'Feedback Score', 'Most Valuable Session', 'Liked Most', 'Improvements',
        ], function ($handle) use ($feedback) {
            foreach ($feedback as $item) {
                fputcsv($handle, [
                    $item->registration?->registration_number ?? '',
                    $item->registration?->full_name ?? '',
                    $item->created_at?->format('d M Y, h:i A') ?? '',
                    $item->experience_rating,
                    $item->session_quality,
                    $item->content_usefulness,
                    $item->networking_rating,
                    $item->recommendation,
                    $item->registration?->leadScore?->social_score ?? 0,
                    $item->most_valuable_session,
                    $item->liked_most,
                    $item->improvements,
                ]);
            }
        });
    }

    protected function exportLeadScores()
    {
        $scores = LeadScore::with('registration')->orderByDesc('total_score')->get();

        return $this->downloadCsv('lead-scores', [
            'Rank', 'Registration Number', 'Lead', 'Registration Score', 'Referral Score',
            'Feedback Score', 'Engagement Score', 'Overall Score',
        ], function ($handle) use ($scores) {
            foreach ($scores as $index => $score) {
                fputcsv($handle, [
                    $index + 1,
                    $score->registration?->registration_number ?? '',
                    $score->registration?->full_name ?? '',
                    $score->registration_score + $score->kyc_score,
                    $score->referral_score,
                    $score->social_score,
                    $score->quiz_score + $score->stall_visit_score,
                    $score->total_score,
                ]);
            }
        });
    }

    protected function exportCheckIns()
    {
        $checkIns = EventRegistration::where('status', 'checked_in')
            ->with('seat')
            ->latest('checked_in_at')
            ->get();

        return $this->downloadCsv('check-ins', [
            'Registration Number', 'Name', 'Email', 'Phone', 'Seat', 'Section', 'Checked In At',
        ], function ($handle) use ($checkIns) {
            foreach ($checkIns as $checkIn) {
                fputcsv($handle, [
                    $checkIn->registration_number,
                    $checkIn->full_name,
                    $checkIn->email,
                    $checkIn->phone,
                    $checkIn->seat?->seat_number ?? '',
                    $checkIn->seat?->section ?? '',
                    $checkIn->checked_in_at?->format('d M Y, h:i A') ?? '',
                ]);
            }
        });
    }

    protected function exportReferrals()
    {
        $referrals = Referral::with(['referrer', 'referred'])->latest()->get();

        return $this->downloadCsv('referrals', [
            'Referrer', 'Referred Name', 'Referred Email', 'Referred Phone',
            'Status', 'Points', 'Date',
        ], function ($handle) use ($referrals) {
            foreach ($referrals as $referral) {
                fputcsv($handle, [
                    $referral->referrer?->full_name ?? '',
                    $referral->referred?->full_name ?? $referral->referred_name ?? '',
                    $referral->referred_email,
                    $referral->referred_phone,
                    ucfirst($referral->status),
                    $referral->points_awarded,
                    $referral->created_at?->format('d M Y, h:i A') ?? '',
                ]);
            }
        });
    }

    protected function downloadCsv(string $name, array $columns, callable $writeRows)
    {
        $filename = $name . '-' . now()->format('Y-m-d-H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($columns, $writeRows) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, $columns);
            $writeRows($handle);
            fclose($handle);
        }, 200, $headers);
    }
}
