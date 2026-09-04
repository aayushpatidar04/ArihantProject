<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArihantPLUS Quiz</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
            --gold: #ffd700;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Sora', sans-serif;
            background: var(--bg);
            color: var(--ink);
            min-height: 100vh;
        }

        .page {
            display: none;
            min-height: 100vh;
            padding: 40px 24px;
        }

        .page.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            background: linear-gradient(165deg, var(--card) 0%, var(--surface) 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 26px;
            padding: 48px 36px;
            max-width: 520px;
            width: 100%;
            text-align: center;
        }

        .card h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px
        }

        .card p {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 24px
        }

        .input {
            width: 100%;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 14px;
            padding: 14px 18px;
            color: var(--ink);
            font-size: 16px;
            text-align: center;
            outline: none;
            margin-bottom: 12px;
            font-family: 'Sora', sans-serif;
        }

        .input:focus {
            border-color: var(--purple-1);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px 28px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 15px;
            border: none;
            cursor: pointer;
            font-family: 'Sora', sans-serif;
        }

        .btn-primary {
            background: linear-gradient(135deg, #d43fe0, #7a1fc9);
            color: #fff;
            width: 100%
        }

        .btn-ghost {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: var(--muted)
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed
        }

        .error-msg {
            background: rgba(220, 60, 60, 0.1);
            border: 1px solid rgba(220, 60, 60, 0.3);
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 12px;
            color: var(--red);
            font-size: 14px;
            display: none;
        }

        .quiz-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--purple-1);
            margin-bottom: 8px
        }


        .options-grid {
            display: grid;
            gap: 12px;
            margin-bottom: 20px;
        }

        .opt-btn {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px 20px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            cursor: pointer;
            transition: all 0.2s;
            text-align: left;
            width: 100%;
            font-family: 'Sora', sans-serif;
            font-size: 15px;
            color: var(--ink);
        }

        .opt-btn:hover {
            border-color: rgba(184, 102, 247, 0.4);
            background: rgba(184, 102, 247, 0.06)
        }

        .opt-btn.selected {
            border-color: var(--purple-1);
            background: rgba(184, 102, 247, 0.12)
        }

        .opt-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed
        }

        .opt-letter {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0
        }

        .lobby-dots {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin-top: 20px;
        }

        .lobby-dots span {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--purple-1);
            animation: bounce 1.4s ease-in-out infinite;
        }

        .lobby-dots span:nth-child(2) {
            animation-delay: 0.2s
        }

        .lobby-dots span:nth-child(3) {
            animation-delay: 0.4s
        }

        @keyframes bounce {

            0%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-10px);
            }
        }

        .result-rank {
            font-size: 72px;
            font-weight: 800;
            color: var(--purple-1);
            margin-bottom: 8px;
        }

        .result-score {
            font-size: 48px;
            font-weight: 800;
            color: var(--gold);
            margin-bottom: 4px;
        }

        .result-label {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 24px;
        }

        .breakdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            font-size: 13px;
        }

        .breakdown-item:last-child {
            border: none;
        }

        .break-icon {
            font-size: 16px;
        }
    </style>
</head>

