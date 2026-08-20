@extends('layouts.app')

@section('title', 'Check-Ins — Admin')

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
    .pagination{margin-top:20px}
</style>
@endpush

@section('content')
<div class="admin-page">
    <div class="admin-wrap">
        <div class="admin-header">
            <h1>Check-Ins</h1>
            <a href="{{ route('admin.dashboard') }}" style="color:var(--purple-1);font-size:14px">← Back</a>
        </div>
        <div class="admin-section">
            <table>
                <thead><tr><th>Name</th><th>Reg #</th><th>Seat</th><th>Section</th><th>Checked In At</th></tr></thead>
                <tbody>
                    @forelse($checkIns as $c)
                    <tr>
                        <td>{{ $c->full_name }}</td>
                        <td>{{ $c->registration_number }}</td>
                        <td>{{ $c->seat?->seat_number ?? '-' }}</td>
                        <td>{{ $c->seat?->section ?? '-' }}</td>
                        <td>{{ $c->checked_in_at?->format('M d, h:i A') ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align:center;color:var(--muted);padding:40px">No check-ins yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pagination">{{ $checkIns->links() }}</div>
        </div>
    </div>
</div>
@endsection
