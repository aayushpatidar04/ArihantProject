<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Leaderboard - ArihantPLUS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.js"
        integrity="sha384-iU8HYtnGQ8Cy4zl7gbNMOhsDTTKX02BTXptVP/vqAWIaTfM7isw76iyZCsjL2eVi" crossorigin="anonymous">
        </script>
    <style>
        :root {
            --bg: #000;
            --surface: #0b0511;
            --card: #170b22;
            --ink: #fff;
            --muted: #9ca3af;
            --purple-1: #b866f7;
            --purple-2: #7a1fc9;
            --green: #8ff0b3;
            --red: #f87171;
        }

        body {
            font-family: 'Sora', sans-serif;
            background: var(--bg);
            color: var(--ink);
            min-height: 100vh;
            overflow-x: hidden;
            margin: 0;
        }

        /* Waiting Screen */
        .waiting-screen {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            text-align: center;
            padding: 40px 20px;
        }

        .waiting-animation {
            position: relative;
            width: 200px;
            height: 200px;
            margin-bottom: 40px;
        }

        .pulse-ring {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            border: 3px solid var(--purple-1);
            border-radius: 50%;
            animation: pulse 2s ease-out infinite;
        }

        .pulse-ring:nth-child(2) {
            animation-delay: 0.5s;
        }

        .pulse-ring:nth-child(3) {
            animation-delay: 1s;
        }

        @keyframes pulse {
            0% {
                transform: translate(-50%, -50%) scale(0.5);
                opacity: 1;
            }

            100% {
                transform: translate(-50%, -50%) scale(1.2);
                opacity: 0;
            }
        }

        .waiting-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 60px;
        }

        .waiting-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 16px;
            background: linear-gradient(135deg, var(--purple-1), var(--purple-2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .waiting-subtitle {
            font-size: 16px;
            color: var(--muted);
            max-width: 500px;
        }

        .loader {
            width: 48px;
            height: 48px;
            border: 4px solid var(--purple-1);
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-top: 30px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Active Screen */
        .active-screen {
            padding: 32px 24px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .quiz-header {
            text-align: center;
            margin-bottom: 32px;
            padding: 24px;
            background: linear-gradient(135deg, var(--surface), var(--card));
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .quiz-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .status-waiting {
            background: rgba(255, 165, 0, 0.15);
            color: #ffa500;
        }

        .status-active {
            background: rgba(40, 180, 100, 0.15);
            color: var(--green);
        }

        .status-paused {
            background: rgba(255, 165, 0, 0.15);
            color: #ffa500;
        }

        .status-completed {
            background: rgba(255, 255, 255, 0.06);
            color: var(--muted);
        }

        .question-indicator {
            font-size: 14px;
            color: var(--muted);
            margin-top: 8px;
        }

        .question-indicator strong {
            color: var(--purple-1);
        }

        /* Layout */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .panel {
            background: var(--surface);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 24px;
            transition: all 0.3s;
        }

        .panel-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .panel-title .icon {
            font-size: 22px;
        }

        /* Chart */
        .chart-container {
            position: relative;
            height: 300px;
            margin: 0 auto;
        }

        /* Leaderboard */
        .leaderboard-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
            max-height: 600px;
            overflow-y: auto;
        }

        .lb-entry {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            background: var(--card);
            border-radius: 12px;
            transition: all 0.5s ease;
            border: 1px solid transparent;
        }

        .lb-entry.rank-change-up {
            animation: slideUp 0.5s ease;
            border-color: rgba(40, 180, 100, 0.3);
        }

        .lb-entry.rank-change-down {
            animation: slideDown 0.5s ease;
            border-color: rgba(248, 113, 113, 0.3);
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0.5;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0.5;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .lb-rank {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 14px;
            flex-shrink: 0;
        }

        .rank-1 {
            background: linear-gradient(135deg, #ffd700, #ffaa00);
            color: #000;
        }

        .rank-2 {
            background: linear-gradient(135deg, #e0e0e0, #a0a0a0);
            color: #000;
        }

        .rank-3 {
            background: linear-gradient(135deg, #cd7f32, #a0522d);
            color: #fff;
        }

        .rank-other {
            background: rgba(255, 255, 255, 0.06);
            color: var(--muted);
        }

        .lb-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--purple-1), var(--purple-2));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
        }

        .lb-info {
            flex: 1;
            min-width: 0;
        }

        .lb-name {
            font-weight: 600;
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .lb-meta {
            font-size: 11px;
            color: var(--muted);
            margin-top: 2px;
        }

        .lb-score {
            text-align: right;
            flex-shrink: 0;
        }

        .lb-score-value {
            font-size: 20px;
            font-weight: 800;
            color: var(--purple-1);
        }

        .lb-score-label {
            font-size: 10px;
            color: var(--muted);
            text-transform: uppercase;
        }

        /* Stats bar */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s;
        }

        .stat-card:hover {
            border-color: rgba(184, 102, 247, 0.3);
            transform: translateY(-2px);
        }

        .stat-value {
            font-size: 32px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--purple-1), var(--purple-2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            font-size: 12px;
            color: var(--muted);
            text-transform: uppercase;
            margin-top: 4px;
            letter-spacing: 0.05em;
        }

        /* Waiting for next question */
        .waiting-next {
            text-align: center;
            padding: 40px;
            color: var(--muted);
        }

        .waiting-next .icon {
            font-size: 48px;
            margin-bottom: 16px;
        }

        .waiting-next p {
            font-size: 16px;
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .waiting-title {
                font-size: 24px;
            }

            .lb-name {
                font-size: 13px;
            }

            .lb-score-value {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    @if(!$activeSession && !$isCompleted)
        <!-- Waiting Screen -->
        <div class="waiting-screen">
            <div class="waiting-animation">
                <div class="pulse-ring"></div>
                <div class="pulse-ring"></div>
                <div class="pulse-ring"></div>
                <div class="waiting-icon">🎯</div>
            </div>
            <h1 class="waiting-title">No Quiz Active</h1>
            <p class="waiting-subtitle">A quiz will start soon. Stay tuned and get ready to compete!</p>
            <div class="loader"></div>
        </div>
    @else
        <!-- Active or Completed Screen -->
        <div class="active-screen" id="activeScreen">
            <div class="quiz-header fade-in">
                <div class="status-badge status-{{ $activeSession ? $activeSession->status : 'completed' }}">
                    {{ $activeSession ? ucfirst($activeSession->status) : 'Completed' }}
                </div>
                <h1>{{ $quizType->name ?? 'Quiz' }}</h1>
                <div class="question-indicator">
                    @if($activeSession && $activeSession->current_question_order > 0)
                        Question <strong>{{ $activeSession->current_question_order }}</strong> of
                        <strong>{{ $questions->count() }}</strong>
                    @elseif($isCompleted)
                        Quiz Completed — <strong>{{ $questions->count() }}</strong> questions
                    @else
                        Quiz started — waiting for first question
                    @endif
                </div>
            </div>

            @if($isCompleted)
                <!-- Completed: Overall Leaderboard Only -->
                <div class="dashboard-grid fade-in">
                    <div class="panel full-width">
                        <div class="panel-title"><span class="icon">🏆</span> Final Leaderboard — Top 20</div>
                        <div class="leaderboard-list" id="leaderboardList">
                            @foreach($leaderboard as $entry)
                                <div class="lb-entry" data-participant-id="{{ $entry['participant_id'] }}">
                                    <div class="lb-rank rank-{{ $entry['rank'] <= 3 ? $entry['rank'] : 'other' }}">
                                        {{ $entry['rank'] }}
                                    </div>
                                    <div class="lb-avatar">{{ substr($entry['name'], 0, 1) }}</div>
                                    <div class="lb-info">
                                        <div class="lb-name">{{ $entry['name'] }}</div>
                                        <div class="lb-meta">{{ $entry['email'] }}</div>
                                        <div class="lb-meta">{{ $entry['correct_count'] }} correct · {{ $entry['total_answered'] }}
                                            answered</div>
                                        <div class="lb-meta">{{ $entry['avg_response_time_ms'] ? number_format($entry['avg_response_time_ms'] / 1000, 1) . 's' : '-' }}</div>
                                        
                                    </div>
                                    <div class="lb-score">
                                        <div class="lb-score-value">{{ $entry['score'] }}</div>
                                        <div class="lb-score-label">points</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @elseif($showAnalytics)
                <!-- Active: Stats + Chart + Leaderboard -->
                <div class="stats-row fade-in">
                    <div class="stat-card">
                        <div class="stat-value" id="statTotal">{{ $analytics['total_responded'] ?? 0 }}</div>
                        <div class="stat-label">Responses</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" id="statCorrect">{{ $analytics['correct_count'] ?? 0 }}</div>
                        <div class="stat-label">Correct</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" id="statRate">{{ $analytics['correct_rate'] ?? 0 }}%</div>
                        <div class="stat-label">Accuracy</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" id="statTime">
                            @if($analytics['avg_response_time_ms'])
                                {{ number_format($analytics['avg_response_time_ms'] / 1000, 1) }}s
                            @else
                                0s
                            @endif
                        </div>
                        <div class="stat-label">Avg Time</div>
                    </div>
                </div>

                <div class="dashboard-grid">
                    <div class="panel fade-in">
                        <div class="panel-title"><span class="icon">📊</span> Response Breakdown</div>
                        <div class="chart-container">
                            <canvas id="responseChart"></canvas>
                        </div>
                    </div>
                    <div class="panel fade-in">
                        <div class="panel-title"><span class="icon">🏆</span> Top 20 Leaderboard</div>
                        <div class="leaderboard-list" id="leaderboardList">
                            @foreach($leaderboard as $entry)
                                <div class="lb-entry" data-participant-id="{{ $entry['participant_id'] }}">
                                    <div class="lb-rank rank-{{ $entry['rank'] <= 3 ? $entry['rank'] : 'other' }}">
                                        {{ $entry['rank'] }}
                                    </div>
                                    <div class="lb-avatar">{{ substr($entry['name'], 0, 1) }}</div>
                                    <div class="lb-info">
                                        <div class="lb-name">{{ $entry['name'] }}</div>
                                        <div class="lb-meta">{{ $entry['correct_count'] }} correct · {{ $entry['total_answered'] }}
                                            answered</div>
                                    </div>
                                    <div class="lb-score">
                                        <div class="lb-score-value">{{ $entry['score'] }}</div>
                                        <div class="lb-score-label">points</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @elseif($activeSession)
                <!-- Active but no question shown yet -->
                <div class="waiting-next fade-in">
                    <div class="icon">📊</div>
                    <p>Analytics will appear after the first question</p>
                </div>
            @endif
        </div>
    @endif

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // === Functions (always available) ===

        function showStartingOverlay(data) {
            const existing = document.getElementById('startingOverlay');
            if (existing) existing.remove();

            const qrHtml = data.qr_url
                ? '<img src="' + data.qr_url + '" style="width:200px;height:200px;border-radius:16px;border:3px solid #b866f7;margin:20px auto;" />'
                : '<div style="width:200px;height:200px;background:#1e1230;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:14px;color:#9ca3af;border:2px dashed #b866f7;">QR Code</div>';

            const overlay = document.createElement('div');
            overlay.id = 'startingOverlay';
            overlay.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.92);display:flex;flex-direction:column;align-items:center;justify-content:center;z-index:9999;animation:fadeIn 0.5s ease;';
            overlay.innerHTML = '<div style="text-align:center;padding:40px;">' +
                '<h2 style="font-family:Sora,sans-serif;font-size:28px;font-weight:700;color:#fff;margin-bottom:8px;">Quiz is Starting!</h2>' +
                '<p style="color:#9ca3af;font-size:16px;margin-bottom:30px;">Scan the QR code and use PIN to join</p>' +
                qrHtml +
                '<div style="background:#1e1230;border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:16px 24px;margin-top:16px;">' +
                '<p style="color:#9ca3af;font-size:12px;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">PIN</p>' +
                '<p style="font-size:32px;font-weight:800;color:#b866f7;letter-spacing:0.2em;font-family:monospace;">' + data.pin + '</p>' +
                '</div>' +
                '</div>';
            document.body.appendChild(overlay);
        }

        function hideStartingOverlay() {
            const overlay = document.getElementById('startingOverlay');
            if (overlay) overlay.remove();
        }

        function loadLeaderboardPage() {
            window.location.href = '/quiz/leaderboard';
        }

        function initChart() {
            const ctx = document.getElementById('responseChart');
            if (!ctx) return;
            const labels = @json($analytics['options'] ?? []);
            const data = {{ Js::from($analytics['option_counts'] ?? [0, 0, 0, 0]) }};
            const correct = @json($analytics['correct_option'] ?? -1);
            const colors = labels.map((_, i) => i === correct ? 'rgba(40,180,100,0.8)' : 'rgba(184,102,247,0.6)');

            if (responseChart) responseChart.destroy();
            responseChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Responses',
                        data: data,
                        backgroundColor: colors,
                        borderColor: colors.map(c => c.replace('0.8', '1').replace('0.6', '1')),
                        borderWidth: 1,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { color: '#9ca3af' }, grid: { color: 'rgba(255,255,255,0.05)' } },
                        x: { ticks: { color: '#9ca3af' }, grid: { display: false } }
                    },
                    animation: { duration: 500 }
                }
            });
        }

        function updateLeaderboard(newLeaderboard) {
            const container = document.getElementById('leaderboardList');
            if (!container) return;
            const oldMap = {};
            prevLeaderboard.forEach(e => { oldMap[e.participant_id] = e; });
            let html = '';
            newLeaderboard.forEach((entry, index) => {
                const oldEntry = oldMap[entry.participant_id];
                let changeClass = '';
                if (oldEntry) {
                    const oldRank = oldEntry.rank;
                    const newRank = index + 1;
                    if (newRank < oldRank) changeClass = 'rank-change-up';
                    else if (newRank > oldRank) changeClass = 'rank-change-down';
                }
                const rankClass = entry.rank <= 3 ? 'rank-' + entry.rank : 'rank-other';
                html += '<div class="lb-entry ' + changeClass + '" data-participant-id="' + entry.participant_id + '">' +
                    '<div class="lb-rank ' + rankClass + '">' + entry.rank + '</div>' +
                    '<div class="lb-avatar">' + entry.name.charAt(0).toUpperCase() + '</div>' +
                    '<div class="lb-info"><div class="lb-name">' + entry.name + '</div>' +
                    '<div class="lb-meta">' + entry.correct_count + ' correct · ' + entry.total_answered + ' answered</div></div>' +
                    '<div class="lb-score"><div class="lb-score-value">' + entry.score + '</div>' +
                    '<div class="lb-score-label">points</div></div></div>';
            });
            container.innerHTML = html;
            prevLeaderboard = newLeaderboard;
        }

        function updateStats(analytics) {
            const totalEl = document.getElementById('statTotal');
            const correctEl = document.getElementById('statCorrect');
            const rateEl = document.getElementById('statRate');
            const timeEl = document.getElementById('statTime');
            if (totalEl) totalEl.textContent = analytics.total_responded || 0;
            if (correctEl) correctEl.textContent = analytics.correct_count || 0;
            if (rateEl) rateEl.textContent = (analytics.correct_rate || 0) + '%';
            if (timeEl && analytics.avg_response_time_ms) timeEl.textContent = (analytics.avg_response_time_ms / 1000).toFixed(1) + 's';
        }

        function updateChart(analytics) {
            if (!responseChart || !analytics.option_counts) return;
            const correct = analytics.correct_option ?? -1;
            const labels = analytics.options || [];
            const colors = labels.map((_, i) => i === correct ? 'rgba(40,180,100,0.8)' : 'rgba(184,102,247,0.6)');
            responseChart.data.datasets[0].data = analytics.option_counts;
            responseChart.data.datasets[0].backgroundColor = colors;
            responseChart.data.datasets[0].borderColor = colors.map(c => c.replace('0.6', '1').replace('0.8', '1'));
            responseChart.update('active');
        }

        // === Pusher ===
        const pusher = new Pusher('{{ env("PUSHER_APP_KEY", "local") }}', {
            cluster: '{{ env("PUSHER_APP_CLUSTER", "ap2") }}',
            forceTLS: true,
        });

        let sessionId = null;
        let channel = null;
        let adminChannel = null;
        let responseChart = null;
        let prevLeaderboard = @json($leaderboard);

        function setupSessionChannels(sId) {
            if (sessionId === sId) return;
            sessionId = sId;

            channel = pusher.subscribe('quiz.' + sId);
            adminChannel = pusher.subscribe('admin.quiz.' + sId);

            // Unbind any old handlers to avoid duplicates
            channel.unbind('quiz.question.shown');
            channel.unbind('quiz.ended');
            adminChannel.unbind('quiz.answer.received');
            adminChannel.unbind('quiz.question.analytics');
            adminChannel.unbind('quiz.leaderboard.update');
            channel.bind('quiz.question.shown', (data) => {
                console.log('Question shown:', data.question_order, '/', data.total_questions);
                hideStartingOverlay();
                setTimeout(() => location.reload(), 500);
            });

            channel.bind('quiz.ended', () => {
                hideStartingOverlay();
                const o = document.createElement('div');
                o.id = 'quizEndedOverlay';
                o.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.92);display:flex;flex-direction:column;align-items:center;justify-content:center;z-index:9999;animation:fadeIn 0.5s ease;';
                o.innerHTML = '<div style="text-align:center;padding:40px;"><div style="font-size:64px;margin-bottom:20px;">🏆</div><h2 style="font-family:Sora,sans-serif;font-size:28px;font-weight:700;color:#fff;margin-bottom:8px;">Quiz Ended</h2><p style="color:#9ca3af;font-size:16px;margin-bottom:30px;">Loading final leaderboard...</p><div style="width:48px;height:48px;border:4px solid #b866f7;border-top-color:transparent;border-radius:50%;animation:spin 1s linear infinite;margin:0 auto;"></div></div>';
                document.body.appendChild(o);
                setTimeout(loadLeaderboardPage, 3000);
            });

            // adminChannel.bind('quiz.answer.received', (data) => {
            //     if (data.leaderboard) updateLeaderboard(data.leaderboard);
            //     if (data.option_counts) { updateStats(data); updateChart(data); }
            // });

            adminChannel.bind('quiz.question.analytics', (data) => {
                if (data.option_counts) { updateStats(data); updateChart(data); }
            });

            adminChannel.bind('quiz.leaderboard.update', (data) => {
                if (data.leaderboard) updateLeaderboard(data.leaderboard);
            });

            // Start polling for live updates
            setInterval(async () => {
                try {
                    const res = await fetch('/api/quiz/leaderboard-data?session=' + sessionId);
                    const data = await res.json();
                    if (data.analytics && data.analytics.option_counts) {
                        updateStats(data.analytics);
                        updateChart(data.analytics);
                    }
                    if (data.leaderboard) {
                        updateLeaderboard(data.leaderboard);
                    }
                } catch (e) { console.error('Poll error', e); }
            }, 3000);
        }

        const startedChannel = pusher.subscribe('quiz.started');
        startedChannel.bind('quiz.session.started', (data) => {
            console.log('Quiz started:', data.quiz_name, 'PIN:', data.pin);
            showStartingOverlay(data);
            setupSessionChannels(data.session_id);
        });

        @if($activeSession)
            setupSessionChannels('{{ $activeSession->id }}');
            @if($showAnalytics && $analytics)
                setTimeout(initChart, 100);
            @endif
        @endif
    </script>
</body>

</html>