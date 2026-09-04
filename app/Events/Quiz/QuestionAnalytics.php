<?php

namespace App\Events\Quiz;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuestionAnalytics implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sessionId;
    public $analytics;

    public function __construct($sessionId, array $analytics)
    {
        $this->sessionId = $sessionId;
        $this->analytics = $analytics;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('admin.quiz.' . $this->sessionId);
    }

    public function broadcastAs(): string
    {
        return 'quiz.question.analytics';
    }

    public function broadcastWith(): array
    {
        return $this->analytics;
    }
}
