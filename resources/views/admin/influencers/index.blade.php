@extends('layouts.app')

@section('title', 'Manage Influencers — Admin')

@push('styles')
    <style>
        .admin-page {
            min-height: 100vh;
            padding: 40px 24px 70px;
            background: var(--bg-soft);
        }

        .admin-wrap {
            max-width: 1200px;
            margin: 0 auto;
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 28px;
        }

        .admin-header h1 {
            font-size: 30px;
            margin-bottom: 6px;
        }

        .admin-header p {
            color: var(--muted);
            font-size: 14px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .back-link {
            color: var(--purple-1);
            font-size: 14px;
            text-decoration: none;
        }

        .admin-card {
            background: linear-gradient(160deg,
                    rgba(22, 12, 30, 0.9),
                    rgba(8, 4, 12, 0.96));
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 20px;
            overflow: hidden;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 950px;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 16px 18px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            vertical-align: middle;
        }

        th {
            color: var(--muted);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            font-weight: 700;
            background: rgba(255, 255, 255, 0.018);
        }

        td {
            font-size: 13px;
            color: #ded7e6;
        }

        .influencer-name {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .influencer-name strong {
            color: var(--ink);
            font-size: 14px;
        }

        .influencer-name small {
            color: var(--muted-2);
        }

        .stats-number {
            font-weight: 700;
            color: var(--ink);
        }

        .points {
            color: #d9a7ff;
            font-weight: 700;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
        }

        .badge-active {
            background: rgba(40, 180, 100, 0.12);
            color: #8ff0b3;
            border: 1px solid rgba(40, 180, 100, 0.22);
        }

        .action-buttons {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 11px;
            border-radius: 9px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.04);
            color: #e9defa;
            font-size: 12px;
            text-decoration: none;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .action-btn:hover {
            border-color: rgba(184, 102, 247, 0.55);
            background: rgba(184, 102, 247, 0.12);
            color: #fff;
        }

        .action-delete:hover {
            border-color: rgba(255, 90, 90, 0.5);
            background: rgba(255, 80, 80, 0.1);
            color: #ffaaaa;
        }

        .empty-state {
            text-align: center;
            padding: 65px 20px;
        }

        .empty-state h3 {
            margin-bottom: 8px;
            font-size: 20px;
        }

        .empty-state p {
            color: var(--muted);
            margin-bottom: 22px;
            font-size: 14px;
        }

        .alert {
            padding: 13px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .alert-success {
            background: rgba(40, 180, 100, 0.1);
            border: 1px solid rgba(40, 180, 100, 0.2);
            color: #8ff0b3;
        }

        .pagination-wrap {
            margin-top: 24px;
        }

        @media (max-width: 700px) {
            .admin-page {
                padding: 28px 16px 50px;
            }

            .admin-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .header-actions {
                width: 100%;
                flex-direction: column;
                align-items: stretch;
            }

            .header-actions .btn {
                width: 100%;
                text-align: center;
            }

            .back-link {
                text-align: center;
            }
        }
    </style>
@endpush

@section('content')

    <div class="admin-page">

        <div class="admin-wrap">

            <div class="admin-header">

                <div>
                    <h1>Manage Influencers</h1>
                    <p>
                        Create and manage influencer accounts and social activity submissions.
                    </p>
                </div>

                <div class="header-actions">

                    <a href="{{ route('admin.influencers.create') }}" class="btn btn-primary">
                        + Create Influencer
                    </a>

                    <a href="{{ route('admin.dashboard') }}" class="back-link">
                        ← Back to Dashboard
                    </a>

                </div>

            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="admin-card">

                @if($influencers->count())

                    <div class="table-wrap">

                        <table>

                            <thead>
                                <tr>
                                    <th>Influencer</th>
                                    <th>Total Posts</th>
                                    <th>Approved</th>
                                    <th>Pending</th>
                                    <th>Points</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($influencers as $influencer)

                                    <tr>

                                        <td>
                                            <div class="influencer-name">
                                                <strong>
                                                    {{ $influencer->name }}
                                                </strong>

                                                <small>
                                                    {{ $influencer->email }}
                                                </small>
                                            </div>
                                        </td>

                                        <td>
                                            <span class="stats-number">
                                                {{ $influencer->influencer_posts_count }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="badge badge-active">
                                                {{ $influencer->approved_posts_count }}
                                            </span>
                                        </td>

                                        <td>
                                            {{ $influencer->pending_posts_count }}
                                        </td>

                                        <td>
                                            <span class="points">
                                                {{ $influencer->total_points ?? 0 }}
                                            </span>
                                        </td>

                                        <td>
                                            {{ $influencer->created_at?->format('d M Y') ?? '—' }}
                                        </td>

                                        <td>

                                            <div class="action-buttons">

                                                <a href="{{ route('admin.influencers.show', $influencer) }}" class="action-btn">
                                                    View
                                                </a>

                                                <a href="{{ route('admin.influencers.edit', $influencer) }}" class="action-btn">
                                                    Edit
                                                </a>

                                                <form method="POST" action="{{ route('admin.influencers.destroy', $influencer) }}"
                                                    onsubmit="return confirm('Are you sure you want to delete this influencer? All their social activity records will also be deleted.')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="action-btn action-delete">
                                                        Delete
                                                    </button>
                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="empty-state">

                        <h3>No Influencers Created Yet</h3>

                        <p>
                            Create your first influencer account to allow them
                            to submit social media activities.
                        </p>

                        <a href="{{ route('admin.influencers.create') }}" class="btn btn-primary">
                            Create First Influencer
                        </a>

                    </div>

                @endif

            </div>

            @if($influencers->hasPages())
                <div class="pagination-wrap">
                    {{ $influencers->links() }}
                </div>
            @endif

        </div>

    </div>

@endsection