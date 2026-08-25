@extends('layouts.app')

@section('title', 'Registrations — Admin')

@push('styles')
<style>
    .admin-page{min-height:100vh;padding:40px 24px;background:var(--bg-soft)}
    .admin-wrap{max-width:1200px;margin:0 auto}
    .admin-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px}
    .filter-bar{display:flex;gap:12px;margin-bottom:24px;flex-wrap:wrap}
    .filter-bar input,.filter-bar select{background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:10px 14px;color:#fff;font-size:13px;outline:none}
    .filter-bar input{width:240px}
    .filter-bar button{padding:10px 20px;border-radius:12px;background:var(--purple-1);color:#fff;border:none;font-weight:600;cursor:pointer}
    .admin-section{background:linear-gradient(160deg,rgba(22,12,30,0.9) 0%,rgba(8,4,12,0.96) 100%);border:1px solid rgba(255,255,255,0.05);border-radius:18px;padding:24px}
    table{width:100%;border-collapse:collapse;font-size:13px}
    th,td{padding:12px;text-align:left;border-bottom:1px solid rgba(255,255,255,0.06)}
    th{color:var(--muted);font-weight:600;font-size:12px;text-transform:uppercase}
    td{color:var(--ink)}
    .badge{display:inline-block;padding:4px 12px;border-radius:999px;font-size:11px;font-weight:600}
    .badge-paid{background:rgba(40,180,100,0.15);color:#8ff0b3}
    .badge-pending{background:rgba(255,180,0,0.15);color:#ffd700}
    .pagination{margin-top:20px;display:flex;gap:8px;justify-content:center}
    .pagination a,.pagination span{padding:8px 14px;border-radius:8px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);color:var(--muted);font-size:13px}
    .pagination span{background:var(--purple-1);color:#fff}
</style>
@endpush

@section('content')
<div class="admin-page">
    <div class="admin-wrap">
        <div class="admin-header">
            <h1>All Registrations</h1>
            <a href="{{ route('admin.dashboard') }}" style="color:var(--purple-1);font-size:14px">← Back to Dashboard</a>
        </div>

        <form class="filter-bar" method="GET">
            <input type="text" name="search" placeholder="Search name, email, phone..." value="{{ request('search') }}">
            <select name="status">
                <option value="">All Status</option>
                <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                <option value="otp_verified" {{ request('status')=='otp_verified'?'selected':'' }}>OTP Verified</option>
                <option value="kyc_completed" {{ request('status')=='kyc_completed'?'selected':'' }}>KYC Done</option>
                <option value="paid" {{ request('status')=='paid'?'selected':'' }}>Paid</option>
                <option value="checked_in" {{ request('status')=='checked_in'?'selected':'' }}>Checked In</option>
            </select>
            <button type="submit">Filter</button>
        </form>

        <div class="admin-section">
            <table>
                <thead>
                    <tr><th>Reg #</th><th>Name</th><th>Email</th><th>Phone</th><th>Type</th><th>Status</th><th>Payment</th><th>Seat</th><th>Date</th></tr>
                </thead>
                <tbody>
                    @forelse($registrations as $r)
                    <tr>
                        <td>{{ $r->registration_number }}</td>
                        <td>{{ $r->full_name }}<br>{{ $r->is_subbroker ? 'Sub-broker' : ($r->is_existing_client ? 'Existing Client' : 'New Client') }}</td>
                        <td>{{ $r->email }}</td>
                        <td>{{ $r->phone }}</td>
                        <td>{{ ucfirst($r->type) }}</td>
                        <td><span class="badge badge-{{ $r->status }}">{{ str_replace('_', ' ', ucfirst($r->status)) }}</span></td>
                        <td>{{ $r->payment?->status ?? 'N/A' }}<br>{{ $r->payment?->gateway_order_id ? 'Order ID : ' . $r->payment?->gateway_order_id : '' }}<br>{{ $r->payment?->gateway_payment_id ? 'Payment ID : ' . $r->payment?->gateway_payment_id : '' }}</td>
                        <td>{{ $r->seat?->seat_number ?? '-' }}</td>
                        <td>{{ $r->created_at->format('M d') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="9" style="text-align:center;color:var(--muted);padding:40px">No registrations found.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pagination">{{ $registrations->links() }}</div>
        </div>
    </div>
</div>
@endsection
