<?php

namespace App\Events\Quiz;

use App\Models\QuizSession;
use App\Models\QuizQuestion;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuizStarted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $session;
    public $quizType;
    public $totalQuestions;
    public $qrPath;

    public function __construct(QuizSession $session, $qrPath)
    {
        $this->session = $session;
        $this->qrPath = $qrPath;
        $this->quizType = \App\Models\QuizType::where('key', $session->quiz_type)->first();
        $this->totalQuestions = QuizQuestion::where('quiz_type', $session->quiz_type)->count();
    }

    public function broadcastOn(): Channel
    {
        return new Channel('quiz.started');
    }

    public function broadcastAs(): string
    {
        return 'quiz.session.started';
    }

    public function broadcastWith(): array
    {
        return [
            'session_id' => $this->session->id,
            'quiz_type' => $this->session->quiz_type,
            'quiz_name' => $this->quizType->name ?? 'Quiz',
            'pin' => $this->session->pin,
            'status' => $this->session->status,
            'current_question_order' => $this->session->current_question_order,
            'total_questions' => $this->totalQuestions,
            'started_at' => $this->session->started_at ? $this->session->started_at->toIso8601String() : null,
            'qr_url' => url('/storage/' . $this->qrPath),
        ];
    }
}
