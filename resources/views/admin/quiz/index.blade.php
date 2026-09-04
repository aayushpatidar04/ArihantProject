@extends('layouts.app')

@section('title', 'Quiz Management — ArihantPLUS')

@push('styles')
    <style>
        .quiz-page {
            padding: 32px 24px;
            max-width: 1200px;
            margin: 0 auto
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 700
        }

        .quiz-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px
        }

        .quiz-card {
            background: linear-gradient(165deg, #170b22 0%, #0b0511 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 24px;
            transition: all 0.2s
        }

        .quiz-card:hover {
            border-color: rgba(184, 102, 247, 0.3);
            transform: translateY(-2px)
        }

        .quiz-card.active {
            border-color: rgba(40, 180, 100, 0.4);
            box-shadow: 0 0 20px rgba(40, 180, 100, 0.1)
        }

        .quiz-card h3 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 8px
        }

        .quiz-card p {
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 16px
        }

        .quiz-badge {
            display: inline-flex;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 12px
        }

        .badge-active {
            background: rgba(40, 180, 100, 0.15);
            color: #8ff0b3
        }

        .badge-inactive {
            background: rgba(255, 255, 255, 0.06);
            color: var(--muted)
        }

        .card-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .active-session-panel {
            background: rgba(40, 180, 100, 0.08);
            border: 1px solid rgba(40, 180, 100, 0.3);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 32px
        }

        .active-session-panel h2 {
            font-size: 18px;
            font-weight: 700;
            color: #8ff0b3;
            margin-bottom: 16px
        }

        .qr-display {
            text-align: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.04);
            border-radius: 12px;
            margin-bottom: 16px
        }

        .qr-display img {
            width: 200px;
            height: 200px;
            border-radius: 12px
        }

        .pin-display {
            font-size: 36px;
            font-weight: 800;
            letter-spacing: 0.2em;
            color: var(--purple-1);
            text-align: center;
            margin: 16px 0;
            font-family: monospace
        }

        .session-meta {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 16px
        }

        .btn-row {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 20px
        }

        .recent-table {
            width: 100%;
            margin-top: 32px
        }

        .recent-table table {
            width: 100%;
            border-collapse: collapse
        }

        .recent-table th,
        .recent-table td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            font-size: 14px
        }

        .recent-table th {
            color: var(--muted);
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em
        }
    </style>
@endpush

