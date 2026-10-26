<?php

namespace App\Services;

use App\Models\QuizAnswer;
use App\Models\QuizParticipant;
use App\Models\QuizQuestion;
use App\Models\QuizSession;
use App\Models\QuizType;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;

class QuizService
{
    /* ------------------------------------------------------------------ */
    /*  Session helpers                                                    */
    /* ------------------------------------------------------------------ */

    public function generatePin(): string
    {
        do {
            $pin = str_pad((string) random_int(0, 999999), config('quiz.pin_length', 6), '0', STR_PAD_LEFT);
        } while (QuizSession::where('pin', $pin)->exists());

        return $pin;
    }

    public function generateQrCode(string $quizType): string
    {
        $url = url('/quiz?type=' . $quizType);
        $qr = new \Endroid\QrCode\QrCode($url);
        $qr->setSize(400)->setMargin(10);
        $qr->setForegroundColor(new \Endroid\QrCode\Color\Color(255, 255, 255));
        $qr->setBackgroundColor(new \Endroid\QrCode\Color\Color(6, 2, 8));
        $writer = new \Endroid\QrCode\Writer\PngWriter();
        $result = $writer->write($qr);
        $path = "qrcodes/quiz_{$quizType}.png";
        \Storage::disk('public')->put($path, $result->getString());
        return $path;
    }

    public function endPreviousActiveSession(): ?QuizSession
    {
        $active = QuizSession::whereIn('status', ['waiting', 'active', 'paused'])->first();
        if ($active) {
            $active->update(['status' => 'completed', 'phase' => 'podium', 'ended_at' => now()]);
            return $active;
        }
        return null;
    }

    public function getActiveSessionForType(string $quizType): ?QuizSession
    {
        return QuizSession::where('quiz_type', $quizType)
            ->whereIn('status', ['waiting', 'active', 'paused'])
            ->orderByDesc('started_at')
            ->first();
    }

    public function getCurrentQuestion(QuizSession $session): ?QuizQuestion
    {
        if ($session->current_question_order <= 0)
            return null;
        return QuizQuestion::where('quiz_type', $session->quiz_type)
            ->where('order', $session->current_question_order)
            ->first();
    }

    public function totalQuestions(QuizSession $session): int
    {
        return QuizQuestion::where('quiz_type', $session->quiz_type)->count();
    }

    public function nowMs(): int
    {
        return (int) round(microtime(true) * 1000);
    }

    /* ------------------------------------------------------------------ */
    /*  Question timing                                                    */
    /* ------------------------------------------------------------------ */

    /**
     * Put a question on screen. Players first "read" it (options locked), then the answer timer runs.
     */
    public function openQuestion(QuizSession $session, QuizQuestion $question): void
    {
        $now = $this->nowMs();
        $opens = $now + (int) config('quiz.read_time_seconds', 4) * 1000;
        $ends = $opens + $question->timeLimitSeconds() * 1000;

        $session->update([
            'status' => 'active',
            'phase' => 'question',
            'started_at' => $session->started_at ?? now(),
            'current_question_order' => $question->order,
            'question_started_at' => now()->addSeconds((int) config('quiz.read_time_seconds', 4)),
            'question_opens_at_ms' => $opens,
            'question_ends_at_ms' => $ends,
            'paused_remaining_ms' => null,
        ]);
    }

    public function pauseTimer(QuizSession $session): void
    {
        $remaining = $session->phase === 'question'
            ? max(0, (int) $session->question_ends_at_ms - $this->nowMs())
            : null;

        $session->update(['status' => 'paused', 'paused_remaining_ms' => $remaining]);
    }

    public function resumeTimer(QuizSession $session): void
    {
        $data = ['status' => 'active'];

        if ($session->phase === 'question' && $session->paused_remaining_ms !== null) {
            $question = $this->getCurrentQuestion($session);
            $limitMs = $question ? $question->timeLimitSeconds() * 1000 : 0;
            $ends = $this->nowMs() + (int) $session->paused_remaining_ms;
            $data['question_ends_at_ms'] = $ends;
            $data['question_opens_at_ms'] = $ends - $limitMs;   // keeps response times pause-proof
            $data['paused_remaining_ms'] = null;
        }

        $session->update($data);
    }

    /* ------------------------------------------------------------------ */
    /*  Answers & scoring                                                  */
    /* ------------------------------------------------------------------ */

