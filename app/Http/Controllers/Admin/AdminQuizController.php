<?php

namespace App\Http\Controllers\Admin;

use App\Events\Quiz\QuestionRevealed;
use App\Events\Quiz\QuestionShown;
use App\Events\Quiz\QuizEnded;
use App\Events\Quiz\QuizPaused;
use App\Events\Quiz\QuizResumed;
use App\Events\Quiz\QuizStarted;
use App\Events\Quiz\ScoreboardShown;
use App\Http\Controllers\Controller;
use App\Models\QuizQuestion;
use App\Models\QuizSession;
use App\Models\QuizType;
use App\Services\QuizService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminQuizController extends Controller
{
    protected $quiz;

    public function __construct()
    {
        $this->quiz = new QuizService();
    }

    public function index(Request $request)
    {
        $quizTypes = QuizType::orderBy('sort_order')->pluck('name', 'key')->toArray();
        $activeSession = QuizSession::whereIn('status', ['waiting', 'active', 'paused'])->first();
        $recentSessions = QuizSession::orderByDesc('started_at')->limit(10)->get();

        return view('admin.quiz.index', compact('quizTypes', 'activeSession', 'recentSessions'));
    }

    /* ------------------------------------------------------------------ */
    /*  Session lifecycle                                                  */
    /* ------------------------------------------------------------------ */

    public function startSession(Request $request, $type)
    {
        $questionCount = QuizQuestion::where('quiz_type', $type)->count();
        if ($questionCount === 0) {
            return $this->fail($request, 'Add at least 1 question before starting.');
        }

        $this->quiz->endPreviousActiveSession();

        $session = QuizSession::create([
            'quiz_type' => $type,
            'pin' => $this->quiz->generatePin(),
            'status' => 'waiting',
            'phase' => 'lobby',
            'current_question_order' => 0,
            'created_by' => Auth::id(),
        ]);

        $qrPath = $this->quiz->generateQrCode($type);

        broadcast(new QuizStarted($session, $qrPath));

        return response()->json([
            'success' => true,
            'session_id' => $session->id,
            'pin' => $session->pin,
            'qr_url' => $qrPath ? asset('storage/' . $qrPath) : null,
            'host_url' => route('admin.quiz.host', $type),
        ]);
    }

    /** Opens the next question (or the first one, from the lobby). */
    public function showQuestion(Request $request, $type)
    {
        $session = $this->activeSession($type);
        if (!$session)
            return response()->json(['success' => false, 'message' => 'No active session'], 404);

        if ($session->phase === 'question' && !$request->boolean('force')) {
            return response()->json(['success' => false, 'message' => 'A question is still running.'], 409);
        }

        $nextOrder = $session->current_question_order + 1;
        $question = QuizQuestion::where('quiz_type', $type)->where('order', $nextOrder)->first();

        if (!$question) {
            return response()->json(['success' => false, 'message' => 'No more questions', 'last' => true], 404);
        }

        $this->quiz->openQuestion($session, $question);
        $session->refresh();

        broadcast(new QuestionShown($session, $question));

        return $this->stateResponse($session, ['question_order' => $nextOrder]);
    }

    public function prevQuestion(Request $request, $type)
    {
        $session = $this->activeSession($type);
        if (!$session)
            return response()->json(['success' => false, 'message' => 'No active session'], 404);

        $prevOrder = max(1, $session->current_question_order - 1);
        $question = QuizQuestion::where('quiz_type', $type)->where('order', $prevOrder)->first();
        if (!$question)
            return response()->json(['success' => false, 'message' => 'No previous question'], 404);

        $this->quiz->openQuestion($session, $question);
        $session->refresh();

        broadcast(new QuestionShown($session, $question));

        return $this->stateResponse($session, ['question_order' => $prevOrder]);
    }

    /** Timer finished or everyone answered: lock answers and show the correct option. */
    public function reveal(Request $request, $type)
    {
        $session = $this->activeSession($type);
        if (!$session)
            return response()->json(['success' => false, 'message' => 'No active session'], 404);

        if ($session->phase === 'question') {
            $session->update(['phase' => 'reveal', 'status' => 'active', 'paused_remaining_ms' => null]);
            broadcast(new QuestionRevealed($session));
        }

        return $this->stateResponse($session->refresh());
    }

    /** Between-question leaderboard. */
    public function scoreboard(Request $request, $type)
    {
        $session = $this->activeSession($type);
        if (!$session)
            return response()->json(['success' => false, 'message' => 'No active session'], 404);

        if ($session->phase === 'reveal') {
            $session->update(['phase' => 'scoreboard']);
            broadcast(new ScoreboardShown($session));
        }

        return $this->stateResponse($session->refresh());
    }

    public function pause(Request $request, $type)
    {
        $session = QuizSession::where('quiz_type', $type)->where('status', 'active')->first();
        if (!$session)
            return response()->json(['success' => false, 'message' => 'No active session'], 404);

        $this->quiz->pauseTimer($session);
        $session->refresh();
        broadcast(new QuizPaused($session));

        return $this->stateResponse($session);
    }

    public function resume(Request $request, $type)
    {
        $session = QuizSession::where('quiz_type', $type)->where('status', 'paused')->first();
        if (!$session)
            return response()->json(['success' => false, 'message' => 'No paused session'], 404);

        $this->quiz->resumeTimer($session);
        $session->refresh();
        broadcast(new QuizResumed($session));

        return $this->stateResponse($session);
    }

    public function end(Request $request, $type)
    {
        $session = $this->activeSession($type);
        if (!$session) {
            if ($this->wantsJson($request))
                return response()->json(['success' => false, 'message' => 'No active session'], 404);
            return back()->with('error', 'No active session.');
        }

        $session->update(['status' => 'completed', 'phase' => 'podium', 'ended_at' => now(), 'paused_remaining_ms' => null]);
        broadcast(new QuizEnded($session));

        if (!$this->wantsJson($request))
            return redirect()->route('admin.quiz.results', $type);

        return $this->stateResponse($session->refresh(), [
            'total_participants' => $session->participants()->count(),
            'results_url' => route('admin.quiz.results', $type),
        ]);
    }

    /* ------------------------------------------------------------------ */
    /*  Host screen (the Kahoot-style big screen)                          */
    /* ------------------------------------------------------------------ */

    public function hostScreen(Request $request, $type)
    {
        $session = $this->activeSession($type);
        if (!$session) {
            return redirect()->route('admin.quiz.index')->with('error', 'Start the quiz first.');
        }

        $quizType = QuizType::where('key', $type)->first();
        $qrPath = 'qrcodes/quiz_' . $type . '.png';
        $qrUrl = \Storage::disk('public')->exists($qrPath) ? asset('storage/' . $qrPath) : null;

        return view('admin.quiz.host', [
            'session' => $session,
            'type' => $type,
            'quizName' => $quizType->name ?? 'Quiz',
            'qrUrl' => $qrUrl,
            'joinUrl' => url('/quiz?type=' . $type),
            'joinHost' => preg_replace('#^https?://#', '', rtrim(url('/quiz'), '/')),
        ]);
    }

    public function hostState(Request $request, $type)
    {
        $session = QuizSession::where('quiz_type', $type)->orderByDesc('created_at')->first();
        if (!$session)
            return response()->json(['success' => false, 'message' => 'No session'], 404);

        return response()->json(['success' => true] + $this->quiz->hostState($session, (int) $request->query('since', 0)));
    }

    /* ------------------------------------------------------------------ */
    /*  Question bank                                                      */
    /* ------------------------------------------------------------------ */

    public function questions(Request $request, $type)
    {
        $questions = QuizQuestion::where('quiz_type', $type)->orderBy('order')->get();
        $quizType = QuizType::where('key', $type)->firstOrFail();
        $activeSession = QuizSession::whereIn('status', ['waiting', 'active', 'paused'])->first();
        return view('admin.quiz.questions', compact('questions', 'type', 'quizType', 'activeSession'));
    }

    public function storeQuestion(Request $request, $type)
    {
        $request->validate([
            'question_text' => 'required|string|max:500',
            'options' => 'required|array|min:2|max:4',
            'options.*' => 'required|string|max:200',
            'correct_option' => 'required|integer|min:0|max:3',
            'time_limit' => 'nullable|integer|min:5|max:120',
            'order' => 'nullable|integer|min:1',
        ]);

        if (QuizQuestion::where('quiz_type', $type)->count() >= config('quiz.max_questions', 50)) {
            return back()->with('error', 'Maximum questions reached for this quiz.');
        }

        $maxOrder = QuizQuestion::where('quiz_type', $type)->max('order') ?? 0;

        QuizQuestion::create([
            'quiz_type' => $type,
            'question_text' => $request->question_text,
            'options' => array_values($request->options),
            'correct_option' => (int) $request->correct_option,
            'time_limit' => $request->filled('time_limit') ? (int) $request->time_limit : null,
            'order' => $request->order ?? $maxOrder + 1,
        ]);

        return back()->with('success', 'Question added.');
    }

    public function updateQuestion(Request $request, $type, $id)
    {
        $question = QuizQuestion::where('quiz_type', $type)->findOrFail($id);

        $request->validate([
            'question_text' => 'required|string|max:500',
            'options' => 'required|array|min:2|max:4',
            'options.*' => 'required|string|max:200',
            'correct_option' => 'required|integer|min:0|max:3',
            'time_limit' => 'nullable|integer|min:5|max:120',
        ]);

        $question->update([
            'question_text' => $request->question_text,
            'options' => array_values($request->options),
            'correct_option' => (int) $request->correct_option,
            'time_limit' => $request->filled('time_limit') ? (int) $request->time_limit : null,
        ]);

        return back()->with('success', 'Question updated.');
    }

    
    public function destroyQuestion(Request $request, $type, $id)
    {
        $question = QuizQuestion::where('quiz_type', $type)
            ->findOrFail($id);

        $question->delete();

        // Renumber the remaining questions for this quiz.
        $questions = QuizQuestion::where('quiz_type', $type)
            ->orderBy('order')
            ->orderBy('id')
            ->get();

        foreach ($questions as $index => $remainingQuestion) {
            $newOrder = $index + 1;

            if ($remainingQuestion->order !== $newOrder) {
                $remainingQuestion->update([
                    'order' => $newOrder,
                ]);
            }
        }

        return back()->with('success', 'Question deleted and question order updated.');
    }


    public function reorderQuestions(Request $request, $type)
    {
        $request->validate(['order' => 'required|array']);
        foreach ($request->order as $order => $id) {
            QuizQuestion::where('quiz_type', $type)->where('id', $id)->update(['order' => $order + 1]);
        }
        return response()->json(['success' => true]);
    }

    /* ------------------------------------------------------------------ */
    /*  Dashboards (unchanged behaviour)                                   */
    /* ------------------------------------------------------------------ */

    public function liveDashboard(Request $request, $type)
    {
        $session = QuizSession::where('quiz_type', $type)->whereIn('status', ['waiting', 'active', 'paused'])->firstOrFail();
        $questions = QuizQuestion::where('quiz_type', $type)->orderBy('order')->get();
        $currentQuestion = $questions->firstWhere('order', $session->current_question_order);
        $participantCount = $session->participants()->count();
        $analytics = [];
        $leaderboard = $this->quiz->getLeaderboard($session, 10);
        if ($currentQuestion) {
            $analytics = $this->quiz->getQuestionAnalytics($session, $currentQuestion);
        }
        $question = $currentQuestion;

        return view('admin.quiz.live', compact('session', 'type', 'questions', 'currentQuestion', 'participantCount', 'question', 'analytics', 'leaderboard'));
    }

    public function sessionResults(Request $request, $type, $sessionId = null)
    {
        $sessions = QuizSession::where('quiz_type', $type)
            ->where('status', 'completed')
            ->withCount('participants')
            ->orderByDesc('ended_at')
            ->orderByDesc('started_at')
            ->get();
        $session = $sessionId ? $sessions->firstWhere('id', $sessionId) : $sessions->first();

        abort_unless($session, 404);

        $overview = $this->quiz->getSessionOverview($session);
        $questions = QuizQuestion::where('quiz_type', $type)->orderBy('order')->get();

        return view('admin.quiz.results', compact('session', 'sessions', 'overview', 'questions', 'type'));
    }

    public function createType(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100', 'description' => 'nullable|string|max:500']);
        $key = Str::slug($request->name);
        $maxOrder = QuizType::max('sort_order') ?? 0;
        QuizType::create(['key' => $key, 'name' => $request->name, 'description' => $request->description, 'sort_order' => $maxOrder + 1]);
        return back()->with('success', 'Quiz type created.');
    }

    public function updateType(Request $request, $type)
    {
        $request->validate(['name' => 'required|string|max:100']);
        $qt = QuizType::where('key', $type)->first();
        if (!$qt)
            return back()->with('error', 'Quiz type not found.');
        $qt->update(['name' => $request->name]);
        return back()->with('success', 'Updated.');
    }

    public function deleteType($type)
    {
        $qt = QuizType::where('key', $type)->first();
        if (!$qt)
            return back()->with('error', 'Quiz type not found.');
        $qt->delete();
        return back()->with('success', 'Quiz type deleted.');
    }

    /* ------------------------------------------------------------------ */

    protected function activeSession(string $type): ?QuizSession
    {
        return QuizSession::where('quiz_type', $type)->whereIn('status', ['waiting', 'active', 'paused'])->first();
    }

    protected function wantsJson(Request $request): bool
    {
        return $request->expectsJson() || $request->isJson() || $request->ajax();
    }

    protected function stateResponse(QuizSession $session, array $extra = [])
    {
        return response()->json(['success' => true] + $extra + ['state' => $this->quiz->hostState($session)]);
    }

    protected function fail(Request $request, string $message)
    {
        return $this->wantsJson($request)
            ? response()->json(['success' => false, 'message' => $message], 422)
            : back()->with('error', $message);
    }
}