<body>

    <!-- Page 1: PIN Entry -->
    <div class="page active" id="page-entry">
        <div class="card">
            @if(isset($session) && $session)
                <div class="quiz-title">{{ \App\Models\QuizType::where('key', '$quizType')->value('name') ?? $quizType }}</div>
                <h1>Enter PIN</h1>
                <p>Enter the PIN shared by the host to join the quiz.</p>
                <div class="error-msg" id="pinError"></div>
                <input type="text" class="input" id="pinInput" placeholder="Enter 6-digit PIN" maxlength="6"
                    inputmode="numeric" autocomplete="off">
                <button class="btn btn-primary" onclick="validatePin()">Join Quiz</button>
            @else
                <h1>Quiz Not Active</h1>
                <p>There is no active quiz session for
                    <strong>{{ \App\Models\QuizType::where('key', '$quizType')->value('name') ?? $quizType }}</strong> at the moment. Please wait for
                    the host to start the quiz.</p>
            @endif
        </div>
    </div>

    <!-- Page 2: Detail Entry -->
    <div class="page" id="page-details">
        <div class="card">
            <div class="quiz-title">{{ \App\Models\QuizType::where('key', '$quizType')->value('name') ?? $quizType }}</div>
            <h1>Join Quiz</h1>
            <p>Enter your details to participate.</p>
            <div class="error-msg" id="detailError"></div>
            <input type="text" class="input" id="nameInput" placeholder="Your Name" required>
            <input type="email" class="input" id="emailInput" placeholder="Email Address" required>
            <input type="tel" class="input" id="mobileInput" placeholder="Mobile Number" required>
            <button class="btn btn-primary" onclick="joinQuiz()">Join Quiz</button>
        </div>
    </div>

    <!-- Page 3: Lobby -->
    <div class="page" id="page-lobby">
        <div class="card">
            <div class="quiz-title">{{ \App\Models\QuizType::where('key', '$quizType')->value('name') ?? $quizType }}</div>
            <h1>You're In!</h1>
            <p>Waiting for the quiz to start...</p>
            <div class="lobby-dots"><span></span><span></span><span></span></div>
        </div>
    </div>

    <!-- Page 4: Quiz Play -->
    <div class="page" id="page-play">
        <div style="max-width:700px;width:100%;margin:0 auto;padding:20px 0">
            <div class="quiz-title" id="qOrder" style="text-align:center;margin-bottom:16px"></div>
            <div id="qText" style="font-size:22px;font-weight:700;margin-bottom:20px;line-height:1.4;text-align:center">
            </div>
                       <div class="options-grid" id="optionsGrid"></div>
            <div id="playStatus"
                style="text-align:center;color:var(--muted);font-size:14px;margin-top:16px;display:none"></div>
        </div>
    </div>

    <!-- Page 5: Results -->
    <div class="page" id="page-results">
        <div class="card">
            @if(isset($results))
                <div class="result-rank">#{{ $results['rank'] ?? '-' }}</div>
                <div class="result-score">{{ $results['score'] }}</div>
                <div class="result-label">out of {{ $results['correct_count'] * 10 }} points ·
                    {{ $results['correct_count'] }}/{{ $results['total_questions'] }} correct</div>
                @if($results['avg_response_time_ms'])
                    <p style="color:var(--muted);font-size:14px;margin-bottom:24px">Avg response time:
                        {{ number_format($results['avg_response_time_ms'] / 1000, 1) }}s</p>
                @endif
                <div style="text-align:left;margin-bottom:24px">
                    @foreach($results['breakdown'] as $b)
                        <div class="breakdown-item">
                            <span class="break-icon">{{ $b['is_correct'] ? '✅' : '❌' }}</span>
                            <span
                                style="flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $b['question_text'] }}</span>
                            <span
                                style="font-size:11px;color:var(--muted)">{{ $b['response_time_ms'] ? number_format($b['response_time_ms'] / 1000, 1) . 's' : '-' }}</span>
                        </div>
                    @endforeach
                </div>
                <a href="/quiz?type={{ $session->quiz_type ?? '' }}" class="btn btn-ghost">Back to Quiz</a>
            @else
                <h1>Results Not Available</h1>
                <p>Quiz results will appear here after the quiz ends.</p>
            @endif
        </div>
    </div>

    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        let sessionId = null, quizType = '{{ $quizType ?? "" }}', participantId = null, currentQuestion = null;

        function showPage(id) { document.querySelectorAll('.page').forEach(p => p.classList.remove('active')); document.getElementById(id).classList.add('active'); }

        async function validatePin() {
            const pin = document.getElementById('pinInput').value.trim();
            const err = document.getElementById('pinError');
            if (pin.length !== 6) { err.textContent = 'PIN must be 6 digits.'; err.style.display = 'block'; return; }
            err.style.display = 'none';
            try {
                const res = await fetch('/api/quiz/validate-pin', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ quiz_type: quizType, pin }) });
                const data = await res.json();
                if (data.valid) { sessionId = data.session_id; showPage('page-details'); }
                else { err.textContent = data.message || 'Invalid PIN.'; err.style.display = 'block'; }
            } catch (e) { err.textContent = 'Network error.'; err.style.display = 'block'; }
        }

        async function joinQuiz() {
            const name = document.getElementById('nameInput').value.trim();
            const email = document.getElementById('emailInput').value.trim();
            const mobile = document.getElementById('mobileInput').value.trim();
            const err = document.getElementById('detailError');
            if (!name || !email || !mobile) { err.textContent = 'All fields are required.'; err.style.display = 'block'; return; }
            err.style.display = 'none';
            try {
                const res = await fetch('/api/quiz/join', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ session_id: sessionId, quiz_type: quizType, name, email, mobile }) });
                const data = await res.json();
                if (data.participant_id) {
                    participantId = data.participant_id;
                    initWebSocket();
                    showPage('page-lobby');
                } else { err.textContent = data.message || 'Failed to join.'; err.style.display = 'block'; }
            } catch (e) { err.textContent = 'Network error.'; err.style.display = 'block'; }
        }

        function initWebSocket() {
            const pusher = new Pusher('{{ env("PUSHER_APP_KEY", "local") }}', {
                cluster: '{{ env("PUSHER_APP_CLUSTER", "ap2") }}', forceTLS: true,
                // Using Pusher cloud (no custom wsHost)
            });
            const channel = pusher.subscribe('quiz.' + sessionId);
            channel.bind('quiz.question.shown', (data) => { currentQuestion = data; renderQuestion(data); });
            channel.bind('quiz.ended', () => { window.location.href = '/quiz/results?session=' + sessionId; });
            setInterval(() => { if (sessionId && participantId) pollState(); }, {{ config('quiz.polling_interval_ms', 3000) }});
        }

        async function pollState() {
            try {
                const res = await fetch('/api/quiz/session/' + sessionId + '/state');
                const data = await res.json();
                if (data.status === 'completed') { window.location.href = '/quiz/results?session=' + sessionId; return; }
                if (data.current_question && !document.getElementById('page-play').classList.contains('active')) {
                    currentQuestion = data.current_question;
                    renderQuestion(data.current_question);
                }
                           } catch (e) { }
        }

        function renderQuestion(q) {
            showPage('page-play');
            document.getElementById('qOrder').textContent = 'Question ' + (q.order || q.question_order) + ' of ' + '{{ $totalQuestions ?? "?" }}';
            document.getElementById('qText').textContent = q.question_text || q.text;
            const grid = document.getElementById('optionsGrid');
            grid.innerHTML = '';
            (q.options || []).forEach((opt, i) => {
                const btn = document.createElement('button');
                btn.className = 'opt-btn'; btn.onclick = () => submitAnswer(i);
                btn.innerHTML = '<div class="opt-letter">' + String.fromCharCode(65 + i) + '</div><div>' + opt + '</div>';
                grid.appendChild(btn);
            });
            document.getElementById('playStatus').style.display = 'none';
           
        }

        async function submitAnswer(optionIndex) {
            if (!currentQuestion) return;
            const err = document.getElementById('playStatus');
            const qId = currentQuestion.id || currentQuestion.question_id;
            try {
                const res = await fetch('/api/quiz/submit-answer', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ session_id: sessionId, question_id: qId, selected_option: optionIndex }) });
                const data = await res.json();
                if (data.success) {
                                        err.style.display = 'block'; err.style.color = 'var(--muted)';
                    err.textContent = 'Answer submitted';
                } else { err.textContent = data.message; err.style.display = 'block'; }
            } catch (e) { err.textContent = 'Error.'; err.style.display = 'block'; }
        }

       function disableOptions() { document.querySelectorAll('.opt-btn').forEach(b => b.disabled = true); } document.getElementById('pinInput').addEventListener('keypress', e => { if (e.key === 'Enter') validatePin(); });
        @if(isset($participant) && $participant)
            showPage('page-lobby');
            initWebSocket();
        @endif
        @if(isset($question) && $question)
            currentQuestion = @json($question);
            renderQuestion(@json($question));
        @endif
    </script>
</body>

</html>