    /**
     * @return array{ok:bool, message?:string, answer?:QuizAnswer}
     */
    public function submitAnswer(QuizSession $session, QuizParticipant $participant, QuizQuestion $question, int $selected): array
    {
        $session->refresh();

        if ($session->status === 'paused')
            return ['ok' => false, 'message' => 'Quiz is paused.'];
        if ($session->status !== 'active' || $session->phase !== 'question')
            return ['ok' => false, 'message' => 'This question is closed.'];
        if ((int) $session->current_question_order !== (int) $question->order)
            return ['ok' => false, 'message' => 'That question is no longer live.'];

        $now = $this->nowMs();
        $opens = (int) $session->question_opens_at_ms;
        $ends = (int) $session->question_ends_at_ms;

        if ($now < $opens - 300)
            return ['ok' => false, 'message' => 'Hold on, answers are not open yet.'];
        if ($now > $ends + (int) config('quiz.answer_grace_ms', 1500))
            return ['ok' => false, 'message' => "Time's up!"];

        if (QuizAnswer::where('session_id', $session->id)->where('participant_id', $participant->id)->where('question_id', $question->id)->exists())
            return ['ok' => false, 'message' => 'You already answered.'];

        $limitMs = $question->timeLimitSeconds() * 1000;
        $responseMs = max(0, min($limitMs, $now - $opens));
        $isCorrect = $selected === (int) $question->correct_option;
        $points = $isCorrect ? $this->pointsFor($session, $participant, $question, $responseMs, $limitMs) : 0;

        try {
            $answer = QuizAnswer::create([
                'session_id' => $session->id,
                'participant_id' => $participant->id,
                'question_id' => $question->id,
                'selected_option' => $selected,
                'is_correct' => $isCorrect,
                'points' => $points,
                'response_time_ms' => $responseMs,
                'submitted_at' => now(),
            ]);
        } catch (QueryException $e) {
            return ['ok' => false, 'message' => 'You already answered.'];
        }

        return ['ok' => true, 'answer' => $answer];
    }

    protected function pointsFor(QuizSession $session, QuizParticipant $participant, QuizQuestion $question, int $responseMs, int $limitMs): int
    {
        if (config('quiz.scoring_mode', 'speed') === 'flat') {
            $base = (int) config('quiz.points_per_correct', 10);
        } else {
            $ratio = $limitMs > 0 ? min(1, $responseMs / $limitMs) : 1;
            $base = (int) round(config('quiz.max_points', 1000) * (1 - $ratio / 2));
        }

        $bonusStep = (int) config('quiz.streak_bonus', 0);
        if ($bonusStep > 0) {
            $streak = $this->streakThrough($session->id, $participant->id, $question->order - 1) + 1;
            if ($streak >= 2) {
                $base += min((int) config('quiz.streak_bonus_cap', 500), $bonusStep * ($streak - 1));
            }
        }

        return $base;
    }

    /** Consecutive correct answers ending at question order $throughOrder. */
    public function streakThrough(string $sessionId, int $participantId, int $throughOrder): int
    {
        if ($throughOrder < 1)
            return 0;

        $rows = QuizAnswer::query()
            ->join('quiz_questions as qq', 'qq.id', '=', 'quiz_answers.question_id')
            ->where('quiz_answers.session_id', $sessionId)
            ->where('quiz_answers.participant_id', $participantId)
            ->where('qq.order', '<=', $throughOrder)
            ->orderByDesc('qq.order')
            ->get(['qq.order as q_order', 'quiz_answers.is_correct']);

        $streak = 0;
        $expected = $throughOrder;
        foreach ($rows as $row) {
            if ((int) $row->q_order !== $expected || !$row->is_correct)
                break;
            $streak++;
            $expected--;
        }
        return $streak;
    }

    /* ------------------------------------------------------------------ */
    /*  Analytics & leaderboard                                            */
    /* ------------------------------------------------------------------ */

