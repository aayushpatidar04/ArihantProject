@extends('layouts.app')

@section('title', 'Quiz Results — ArihantPLUS')

@push('styles')
    <style>
        .results-page {
            padding: 40px 24px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center
        }

        .results-card {
            background: linear-gradient(165deg, #170b22 0%, #0b0511 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 26px;
            padding: 48px 36px;
            max-width: 520px;
            width: 100%;
            text-align: center
        }

        .result-rank {
            font-size: 72px;
            font-weight: 800;
            color: var(--purple-1);
            margin-bottom: 8px
        }

        .result-score {
            font-size: 48px;
            font-weight: 800;
            color: var(--gold);
            margin-bottom: 4px
        }

        .result-label {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 24px
        }

        .breakdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            font-size: 13px;
            text-align: left
        }

        .breakdown-item:last-child {
            border: none
        }

        .break-icon {
            font-size: 16px
        }

        .back-link {
            color: var(--muted);
            font-size: 13px;
            margin-top: 20px
        }

        .back-link a {
            color: var(--purple-1);
            text-decoration: none
        }
    </style>
@endpush

@section('content')
    <div class="results-page">
        <div class="results-card">
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
                <a href="/quiz?type={{ $session->quiz_type ?? '' }}" class="btn btn-ghost">← Back to Quizzes</a>
            @else
                <h1>Results Not Available</h1>
                <p style="color:var(--muted);margin-top:8px">Quiz results will appear here after the quiz ends.</p>
            @endif
        </div>
    </div>
@endsection