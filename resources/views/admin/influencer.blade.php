@extends('layouts.app')

@section('title', 'Influencers — Admin')

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
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px
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

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 11px
        }

        .badge-approved {
            background: rgba(40, 180, 100, 0.15);
            color: #8ff0b3
        }

        .badge-pending {
            background: rgba(255, 180, 0, 0.15);
            color: #ffd700
        }

        .badge-rejected {
            background: rgba(220, 60, 60, 0.15);
            color: #ff9e9e
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
            <h1>Influencers</h1>
            <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap">
                @permission('influencers', 'create')
                <a href="{{ route('admin.influencers.create') }}" class="btn btn-primary"
                    style="font-size:13px;padding:9px 16px">+ Add Influencer</a>
                @endpermission
                <a href="{{ route('admin.dashboard') }}" style="color:var(--purple-1);font-size:14px">← Back</a>
            </div>
        </div>
        <div class="admin-section">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Total Posts</th>
                        <th>Approved</th>
                        <th>Pending</th>
                        <th>Points</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($influencers as $influencer)
                    @php
                        $posts = $influencer->influencerPosts;
                        $approved = $posts->where('status', 'approved')->count();
                        $pending = $posts->where('status', 'pending')->count();
                        $points = $posts->where('status', 'approved')->sum('points_awarded');
                     @endphp
                    <tr>
                        <td><strong>{{ $influencer->name }}</strong></td>
                        <td>{{ $influencer->email }}</td>
                        <td>{{ $posts->count() }}</td>
                        <td>{{ $approved }}</td>
                        <td>{{ $pending }}</td>
                        <td>{{ $points }}</td>
                        <td style="display:flex;gap:6px;flex-wrap:wrap">
                            @permission('influencers', 'edit')
                            <a href="{{ route('admin.influencers.edit', $influencer) }}"
                                style="padding:5px 10px;border-radius:8px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);color:var(--purple-1);font-size:12px;font-weight:600">Edit</a>
                            @endpermission
                            @permission('influencers', 'delete')
                            <form action="{{ route('admin.influencers.destroy', $influencer) }}" method="POST"
                                style="display:inline" onsubmit="return confirm('Delete this influencer?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    style="padding:5px 10px;border-radius:8px;background:rgba(220,60,60,0.1);border:1px solid rgba(220,60,60,0.2);color:#ff9e9e;font-size:12px;font-weight:600;cursor:pointer">Delete</button>
                            </form>
                            @endpermission
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center;color:var(--muted);padding:40px">No influencers yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pagination">{{ $influencers->links() }}</div>
        </div>
    </div>
</div>
@endsection