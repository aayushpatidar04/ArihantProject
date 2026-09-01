<?php

namespace App\Services;

use App\Models\InfluencerPost;
use App\Models\User;

class InfluencerScoringService
{
    /**
     * Points awarded for an approved influencer post.
     */
    protected int $approvedPostPoints = 20;

    public function approvePost(InfluencerPost $post): void
    {
        $post->update([
            'status' => 'approved',
            'points_awarded' => $this->approvedPostPoints,
            'approved_at' => now(),
        ]);
    }

    public function rejectPost(
        InfluencerPost $post,
        ?string $reason = null
    ): void {
        $post->update([
            'status' => 'rejected',
            'points_awarded' => 0,
            'admin_notes' => $reason,
            'approved_at' => null,
        ]);
    }

    public function getTotalScore(User $user): int
    {
        return (int) $user->influencerPosts()
            ->where('status', 'approved')
            ->sum('points_awarded');
    }
}