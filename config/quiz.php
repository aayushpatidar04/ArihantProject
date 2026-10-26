<?php

return [
    // 'speed' = Kahoot-style (faster correct answers earn more), 'flat' = fixed points per correct answer
    'scoring_mode' => env('QUIZ_SCORING_MODE', 'speed'),
    'points_per_correct' => 10,          // used when scoring_mode = flat
    'max_points' => 1000,                // used when scoring_mode = speed (instant answer = max, last-second = half)
    'streak_bonus' => 100,               // extra points per streak step (0 disables)
    'streak_bonus_cap' => 500,

    'default_time_limit' => 20,          // seconds, when a question has no time_limit
    'read_time_seconds' => 4,            // question is shown alone for this long before options unlock
    'answer_grace_ms' => 1500,           // network allowance after the timer ends

    'max_questions' => 50,
    'max_participants' => 1000,
    'pin_length' => 6,
    'polling_interval_ms' => 3000,
    'host_polling_interval_ms' => 2000,
];
