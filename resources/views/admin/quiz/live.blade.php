@extends('layouts.app')

@section('title', 'Live Quiz Dashboard — ArihantPLUS')

@push('styles')
    <style>
        .live-page {
            padding: 20px 24px;
            min-height: 100vh;
            background: #000
        }

        .live-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08)
        }

        .live-header h1 {
            font-size: 20px;
            font-weight: 700
        }

        .live-grid {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 24px
        }

        .question-card {
            background: linear-gradient(165deg, #170b22 0%, #0b0511 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 40px;
            min-height: 400px
        }

        .q-order {
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 12px
        }

        .q-text {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 32px;
            line-height: 1.4
        }

        .q-options-grid {
            display: grid;
            gap: 12px
        }

        .q-opt {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px 20px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.3s
        }

        .q-opt-letter {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px
        }

        .q-opt-text {
            flex: 1;
            font-size: 15px
        }

        .q-opt-bar {
            height: 6px;
            border-radius: 3px;
            background: rgba(255, 255, 255, 0.1);
            flex: 1;
            max-width: 200px;
            overflow: hidden
        }

        .q-opt-bar-fill {
            height: 100%;
            border-radius: 3px;
            background: var(--purple-1);
            transition: width 0.5s
        }

        .q-opt-count {
            font-size: 14px;
            font-weight: 700;
            min-width: 40px;
            text-align: right
        }

        .q-opt.correct-reveal {
            border-color: rgba(40, 180, 100, 0.5);
            background: rgba(40, 180, 100, 0.08)
        }

        .q-opt.wrong-reveal {
            border-color: rgba(220, 60, 60, 0.3);
            opacity: 0.7
        }

        .no-question {
            text-align: center;
            padding: 80px 20px;
            color: var(--muted)
        }

        .no-question-icon {
            font-size: 48px;
            margin-bottom: 16px
        }

        .first-correct-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 215, 0, 0.12);
            border: 1px solid rgba(255, 215, 0, 0.3);
            padding: 8px 16px;
            border-radius: 999px;
            font-size: 13px;
            color: #ffd700;
            margin-bottom: 20px
        }

        .stats-summary {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
            flex-wrap: wrap
        }

        .stat-pill {
            padding: 8px 16px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            font-size: 13px
        }

        .stat-pill strong {
            color: var(--purple-1)
        }

        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 20px
        }

        .sidebar-card {
            background: linear-gradient(165deg, #170b22 0%, #0b0511 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 20px
        }

        .sidebar-card h3 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 16px
        }

        .leaderboard-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04)
        }

        .leaderboard-item:last-child {
            border: none
        }

        .lb-rank {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 12px
        }

        .lb-rank.gold {
            background: rgba(255, 215, 0, 0.2);
            color: #ffd700
        }

        .lb-rank.silver {
            background: rgba(192, 192, 192, 0.2);
            color: #c0c0c0
        }

        .lb-rank.bronze {
            background: rgba(205, 127, 50, 0.2);
            color: #cd7f32
        }

        .lb-name {
            flex: 1;
            font-size: 14px
        }

        .lb-score {
            font-weight: 700;
            color: var(--purple-1)
        }

        .controls-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(11, 5, 17, 0.95);
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding: 16px 24px;
            display: flex;
            justify-content: center;
            gap: 12px;
            z-index: 50;
            backdrop-filter: blur(10px)
        }

        .btn-control {
            padding: 10px 24px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer
        }

        .btn-next {
            background: linear-gradient(135deg, #d43fe0, #7a1fc9);
            color: #fff
        }

        .btn-prev {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: var(--muted)
        }

        .btn-pause {
            background: rgba(255, 180, 0, 0.15);
            border: 1px solid rgba(255, 180, 0, 0.3);
            color: #ffd700
        }

        .btn-end {
            background: rgba(220, 60, 60, 0.15);
            border: 1px solid rgba(220, 60, 60, 0.3);
            color: #f87171
        }

       
        .previous-questions {
            margin-top: 24px
        }

        .prev-q-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 14px;
            padding: 16px;
            margin-bottom: 12px
        }

        .prev-q-text {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px
        }

        .prev-q-stats {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            font-size: 12px;
            color: var(--muted)
        }

        .prev-q-stats span {
            background: rgba(255, 255, 255, 0.04);
            padding: 3px 8px;
            border-radius: 6px
        }

        @media(max-width:900px) {
            .live-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <div class="live-page">
        <div class="live-header">
            <div>
                <h1>📊 {{ \App\Models\QuizType::where('key', $type)->value('name') ?? 'Quiz' }} — Live Dashboard</h1>
                <p style="color:var(--muted);font-size:13px;margin-top:4px">Status: <strong
                        style="color:#8ff0b3">{{ ucfirst($session->status) }}</strong> | Participants:
                    <strong>{{ $participantCount }}</strong></p>
            </div>
            <div style="display:flex;gap:10px">
                <a href="{{ route('admin.quiz.index') }}" class="btn btn-ghost">← All Quizzes</a>
                @if($session->status === 'completed')
                    <a href="{{ route('admin.quiz.results', $type) }}" class="btn btn-primary">📋 Full Results</a>
                @endif
            </div>
        </div>

        @if(!$question)
            <div class="question-card">
                <div class="no-question">
                    <div class="no-question-icon">⏳</div>
                    <h2 style="font-size:20px;font-weight:700;margin-bottom:8px">Waiting to Start</h2>
                    <p style="color:var(--muted)">Click "Show Question" to begin the quiz.</p>
                </div>
            </div>
        @else
            <div class="live-grid">
                <div class="question-card">
                    <div class="q-order">Question {{ $question->order }} of
                        {{ \App\Models\QuizQuestion::where('quiz_type', $type)->count() }}</div>
                    <div class="q-text">{{ $question->question_text }}</div>

                    @if($analytics && $analytics['first_correct'])
                        <div class="first-correct-badge">
                            ⭐ First correct: {{ $analytics['first_correct']['name'] }}
                            ({{ number_format($analytics['first_correct']['response_time_ms'] / 1000, 1) }}s)
                        </div>
                    @endif

                    <div class="stats-summary">
                        <div class="stat-pill">Responses: <strong
                                id="totalResponses">{{ $analytics['total_responded'] ?? 0 }}</strong> / {{ $participantCount }}
                        </div>
                        <div class="stat-pill">Correct: <strong id="correctRate">{{ $analytics['correct_rate'] ?? 0 }}%</strong>
                        </div>
                        @if($analytics['avg_response_time_ms'])
                            <div class="stat-pill">Avg Time: <strong
                                    id="avgTime">{{ number_format($analytics['avg_response_time_ms'] / 1000, 1) }}s</strong></div>
                        @endif
                    </div>

                    <div class="q-options-grid" id="optionsGrid">
                        @foreach($question->options as $i => $opt)
                                            <?php
                                    $count = $analytics['option_counts'][$i] ?? 0;
                                    $total = $analytics['total_responded'] ?? 1;
                                    $pct = $total > 0 ? round(($count / $total) * 100) : 0;
                                    $isReveal = $session->status === 'completed' || ($session->current_question_order > 0);
                                    $cls = '';
                                    if ($isReveal) {
                                        if ($i === $question->correct_option)
                                            $cls = 'correct-reveal';
                                        else
                                            $cls = 'wrong-reveal';
                                    }
                             ?>
                                            <div class="q-opt {{ $cls }}" id="opt-{{ $i }}">
                                                <div class="q-opt-letter">{{ chr(65 + $i) }}</div>
                                                <div class="q-opt-text">{{ $opt }}</div>
                                                <div class="q-opt-bar">
                                                    <div class="q-opt-bar-fill" id="bar-{{ $i }}" style="width:{{ $pct }}%"></div>
                                                </div>
                                                <div class="q-opt-count" id="count-{{ $i }}">{{ $count }}</div>
                                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="sidebar">
                    <div class="sidebar-card">
                        <h3>🏆 Leaderboard</h3>
                        @foreach($leaderboard as $entry)
                            <div class="leaderboard-item">
                                <div
                                    class="lb-rank {{ $entry['rank'] == 1 ? 'gold' : ($entry['rank'] == 2 ? 'silver' : ($entry['rank'] == 3 ? 'bronze' : '')) }}">
                                    {{ $entry['rank'] }}</div>
                                <div class="lb-name">{{ $entry['name'] }}</div>
                                <div class="lb-score">{{ $entry['score'] }}</div>
                            </div>
                        @endforeach
                        @if(count($leaderboard) === 0)
                            <p style="color:var(--muted);font-size:13px;text-align:center;padding:20px">No answers yet</p>
                        @endif
                    </div>

                    <div class="sidebar-card">
                        <h3>📊 Session Stats</h3>
                        <div style="font-size:13px;color:var(--muted)">
                            <p>Quiz Type: <strong
                                    style="color:var(--ink)">{{ \App\Models\QuizType::where('key', '$type')->value('name') ?? '$type' }}</strong></p>
                            <p>PIN: <strong style="color:var(--purple-1);font-family:monospace">{{ $session->pin }}</strong></p>
                            <p>Started: <strong
                                    style="color:var(--ink)">{{ $session->started_at?->format('M d, Y h:i A') ?? 'Not started' }}</strong>
                            </p>
                            <p>Participants: <strong style="color:var(--ink)">{{ $participantCount }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="controls-bar">
        @if($session->status === 'active')
            <button onclick="pauseQuiz()" class="btn-control btn-pause">⏸ Pause</button>
        @elseif($session->status === 'paused')
            <button onclick="resumeQuiz()" class="btn-control btn-pause"
                style="background:rgba(40,180,100,0.15);border:1px solid rgba(40,180,100,0.3);color:#8ff0b3">▶ Resume</button>
        @endif
        @if($session->current_question_order > 0)
            <button onclick="prevQuestion()" class="btn-control btn-prev">← Previous</button>
        @endif
        <button onclick="showQuestion()" class="btn-control btn-next">
            {{ $session->current_question_order === 0 ? '▶ Show Question 1' : 'Next Question →' }}
        </button>
        <button onclick="endQuiz()" class="btn-control btn-end">⏹ End Quiz</button>
    </div>

    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        const sessionId = '{{ $session->id }}';
        const csrfToken = '{{ csrf_token() }}';
        const quizType = '{{ $type }}';

        const pusher = new Pusher('{{ env("PUSHER_APP_KEY", "local") }}', {
            cluster: '{{ env("PUSHER_APP_CLUSTER", "ap2") }}',
            forceTLS: true,
            // Using Pusher cloud default ports
            // Using Pusher cloud default transports
        });

        const channel = pusher.subscribe('quiz.' + sessionId);
        const adminChannel = pusher.subscribe('admin.quiz.' + sessionId);

        channel.bind('quiz.question.shown', (data) => { currentQuestion = data; loadQuestion(data); });
        channel.bind('quiz.ended', () => { alert('Quiz ended!'); window.location.href = '/admin/dashboard'; });

        adminChannel.bind('quiz.answer.received', (data) => {
            updateAnalytics(data);
        });

        adminChannel.bind('quiz.question.analytics', (data) => {
            updateAnalytics(data);
        });

        adminChannel.bind('quiz.participant.joined', (data) => {
            location.reload();
        });

        function updateAnalytics(data) {
            if (data.option_counts) {
                data.option_counts.forEach((count, i) => {
                    const el = document.getElementById('count-' + i);
                    const bar = document.getElementById('bar-' + i);
                    if (el && bar) {
                        el.textContent = count;
                        const total = data.total_responded || 1;
                        bar.style.width = (total > 0 ? (count / total) * 100 : 0) + '%';
                    }
                });
                const totalEl = document.getElementById('totalResponses');
                const rateEl = document.getElementById('correctRate');
                const avgEl = document.getElementById('avgTime');
                if (totalEl) totalEl.textContent = data.total_responded;
                if (rateEl) rateEl.textContent = data.correct_rate + '%';
                if (avgEl && data.avg_response_time_ms) avgEl.textContent = (data.avg_response_time_ms / 1000).toFixed(1) + 's';
            }
        }

        function showQuestion() {
            fetch('/admin/quiz/{{ $type }}/show-question', { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' }, body: '{}' })
                .then(r => r.json()).then(d => { if (d.success) location.reload(); else alert(d.message); });
        }

        function prevQuestion() {
            fetch('/admin/quiz/{{ $type }}/prev-question', { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' }, body: '{}' })
                .then(r => r.json()).then(d => { if (d.success) location.reload(); });
        }

        function pauseQuiz() {
            fetch('/admin/quiz/{{ $type }}/pause', { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' }, body: '{}' })
                .then(r => r.json()).then(d => { if (d.success) location.reload(); });
        }

        function resumeQuiz() {
            fetch('/admin/quiz/{{ $type }}/resume', { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' }, body: '{}' })
                .then(r => r.json()).then(d => { if (d.success) location.reload(); });
        }

        function endQuiz() {
            if (!confirm('End this quiz? This cannot be undone.')) return;
            fetch('/admin/quiz/{{ $type }}/end', { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' }, body: '{}' })
                .then(r => r.json()).then(d => { if (d.success) window.location.href = '/admin/quiz/{{ $type }}/results'; });
        }
    </script>
@endsection