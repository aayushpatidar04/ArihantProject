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
    public function __construct(
        protected LeadScoringService $leadScore
    ) {}

    /**
     * List all active stalls.
     */
    public function index()
    {
        $reg = $this->getCurrentRegistration();

        if (!$reg) {
            return redirect()->route('login');
        }

        if ($reg->status != "paid" && $reg->status != "checked_in") {
            return back()->with('error', 'You must be checked in, to visit stalls.');
        }

        $stalls = Stall::where('is_active', true)
            ->orderBy('name')
            ->get();

        $visitedIds = StallVisit::where('event_registration_id', $reg->id)
            ->pluck('stall_id')
            ->toArray();

        return view('stalls.index', compact(
            'stalls',
            'visitedIds',
            'reg'
        ));
    }

    /**
     * Show QR scanner.
     */
    public function scanner()
    {
        $reg = $this->getCurrentRegistration();

        if (!$reg) {
            return redirect()->route('login');
        }

        if ($reg->status != "checked_in") {
            return back()->with(
                'error',
                'You must be checked in before scanning stall QR codes.'
            );
        }

        return view('stalls.scanner');
    }

    /**
     * Handle stall QR scan.
     *
     * The QR token itself identifies the stall.
     */
    public function scan(string $qr_token)
    {
        $reg = $this->getCurrentRegistration();

        if (!$reg) {
            return redirect()->route('login');
        }

        /**
         * Participant MUST be checked in.
         */
        if ($reg->status != "checked_in") {
            return redirect()
                ->route('stalls.index')
                ->with(
                    'error',
                    'You must be checked in before visiting a stall.'
                );
        }

        /**
         * Find stall using its unique QR token.
         */
        $stall = Stall::where('qr_token', $qr_token)
            ->where('is_active', true)
            ->first();

        if (!$stall) {
            return redirect()
                ->route('stalls.index')
                ->with(
                    'error',
                    'Invalid or inactive stall QR code.'
                );
        }

        /**
         * Check whether this participant already visited
         * this stall.
         */
        $visit = StallVisit::where('event_registration_id', $reg->id)
            ->where('stall_id', $stall->id)
            ->first();

        /**
         * First visit.
         */
        if (!$visit) {
            $visit = StallVisit::create([
                'event_registration_id' => $reg->id,
                'stall_id' => $stall->id,
                'visited_at' => now(),
                'engagement_points' => 10,
            ]);

            $this->leadScore->calculateScore($reg);
        }

        return redirect()->route('stalls.show', $stall);
    }

    /**
     * Show individual stall to participant.
     */
    public function show(Stall $stall)
    {
        $reg = $this->getCurrentRegistration();

        if (!$reg) {
            return redirect()->route('login');
        }

        if ($reg->status != "checked_in") {
            return redirect()
                ->route('stalls.index')
                ->with(
                    'error',
                    'You must be checked in to visit stalls.'
                );
        }

        if (!$stall->is_active) {
            abort(404);
        }

        /**
         * The participant can only access the stall page
         * after visiting it through its QR.
         */
        $visit = StallVisit::where('event_registration_id', $reg->id)
            ->where('stall_id', $stall->id)
            ->first();

        if (!$visit) {
            return redirect()
                ->route('stalls.index')
                ->with(
                    'error',
                    'Please scan the stall QR code first.'
                );
        }

        /**
         * Load questions + options.
         *
         * Use the model/relationship names we created
         * in the quiz migration/models.
         */
        $stall->load([
            'activeQuiz.questions.options',
            'feedbackQuestions.options',
        ]);

        return view('stalls.show', compact(
            'stall',
            'visit',
            'reg'
        ));
    }

    /**
     * Submit stall quiz + feedback.
     */
    public function submitFeedback(Request $request, Stall $stall)
    {
        $reg = $this->getCurrentRegistration();

        if (!$reg) {
            return redirect()->route('login');
        }

        if ($reg->status != "checked_in") {
            return redirect()
                ->route('stalls.index')
                ->with(
                    'error',
                    'You must be checked in to submit stall activity.'
                );
        }

        $visit = StallVisit::where('event_registration_id', $reg->id)
            ->where('stall_id', $stall->id)
            ->firstOrFail();

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:1000',
            'quiz_answers' => 'nullable|array',
        ]);

        $answers = $request->input('quiz_answers', []);

        $quizScore = $this->calculateQuizScore(
            $stall,
            $answers
        );

        $visit->update([
            'rating' => $request->rating,
            'feedback' => $request->feedback,
            'quiz_answers' => json_encode($answers),
            'quiz_score' => $quizScore,
            'engagement_points' => 10 + $quizScore,
        ]);

        $this->leadScore->calculateScore($reg);

        return back()->with(
            'success',
            'Your feedback and quiz have been submitted successfully!'
        );
    }

    /**
     * Calculate quiz score from database questions/options.
     */
    protected function calculateQuizScore(
        StallVisit $visit,
        array $answers
    ): int {
        $visit->load([
            'stall.active_quiz.questions.options',
        ]);

        $quiz = $visit->stall->active_quiz;

        if (!$quiz || !$quiz->is_active) {
            return 0;
        }

        $score = 0;

        foreach ($quiz->questions as $question) {

            $selectedOptionId = $answers[$question->id] ?? null;

            if (!$selectedOptionId) {
                continue;
            }

            $correctOption = $question->options
                ->firstWhere('is_correct', true);

            if (
                $correctOption &&
                (int) $correctOption->id === (int) $selectedOptionId
            ) {
                $score += (int) $question->points;
            }
        }

        return $score;
    }

    /**
     * Get current participant registration.
     */
    protected function getCurrentRegistration(): ?EventRegistration
    {
        if (!Auth::check()) {
            return null;
        }

        return EventRegistration::where('user_id', Auth::id())
            ->latest()
            ->first();
    }
}