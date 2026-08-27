@extends('layouts.app')

@section('title', 'Admin Dashboard — ArihantPLUS')

@push('styles')
<style>
    .admin-page{min-height:100vh;padding:40px 24px;background:var(--bg-soft)}
    .admin-wrap{max-width:1200px;margin:0 auto}
    .admin-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:32px;flex-wrap:wrap;gap:16px}
    .admin-header h1{font-size:28px;font-weight:700}
    .stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:32px}
    .stat-card{background:linear-gradient(160deg,rgba(22,12,30,0.9) 0%,rgba(8,4,12,0.96) 100%);border:1px solid rgba(255,255,255,0.05);border-radius:18px;padding:24px;text-align:center}
    .stat-card .num{font-size:32px;font-weight:800;color:var(--purple-1);margin-bottom:4px}
    .stat-card .lbl{font-size:13px;color:var(--muted)}
    .stat-card .sub {font-size: 12px;color: var(--ink);opacity: 0.75;line-height: 1.4;margin-top: 2px;}
    .admin-section{background:linear-gradient(160deg,rgba(22,12,30,0.9) 0%,rgba(8,4,12,0.96) 100%);border:1px solid rgba(255,255,255,0.05);border-radius:18px;padding:24px;margin-bottom:24px}
    .admin-section h2{font-size:18px;font-weight:700;margin-bottom:16px}
    table{width:100%;border-collapse:collapse;font-size:13px}
    th,td{padding:12px;text-align:left;border-bottom:1px solid rgba(255,255,255,0.06)}
    th{color:var(--muted);font-weight:600;font-size:12px;text-transform:uppercase;letter-spacing:0.05em}
    td{color:var(--ink)}
    .badge{display:inline-block;padding:4px 12px;border-radius:999px;font-size:11px;font-weight:600}
    .badge-paid{background:rgba(40,180,100,0.15);color:#8ff0b3}
    .badge-pending{background:rgba(255,180,0,0.15);color:#ffd700}
    .badge-checkin{background:rgba(184,102,247,0.15);color:var(--purple-1)}
    .nav-pills{display:flex;gap:10px;margin-bottom:24px;flex-wrap:wrap}
    .nav-pills a{padding:8px 16px;border-radius:999px;font-size:13px;font-weight:600;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);color:var(--muted);transition:all .2s}
    .nav-pills a:hover,.nav-pills a.active{background:var(--purple-1);color:#fff;border-color:var(--purple-1)}
</style>
@endpush

@section('content')
<div class="admin-page">
    <div class="admin-wrap">
        <div class="admin-header">
            <h1>Admin Dashboard</h1>
            <span style="color:var(--muted);font-size:14px">{{ now()->format('F j, Y g:i A') }}</span>
        </div>

        <div class="nav-pills">
            <a href="{{ route('admin.dashboard') }}" class="active">Overview</a>
            <a href="{{ route('admin.registrations') }}">Registrations</a>
            <a href="{{ route('admin.checkins') }}">Check-Ins</a>
            <a href="{{ route('admin.stalls.index') }}">Stalls</a>
            <a href="{{ route('admin.referrals') }}">Referrals</a>
            <a href="{{ route('admin.leaderboard') }}">Leaderboard</a>
            <a href="{{ route('admin.influencer') }}">Influencer</a>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="num">{{ $stats['total_registrations'] }}</div>
                <div class="lbl">Total Registrations</div>
                <div class="sub">Existing: {{ $stats['registrations_existing_clients'] }}</div>
                <div class="sub">Sub Brokers: {{ $stats['registrations_subbrokers'] }}</div>
                <div class="sub">Non Clients: {{ $stats['registrations_non_clients'] }}</div>
            </div>
            <div class="stat-card">
                <div class="num">{{ $stats['paid_registrations'] }}</div>
                <div class="lbl">Paid</div>
                <div class="sub">Existing: {{ $stats['paid_existing_clients'] }}</div>
                <div class="sub">Sub Brokers: {{ $stats['paid_subbrokers'] }}</div>
                <div class="sub">Non Clients: {{ $stats['paid_non_clients'] }}</div>
            </div>
            <div class="stat-card"><div class="num">{{ $stats['checked_in'] }}</div><div class="lbl">Checked In</div></div>
            <div class="stat-card"><div class="num">{{ $stats['allocated_seats'] }}/{{ $stats['total_seats'] }}</div><div class="lbl">Seats Allocated</div></div>
            <div class="stat-card"><div class="num">{{ $stats['total_stall_visits'] }}</div><div class="lbl">Stall Visits</div></div>
            <div class="stat-card">
                <div class="num">{{ $stats['total_referrals'] }}</div>
                <div class="lbl">Referrals</div>
                <div class="sub">Invited: {{ $stats['referrals_invited'] }}</div>
                <div class="sub">Registered: {{ $stats['referrals_registered'] }}</div>
                <div class="sub">Paid: {{ $stats['referrals_paid'] }}</div>
            </div>
            <div class="stat-card"><div class="num">{{ $stats['pending_posts'] }}</div><div class="lbl">Pending Posts</div></div>
        </div>

        <div class="admin-section">
            <h2>Recent Registrations</h2>
            <table>
                <thead><tr><th>Reg #</th><th>Name</th><th>Email</th><th>Type</th><th>Status</th><th>Date</th></tr></thead>
                <tbody>
                    @forelse($recentRegistrations as $r)
                    <tr>
                        <td>{{ $r->registration_number }}</td>
                        <td>{{ $r->full_name }}</td>
                        <td>{{ $r->email }}</td>
                        <td>{{ ucfirst($r->type) }}</td>
                        <td><span class="badge badge-{{ $r->status }}">{{ ucfirst($r->status) }}</span></td>
                        <td>{{ $r->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center;color:var(--muted)">No registrations yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px">
            <div class="admin-section">
                <h2>Top Referrers</h2>
                <table>
                    <thead><tr><th>Name</th><th>Points</th></tr></thead>
                    <tbody>
                        @forelse($topReferrers as $t)
                        <tr><td>{{ $t->full_name }}</td><td>{{ $t->total_points ?? 0 }}</td></tr>
                        @empty
                        <tr><td colspan="2" style="text-align:center;color:var(--muted)">No data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="admin-section">
                <h2>Top Influencers</h2>
                <table>
                    <thead><tr><th>Name</th><th>Points</th></tr></thead>
                    <tbody>
                        @forelse($topInfluencers as $t)
                        <tr><td>{{ $t->full_name }}</td><td>{{ $t->total_points ?? 0 }}</td></tr>
                        @empty
                        <tr><td colspan="2" style="text-align:center;color:var(--muted)">No data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
