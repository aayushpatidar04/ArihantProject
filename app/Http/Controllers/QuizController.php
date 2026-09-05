<?php

namespace App\Http\Controllers;

use App\Models\QuizSession;
use App\Models\QuizParticipant;
use App\Models\QuizAnswer;
use App\Models\QuizQuestion;
use App\Models\QuizType;
use App\Services\QuizService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $quizType = $request->query('type');
        $allTypes = \App\Models\QuizType::where('is_active', true)->orderBy('sort_order')->get();
        $quizTypes = $allTypes->pluck('name', 'key')->toArray();

        // No type param => show quiz listing page
        if (!$quizType) {
            return view('quiz.index', [
                'quizTypes' => $quizTypes,
                'allTypes' => $allTypes,
                'quizType' => null,
                'session' => null,
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

        return view('quiz.index', ['quizTypes' => $quizTypes, 'quizType' => $quizType, 'session' => $session, 'mode' => 'join']);
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
        return response()->json(['valid' => true, 'session_id' => $session->id]);
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

        if (!in_array($session->status, ['waiting', 'active', 'paused'])) {
            return response()->json(['success' => false, 'message' => 'This quiz has ended. You cannot join.']);
        }

        $existing = QuizParticipant::where('session_id', $session->id)
            ->where('email', $request->email)
            ->first();

        if ($existing) {
            Session::put('quiz_participant_id', $existing->id);
            broadcast(new \App\Events\Quiz\ParticipantJoined($session, $existing))->toOthers();
            return response()->json(['success' => true, 'participant_id' => $existing->id, 'rejoined' => true]);
        }

        $participant = QuizParticipant::create([
            'session_id' => $session->id,
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'joined_at' => now(),
        ]);

        Session::put('quiz_participant_id', $participant->id);
        broadcast(new \App\Events\Quiz\ParticipantJoined($session, $participant))->toOthers();

        return response()->json(['success' => true, 'participant_id' => $participant->id, 'rejoined' => false]);
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
            return response()->json(['success' => false, 'message' => 'Not joined.']);

        $session = QuizSession::where('id', $request->session_id)
            ->whereIn('status', ['active', 'paused'])
            ->firstOrFail();

        $question = QuizQuestion::where('id', $request->question_id)
            ->where('quiz_type', $session->quiz_type)
            ->firstOrFail();

        $isCorrect = (int) $request->selected_option === (int) $question->correct_option;

        $existing = QuizAnswer::where('session_id', $session->id)
            ->where('participant_id', $participantId)
            ->where('question_id', $question->id)
            ->first();
        $startedAt = $session->question_started_at;

        $responseMs = $startedAt
            ? max(0, now()->timestamp * 1000 - $startedAt->timestamp * 1000)
            : 0;

        if ($existing) {
            $existing->update([
                'selected_option' => (int) $request->selected_option,
                'is_correct' => $isCorrect,
                'response_time_ms' => $responseMs,
                'submitted_at' => now(),
            ]);
            $answer = $existing;
        } else {
            $answer = QuizAnswer::create([
                'session_id' => $session->id,
                'participant_id' => $participantId,
                'question_id' => $question->id,
                'selected_option' => (int) $request->selected_option,
                'is_correct' => $isCorrect,
                'response_time_ms' => $responseMs,
                'submitted_at' => now(),
            ]);
        }

        broadcast(new \App\Events\Quiz\AnswerReceived($session, $answer->participant, $answer))->toOthers();

        return response()->json(['success' => true, 'is_correct' => $isCorrect, 'updated' => (bool) $existing]);
    }

    public function sessionState(Request $request, $sessionId)
    {
        $session = QuizSession::findOrFail($sessionId);
        $participantId = Session::get('quiz_participant_id');
        $participant = $participantId ? QuizParticipant::find($participantId) : null;

        $question = (new \App\Services\QuizService())->getCurrentQuestion($session);
        $participantAnswered = false;
        $isCorrect = null;

        if ($question && $participant) {
            $answer = QuizAnswer::where('session_id', $session->id)
                ->where('participant_id', $participant->id)
                ->where('question_id', $question->id)
                ->first();
            if ($answer) {
                $participantAnswered = true;
                $isCorrect = $answer->is_correct;
            }
        }

        return response()->json([
            'status' => $session->status,
            'current_question' => $question ? [
                'id' => $question->id,
                'text' => $question->question_text,
                'options' => $question->options,
                'order' => $question->order,
            ] : null,
            'participant_answered' => $participantAnswered,
            'is_correct' => $isCorrect,
        ]);
    }

    public function leaderboard(Request $request)
    {
        $activeSession = QuizSession::whereIn('status', ['waiting', 'active', 'paused'])->orderByDesc('started_at')->first();
        $lastCompleted = QuizSession::where('status', 'completed')->orderByDesc('ended_at')->first();
        $quizType = null;
        $questions = [];
        $leaderboard = [];
        $analytics = null;
        $showAnalytics = false;
        $isCompleted = false;

        if ($activeSession) {
            $quizType = QuizType::where('key', $activeSession->quiz_type)->first();
            $questions = QuizQuestion::where('quiz_type', $activeSession->quiz_type)->orderBy('order')->get();

            if ($activeSession->current_question_order >= 1) {
                $prevOrder = $activeSession->current_question_order - 1;
                $prevQuestion = $questions->firstWhere('order', $prevOrder);
                if ($prevQuestion) {
                    $showAnalytics = true;
                    $service = new QuizService();
                    $analytics = $service->getQuestionAnalytics($activeSession, $prevQuestion);
                    $leaderboard = $service->getLeaderboard($activeSession, 20);
                }
            }
        } elseif ($lastCompleted) {
            $isCompleted = true;
            $quizType = QuizType::where('key', $lastCompleted->quiz_type)->first();
            $questions = QuizQuestion::where('quiz_type', $lastCompleted->quiz_type)->orderBy('order')->get();
            $service = new QuizService();
            $leaderboard = $service->getLeaderboard($lastCompleted, 20);
        }

        return view('quiz.leaderboard', compact('activeSession', 'lastCompleted', 'quizType', 'questions', 'leaderboard', 'analytics', 'showAnalytics', 'isCompleted'));
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

        $results = (new \App\Services\QuizService())->getParticipantResults($session, $participant);

        return view('quiz.results', compact('results', 'session'));
    }
}
