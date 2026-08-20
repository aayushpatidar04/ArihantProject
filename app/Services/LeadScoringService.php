<?php

namespace App\Services;

use App\Models\EventRegistration;
use App\Models\LeadScore;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LeadScoringService
{
    protected array $weights = [
        'registration' => 10,
        'kyc' => 20,
        'quiz' => 15,
        'stall_visit' => 10,
        'referral' => 25,
        'social' => 20,
    ];

    /**
     * Recalculate and update lead score for a registration.
     */
    public function calculateScore(EventRegistration $registration): LeadScore
    {
        $score = LeadScore::firstOrNew(['event_registration_id' => $registration->id]);

        // Registration base
        $score->registration_score = $this->weights['registration'];

        // KYC completion
        $score->kyc_score = $registration->kyc && $registration->kyc->validation_status === 'verified'
            ? $this->weights['kyc']
            : 0;

        // Quiz average
        $avgQuiz = $registration->stallVisits()->avg('quiz_score') ?? 0;
        $score->quiz_score = min($this->weights['quiz'], round($avgQuiz / 100 * $this->weights['quiz']));

        // Stall visits (max 5 visits = full score)
        $visitCount = $registration->stallVisits()->count();
        $score->stall_visit_score = min($this->weights['stall_visit'], $visitCount * ($this->weights['stall_visit'] / 5));

        // Referrals (max 5 successful = full score)
        $referralCount = $registration->referralsMade()->where('status', 'paid')->count();
        $score->referral_score = min($this->weights['referral'], $referralCount * ($this->weights['referral'] / 5));

        // Social posts approved
        $socialCount = $registration->influencerPosts()->where('status', 'approved')->count();
        $score->social_score = min($this->weights['social'], $socialCount * ($this->weights['social'] / 5));

        $score->total_score = $score->registration_score
            + $score->kyc_score
            + $score->quiz_score
            + $score->stall_visit_score
            + $score->referral_score
            + $score->social_score;

        $score->save();

        // Push to CRM if threshold met
        if ($score->total_score >= 50 && !$score->synced_to_crm) {
            $this->pushToCrm($registration, $score);
        }

        return $score;
    }

    /**
     * Push lead score to external CRM/eKYC system.
     */
    protected function pushToCrm(EventRegistration $registration, LeadScore $score): void
    {
        $crmUrl = config('services.crm.push_url');
        $crmKey = config('services.crm.api_key');

        if (empty($crmUrl)) {
            Log::info('CRM URL not configured. Skipping sync for registration ' . $registration->id);
            return;
        }

        try {
            $response = Http::withToken($crmKey)->post($crmUrl, [
                'registration_number' => $registration->registration_number,
                'name' => $registration->full_name,
                'email' => $registration->email,
                'phone' => $registration->phone,
                'lead_score' => $score->total_score,
                'breakdown' => [
                    'registration' => $score->registration_score,
                    'kyc' => $score->kyc_score,
                    'quiz' => $score->quiz_score,
                    'stall_visits' => $score->stall_visit_score,
                    'referrals' => $score->referral_score,
                    'social' => $score->social_score,
                ],
                'event' => 'ArihantPLUS AI & Algo Conclave 2026',
                'timestamp' => now()->toIso8601String(),
            ]);

            if ($response->successful()) {
                $score->update(['synced_to_crm' => true, 'synced_at' => now()]);
            } else {
                Log::error('CRM push failed: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('CRM push exception: ' . $e->getMessage());
        }
    }
}
