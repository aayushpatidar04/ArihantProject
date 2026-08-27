@extends('layouts.app')

@section('title', $stall->name . ' Visits — Admin')

@push('styles')
    <style>
        .admin-page {
            min-height: 100vh;
            padding: 40px 24px 70px;
            background: var(--bg-soft);
        }

        .admin-wrap {
            max-width: 1200px;
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

        /* Summary */

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .summary-card {
            background: linear-gradient(160deg,
                    rgba(22, 12, 30, 0.9),
                    rgba(8, 4, 12, 0.96));
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 18px;
            padding: 20px;
        }

        .summary-label {
            color: var(--muted);
            font-size: 12px;
            margin-bottom: 8px;
        }

        .summary-value {
            color: var(--ink);
            font-size: 28px;
            font-weight: 700;
        }

        .summary-subtext {
            color: var(--muted-2);
            font-size: 11px;
            margin-top: 5px;
        }

        /* Table */

        .admin-card {
            background: linear-gradient(160deg,
                    rgba(22, 12, 30, 0.9),
                    rgba(8, 4, 12, 0.96));
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 20px;
            overflow: hidden;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 950px;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 16px 18px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            vertical-align: middle;
        }

        th {
            color: var(--muted);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            font-weight: 700;
            background: rgba(255, 255, 255, 0.018);
        }

        td {
            color: #ded7e6;
            font-size: 13px;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .participant {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .participant strong {
            color: var(--ink);
            font-size: 14px;
        }

        .participant small {
            color: var(--muted-2);
            font-size: 11px;
        }

        /* Badges */

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
        }

        .badge-success {
            background: rgba(40, 180, 100, 0.12);
            color: #8ff0b3;
            border: 1px solid rgba(40, 180, 100, 0.22);
        }

        .badge-muted {
            background: rgba(255, 255, 255, 0.06);
            color: var(--muted);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .badge-purple {
            background: rgba(184, 102, 247, 0.12);
            color: var(--purple-1);
            border: 1px solid rgba(184, 102, 247, 0.25);
        }

        /* Score */

        .score {
            font-weight: 700;
            color: var(--purple-1);
        }

        /* Button */

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 12px;
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

        .empty-state {
            text-align: center;
            padding: 70px 20px;
        }

        .empty-state h3 {
            margin-bottom: 8px;
            font-size: 20px;
        }

        .empty-state p {
            color: var(--muted);
            font-size: 14px;
            margin: 0;
        }

        .pagination-wrap {
            margin-top: 24px;
        }

        @media (max-width: 900px) {
            .summary-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .admin-page {
                padding: 28px 16px 50px;
            }

            .admin-header {
                flex-direction: column;
            }

            .summary-grid {
                grid-template-columns: 1fr;
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
                    <h1>{{ $stall->name }} — Visits</h1>
                    <p>
                        Review participant visits, quiz participation and feedback
                        responses for this stall.
                    </p>
                </div>

                <a href="{{ route('admin.stalls.show', $stall) }}" class="action-btn">
                    ← Back to Stall
                </a>
            </div>

            {{-- Summary Cards --}}
            <div class="summary-grid">

                <div class="summary-card">
                    <div class="summary-label">Total Visits</div>
                    <div class="summary-value">
                        {{ $totalVisits }}
                    </div>
                    <div class="summary-subtext">
                        Participants who scanned this stall QR
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-label">Quiz Completed</div>
                    <div class="summary-value">
                        {{ $quizCompleted }}
                    </div>
                    <div class="summary-subtext">
                        Participants who submitted quiz answers
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-label">Feedback Submitted</div>
                    <div class="summary-value">
                        {{ $feedbackSubmitted }}
                    </div>
                    <div class="summary-subtext">
                        Participants who submitted feedback
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-label">Average Quiz Score</div>
                    <div class="summary-value">
                        {{ $averageQuizScore !== null
        ? number_format($averageQuizScore, 1)
        : '—'
                        }}
                    </div>
                    <div class="summary-subtext">
                        Average score of completed quizzes
                    </div>
                </div>

            </div>

            {{-- Visits Table --}}
            <div class="admin-card">

                @if($visits->count())

                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Participant</th>
                                    <th>Registration No.</th>
                                    <th>Visited At</th>
                                    <th>Quiz</th>
                                    <th>Score</th>
                                    <th>Feedback</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($visits as $visit)

                                                    <tr>

                                                        {{-- Participant --}}
                                                        <td>
                                                            <div class="participant">
                                                                <strong>
                                                                    {{ $visit->registration?->user?->name
                                        ?? 'Unknown Participant'
                                                                            }}
                                                                </strong>

                                                                <small>
                                                                    {{ $visit->registration?->user?->email
                                        ?? '—'
                                                                            }}
                                                                </small>
                                                            </div>
                                                        </td>

                                                        {{-- Registration Number --}}
                                                        <td>
                                                            {{ $visit->registration?->registration_number ?? '—' }}
                                                        </td>

                                                        {{-- Visit Time --}}
                                                        <td>
                                                            {{ $visit->visited_at?->format('d M Y, h:i A') ?? '—' }}
                                                        </td>

                                                        {{-- Quiz --}}
                                                        <td>
                                                            @if($visit->quizAnswers->count())
                                                                <span class="badge badge-success">
                                                                    Completed
                                                                </span>
                                                            @else
                                                                <span class="badge badge-muted">
                                                                    Not Attempted
                                                                </span>
                                                            @endif
                                                        </td>

                                                        {{-- Score --}}
                                                        <td>
                                                            @if($visit->quizAnswers->count())
                                                                <span class="score">
                                                                    {{ $visit->quiz_score ?? 0 }}
                                                                </span>
                                                            @else
                                                                —
                                                            @endif
                                                        </td>

                                                        {{-- Feedback --}}
                                                        <td>
                                                            @if($visit->feedbackResponses->count())
                                                                <span class="badge badge-purple">
                                                                    Submitted
                                                                </span>
                                                            @else
                                                                <span class="badge badge-muted">
                                                                    Pending
                                                                </span>
                                                            @endif
                                                        </td>

                                                        {{-- Action --}}
                                                        <td>
                                                            <a href="{{ route(
                                        'admin.stalls.visits.show',
                                        [$stall, $visit]
                                    ) }}" class="action-btn">
                                                                View Responses
                                                            </a>
                                                        </td>

                                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>

                @else

                    <div class="empty-state">
                        <h3>No Stall Visits Yet</h3>
                        <p>
                            Participant visits will appear here after they scan this
                            stall's QR code.
                        </p>
                    </div>

                @endif

            </div>

            @if($visits->hasPages())
                <div class="pagination-wrap">
                    {{ $visits->links() }}
                </div>
            @endif

        </div>
    </div>

@endsection