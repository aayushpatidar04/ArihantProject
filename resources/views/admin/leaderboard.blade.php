@extends('layouts.app')

@section('title', 'Leaderboard — Admin')

@push('styles')
<style>
    .admin-page{min-height:100vh;padding:40px 24px;background:var(--bg-soft)}
    .admin-wrap{max-width:1200px;margin:0 auto}
    .admin-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:24px}
    .overall-section{margin-bottom:24px;overflow-x:auto}
    .grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
    .admin-section{background:linear-gradient(160deg,rgba(22,12,30,0.9) 0%,rgba(8,4,12,0.96) 100%);border:1px solid rgba(255,255,255,0.05);border-radius:18px;padding:24px}
    .admin-section h2{font-size:16px;font-weight:700;margin-bottom:16px}
    table{width:100%;border-collapse:collapse;font-size:13px}
    th,td{padding:10px;text-align:left;border-bottom:1px solid rgba(255,255,255,0.06)}
    th{color:var(--muted);font-weight:600;font-size:11px;text-transform:uppercase}
    td{color:var(--ink)}
    .overall-table{min-width:760px}
    .overall-table .total-score{color:#8ff0b3;font-weight:700}
    .overall-table .participant{font-weight:600;white-space:nowrap}
    .overall-table .meta{display:block;color:var(--muted);font-size:11px;margin-top:3px}
    @media(max-width:900px){.grid-3{grid-template-columns:1fr}}
</style>
@endpush

@section('content')
<div class="admin-page">
    <div class="admin-wrap">
        <div class="admin-header">
            <h1>Leaderboards</h1>
            <a href="{{ route('admin.dashboard') }}" style="color:var(--purple-1);font-size:14px">← Back</a>
        </div>

        <div class="admin-section overall-section">
            <h2>Overall Lead Ranking</h2>
            <table class="overall-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Lead</th>
                        <th>Registration</th>
                        <th>Referral</th>
                        <th>Event Feedback</th>
                        <th>Engagement</th>
                        <th>Overall Score</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($overallLeaderboard as $i => $score)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>
                                <span class="participant">{{ $score->registration?->full_name ?? 'Unknown lead' }}</span>
                                <span class="meta">{{ $score->registration?->registration_number ?? '-' }}</span>
                            </td>
                            <td>{{ $score->registration_score }}</td>
                            <td>{{ $score->referral_score }}</td>
                            <td>{{ $score->social_score }}</td>
                            <td>{{ $score->quiz_score + $score->stall_visit_score }}</td>
                            <td class="total-score">{{ $score->total_score }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;color:var(--muted);padding:30px">
                                No lead scores available yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="grid-3">
            <div class="admin-section">
                <h2>🏆 Top Referrers</h2>
                <table>
                    <thead><tr><th>#</th><th>Name</th><th>Points</th></tr></thead>
                    <tbody>
                        @foreach($referralLeaderboard as $i => $r)
                        <tr><td>{{ $i+1 }}</td><td>{{ $r->full_name }}</td><td>{{ $r->total_points ?? 0 }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="admin-section">
                <h2>📱 Top Influencers</h2>
                <table>
                    <thead><tr><th>#</th><th>Name</th><th>Points</th></tr></thead>
                    <tbody>
                        @foreach($influencerLeaderboard as $i => $r)
                        <tr><td>{{ $i+1 }}</td><td>{{ $r->name }}</td><td>{{ $r->total_points ?? 0 }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="admin-section">
                <h2>🎯 Stall Explorers</h2>
                <table>
                    <thead><tr><th>#</th><th>Name</th><th>Visits</th></tr></thead>
                    <tbody>
                        @foreach($stallLeaderboard as $i => $r)
                        <tr><td>{{ $i+1 }}</td><td>{{ $r->full_name }}</td><td>{{ $r->visit_count }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
