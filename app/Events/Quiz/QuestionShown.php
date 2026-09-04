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

class QuestionShown implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $session;
    public $question;
    public $questionOrder;
    public $totalQuestions;

    public function __construct(QuizSession $session, QuizQuestion $question)
    {
        $this->session = $session;
        $this->question = $question;
        $this->questionOrder = $question->order;
        $this->totalQuestions = QuizQuestion::where('quiz_type', $session->quiz_type)->count();
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
        return [
            'session_id' => $this->session->id,
            'question_id' => $this->question->id,
            'question_text' => $this->question->question_text,
            'options' => $this->question->options,
            'correct_option' => $this->question->correct_option,
           
            'question_order' => $this->questionOrder,
            'total_questions' => $this->totalQuestions,
            'server_time' => now()->toIso8601String(),
        ];
    }
}
