<?php

namespace App\Events\Quiz;

use App\Models\QuizSession;
use App\Services\QuizService;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/** Between-question leaderboard. Phones refetch their own rank on this event. */
class ScoreboardShown implements ShouldBroadcastNow
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
        return 'quiz.scoreboard.shown';
    }

    public function broadcastWith(): array
    {
        return [
            'session_id' => $this->session->id,
            'phase' => 'scoreboard',
            'server_now_ms' => (new QuizService())->nowMs(),
        ];
    }
}
