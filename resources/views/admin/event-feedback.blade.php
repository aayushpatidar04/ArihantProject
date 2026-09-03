@extends('layouts.app')

@section('title', 'Event Feedback — Admin')

@push('styles')
    <style>
        .admin-page {
            min-height: 100vh;
            padding: 40px 24px;
            background: var(--bg-soft)
        }

        .admin-wrap {
            max-width: 1400px;
            margin: 0 auto
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            gap: 16px;
            flex-wrap: wrap
        }

        .admin-section {
            background: linear-gradient(160deg, rgba(22, 12, 30, 0.9) 0%, rgba(8, 4, 12, 0.96) 100%);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 18px;
            padding: 24px;
            overflow-x: auto
        }

        table {
            width: 100%;
            min-width: 1250px;
            border-collapse: collapse;
            font-size: 13px
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            vertical-align: top;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06)
        }

        th {
            color: var(--muted);
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            white-space: nowrap
        }

        td {
            color: var(--ink);
            line-height: 1.5
        }

        .participant-name {
            font-weight: 600;
            white-space: nowrap
        }

        .participant-meta {
            color: var(--muted);
            font-size: 12px;
            margin-top: 3px
        }

        .answer {
            min-width: 180px;
            max-width: 260px;
            white-space: normal;
            overflow-wrap: anywhere
        }

        .score {
            color: #8ff0b3;
            font-weight: 700;
            white-space: nowrap
        }

        .pagination {
            margin-top: 20px;
            display: flex;
            gap: 8px;
            justify-content: center
        }

        .pagination a,
        .pagination span {
            padding: 8px 14px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: var(--muted);
            font-size: 13px
        }

        .pagination span {
            background: var(--purple-1);
            color: #fff
        }
    </style>
@endpush

@section('content')
<div class="admin-page">
    <div class="admin-wrap">
        <div class="admin-header">
            <h1>Event Feedback</h1>
            <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap">
                @permission('event-feedback', 'export')
                <a href="{{ route('admin.export', ['type' => 'feedback']) }}" class="btn btn-primary"
                    style="font-size:13px;padding:9px 16px">
                    Export Excel
                </a>
                @endpermission
                <a href="{{ route('admin.dashboard') }}" style="color:var(--purple-1);font-size:14px">
                    ← Back to Dashboard
                </a>
            </div>
        </div>

        <div class="admin-section">
            <table>
                <thead>
                    <tr>
                        <th>Participant</th>
                        <th>Submitted</th>
                        <th>Experience</th>
                        <th>Session Quality</th>
                        <th>Content Usefulness</th>
                        <th>Networking</th>
                        <th>Recommendation</th>
                        <th>Feedback Score</th>
                        <th>Most Valuable Session</th>
                        <th>Liked Most</th>
                        <th>Improvements</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($feedback as $item)
                        <tr>
                            <td>
                                <div class="participant-name">{{ $item->registration?->full_name ?? 'Unknown' }}</div>
                                <div class="participant-meta">
                                    {{ $item->registration?->registration_number ?? 'Registration unavailable' }}
                                </div>
                            </td>
                            <td>{{ $item->created_at?->format('M d, Y h:i A') ?? '-' }}</td>
                            <td>{{ $item->experience_rating }}/5</td>
                            <td>{{ $item->session_quality }}</td>
                            <td>{{ $item->content_usefulness }}</td>
                            <td>{{ $item->networking_rating }}</td>
                            <td>{{ $item->recommendation }}</td>
                            <td class="score">{{ $item->registration?->leadScore?->social_score ?? 0 }}/20</td>
                            <td class="answer">{!! nl2br(e($item->most_valuable_session)) !!}</td>
                            <td class="answer">{!! nl2br(e($item->liked_most)) !!}</td>
                            <td class="answer">{!! nl2br(e($item->improvements)) !!}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" style="text-align:center;color:var(--muted);padding:40px">
                                No event feedback submitted yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination">{{ $feedback->links() }}</div>
        </div>
    </div>
</div>
</div>
@endsection