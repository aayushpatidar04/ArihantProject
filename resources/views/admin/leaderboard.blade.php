@extends('layouts.app')

@section('title', 'Leaderboard — Admin')

@push('styles')
<style>
    .admin-page{min-height:100vh;padding:40px 24px;background:var(--bg-soft)}
    .admin-wrap{max-width:1200px;margin:0 auto}
    .admin-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;gap:12px;flex-wrap:wrap}
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
    .pagination{margin-top:16px;display:flex;gap:8px;justify-content:center;flex-wrap:wrap}
    .pagination a,.pagination span{padding:7px 12px;border-radius:8px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);color:var(--muted);font-size:12px}
    .pagination span{background:var(--purple-1);color:#fff}
    @media(max-width:900px){.grid-3{grid-template-columns:1fr}}
</style>
@endpush

@section('content')
<div class="admin-page">
    <div class="admin-wrap">
        <div class="admin-header">
            <h1>Leaderboards</h1>
            <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap">
                <a href="{{ route('admin.export', ['type' => 'leadscore']) }}" class="btn btn-primary" style="font-size:13px;padding:9px 16px">
                    Export Excel
                </a>
                <a href="{{ route('admin.dashboard') }}" style="color:var(--purple-1);font-size:14px">← Back</a>
            </div>
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
                            <td>{{ $score->registration_score + $score->kyc_score }}</td>
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
            <div class="pagination">{{ $overallLeaderboard->links() }}</div>
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
                <div class="pagination">{{ $referralLeaderboard->links() }}</div>
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
                <div class="pagination">{{ $influencerLeaderboard->links() }}</div>
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
                <div class="pagination">{{ $stallLeaderboard->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
