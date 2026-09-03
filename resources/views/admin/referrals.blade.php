@extends('layouts.app')

@section('title', 'Referrals — Admin')

@push('styles')
    <style>
        .admin-page {
            min-height: 100vh;
            padding: 40px 24px;
            background: var(--bg-soft)
        }

        .admin-wrap {
            max-width: 1200px;
            margin: 0 auto
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px
        }

        .admin-section {
            background: linear-gradient(160deg, rgba(22, 12, 30, 0.9) 0%, rgba(8, 4, 12, 0.96) 100%);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 18px;
            padding: 24px
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06)
        }

        th {
            color: var(--muted);
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase
        }

        td {
            color: var(--ink)
        }

        .pagination {
            margin-top: 20px
        }
    </style>
@endpush

@section('content')
<div class="admin-page">
    <div class="admin-wrap">
        <div class="admin-header">
            <h1>All Referrals</h1>
            <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap">
                @permission('referrals', 'export')
                <a href="{{ route('admin.export', ['type' => 'referrals']) }}" class="btn btn-primary"
                    style="font-size:13px;padding:9px 16px">
                    Export Excel
                </a>
                @endpermission
                <a href="{{ route('admin.dashboard') }}" style="color:var(--purple-1);font-size:14px">← Back</a>
            </div>
        </div>
        <div class="admin-section">
            <table>
                <thead>
                    <tr>
                        <th>Referrer</th>
                        <th>Referred Email</th>
                        <th>Referred Phone</th>
                        <th>Status</th>
                        <th>Points</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($referrals as $r)
                        <tr>
                            <td>{{ $r->referrer?->full_name ?? 'N/A' }}</td>
                            <td>{{ $r->referred_email }}</td>
                            <td>{{ $r->referred_phone }}</td>
                            <td>{{ ucfirst($r->status) }}</td>
                            <td>{{ $r->points_awarded }}</td>
                            <td>{{ $r->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;color:var(--muted);padding:40px">No referrals yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pagination">{{ $referrals->links() }}</div>
        </div>
    </div>
</div>
@endsection