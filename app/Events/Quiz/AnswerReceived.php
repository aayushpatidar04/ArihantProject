<?php

namespace App\Events\Quiz;

use App\Models\QuizAnswer;
use App\Models\QuizParticipant;
use App\Models\QuizSession;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Lightweight on purpose: one grouped query, no leaderboard.
 * (The old version rebuilt analytics + a 20-row leaderboard for every single answer.)
 */
class AnswerReceived implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $session;
    public $participant;
    public $answer;
    public $answeredCount;
    public $optionCounts = [0, 0, 0, 0];
    public $correctCount = 0;

    public function __construct(QuizSession $session, QuizParticipant $participant, QuizAnswer $answer)
    {
        $this->session = $session;
        $this->participant = $participant;
        $this->answer = $answer;
        $rows = QuizAnswer::where('session_id', $session->id)
            ->where('question_id', $answer->question_id)
            ->selectRaw('selected_option, COUNT(*) AS c, SUM(is_correct) AS ok')
            ->groupBy('selected_option')->get();
        foreach ($rows as $r) {
            if (isset($this->optionCounts[$r->selected_option]))
                $this->optionCounts[$r->selected_option] = (int) $r->c;
            $this->correctCount += (int) $r->ok;
        }
        $this->answeredCount = array_sum($this->optionCounts);
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
            'question_id' => $this->answer->question_id,
            'participant_id' => $this->participant->id,
            'participant_name' => $this->participant->name,
            'total_responded' => $this->answeredCount,
            // consumed by the legacy admin live dashboard
            'option_counts' => $this->optionCounts,
            'correct_count' => $this->correctCount,
            'correct_rate' => $this->answeredCount > 0 ? round($this->correctCount / $this->answeredCount * 100, 1) : 0,
        ];
    }
}
