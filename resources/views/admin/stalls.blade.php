@extends('layouts.app')

@section('title', 'Stall Stats — Admin')

@push('styles')
<style>
    .admin-page{min-height:100vh;padding:40px 24px;background:var(--bg-soft)}
    .admin-wrap{max-width:1200px;margin:0 auto}
    .admin-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:24px}
    .admin-section{background:linear-gradient(160deg,rgba(22,12,30,0.9) 0%,rgba(8,4,12,0.96) 100%);border:1px solid rgba(255,255,255,0.05);border-radius:18px;padding:24px}
    table{width:100%;border-collapse:collapse;font-size:13px}
    th,td{padding:12px;text-align:left;border-bottom:1px solid rgba(255,255,255,0.06)}
    th{color:var(--muted);font-weight:600;font-size:12px;text-transform:uppercase}
    td{color:var(--ink)}
</style>
@endpush

@section('content')
<div class="admin-page">
    <div class="admin-wrap">
        <div class="admin-header">
            <h1>Stall Statistics</h1>
            <a href="{{ route('admin.dashboard') }}" style="color:var(--purple-1);font-size:14px">← Back</a>
        </div>
        <div class="admin-section">
            <table>
                <thead><tr><th>Stall</th><th>Location</th><th>Total Visits</th><th>Avg Rating</th></tr></thead>
                <tbody>
                    @forelse($stalls as $s)
                    <tr>
                        <td>{{ $s->name }}</td>
                        <td>{{ $s->location ?? '-' }}</td>
                        <td>{{ $s->visits_count }}</td>
                        <td>{{ $s->avg_rating !== null ? number_format($s->avg_rating, 1) : '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align:center;color:var(--muted);padding:40px">No stall data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
