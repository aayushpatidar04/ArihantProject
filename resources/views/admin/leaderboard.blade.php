@extends('layouts.app')

@section('title', 'Leaderboard — Admin')

@push('styles')
<style>
    .admin-page{min-height:100vh;padding:40px 24px;background:var(--bg-soft)}
    .admin-wrap{max-width:1200px;margin:0 auto}
    .admin-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:24px}
    .grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
    .admin-section{background:linear-gradient(160deg,rgba(22,12,30,0.9) 0%,rgba(8,4,12,0.96) 100%);border:1px solid rgba(255,255,255,0.05);border-radius:18px;padding:24px}
    .admin-section h2{font-size:16px;font-weight:700;margin-bottom:16px}
    table{width:100%;border-collapse:collapse;font-size:13px}
    th,td{padding:10px;text-align:left;border-bottom:1px solid rgba(255,255,255,0.06)}
    th{color:var(--muted);font-weight:600;font-size:11px;text-transform:uppercase}
    td{color:var(--ink)}
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
