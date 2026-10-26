<?php

namespace App\Events\Quiz;

use App\Models\QuizSession;
use App\Services\QuizService;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuizResumed implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $session;

    public function __construct(QuizSession $session)
    {
        $this->session = $session;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('quiz.' . $this->session->id);
    }

    public function broadcastAs(): string
    {
        return 'quiz.question.resumed';
    }

    public function broadcastWith(): array
    {
        $svc = new QuizService();
        $question = $svc->getCurrentQuestion($this->session);
        return [
            'session_id' => $this->session->id,
            'message' => 'Quiz resumed',
            'server_now_ms' => $svc->nowMs(),
            'question' => $question ? $svc->questionPayload($this->session, $question, $svc->revealed($this->session)) : null,
        ];
    }
}
