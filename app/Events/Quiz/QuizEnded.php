<?php

namespace App\Events\Quiz;

use App\Models\QuizSession;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuizEnded implements ShouldBroadcastNow
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
        return 'quiz.ended';
    }

    public function broadcastWith(): array
    {
        return [
            'session_id' => $this->session->id,
            'message' => 'Quiz has ended',
            'results_url' => url('/quiz/results?session=' . $this->session->id),
        ];
    }
}