    public function getQuestionAnalytics(QuizSession $session, QuizQuestion $question): array
    {
        $answers = QuizAnswer::where('session_id', $session->id)
            ->where('question_id', $question->id)
            ->get();

        $totalResponded = $answers->count();
        $optionCounts = [0, 0, 0, 0];
        $correctCount = 0;
        $firstCorrect = null;
        $minResponseTime = null;

        foreach ($answers as $answer) {
            if (isset($optionCounts[$answer->selected_option]))
                $optionCounts[$answer->selected_option]++;
            if ($answer->is_correct) {
                $correctCount++;
                if ($minResponseTime === null || $answer->response_time_ms < $minResponseTime) {
                    $minResponseTime = $answer->response_time_ms;
                    $firstCorrect = $answer->participant;
                }
            }
        }

        $avgResponseTime = $answers->where('is_correct', true)->avg('response_time_ms');

        return [
            'question_id' => $question->id,
            'question_text' => $question->question_text,
            'options' => $question->options,
            'correct_option' => $question->correct_option,
            'option_counts' => $optionCounts,
            'total_responded' => $totalResponded,
            'correct_count' => $correctCount,
            'correct_rate' => $totalResponded > 0 ? round(($correctCount / $totalResponded) * 100, 1) : 0,
            'first_correct' => $firstCorrect ? [
                'name' => $firstCorrect->name,
                'response_time_ms' => $minResponseTime,
            ] : null,
            'avg_response_time_ms' => $avgResponseTime ? (int) $avgResponseTime : null,
        ];
    }

    /**
     * Full ranking in ONE aggregate query (no per-participant queries).
     * Sort: score desc, correct desc, avg correct-answer time asc. Equal on all three = shared rank.
     *
     * @param int|null $excludeQuestionId  rank as it stood before this question (for rank-movement arrows)
     */
    public function rankings(QuizSession $session, ?int $excludeQuestionId = null): array
    {
        $stats = QuizAnswer::query()
            ->where('session_id', $session->id)
            ->when($excludeQuestionId, fn($q) => $q->where('question_id', '!=', $excludeQuestionId))
            ->selectRaw('participant_id, SUM(points) AS score, SUM(is_correct) AS correct_count, COUNT(*) AS total_answered, AVG(CASE WHEN is_correct = 1 THEN response_time_ms END) AS avg_ms')
            ->groupBy('participant_id')
            ->get()
            ->keyBy('participant_id');

        $rows = QuizParticipant::where('session_id', $session->id)
            ->get(['id', 'name', 'email'])
            ->map(function ($p) use ($stats) {
                $s = $stats->get($p->id);
                return [
                    'participant_id' => $p->id,
                    'name' => $p->name,
                    'email' => $p->email,
                    'score' => (int) ($s->score ?? 0),
                    'correct_count' => (int) ($s->correct_count ?? 0),
                    'total_answered' => (int) ($s->total_answered ?? 0),
                    'avg_response_time_ms' => ($s && $s->avg_ms !== null) ? (int) $s->avg_ms : null,
                ];
            })
            ->all();

        usort($rows, function ($a, $b) {
            if ($b['score'] !== $a['score'])
                return $b['score'] <=> $a['score'];
            if ($b['correct_count'] !== $a['correct_count'])
                return $b['correct_count'] <=> $a['correct_count'];
            $at = $a['avg_response_time_ms'];
            $bt = $b['avg_response_time_ms'];
            if ($at === null && $bt === null)
                return 0;
            if ($at === null)
                return 1;
            if ($bt === null)
                return -1;
            return $at <=> $bt;
        });

        $rank = 0;
        $prev = null;
        foreach ($rows as $i => $row) {
            $key = [$row['score'], $row['correct_count'], $row['avg_response_time_ms']];
            if ($prev === null || $key !== $prev)
                $rank = $i + 1;
            $rows[$i]['rank'] = $rank;
            $prev = $key;
        }

        return $rows;
    }

    /** Same ranking, cached briefly so hundreds of phones asking at reveal time cost one query. */
    public function cachedRankings(QuizSession $session, ?int $excludeQuestionId = null): array
    {
        $key = sprintf('quiz:rank:%s:%s:%s:%s', $session->id, $session->current_question_order, $session->phase, $excludeQuestionId ?? 'all');
        return Cache::remember($key, 20, fn() => $this->rankings($session, $excludeQuestionId));
    }

    public function getLeaderboard(QuizSession $session, int $limit = 10): array
    {
        return array_slice($this->rankings($session), 0, $limit);
    }

