@extends('layouts.app')

@section('title', 'Quiz Results — ArihantPLUS')

@push('styles')
    <style>
        .results-page {
            padding: 32px 24px;
            max-width: 1000px;
            margin: 0 auto
        }

        .overview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 32px
        }

        .overview-card {
            background: linear-gradient(165deg, #170b22 0%, #0b0511 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 20px;
            text-align: center
        }

        .overview-card .value {
            font-size: 36px;
            font-weight: 800;
            color: var(--purple-1)
        }

        .overview-card .label {
            font-size: 13px;
            color: var(--muted);
            margin-top: 4px
        }

        .leaderboard-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 32px
        }

        .leaderboard-table th,
        .leaderboard-table td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            font-size: 14px
        }

        .leaderboard-table th {
            color: var(--muted);
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase
        }

        .rank-badge {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px
        }

        .rank-1 {
            background: rgba(255, 215, 0, 0.2);
            color: #ffd700
        }

        .rank-2 {
            background: rgba(192, 192, 192, 0.2);
            color: #c0c0c0
        }

        .rank-3 {
            background: rgba(205, 127, 50, 0.2);
            color: #cd7f32
        }

        .qa-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 16px
        }

        .qa-card h4 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 12px
        }

        .qa-bars {
            display: flex;
            gap: 8px;
            align-items: center;
            margin-bottom: 8px
        }

        .qa-bar {
            flex: 1;
            height: 24px;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.06);
            overflow: hidden;
            position: relative
        }

        .qa-bar-fill {
            height: 100%;
            border-radius: 6px;
            transition: width 0.5s
        }

        .qa-bar-label {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 11px;
            font-weight: 700
        }

        .qa-stats {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            font-size: 13px;
            color: var(--muted)
        }
        .page-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
    </style>
@endpush

@section('content')
    <div class="results-page">
        <div class="page-header">
            <div>
                <h1 style="font-size:28px;font-weight:700">Quiz Results</h1>
                <p style="color:var(--muted);font-size:14px;margin-top:4px">{{ \App\Models\QuizType::where('key', $type)->value('name') ?? 'Quiz' }}
                </p>
            </div>
            <a href="{{ route('admin.quiz.index') }}" class="btn btn-ghost">← Back to Quizzes</a>
        </div>

        <div class="overview-grid">
            <div class="overview-card">
                <div class="value">{{ $overview['total_participants'] }}</div>
                <div class="label">Participants</div>
            </div>
            <div class="overview-card">
                <div class="value">{{ $overview['total_questions'] }}</div>
                <div class="label">Questions</div>
            </div>
            <div class="overview-card">
                <div class="value">{{ $overview['total_answers'] }}</div>
                <div class="label">Total Answers</div>
            </div>
            <div class="overview-card">
                <div class="value">{{ $overview['avg_score'] }}</div>
                <div class="label">Avg Score</div>
            </div>
        </div>

        <h2 style="font-size:20px;font-weight:700;margin-bottom:16px">🏆 Final Leaderboard</h2>
        <table class="leaderboard-table">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Score</th>
                    <th>Correct</th>
                    <th>Avg Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($overview['leaderboard'] as $entry)
                    <tr>
                        <td><span
                                class="rank-badge {{ $entry['rank'] == 1 ? 'rank-1' : ($entry['rank'] == 2 ? 'rank-2' : ($entry['rank'] == 3 ? 'rank-3' : '')) }}">{{ $entry['rank'] }}</span>
                        </td>
                        <td style="font-weight:600">{{ $entry['name'] }}</td>
                        <td style="color:var(--muted)">{{ $entry['email'] }}</td>
                        <td style="font-weight:700;color:var(--purple-1)">{{ $entry['score'] }}</td>
                        <td>{{ $entry['correct_count'] }} / {{ $overview['total_questions'] }}</td>
                        <td>{{ $entry['avg_response_time_ms'] ? number_format($entry['avg_response_time_ms'] / 1000, 1) . 's' : '-' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2 style="font-size:20px;font-weight:700;margin-bottom:16px">📊 Per-Question Analytics</h2>
        @foreach($overview['question_analytics'] as $qa)
            <div class="qa-card">
                <h4>{{ $qa['question_text'] }}</h4>
                @foreach($qa['options'] as $i => $opt)
                    <?php        $count = $qa['option_counts'][$i];
                    $total = $qa['total_responded'] ?: 1;
                    $pct = ($count / $total) * 100;
                    $color = $i === $qa['correct_option'] ? '#8ff0b3' : 'rgba(255,255,255,0.3)'; ?>
                    <div class="qa-bars">
                        <span style="width:20px;font-size:13px;font-weight:700">{{ chr(65 + $i) }}</span>
                        <div class="qa-bar">
                            <div class="qa-bar-fill" style="width:{{ $pct }}%;background:{{ $color }}"></div><span
                                class="qa-bar-label">{{ $count }}</span>
                        </div>
                        <span style="font-size:12px;color:var(--muted);width:40px">{{ round($pct) }}%</span>
                    </div>
                @endforeach
                <div class="qa-stats">
                    <span>Total: {{ $qa['total_responded'] }}</span>
                    <span>Correct: {{ $qa['correct_count'] }} ({{ $qa['correct_rate'] }}%)</span>
                    @if($qa['first_correct'])
                        <span>First: {{ $qa['first_correct']['name'] }}
                            ({{ number_format($qa['first_correct']['response_time_ms'] / 1000, 1) }}s)</span>
                    @endif
                    @if($qa['avg_response_time_ms'])
                        <span>Avg Time: {{ number_format($qa['avg_response_time_ms'] / 1000, 1) }}s</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection