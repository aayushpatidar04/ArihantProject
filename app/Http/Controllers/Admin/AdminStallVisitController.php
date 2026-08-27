<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stall;
use App\Models\StallVisit;

class AdminStallVisitController extends Controller
{
    
    /**
     * List all participant visits for a specific stall.
     */
    public function index(Stall $stall)
    {
        $visits = $stall->visits()
            ->with([
                'registration.user',
                'quizAnswers',
                'feedbackResponses',
            ])
            ->latest('visited_at')
            ->paginate(20);

        $totalVisits = $stall->visits()->count();

        $quizCompleted = $stall->visits()
            ->whereHas('quizAnswers')
            ->count();

        $feedbackSubmitted = $stall->visits()
            ->whereHas('feedbackResponses')
            ->count();

        $averageQuizScore = $stall->visits()
            ->whereNotNull('quiz_score')
            ->avg('quiz_score');

        return view('admin.stalls.visits.index', compact(
            'stall',
            'visits',
            'totalVisits',
            'quizCompleted',
            'feedbackSubmitted',
            'averageQuizScore'
        ));
    }

    /**
     * Show full quiz and feedback responses for one visit.
     */
    public function show(Stall $stall, StallVisit $visit)
    {
        // Prevent accessing a visit belonging to another stall.
        abort_unless(
            $visit->stall_id === $stall->id,
            404
        );

        $visit->load([
            'registration.user',

            'quizAnswers.question',
            'quizAnswers.option',

            'feedbackResponses.question',
        ]);

        return view('admin.stalls.visits.show', compact(
            'stall',
            'visit'
        ));
    }
}