@section('content')
    <div class="quiz-page">
        <div class="page-header">
            <h1>Quiz Management</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost">← Back to Dashboard</a>
        </div>

        @if(session('success'))
            <div
                style="background:rgba(40,180,100,0.1);border:1px solid rgba(40,180,100,0.3);border-radius:12px;padding:14px 20px;margin-bottom:24px;color:#8ff0b3">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div
                style="background:rgba(220,60,60,0.1);border:1px solid rgba(220,60,60,0.3);border-radius:12px;padding:14px 20px;margin-bottom:24px;color:#f87171">
                {{ session('error') }}
            </div>
        @endif

        @if($activeSession)
            <div class="active-session-panel">
                <h2>🔴 Active Session:
                    {{ App\Models\QuizType::where('key', $activeSession->quiz_type)->value('name') ?? $activeSession->quiz_type }}
                </h2>
                <div class="qr-display">
                    @php
                        $qrPath = 'qrcodes/quiz_' . $activeSession->quiz_type . '.png';
                        $qrUrl = \Storage::disk('public')->exists($qrPath) ? asset('storage/' . $qrPath) : null;
                     @endphp
                    @if($qrUrl)
                        <img src="{{ $qrUrl }}" alt="QR Code">
                    @else
                        <p style="color:var(--muted)">QR not generated yet</p>
                    @endif
                    <p style="color:var(--muted);font-size:12px;margin-top:8px">Participants scan this QR to join</p>
                </div>
                <div class="pin-display">{{ $activeSession->pin }}</div>
                <p style="text-align:center;color:var(--muted);font-size:13px;margin-bottom:16px">Share this PIN with
                    participants</p>
                <div class="session-meta">
                    <span style="color:var(--muted);font-size:13px">Status: <strong
                            style="color:#8ff0b3">{{ ucfirst($activeSession->status) }}</strong></span>
                    <span style="color:var(--muted);font-size:13px">Participants:
                        <strong>{{ $activeSession->participants()->count() }}</strong></span>
                    <span style="color:var(--muted);font-size:13px">Question:
                        <strong>{{ $activeSession->current_question_order }} /
                            {{ \App\Models\QuizQuestion::where('quiz_type', $activeSession->quiz_type)->count() }}</strong></span>
                </div>
                <div class="btn-row">
                    <a href="{{ route('admin.quiz.live', $activeSession->quiz_type) }}" class="btn btn-primary">📊 Live
                        Dashboard</a>
                    <form method="POST" action="{{ route('admin.quiz.end', $activeSession->quiz_type) }}" style="display:inline"
                        onsubmit="return confirm('End this quiz?')">
                        <div>
                            <form method="POST" action="{{ route('admin.quiz.types') }}" style="text-align:center">
                                @csrf
                                <button type="submit" class="btn"
                                    style="background:rgba(220,60,60,0.15);border:1px solid rgba(220,60,60,0.3);color:#f87171">⏹
                                    End
                                    Quiz</button>
                            </form>
                        </div>
                </div>
        @endif

            <h2 style="font-size:20px;font-weight:700;margin-bottom:20px">Quiz Types</h2>
            <div class="quiz-grid">
                @php $quizTypes = \App\Models\QuizType::orderBy('sort_order')->pluck('name', 'key')->toArray(); @endphp
                @foreach($quizTypes as $key => $label)
                            <?php
                    $isActive = $activeSession && $activeSession->quiz_type === $key;
                    $qCount = \App\Models\QuizQuestion::where('quiz_type', $key)->count();
                    $lastSession = \App\Models\QuizSession::where('quiz_type', $key)->orderByDesc('started_at')->first();
                    $lastStatus = $lastSession ? $lastSession->status : null;
                    $showStart = !$isActive && ($lastStatus !== 'completed');
                                                    ?>
                            <div class="quiz-card {{ $isActive ? 'active' : '' }}">
                                <span class="quiz-badge {{ $isActive ? 'badge-active' : 'badge-inactive' }}">
                                    {{ $isActive ? ucfirst($activeSession->status) : ($lastStatus ? ucfirst($lastStatus) : 'Inactive') }}
                                </span>
                                <h3>{{ $label }}</h3>
                                <p style="color:var(--muted);font-size:13px;margin-bottom:16px">
                                    {{ $qCount }} question{{ $qCount === 1 ? '' : 's' }} in bank
                                    @if($lastSession)
                                        &middot; Last played
                                        {{ $lastSession->started_at ? $lastSession->started_at->diffForHumans() : 'Not started' }}
                                    @endif
                                </p>
                                <div class="card-actions">
                                    @if($isActive)
                                        <a href="{{ route('admin.quiz.live', $key) }}" class="btn btn-primary"
                                            style="font-size:13px;padding:8px 16px">&#x1F4CA; Dashboard</a>
                                    @elseif($lastStatus === 'completed')
                                        <a href="{{ route('admin.quiz.results', $key) }}" class="btn btn-ghost"
                                            style="font-size:13px;padding:8px 16px">&#x1F4CB; View Results</a>
                                    @elseif($showStart)
                                        <a href="{{ route('admin.quiz.questions', $key) }}" class="btn btn-ghost"
                                            style="font-size:13px;padding:8px 16px">📝 Add Questions</a>
                                        <button onclick="startQuiz('{{ $key }}', '{{ $label }}')" class="btn btn-primary"
                                            style="font-size:13px;padding:8px 16px">&#x25B6; Start Quiz</button>
                                    @endif
                                </div>
                            </div>
                @endforeach
                <div class="quiz-card"
                    style="border-style:dashed;display:flex;align-items:center;justify-content:center;min-height:180px">
                    <form method="POST" action="{{ route('admin.quiz.types') }}" style="text-align:center">
                        @csrf
                        <input type="text" name="name" placeholder="New quiz type name" required
                            style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.12);border-radius:12px;padding:10px 16px;color:#fff;width:200px;margin-bottom:8px">
                        <br>
                        <input type="text" name="description" placeholder="Description (optional)"
                            style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.12);border-radius:12px;padding:10px 16px;color:#fff;width:200px;margin-bottom:12px">
                        <br>
                        <button type="submit" class="btn btn-ghost" style="font-size:13px">+ Add Quiz Type</button>
                    </form>
                </div>
            </div>

            @if($recentSessions->count() > 0)
                <div class="recent-table">
                    <h2 style="font-size:18px;font-weight:700;margin-bottom:16px">Recent Sessions</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Quiz Type</th>
                                <th>PIN</th>
                                <th>Status</th>
                                <th>Participants</th>
                                <th>Started</th>
                                <th>Ended</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentSessions as $s)
                                <tr>
                                    <td>{{ \App\Models\QuizType::where('key', $s->quiz_type)->value('name') ?? $s->quiz_type }}</td>
                                    <td style="font-family:monospace">{{ $s->pin }}</td>
                                    <td><span
                                            class="quiz-badge {{ $s->status === 'completed' ? 'badge-inactive' : 'badge-active' }}">{{ ucfirst($s->status) }}</span>
                                    </td>
                                    <td>{{ $s->participants()->count() }}</td>
                                    <td>{{ $s->started_at?->format('M d, H:i') ?? '-' }}</td>
                                    <td>{{ $s->ended_at?->format('M d, H:i') ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        @push('scripts')
            <script>
                function startQuiz(type, label) {
                    if (!confirm('Start quiz for ' + label + '?')) return;
                    const btn = event.target;
                    btn.disabled = true;
                    fetch('/admin/quiz/' + type + '/start', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }, body: '{}' })
                        .then(r => r.json()).then(d => {
                            if (d.success) location.reload();
                            else { alert(d.message || 'Failed to start'); btn.disabled = false; }
                        }).catch(() => { alert('Error'); btn.disabled = false; });
                }
            </script>
        @endpush
@endsection