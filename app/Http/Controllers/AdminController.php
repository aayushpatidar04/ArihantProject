<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use App\Models\StallVisit;
use App\Models\Referral;
use App\Models\InfluencerPost;
use App\Models\Seat;
use App\Models\LeadScore;
use App\Models\Communication;
use App\Services\LeadScoringService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct(protected LeadScoringService $leadScore) {}

    public function dashboard()
    {
        $stats = [
            'total_registrations' => EventRegistration::count(),
            'registrations_subbrokers' => EventRegistration::where('is_subbroker', true)->count(),
            'registrations_existing_clients' => EventRegistration::where('is_existing_client', true)->where('is_subbroker', false)->count(),
            'registrations_non_clients' => EventRegistration::where('is_existing_client', false)->where('is_subbroker', false)->count(),

            'paid_registrations' => EventRegistration::where('status', 'paid')->orWhere('status', 'checked_in')->count(),
            'paid_subbrokers' => EventRegistration::whereIn('status', ['paid','checked_in'])->where('is_subbroker', true)->count(),
            'paid_existing_clients' => EventRegistration::whereIn('status', ['paid','checked_in'])->where('is_existing_client', true)->where('is_subbroker', false)->count(),
            'paid_non_clients' => EventRegistration::whereIn('status', ['paid','checked_in'])->where('is_existing_client', false)->where('is_subbroker', false)->count(),
                                                
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

    public function influencerPosts()
    {
        $posts = InfluencerPost::with('registration')->latest()->paginate(50);
        return view('admin.influencer', compact('posts'));
    }

    public function approvePost(InfluencerPost $post)
    {
        $post->update([
            'status' => 'approved',
            'points_awarded' => 20,
            'approved_at' => now(),
        ]);
        $this->leadScore->calculateScore($post->registration);
        return back()->with('success', 'Post approved and points awarded.');
    }

    public function rejectPost(InfluencerPost $post, Request $request)
    {
        $post->update([
            'status' => 'rejected',
            'admin_notes' => $request->input('reason', ''),
        ]);
        return back()->with('success', 'Post rejected.');
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
        return EventRegistration::select('event_registrations.id', 'event_registrations.full_name')
            ->selectRaw('SUM(influencer_posts.points_awarded) as total_points')
            ->leftJoin('influencer_posts', 'event_registrations.id', '=', 'influencer_posts.event_registration_id')
            ->where('influencer_posts.status', 'approved')
            ->groupBy('event_registrations.id')
            ->orderByDesc('total_points')
            ->limit($limit)
            ->get();
    }

    protected function getStallStats()
    {
        return \App\Models\Stall::withCount('visits')
            ->with(['visits' => function ($q) {
                $q->selectRaw('stall_id, AVG(rating) as avg_rating')->groupBy('stall_id');
            }])
            ->get();
    }
}
