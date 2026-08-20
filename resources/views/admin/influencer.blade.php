@extends('layouts.app')

@section('title', 'Influencer Posts — Admin')

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
    .btn-sm{padding:6px 14px;border-radius:8px;font-size:12px;font-weight:600;border:none;cursor:pointer;margin-right:6px}
    .btn-approve{background:rgba(40,180,100,0.2);color:#8ff0b3}
    .btn-reject{background:rgba(220,60,60,0.2);color:#ff9e9e}
    .pagination{margin-top:20px}
</style>
@endpush

@section('content')
<div class="admin-page">
    <div class="admin-wrap">
        <div class="admin-header">
            <h1>Influencer Submissions</h1>
            <a href="{{ route('admin.dashboard') }}" style="color:var(--purple-1);font-size:14px">← Back</a>
        </div>
        <div class="admin-section">
            <table>
                <thead><tr><th>Name</th><th>Platform</th><th>Type</th><th>URL</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse($posts as $p)
                    <tr>
                        <td>{{ $p->registration?->full_name ?? 'N/A' }}</td>
                        <td>{{ ucfirst($p->platform) }}</td>
                        <td>{{ ucfirst($p->post_type) }}</td>
                        <td><a href="{{ $p->post_url }}" target="_blank" style="color:var(--purple-1);word-break:break-all">Link</a></td>
                        <td>{{ ucfirst($p->status) }}</td>
                        <td>
                            @if($p->status === 'pending')
                            <form style="display:inline" action="{{ route('admin.influencer.approve', $p) }}" method="POST">@csrf<button class="btn-sm btn-approve">Approve</button></form>
                            <form style="display:inline" action="{{ route('admin.influencer.reject', $p) }}" method="POST">@csrf<button class="btn-sm btn-reject">Reject</button></form>
                            @else
                            <span style="color:var(--muted);font-size:12px">Processed</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center;color:var(--muted);padding:40px">No submissions.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pagination">{{ $posts->links() }}</div>
        </div>
    </div>
</div>
@endsection
