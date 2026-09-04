<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuizType;
use App\Models\QuizSession;
use App\Models\QuizQuestion;
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

    public function startSession(Request $request, $type)
    {
        $lastSession = QuizSession::where('quiz_type', $type)->orderByDesc('started_at')->first();
        if ($lastSession && $lastSession->status === 'completed') {
            return back()->with('error', 'This quiz has already ended and cannot be restarted.');
        }

        $this->quiz->endPreviousActiveSession();

        $questionCount = QuizQuestion::where('quiz_type', $type)->count();
        if ($questionCount === 0) {
            return back()->with('error', 'Add at least 1 question before starting.');
        }

        $session = QuizSession::create([
            'quiz_type' => $type,
            'pin' => $this->quiz->generatePin(),
            'status' => 'waiting',
            'current_question_order' => 0,
            'created_by' => Auth::id(),
        ]);

        $qrPath = $this->quiz->generateQrCode($type);

        return response()->json([
            'success' => true,
            'session_id' => $session->id,
            'pin' => $session->pin,
            'qr_url' => $qrPath ? asset('storage/' . $qrPath) : null,
        ]);
    }

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
            'correct_option' => 'required|integer|min:0|max:3',
            'order' => 'nullable|integer|min:1',
        ]);

        $maxOrder = QuizQuestion::where('quiz_type', $type)->max('order') ?? 0;

        QuizQuestion::create([
            'quiz_type' => $type,
            'question_text' => $request->question_text,
            'options' => array_values($request->options),
            'correct_option' => (int) $request->correct_option,
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
            'correct_option' => 'required|integer|min:0|max:3',
        ]);

        $question->update([
            'question_text' => $request->question_text,
            'options' => array_values($request->options),
            'correct_option' => (int) $request->correct_option,
        ]);

        return back()->with('success', 'Question updated.');
    }

    public function destroyQuestion(Request $request, $type, $id)
    {
        $question = QuizQuestion::where('quiz_type', $type)->findOrFail($id);
        $question->delete();
        return back()->with('success', 'Question deleted.');
    }

    public function reorderQuestions(Request $request, $type)
    {
        $request->validate(['order' => 'required|array']);
        foreach ($request->order as $order => $id) {
            QuizQuestion::where('quiz_type', $type)->where('id', $id)->update(['order' => $order + 1]);
        }
        return response()->json(['success' => true]);
    }

    public function showQuestion(Request $request, $type)
    {
        $session = QuizSession::where('quiz_type', $type)->whereIn('status', ['waiting', 'active', 'paused'])->first();
        if (!$session)
            return response()->json(['success' => false, 'message' => 'No active session'], 404);

        $nextOrder = $session->current_question_order + 1;
        $question = QuizQuestion::where('quiz_type', $type)->where('order', $nextOrder)->first();

        if (!$question) {
            return response()->json(['success' => false, 'message' => 'No more questions'], 404);
        }

        if ($session->current_question_order === 0) {
            $session->update(['status' => 'active', 'started_at' => now()]);
        }

        $session->update(['current_question_order' => $nextOrder]);

        broadcast(new \App\Events\Quiz\QuestionShown($session, $question))->toOthers();

        return response()->json(['success' => true, 'question_order' => $nextOrder, 'question' => $question]);
    }

    public function prevQuestion(Request $request, $type)
    {
        $session = QuizSession::where('quiz_type', $type)->whereIn('status', ['active', 'paused'])->first();
        if (!$session)
            return response()->json(['success' => false, 'message' => 'No active session'], 404);

        $prevOrder = max(1, $session->current_question_order - 1);
        $question = QuizQuestion::where('quiz_type', $type)->where('order', $prevOrder)->first();

        if (!$question) {
            return response()->json(['success' => false, 'message' => 'No previous question'], 404);
        }

        $session->update(['current_question_order' => $prevOrder]);

        broadcast(new \App\Events\Quiz\QuestionShown($session, $question))->toOthers();

        return response()->json(['success' => true, 'question_order' => $prevOrder, 'question' => $question]);
    }

    public function pause(Request $request, $type)
    {
        $session = QuizSession::where('quiz_type', $type)->where('status', 'active')->first();
        if (!$session)
            return response()->json(['success' => false, 'message' => 'No active session'], 404);

        $session->update(['status' => 'paused']);

        broadcast(new \App\Events\Quiz\QuizPaused($session))->toOthers();

        return response()->json(['success' => true]);
    }

    public function resume(Request $request, $type)
    {
        $session = QuizSession::where('quiz_type', $type)->where('status', 'paused')->first();
        if (!$session)
            return response()->json(['success' => false, 'message' => 'No paused session'], 404);

        $session->update(['status' => 'active']);

        broadcast(new \App\Events\Quiz\QuizResumed($session))->toOthers();

        return response()->json(['success' => true]);
    }

    public function end(Request $request, $type)
    {
        $session = QuizSession::where('quiz_type', $type)->whereIn('status', ['waiting', 'active', 'paused'])->first();
        if (!$session)
            return response()->json(['success' => false, 'message' => 'No active session'], 404);

        $session->update(['status' => 'completed', 'ended_at' => now()]);

        broadcast(new \App\Events\Quiz\QuizEnded($session))->toOthers();

        return response()->json(['success' => true]);
    }

    public function liveDashboard(Request $request, $type)
    {
        $session = QuizSession::where('quiz_type', $type)->whereIn('status', ['waiting', 'active', 'paused'])->firstOrFail();
        $questions = QuizQuestion::where('quiz_type', $type)->orderBy('order')->get();
        $currentQuestion = $questions->firstWhere('order', $session->current_question_order);
        $participantCount = $session->participants()->count();
        $analytics = [];
        $leaderboard = (new QuizService())->getLeaderboard($session, 10);
        if ($currentQuestion) {
            $analytics = (new QuizService())->getQuestionAnalytics($session, $currentQuestion);
        }
        $question = $currentQuestion;

        return view('admin.quiz.live', compact('session', 'type', 'questions', 'currentQuestion', 'participantCount', 'question', 'analytics', 'leaderboard'));
    }

    public function sessionResults(Request $request, $type)
    {
        $session = QuizSession::where('quiz_type', $type)->where('status', 'completed')->orderByDesc('ended_at')->firstOrFail();
        $service = new QuizService();
        $overview = $service->getSessionOverview($session);
        $questions = QuizQuestion::where('quiz_type', $type)->orderBy('order')->get();

        return view('admin.quiz.results', compact('session', 'overview', 'questions', 'type'));
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
}
