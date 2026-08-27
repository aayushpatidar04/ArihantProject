@extends('layouts.app')

@section('title', 'Visit Responses — Admin')

@push('styles')
    <style>
        .admin-page {
            min-height: 100vh;
            padding: 40px 24px 70px;
            background: var(--bg-soft);
        }

        .admin-wrap {
            max-width: 1100px;
            margin: 0 auto;
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 28px;
        }

        .admin-header h1 {
            font-size: 30px;
            margin: 0 0 6px;
        }

        .admin-header p {
            color: var(--muted);
            font-size: 14px;
            margin: 0;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 9px 13px;
            border-radius: 9px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.04);
            color: #e9defa;
            font-size: 12px;
            text-decoration: none;
            transition: 0.2s ease;
        }

        .action-btn:hover {
            border-color: rgba(184, 102, 247, 0.55);
            background: rgba(184, 102, 247, 0.12);
        }

        .card {
            background: linear-gradient(160deg,
                    rgba(22, 12, 30, 0.9),
                    rgba(8, 4, 12, 0.96));
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 22px;
        }

        .card-header {
            padding: 18px 22px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .card-header h2 {
            margin: 0;
            font-size: 18px;
        }

        .card-body {
            padding: 22px;
        }

        /* Participant Information */

        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .info-label {
            display: block;
            color: var(--muted);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 6px;
        }

        .info-value {
            color: var(--ink);
            font-size: 14px;
            font-weight: 600;
        }

        /* Score Card */

        .score-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .score-item {
            padding: 18px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.025);
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        .score-label {
            color: var(--muted);
            font-size: 11px;
            margin-bottom: 7px;
        }

        .score-value {
            color: var(--purple-1);
            font-size: 24px;
            font-weight: 700;
        }

        /* Quiz Answers */

        .question-item {
            padding: 18px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .question-item:last-child {
            padding-bottom: 0;
            border-bottom: none;
        }

        .question {
            color: var(--ink);
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .answer-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            padding: 12px 14px;
            background: rgba(255, 255, 255, 0.025);
            border-radius: 10px;
        }

        .answer-text {
            font-size: 13px;
            color: #ded7e6;
        }

        .correct-answer {
            color: #8ff0b3;
            font-size: 12px;
            font-weight: 700;
        }

        .incorrect-answer {
            color: #ffaaaa;
            font-size: 12px;
            font-weight: 700;
        }

        /* Feedback */

        .feedback-item {
            padding: 18px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .feedback-item:last-child {
            padding-bottom: 0;
            border-bottom: none;
        }

        .feedback-question {
            color: var(--ink);
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .feedback-answer {
            padding: 14px 16px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.025);
            color: #ded7e6;
            font-size: 13px;
            line-height: 1.6;
            white-space: pre-line;
        }

        .empty-message {
            color: var(--muted);
            font-size: 14px;
            text-align: center;
            padding: 30px;
        }

        @media (max-width: 800px) {

            .info-grid,
            .score-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .admin-page {
                padding: 28px 16px 50px;
            }

            .admin-header {
                flex-direction: column;
            }

            .answer-row {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
@endpush

@section('content')

    <div class="admin-page">
        <div class="admin-wrap">

            {{-- Header --}}
            <div class="admin-header">
                <div>
                    <h1>Visit Responses</h1>
                    <p>
                        {{ $stall->name }} — Participant engagement details
                    </p>
                </div>

                <a href="{{ route('admin.stalls.visits.index', $stall) }}" class="action-btn">
                    ← Back to Visits
                </a>
            </div>

            {{-- Participant / Visit Details --}}
            <div class="card">
                <div class="card-header">
                    <h2>Participant & Visit Information</h2>
                </div>

                <div class="card-body">
                    <div class="info-grid">

                        <div>
                            <span class="info-label">Participant</span>
                            <div class="info-value">
                                {{ $visit->registration?->user?->name
        ?? 'Unknown Participant'
                                }}
                            </div>
                        </div>

                        <div>
                            <span class="info-label">Registration Number</span>
                            <div class="info-value">
                                {{ $visit->registration?->registration_number ?? '—' }}
                            </div>
                        </div>

                        <div>
                            <span class="info-label">Visited At</span>
                            <div class="info-value">
                                {{ $visit->visited_at?->format('d M Y, h:i A') ?? '—' }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Engagement Score --}}
            <div class="card">
                <div class="card-header">
                    <h2>Engagement Scorecard</h2>
                </div>

                <div class="card-body">
                    <div class="score-grid">

                        <div class="score-item">
                            <div class="score-label">
                                Quiz Score
                            </div>
                            <div class="score-value">
                                {{ $visit->quiz_score ?? 0 }}
                            </div>
                        </div>

                        <div class="score-item">
                            <div class="score-label">
                                Engagement Points
                            </div>
                            <div class="score-value">
                                {{ $visit->engagement_points }}
                            </div>
                        </div>

                        <div class="score-item">
                            <div class="score-label">
                                Quiz Answers
                            </div>
                            <div class="score-value">
                                {{ $visit->quizAnswers->count() }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Quiz Responses --}}
            <div class="card">
                <div class="card-header">
                    <h2>Quiz Responses</h2>
                </div>

                <div class="card-body">

                    @if($visit->quizAnswers->count())

                        @foreach($visit->quizAnswers as $answer)

                            <div class="question-item">

                                <div class="question">
                                    {{ $loop->iteration }}.
                                    {{ $answer->question?->question ?? 'Question unavailable' }}
                                </div>

                                <div class="answer-row">

                                    <div>
                                        <span class="info-label">
                                            Selected Answer
                                        </span>

                                        <div class="answer-text">
                                            {{ $answer->option?->option_text ?? '—' }}
                                        </div>
                                    </div>

                                    <div>
                                        @if($answer->is_correct)
                                            <span class="correct-answer">
                                                ✓ Correct (+{{ $answer->points_earned }} points)
                                            </span>
                                        @else
                                            <span class="incorrect-answer">
                                                ✕ Incorrect
                                            </span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                        @endforeach

                    @else

                        <div class="empty-message">
                            This participant did not attempt the quiz.
                        </div>

                    @endif

                </div>
            </div>

            {{-- Feedback Responses --}}
            <div class="card">
                <div class="card-header">
                    <h2>Feedback Responses</h2>
                </div>

                <div class="card-body">

                    @if($visit->feedbackResponses->count())

                        @foreach($visit->feedbackResponses as $response)

                            <div class="feedback-item">

                                <div class="feedback-question">
                                    {{ $response->question?->question ?? 'Question unavailable' }}
                                </div>

                                <div class="feedback-answer">
                                    {{ $response->answer ?: 'No answer provided.' }}
                                </div>

                            </div>

                        @endforeach

                    @else

                        <div class="empty-message">
                            This participant did not submit feedback.
                        </div>

                    @endif

                </div>
            </div>

        </div>
    </div>

@endsection