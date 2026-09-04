<?php

namespace App\Events\Quiz;

use App\Models\QuizSession;
use App\Models\QuizParticipant;
use App\Models\QuizAnswer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AnswerReceived implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $session;
    public $participant;
    public $answer;
    public $analytics;
    public $leaderboard;

    public function __construct(QuizSession $session, QuizParticipant $participant, QuizAnswer $answer)
    {
        $this->session = $session;
        $this->participant = $participant;
        $this->answer = $answer;

        $quizService = new \App\Services\QuizService();
        $this->analytics = $quizService->getQuestionAnalytics($session, $answer->question);
        $this->leaderboard = $quizService->getLeaderboard($session, 20);
    }

    public function broadcastOn(): Channel
    {
        return new Channel('admin.quiz.' . $this->session->id);
    }

    public function broadcastAs(): string
    {
        return 'quiz.answer.received';
    }

    public function broadcastWith(): array
    {
        return [
            'session_id' => $this->session->id,
            'participant_name' => $this->participant->name,
            'participant_id' => $this->participant->id,
            'selected_option' => $this->answer->selected_option,
            'is_correct' => $this->answer->is_correct,
            'response_time_ms' => $this->answer->response_time_ms,
            'submitted_at' => $this->answer->submitted_at->toIso8601String(),
            'option_counts' => $this->analytics['option_counts'] ?? [],
            'total_responded' => $this->analytics['total_responded'] ?? 0,
            'correct_count' => $this->analytics['correct_count'] ?? 0,
            'correct_rate' => $this->analytics['correct_rate'] ?? 0,
            'avg_response_time_ms' => $this->analytics['avg_response_time_ms'] ?? 0,
            'first_correct' => $this->analytics['first_correct'] ?? null,
            'leaderboard' => $this->leaderboard,
        ];
    }
}
