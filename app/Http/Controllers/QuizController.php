<?php

namespace App\Http\Controllers;

use App\Events\Quiz\AnswerReceived;
use App\Events\Quiz\ParticipantJoined;
use App\Models\QuizParticipant;
use App\Models\QuizQuestion;
use App\Models\QuizSession;
use App\Models\QuizType;
use App\Services\QuizService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $quizType = $request->query('type');
        $allTypes = QuizType::where('is_active', true)->orderBy('sort_order')->get();
        $quizTypes = $allTypes->pluck('name', 'key')->toArray();

        // No type param => show quiz listing page
        if (!$quizType) {
            return view('quiz.index', [
                'quizTypes' => $quizTypes,
                'allTypes' => $allTypes,
                'quizType' => null,
                'session' => null,
                'participant' => null,
                'totalQuestions' => 0,
                'mode' => 'listing',
            ]);
        }

        // Invalid type => redirect to listing
        if (!isset($quizTypes[$quizType])) {
            return redirect('/quiz');
        }

        $session = QuizSession::where('quiz_type', $quizType)
            ->whereIn('status', ['waiting', 'active', 'paused'])
            ->first();

        // Page refresh: restore the player straight back into the game
        $participant = null;
        if ($session && ($pid = Session::get('quiz_participant_id'))) {
            $participant = QuizParticipant::where('id', $pid)->where('session_id', $session->id)->first();
        }

        return view('quiz.index', [
            'quizTypes' => $quizTypes,
            'quizType' => $quizType,
            'quizName' => $quizTypes[$quizType],
            'session' => $session,
            'participant' => $participant,
            'totalQuestions' => $session ? (new QuizService())->totalQuestions($session) : 0,
            'mode' => 'join',
        ]);
    }

    public function validatePin(Request $request)
    {
        $request->validate(['quiz_type' => 'required|string', 'pin' => 'required|string|size:6']);

        $session = QuizSession::where('quiz_type', $request->quiz_type)
            ->where('pin', $request->pin)
            ->whereIn('status', ['waiting', 'active', 'paused'])
            ->first();

        if (!$session)
            return response()->json(['valid' => false, 'message' => 'Invalid PIN or quiz not active.']);

        return response()->json(['valid' => true, 'session_id' => $session->id, 'status' => $session->status]);
    }

    public function join(Request $request)
    {
        $request->validate([
            'session_id' => 'required|string',
            'quiz_type' => 'required|string',
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'mobile' => 'required|string|max:20',
        ]);

        $session = QuizSession::where('id', $request->session_id)
            ->where('quiz_type', $request->quiz_type)
            ->firstOrFail();

        if (!$session->isActive()) {
            return response()->json(['success' => false, 'message' => 'This quiz has ended. You cannot join.']);
        }

        $existing = QuizParticipant::where('session_id', $session->id)
            ->where('email', $request->email)
            ->first();

        if ($existing) {
            Session::put('quiz_participant_id', $existing->id);
            return response()->json(['success' => true, 'participant_id' => $existing->id, 'name' => $existing->name, 'rejoined' => true]);
        }

        if ($session->participants()->count() >= config('quiz.max_participants', 1000)) {
            return response()->json(['success' => false, 'message' => 'This quiz is full.']);
        }

        $participant = QuizParticipant::create([
            'session_id' => $session->id,
            'name' => trim($request->name),
            'email' => $request->email,
            'mobile' => $request->mobile,
            'joined_at' => now(),
        ]);

        Session::put('quiz_participant_id', $participant->id);
        broadcast(new ParticipantJoined($session, $participant));

        return response()->json(['success' => true, 'participant_id' => $participant->id, 'name' => $participant->name, 'rejoined' => false]);
    }

    public function submitAnswer(Request $request)
    {
        $request->validate([
            'session_id' => 'required|string',
            'question_id' => 'required|integer',
            'selected_option' => 'required|integer|min:0|max:3',
        ]);

        $participantId = Session::get('quiz_participant_id');
        if (!$participantId)
            return response()->json(['success' => false, 'message' => 'Not joined.'], 401);

        $session = QuizSession::where('id', $request->session_id)
            ->whereIn('status', ['active', 'paused'])
            ->first();
        if (!$session)
            return response()->json(['success' => false, 'message' => 'This quiz is not running.'], 404);

        $participant = QuizParticipant::where('id', $participantId)->where('session_id', $session->id)->first();
        if (!$participant)
            return response()->json(['success' => false, 'message' => 'Not joined.'], 401);

        $question = QuizQuestion::where('id', $request->question_id)
            ->where('quiz_type', $session->quiz_type)
            ->firstOrFail();

        $svc = new QuizService();
        $result = $svc->submitAnswer($session, $participant, $question, (int) $request->selected_option);

        if (!$result['ok'])
            return response()->json(['success' => false, 'message' => $result['message']], 422);

        // Per-answer broadcasts are only worth their cost in smaller rooms; the host screen also polls.
        if ($session->participants()->count() <= (int) config('quiz.answer_event_max_participants', 100)) {
            broadcast(new AnswerReceived($session, $participant, $result['answer']));
        }

        // Correctness is NOT returned: players find out at reveal time, like Kahoot.
        return response()->json(['success' => true, 'locked' => true]);
    }

    public function sessionState(Request $request, $sessionId)
    {
        $session = QuizSession::findOrFail($sessionId);
        $participantId = Session::get('quiz_participant_id');
        $participant = $participantId
            ? QuizParticipant::where('id', $participantId)->where('session_id', $session->id)->first()
            : null;

        return response()->json((new QuizService())->participantState($session, $participant));
    }

    public function leaderboard(Request $request)
    {
        $activeSession = QuizSession::whereIn('status', ['waiting', 'active', 'paused'])->orderByDesc('started_at')->first();
        $lastCompleted = QuizSession::where('status', 'completed')->orderByDesc('ended_at')->first();
        $quizType = null;
        $questions = [];
        $leaderboard = [];
        $analytics = null;
        $participantCount = 0;
        $showAnalytics = false;
        $isCompleted = false;
        $service = new QuizService();

        if ($activeSession) {
            $quizType = QuizType::where('key', $activeSession->quiz_type)->first();
            $questions = QuizQuestion::where('quiz_type', $activeSession->quiz_type)->orderBy('order')->get();
            $participantCount = QuizParticipant::where('session_id', $activeSession->id)->count();

            if ($activeSession->current_question_order >= 1) {
                $prevOrder = $activeSession->current_question_order - 1;
                $prevQuestion = $questions->firstWhere('order', $prevOrder);
                if ($prevQuestion) {
                    $showAnalytics = true;
                    $analytics = $service->getQuestionAnalytics($activeSession, $prevQuestion);
                    $leaderboard = $service->getLeaderboard($activeSession, 20);
                }
            }
        } elseif ($lastCompleted) {
            $isCompleted = true;
            $quizType = QuizType::where('key', $lastCompleted->quiz_type)->first();
            $questions = QuizQuestion::where('quiz_type', $lastCompleted->quiz_type)->orderBy('order')->get();
            $leaderboard = $service->getLeaderboard($lastCompleted, 20);
            $participantCount = QuizParticipant::where('session_id', $lastCompleted->id)->count();
        }

        return view('quiz.leaderboard', compact('activeSession', 'lastCompleted', 'quizType', 'questions', 'leaderboard', 'analytics', 'showAnalytics', 'isCompleted', 'participantCount'));
    }

    public function results(Request $request)
    {
        $sessionId = $request->query('session');
        $participantId = Session::get('quiz_participant_id');

        if (!$sessionId || !$participantId) {
            return redirect('/quiz')->with('error', 'Invalid access.');
        }

        $session = QuizSession::where('id', $sessionId)->where('status', 'completed')->firstOrFail();
        $participant = QuizParticipant::where('id', $participantId)->where('session_id', $sessionId)->firstOrFail();

        $results = (new QuizService())->getParticipantResults($session, $participant);

        return view('quiz.results', compact('results', 'session'));
    }
}
