<?php

namespace App\Events\Quiz;

use App\Models\QuizSession;
use App\Models\QuizParticipant;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ParticipantJoined implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $session;
    public $participant;
    public $totalParticipants;

    public function __construct(QuizSession $session, QuizParticipant $participant)
    {
        $this->session = $session;
        $this->participant = $participant;
        $this->totalParticipants = $session->participants()->count();
    }

    public function broadcastOn(): Channel
    {
        return new Channel('admin.quiz.' . $this->session->id);
    }

    public function broadcastAs(): string
    {
        return 'quiz.participant.joined';
    }

    public function broadcastWith(): array
    {
        return [
            'session_id' => $this->session->id,
            'participant_name' => $this->participant->name,
            'participant_id' => $this->participant->id,
            'total_participants' => $this->totalParticipants,
        ];
    }
}