    public function getParticipantResults(QuizSession $session, QuizParticipant $participant): array
    {
        $questions = QuizQuestion::where('quiz_type', $session->quiz_type)->orderBy('order')->get();

        $answers = QuizAnswer::where('session_id', $session->id)
            ->where('participant_id', $participant->id)
            ->get()
            ->keyBy('question_id');

        $totalCorrect = 0;
        $totalResponseTime = 0;
        $timedCount = 0;
        $score = 0;

        $breakdown = $questions->map(function ($q) use ($answers, &$totalCorrect, &$totalResponseTime, &$timedCount, &$score) {
            $answer = $answers->get($q->id);
            $isCorrect = $answer?->is_correct ?? false;
            $responseTime = $answer?->response_time_ms;
            $points = (int) ($answer?->points ?? 0);

            if ($isCorrect) {
                $totalCorrect++;
                $score += $points;
                if ($responseTime) {
                    $totalResponseTime += $responseTime;
                    $timedCount++;
                }
            }

            return [
                'question_text' => $q->question_text,
                'options' => $q->options,
                'correct_option' => $q->correct_option,
                'selected_option' => $answer?->selected_option,
                'is_correct' => $isCorrect,
                'points' => $points,
                'response_time_ms' => $responseTime,
            ];
        })->all();

        $rank = collect($this->rankings($session))->firstWhere('participant_id', $participant->id)['rank'] ?? null;

        return [
            'rank' => $rank,
            'score' => $score,
            'correct_count' => $totalCorrect,
            'total_questions' => $questions->count(),
            'avg_response_time_ms' => $timedCount > 0 ? round($totalResponseTime / $timedCount) : null,
            'breakdown' => $breakdown,
        ];
    }

    public function getSessionOverview(QuizSession $session): array
    {
        $totalParticipants = $session->participants()->count();
        $totalQuestions = QuizQuestion::where('quiz_type', $session->quiz_type)->count();
        $totalAnswers = QuizAnswer::where('session_id', $session->id)->count();

        $allScores = $this->rankings($session);
        $scores = array_column($allScores, 'score');
        $avgScore = !empty($scores) ? round(array_sum($scores) / count($scores), 1) : 0;

        $questions = QuizQuestion::where('quiz_type', $session->quiz_type)->orderBy('order')->get();
        $questionAnalytics = $questions->map(fn($q) => $this->getQuestionAnalytics($session, $q))->all();

        return [
            'total_participants' => $totalParticipants,
            'total_questions' => $totalQuestions,
            'total_answers' => $totalAnswers,
            'avg_score' => $avgScore,
            'quiz_type' => $session->quiz_type,
            'status' => $session->status,
            'started_at' => $session->started_at,
            'ended_at' => $session->ended_at,
            'question_analytics' => $questionAnalytics,
            'leaderboard' => $allScores,
        ];
    }

    /* ------------------------------------------------------------------ */
    /*  Payloads shared by broadcasts and state endpoints                  */
    /* ------------------------------------------------------------------ */

    public function revealed(QuizSession $session): bool
    {
        return in_array($session->phase, ['reveal', 'scoreboard', 'podium'], true);
    }

    /** The correct option is only included once the question has been revealed. */
    public function questionPayload(QuizSession $session, QuizQuestion $question, bool $includeCorrect = false): array
    {
        $payload = [
            'id' => $question->id,
            'order' => $question->order,
            'total' => $this->totalQuestions($session),
            'text' => $question->question_text,
            'options' => $question->options,
            'time_limit' => $question->timeLimitSeconds(),
            'opens_at_ms' => $session->question_opens_at_ms,
            'ends_at_ms' => $session->question_ends_at_ms,
            'paused' => $session->status === 'paused',
            'paused_remaining_ms' => $session->paused_remaining_ms,
        ];

        if ($includeCorrect)
            $payload['correct_option'] = $question->correct_option;

        return $payload;
    }

    /** Top-N rows with rank movement and points gained on the current question. */
    public function scoreboardPayload(QuizSession $session, int $limit = 5): array
    {
        $question = $this->getCurrentQuestion($session);
        $now = $this->cachedRankings($session);

        $prevRank = [];
        $gain = [];
        if ($question) {
            foreach ($this->cachedRankings($session, $question->id) as $r)
                $prevRank[$r['participant_id']] = $r['rank'];
            $gain = QuizAnswer::where('session_id', $session->id)->where('question_id', $question->id)
                ->pluck('points', 'participant_id')->all();
        }

        return array_map(fn($r) => [
            'participant_id' => $r['participant_id'],
            'name' => $r['name'],
            'score' => $r['score'],
            'rank' => $r['rank'],
            'prev_rank' => $prevRank[$r['participant_id']] ?? $r['rank'],
            'gain' => (int) ($gain[$r['participant_id']] ?? 0),
        ], array_slice($now, 0, $limit));
    }

