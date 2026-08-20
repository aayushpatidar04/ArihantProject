<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use App\Models\Stall;
use App\Models\StallVisit;
use App\Services\LeadScoringService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StallController extends Controller
{
    public function __construct(protected LeadScoringService $leadScore) {}

    /**
     * List all stalls.
     */
    public function index()
    {
        $stalls = Stall::where('is_active', true)->get();
        $reg = $this->getCurrentRegistration();
        $visitedIds = $reg ? $reg->stallVisits()->pluck('stall_id')->toArray() : [];
        return view('stalls.index', compact('stalls', 'visitedIds', 'reg'));
    }

    /**
     * API: Check-in to a stall via QR scan.
     */
    public function checkIn(Request $request)
    {
        $request->validate([
            'stall_id' => 'required|integer|exists:stalls,id',
            'qr_code' => 'required|string',
        ]);

        $reg = EventRegistration::whereHas('qrCodes', function ($q) use ($request) {
            $q->where('code', $request->qr_code)->where('purpose', 'entry');
        })->first();

        if (!$reg) {
            return response()->json(['success' => false, 'message' => 'Invalid QR.'], 404);
        }

        $alreadyVisited = StallVisit::where('event_registration_id', $reg->id)
            ->where('stall_id', $request->stall_id)
            ->exists();

        if ($alreadyVisited) {
            return response()->json(['success' => false, 'message' => 'Already visited this stall.'], 409);
        }

        $visit = StallVisit::create([
            'event_registration_id' => $reg->id,
            'stall_id' => $request->stall_id,
            'visited_at' => now(),
            'engagement_points' => 10,
        ]);

        $this->leadScore->calculateScore($reg);

        return response()->json([
            'success' => true,
            'message' => 'Stall check-in successful!',
            'visit_id' => $visit->id,
        ]);
    }

    /**
     * Submit feedback and quiz for a stall visit.
     */
    public function submitFeedback(Request $request)
    {
        $request->validate([
            'visit_id' => 'required|integer|exists:stall_visits,id',
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:1000',
            'quiz_answers' => 'nullable|array',
        ]);

        $reg = $this->getCurrentRegistration();
        if (!$reg) {
            return redirect()->route('login');
        }

        $visit = StallVisit::where('id', $request->visit_id)
            ->where('event_registration_id', $reg->id)
            ->firstOrFail();

        $quizScore = $this->calculateQuizScore($request->quiz_answers ?? []);

        $visit->update([
            'rating' => $request->rating,
            'feedback' => $request->feedback,
            'quiz_answers' => $request->quiz_answers,
            'quiz_score' => $quizScore,
            'engagement_points' => 10 + $quizScore,
        ]);

        $this->leadScore->calculateScore($reg);

        return back()->with('success', 'Feedback submitted successfully!');
    }

    protected function calculateQuizScore(array $answers): int
    {
        // Simple scoring: 20 points per correct answer, max 100
        $correct = 0;
        $mapping = config('event.quiz_answers', []);
        foreach ($answers as $q => $a) {
            if (isset($mapping[$q]) && $mapping[$q] === $a) {
                $correct++;
            }
        }
        return min(100, $correct * 20);
    }

    protected function getCurrentRegistration(): ?EventRegistration
    {
        if (!Auth::check()) return null;
        return EventRegistration::where('user_id', Auth::id())->latest()->first();
    }
}
