@extends('layouts.app')

@section('title', $user->name . ' — Influencer')

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
            gap: 10px;
            align-items: center;
        }

        .back-link {
            color: var(--purple-1);
            font-size: 14px;
            text-decoration: none;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: linear-gradient(160deg,
                    rgba(22, 12, 30, 0.9),
                    rgba(8, 4, 12, 0.96));
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 16px;
            padding: 20px;
        }

        .stat-label {
            color: var(--muted);
            font-size: 12px;
            margin-bottom: 8px;
        }

        .stat-value {
            color: var(--ink);
            font-size: 26px;
            font-weight: 700;
        }

        .points {
            color: #d9a7ff;
        }

        .admin-card {
            background: linear-gradient(160deg,
                    rgba(22, 12, 30, 0.9),
                    rgba(8, 4, 12, 0.96));
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 20px;
            overflow: hidden;
        }

        .card-header {
            padding: 20px 22px;
            border-bottom: 1px solid rgba(255, 255, 255, .06);
        }

        .card-header h2 {
            margin: 0;
            font-size: 17px;
        }

        .influencer-info {
            padding: 22px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .info-label {
            display: block;
            color: var(--muted);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .6px;
            margin-bottom: 5px;
        }

        .info-value {
            color: var(--ink);
            font-size: 14px;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 900px;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 15px 18px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, .06);
            vertical-align: middle;
        }

        th {
            color: var(--muted);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .7px;
            background: rgba(255, 255, 255, .018);
        }

        td {
            color: #ded7e6;
            font-size: 13px;
        }

        .post-url {
            color: var(--purple-1);
            text-decoration: none;
        }

        .post-url:hover {
            text-decoration: underline;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
        }

        .badge-pending {
            background: rgba(255, 180, 70, .1);
            color: #ffd08a;
            border: 1px solid rgba(255, 180, 70, .2);
        }

        .badge-approved {
            background: rgba(40, 180, 100, .12);
            color: #8ff0b3;
            border: 1px solid rgba(40, 180, 100, .22);
        }

        .badge-rejected {
            background: rgba(255, 80, 80, .1);
            color: #ffaaaa;
            border: 1px solid rgba(255, 80, 80, .2);
        }

        .empty-state {
            text-align: center;
            padding: 55px 20px;
            color: var(--muted);
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 11px;
            border-radius: 9px;
            border: 1px solid rgba(255, 255, 255, .1);
            background: rgba(255, 255, 255, .04);
            color: #e9defa;
            font-size: 12px;
            text-decoration: none;
        }

        .action-btn:hover {
            border-color: rgba(184, 102, 247, .55);
            background: rgba(184, 102, 247, .12);
            color: #fff;
        }

        @media (max-width: 900px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 650px) {
            .admin-page {
                padding: 28px 16px 50px;
            }

            .admin-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .header-actions {
                width: 100%;
            }

            .header-actions .btn {
                flex: 1;
            }

            .influencer-info {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        .post-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .post-action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 11px;
            border-radius: 9px;
            border: 1px solid rgba(255, 255, 255, .1);
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: .2s ease;
        }

        .post-action-approve {
            background: rgba(40, 180, 100, .10);
            color: #8ff0b3;
            border-color: rgba(40, 180, 100, .22);
        }

        .post-action-approve:hover {
            background: rgba(40, 180, 100, .18);
            border-color: rgba(40, 180, 100, .4);
        }

        .post-action-reject {
            background: rgba(255, 80, 80, .08);
            color: #ffaaaa;
            border-color: rgba(255, 80, 80, .2);
        }

        .post-action-reject:hover {
            background: rgba(255, 80, 80, .15);
            border-color: rgba(255, 80, 80, .4);
        }

        .post-action-disabled {
            color: var(--muted);
            font-size: 12px;
        }
    </style>
@endpush

@section('content')

    <div class="admin-page">

        <div class="admin-wrap">

            <div class="admin-header">

                <div>
                    <h1>{{ $user->name }}</h1>

                    <p>
                        Influencer account and social activity details.
                    </p>
                </div>

                <div class="header-actions">

                    <a href="{{ route('admin.influencers.edit', $user) }}" class="btn btn-primary">
                        Edit
                    </a>

                    <a href="{{ route('admin.influencers.index') }}" class="back-link">
                        ← Back
                    </a>

                </div>

            </div>

            <div class="stats-grid">

                <div class="stat-card">
                    <div class="stat-label">
                        Total Posts
                    </div>

                    <div class="stat-value">
                        {{ $stats['total_posts'] }}
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">
                        Approved
                    </div>

                    <div class="stat-value">
                        {{ $stats['approved_posts'] }}
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">
                        Pending
                    </div>

                    <div class="stat-value">
                        {{ $stats['pending_posts'] }}
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">
                        Total Points
                    </div>

                    <div class="stat-value points">
                        {{ $stats['total_points'] }}
                    </div>
                </div>

            </div>

            <div class="admin-card" style="margin-bottom:24px;">

                <div class="card-header">
                    <h2>Influencer Information</h2>
                </div>

                <div class="influencer-info">

                    <div>
                        <span class="info-label">
                            Name
                        </span>

                        <span class="info-value">
                            {{ $user->name }}
                        </span>
                    </div>

                    <div>
                        <span class="info-label">
                            Email
                        </span>

                        <span class="info-value">
                            {{ $user->email }}
                        </span>
                    </div>

                    <div>
                        <span class="info-label">
                            Account Type
                        </span>

                        <span class="info-value">
                            Influencer
                        </span>
                    </div>

                    <div>
                        <span class="info-label">
                            Created
                        </span>

                        <span class="info-value">
                            {{ $user->created_at?->format('d M Y, h:i A') ?? '—' }}
                        </span>
                    </div>

                </div>

            </div>

            <div class="admin-card">

                <div class="card-header">
                    <h2>Social Activity</h2>
                </div>

                @if($user->influencerPosts->count())

                    <div class="table-wrap">

                        <table>

                            <thead>

                                <tr>
                                    <th>Platform</th>
                                    <th>Type</th>
                                    <th>Post</th>
                                    <th>Status</th>
                                    <th>Points</th>
                                    <th>Submitted</th>
                                    <th>Actions</th>
                                </tr>

                            </thead>

                            <tbody>

                                @foreach($user->influencerPosts as $post)

                                    <tr>

                                        <td>
                                            {{ ucfirst($post->platform) }}
                                        </td>

                                        <td>
                                            {{ ucfirst($post->post_type) }}
                                        </td>

                                        <td>
                                            <a href="{{ $post->post_url }}" target="_blank" rel="noopener noreferrer"
                                                class="post-url">
                                                View Post ↗
                                            </a>
                                        </td>

                                        <td>

                                            @if($post->status === 'approved')

                                                <span class="badge badge-approved">
                                                    Approved
                                                </span>

                                            @elseif($post->status === 'rejected')

                                                <span class="badge badge-rejected">
                                                    Rejected
                                                </span>

                                            @else

                                                <span class="badge badge-pending">
                                                    Pending
                                                </span>

                                            @endif

                                        </td>

                                        <td>
                                            <strong>
                                                {{ $post->points_awarded }}
                                            </strong>
                                        </td>

                                        <td>
                                            {{ $post->created_at?->format('d M Y, h:i A') ?? '—' }}
                                        </td>

                                        <td>
                                            <div class="post-actions">

                                                {{-- APPROVE --}}
                                                @if($post->status !== 'approved')
                                                    <form method="POST" action="{{ route('admin.influencers.posts.approve', $post) }}"
                                                        onsubmit="return confirm('Approve this post and award 20 points?');">
                                                        @csrf

                                                        <button type="submit" class="post-action-btn post-action-approve">
                                                            <i class="fas fa-check"></i>
                                                            Approve
                                                        </button>
                                                    </form>
                                                @endif

                                                {{-- REJECT --}}
                                                @if($post->status !== 'rejected')
                                                    <form method="POST" action="{{ route('admin.influencers.posts.reject', $post) }}"
                                                        onsubmit="return rejectInfluencerPost(this);">
                                                        @csrf

                                                        <input type="hidden" name="reason" value="">

                                                        <button type="submit" class="post-action-btn post-action-reject">
                                                            <i class="fas fa-times"></i>
                                                            Reject
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($post->status === 'approved')
                                                    <span class="post-action-disabled">
                                                        Approved
                                                    </span>
                                                @elseif($post->status === 'rejected')
                                                    <span class="post-action-disabled">
                                                        Rejected
                                                    </span>
                                                @endif

                                            </div>
                                        </td>


                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="empty-state">
                        No social activities submitted yet.
                    </div>

                @endif

            </div>

        </div>

    </div>

    <script> 
        function rejectInfluencerPost(form) { 
            const reason = prompt('Enter rejection reason (optional):'); // User clicked Cancel 
            if (reason === null) { return false; } 
            form.querySelector('input[name="reason"]').value = reason; 
            return confirm( 'Are you sure you want to reject this post?' ); 
        } 
    </script>

@endsection