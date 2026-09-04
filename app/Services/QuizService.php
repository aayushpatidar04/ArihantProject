<?php

namespace App\Services;

use App\Models\QuizSession;
use App\Models\QuizQuestion;
use App\Models\QuizParticipant;
use App\Models\QuizAnswer;
use Illuminate\Support\Facades\DB;

class QuizService
{
    public function generatePin(): string
    {
        return str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
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
            $active->update(['status' => 'completed', 'ended_at' => now()]);
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

    public function recordAnswer(QuizSession $session, QuizParticipant $participant, QuizQuestion $question, int $selectedOption): QuizAnswer
    {
        $isCorrect = $selectedOption === $question->correct_option;
        $responseTime = null;

        $questionStartTime = session("quiz_q{$question->id}_start") ?? now();
        if (!session()->has("quiz_q{$question->id}_start")) {
            session(["quiz_q{$question->id}_start" => $questionStartTime]);
        }

        if ($isCorrect) {
            $responseTime = (int) $questionStartTime->diffInMilliseconds(now());
        }

        $answer = QuizAnswer::create([
            'session_id' => $session->id,
            'participant_id' => $participant->id,
            'question_id' => $question->id,
            'selected_option' => $selectedOption,
            'is_correct' => $isCorrect,
            'response_time_ms' => $responseTime,
            'submitted_at' => now(),
        ]);

        session()->forget("quiz_q{$question->id}_start");

        return $answer;
    }

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

    public function getLeaderboard(QuizSession $session, int $limit = 10): array
    {
        $participants = $session->participants()->get();

        $leaderboard = $participants->map(function ($participant) use ($session) {
            $answers = QuizAnswer::where('session_id', $session->id)
                ->where('participant_id', $participant->id)
                ->get();

            $correctCount = $answers->where('is_correct', true)->count();
            $score = $correctCount * config('quiz.points_per_correct', 10);
            $correctResponseTimes = $answers->where('is_correct', true)->pluck('response_time_ms')->filter();
            $avgResponseTime = $correctResponseTimes->isNotEmpty() ? (int) $correctResponseTimes->avg() : null;

            return [
                'participant_id' => $participant->id,
                'name' => $participant->name,
                'email' => $participant->email,
                'score' => $score,
                'correct_count' => $correctCount,
                'total_answered' => $answers->count(),
                'avg_response_time_ms' => $avgResponseTime,
            ];
        })->sort(function ($a, $b) {
            if ($b['score'] !== $a['score'])
                return $b['score'] <=> $a['score'];
            if ($b['correct_count'] !== $a['correct_count'])
                return $b['correct_count'] <=> $a['correct_count'];
            if ($a['avg_response_time_ms'] === null && $b['avg_response_time_ms'] === null)
                return 0;
            if ($a['avg_response_time_ms'] === null)
                return 1;
            if ($b['avg_response_time_ms'] === null)
                return -1;
            return $a['avg_response_time_ms'] <=> $b['avg_response_time_ms'];
        })->values()->toArray();

        $rank = 1;
        $prevScore = null;
        $prevCorrect = null;
        $prevTime = null;
        $sharedRankCount = 0;

        foreach ($leaderboard as $index => $entry) {
            if (
                $prevScore !== null &&
                $entry['score'] === $prevScore &&
                $entry['correct_count'] === $prevCorrect &&
                $entry['avg_response_time_ms'] === $prevTime
            ) {
                $leaderboard[$index]["rank"] = $rank;
                $sharedRankCount++;
            } else {
                $rank = $index + 1;
                $leaderboard[$index]["rank"] = $rank;
                $sharedRankCount = 0;
            }
            $prevScore = $entry['score'];
            $prevCorrect = $entry['correct_count'];
            $prevTime = $entry['avg_response_time_ms'];
        }

        return array_slice($leaderboard, 0, $limit);
    }

    public function getParticipantResults(QuizSession $session, QuizParticipant $participant): array
    {
        $questions = QuizQuestion::where('quiz_type', $session->quiz_type)
            ->orderBy('order')
            ->get();

        $answers = QuizAnswer::where('session_id', $session->id)
            ->where('participant_id', $participant->id)
            ->get()
            ->keyBy('question_id');

        $totalCorrect = 0;
        $totalResponseTime = 0;
        $correctCount = 0;

        $breakdown = $questions->map(function ($q) use ($answers, &$totalCorrect, &$totalResponseTime, &$correctCount) {
            $answer = $answers->get($q->id);
            $isCorrect = $answer?->is_correct ?? false;
            $responseTime = $answer?->response_time_ms;

            if ($isCorrect) {
                $totalCorrect++;
                if ($responseTime) {
                    $totalResponseTime += $responseTime;
                    $correctCount++;
                }
            }

            return [
                'question_text' => $q->question_text,
                'options' => $q->options,
                'correct_option' => $q->correct_option,
                'selected_option' => $answer?->selected_option,
                'is_correct' => $isCorrect,
                'response_time_ms' => $responseTime,
            ];
        })->all();

        $score = $totalCorrect * config('quiz.points_per_correct', 10);
        $avgResponseTime = $correctCount > 0 ? round($totalResponseTime / $correctCount) : null;

        $allLeaderboard = $this->getLeaderboard($session, 1000);
        $rank = collect($allLeaderboard)->firstWhere('participant_id', $participant->id)['rank'] ?? null;

        return [
            'rank' => $rank,
            'score' => $score,
            'correct_count' => $totalCorrect,
            'total_questions' => $questions->count(),
            'avg_response_time_ms' => $avgResponseTime,
            'breakdown' => $breakdown,
        ];
    }

    public function getSessionOverview(QuizSession $session): array
    {
        $totalParticipants = $session->participants()->count();
        $totalQuestions = QuizQuestion::where('quiz_type', $session->quiz_type)->count();
        $totalAnswers = QuizAnswer::where('session_id', $session->id)->count();

        $allScores = $this->getLeaderboard($session, 1000);
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
}
