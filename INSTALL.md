# Kahoot-style live flow: install

Copy these files over your project (same paths), then:

    php artisan migrate        # adds quiz_sessions.phase/timing columns + quiz_answers.points
    php artisan config:clear

New: resources/views/admin/quiz/host.blade.php (big screen), app/Events/Quiz/QuestionRevealed.php, ScoreboardShown.php,
     database/migrations/2026_10_23_000000_add_live_flow_columns_to_quiz_tables.php
Changed: routes/web.php (4 routes + throttle on validate-pin), config/quiz.php, QuizService, QuizController,
     AdminQuizController, models (Session/Question/Answer), events (QuestionShown/Paused/Resumed/Ended/AnswerReceived),
     quiz/index.blade.php (phone flow), admin/quiz/index.blade.php (opens host tab), quiz/results.blade.php.

Flow: Start Quiz -> host tab opens -> lobby (PIN, QR, names pop in) -> Start -> question (read time, timer, options)
      -> reveal (bar chart) -> leaderboard -> next ... -> podium.  Keys on host: Space/Enter = next, F = fullscreen, M = mute.

Tuning (config/quiz.php): scoring_mode speed|flat, max_points, streak_bonus, default_time_limit, read_time_seconds.
Per-question time uses the existing "time limit" field, which is now actually saved.