    /** Everything the big screen needs, restorable after a refresh. */
    public function hostState(QuizSession $session, int $sinceParticipantId = 0): array
    {
        $question = $this->getCurrentQuestion($session);
        $revealed = $this->revealed($session);

        $state = [
            'server_now_ms' => $this->nowMs(),
            'session' => [
                'id' => $session->id,
                'quiz_type' => $session->quiz_type,
                'quiz_name' => QuizType::where('key', $session->quiz_type)->value('name') ?? 'Quiz',
                'pin' => $session->pin,
                'status' => $session->status,
                'phase' => $session->phase,
                'current_question_order' => $session->current_question_order,
                'total_questions' => $this->totalQuestions($session),
            ],
            'participant_count' => $session->participants()->count(),
            'participants' => $session->phase === 'lobby' || $sinceParticipantId > 0
                ? QuizParticipant::where('session_id', $session->id)->where('id', '>', $sinceParticipantId)
                    ->orderBy('id')->limit(1000)->get(['id', 'name'])->map(fn($p) => ['id' => $p->id, 'name' => $p->name])->all()
                : [],
            'question' => $question ? $this->questionPayload($session, $question, $revealed) : null,
            'answered_count' => 0,
            'option_counts' => null,
            'analytics' => null,
            'scoreboard' => null,
            'podium' => null,
        ];

        if ($question) {
            $a = $this->getQuestionAnalytics($session, $question);
            $state['answered_count'] = $a['total_responded'];
            if ($revealed) {
                $state['option_counts'] = $a['option_counts'];
                $state['analytics'] = [
                    'correct_count' => $a['correct_count'],
                    'correct_rate' => $a['correct_rate'],
                    'first_correct' => $a['first_correct'],
                    'avg_response_time_ms' => $a['avg_response_time_ms'],
                ];
            }
        }

        if (in_array($session->phase, ['scoreboard'], true))
            $state['scoreboard'] = $this->scoreboardPayload($session, 5);

        if ($session->phase === 'podium')
            $state['podium'] = array_slice($this->rankings($session), 0, 10);

        return $state;
    }

    /** What one phone needs. Never leaks the correct option before reveal. */
    public function participantState(QuizSession $session, ?QuizParticipant $participant): array
    {
        $question = $this->getCurrentQuestion($session);
        $revealed = $this->revealed($session);

        $state = [
            'server_now_ms' => $this->nowMs(),
            'status' => $session->status,
            'phase' => $session->phase,
            'participant_count' => $session->participants()->count(),
            'question' => $question && $session->phase !== 'lobby' ? $this->questionPayload($session, $question, $revealed) : null,
            'me' => null,
            'final' => null,
        ];

        if (!$participant)
            return $state;

        $me = ['id' => $participant->id, 'name' => $participant->name, 'answered' => false, 'selected_option' => null];

        if ($question) {
            $answer = QuizAnswer::where('session_id', $session->id)
                ->where('participant_id', $participant->id)
                ->where('question_id', $question->id)->first();
            if ($answer) {
                $me['answered'] = true;
                $me['selected_option'] = $answer->selected_option;
                if ($revealed) {
                    $me['is_correct'] = $answer->is_correct;
                    $me['points_earned'] = $answer->points;
                }
            } elseif ($revealed) {
                $me['is_correct'] = false;
                $me['points_earned'] = 0;
            }
        }

        if ($revealed) {
            $ranking = $this->cachedRankings($session);
            foreach ($ranking as $i => $row) {
                if ($row['participant_id'] === $participant->id) {
                    $me['rank'] = $row['rank'];
                    $me['score'] = $row['score'];
                    $me['correct_count'] = $row['correct_count'];
                    $me['total_players'] = count($ranking);
                    if ($i > 0) {
                        $me['ahead'] = ['name' => $ranking[$i - 1]['name'], 'gap' => $ranking[$i - 1]['score'] - $row['score']];
                    }
                    break;
                }
            }
            if ($question)
                $me['streak'] = $this->streakThrough($session->id, $participant->id, $question->order);
        }

        $state['me'] = $me;

        if ($session->phase === 'podium') {
            $results = $this->getParticipantResults($session, $participant);
            $state['final'] = [
                'rank' => $results['rank'],
                'score' => $results['score'],
                'correct_count' => $results['correct_count'],
                'total_questions' => $results['total_questions'],
                'avg_response_time_ms' => $results['avg_response_time_ms'],
                'top3' => array_map(fn($r) => ['name' => $r['name'], 'score' => $r['score'], 'rank' => $r['rank']],
                    array_slice($this->cachedRankings($session), 0, 3)),
                'results_url' => url('/quiz/results?session=' . $session->id),
            ];
        }

        return $state;
    }
}
