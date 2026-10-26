<?php

namespace App\Events\Quiz;

use App\Models\QuizQuestion;
use App\Models\QuizSession;
use App\Services\QuizService;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * A new question goes live. The correct option is deliberately NOT included
 * (this channel is public); it arrives later in QuestionRevealed.
 */
class QuestionShown implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $session;
    public $question;

    public function __construct(QuizSession $session, QuizQuestion $question)
    {
        $this->session = $session;
        $this->question = $question;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('quiz.' . $this->session->id);
    }

    public function broadcastAs(): string
    {
        return 'quiz.question.shown';
    }

    public function broadcastWith(): array
    {
        $svc = new QuizService();
        return [
            'session_id' => $this->session->id,
            'phase' => 'question',
            'server_now_ms' => $svc->nowMs(),
            'question' => $svc->questionPayload($this->session, $this->question, false),
            // kept for the legacy admin live dashboard
            'question_id' => $this->question->id,
            'question_text' => $this->question->question_text,
            'options' => $this->question->options,
            'question_order' => $this->question->order,
            'total_questions' => $svc->totalQuestions($this->session),
        ];
    }
}
