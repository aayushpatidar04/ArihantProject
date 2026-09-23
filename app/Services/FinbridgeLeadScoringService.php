<?php

namespace App\Services;

class FinbridgeLeadScoringService
{
    public function score(array $data): int
    {
        $score = 0;

        // 1. Interest
        $score += match ($data['interest'] ?? null) {
            'both'       => 20,
            'trading'    => 15,
            'investing'  => 15,
            'exploring'  => 5,
            default      => 0,
        };

        // 2. Existing Demat/Trading Account
        $score += match ($data['has_demat'] ?? null) {
            'yes'   => 15,
            'no'    => 5,
            default => 0,
        };

        // 3. Current Activity
        $score += match ($data['invest_frequency'] ?? null) {
            'regularly'         => 20,
            'occasionally'      => 10,
            'planning_to_start' => 15,
            'dont_invest'       => 0,
            default             => 0,
        };

        // 4. Timeline
        $score += match ($data['start_timeline'] ?? null) {
            'immediately'      => 25,
            'within_1_month'   => 20,
            'within_3_months'  => 10,
            'not_sure'         => 0,
            default            => 0,
        };

        return $score;
    }

    public function status(int $score): string
    {
        return match (true) {
            $score >= 60 => 'hot',
            $score >= 35 => 'warm',
            default      => 'cold',
        };
    }

    /**
     * Convenience: score + status in one call.
     */
    public function evaluate(array $data): array
    {
        $score = $this->score($data);

        return ['lead_score' => $score, 'lead_status' => $this->status($score)];
    }
}