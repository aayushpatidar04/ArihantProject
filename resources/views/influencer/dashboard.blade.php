@extends('layouts.app')

@section('title', 'Influencer Dashboard — ArihantPLUS')

@push('styles')
<style>
    .influencer-dashboard {
        min-height: 100vh;
        padding: 80px 24px 60px;
        background: var(--bg);
    }

    .dashboard-container {
        max-width: 1100px;
        margin: 0 auto;
    }

    .dashboard-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 32px;
    }

    .dashboard-header h1 {
        font-size: 30px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .dashboard-header p {
        color: var(--muted);
        font-size: 14px;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn {
        border: 0;
        cursor: pointer;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: linear-gradient(
            160deg,
            rgba(22, 12, 30, 0.95),
            rgba(8, 4, 12, 0.98)
        );
        border: 1px solid rgba(255, 255, 255, 0.07);
        border-radius: 18px;
        padding: 22px;
    }

    .stat-label {
        color: var(--muted);
        font-size: 13px;
        margin-bottom: 10px;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        line-height: 1;
    }

    .score-card {
        background:
            linear-gradient(
                135deg,
                rgba(184, 102, 247, 0.18),
                rgba(22, 12, 30, 0.96)
            );
        border: 1px solid rgba(184, 102, 247, 0.25);
        border-radius: 20px;
        padding: 24px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .score-content h2 {
        font-size: 20px;
        margin-bottom: 6px;
    }

    .score-content p {
        color: var(--muted);
        font-size: 13px;
    }

    .score-number {
        min-width: 100px;
        height: 100px;
        border-radius: 50%;
        border: 2px solid rgba(184, 102, 247, 0.5);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: rgba(184, 102, 247, 0.08);
    }

    .score-number strong {
        font-size: 30px;
        line-height: 1;
    }

    .score-number span {
        color: var(--muted);
        font-size: 11px;
        margin-top: 5px;
    }

    .posts-section {
        background: linear-gradient(
            160deg,
            rgba(22, 12, 30, 0.95),
            rgba(8, 4, 12, 0.98)
        );
        border: 1px solid rgba(255, 255, 255, 0.07);
        border-radius: 20px;
        overflow: hidden;
    }

    .section-header {
        padding: 22px 24px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.07);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .section-header h2 {
        font-size: 19px;
        font-weight: 700;
    }

    .section-header p {
        color: var(--muted);
        font-size: 12px;
        margin-top: 4px;
    }

    .posts-table-wrapper {
        overflow-x: auto;
    }

    .posts-table {
        width: 100%;
        border-collapse: collapse;
    }

    .posts-table th {
        text-align: left;
        padding: 15px 20px;
        color: var(--muted);
        font-size: 12px;
        font-weight: 600;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        white-space: nowrap;
    }

    .posts-table td {
        padding: 16px 20px;
        font-size: 13px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        vertical-align: middle;
    }

    .posts-table tr:last-child td {
        border-bottom: 0;
    }

    .platform {
        font-weight: 600;
        text-transform: capitalize;
    }

    .post-type {
        color: var(--muted);
        text-transform: capitalize;
    }

    .post-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--purple-1);
        text-decoration: none;
        max-width: 250px;
    }

    .post-link:hover {
        text-decoration: underline;
    }

    .post-url {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 11px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .status-pending {
        background: rgba(255, 193, 7, 0.12);
        color: #ffd86b;
    }

    .status-approved {
        background: rgba(40, 180, 100, 0.13);
        color: #8ff0b3;
    }

    .status-rejected {
        background: rgba(255, 90, 90, 0.12);
        color: #ffaaaa;
    }

    .points {
        font-weight: 700;
    }

    .points-earned {
        color: #8ff0b3;
    }

    .points-zero {
        color: var(--muted);
    }

    .notes {
        color: var(--muted);
        font-size: 12px;
        max-width: 220px;
    }

    .empty-state {
        padding: 55px 25px;
        text-align: center;
    }

    .empty-icon {
        width: 58px;
        height: 58px;
        border-radius: 16px;
        margin: 0 auto 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(184, 102, 247, 0.1);
        color: var(--purple-1);
        font-size: 22px;
    }

    .empty-state h3 {
        font-size: 17px;
        margin-bottom: 7px;
    }

    .empty-state p {
        color: var(--muted);
        font-size: 13px;
    }

    .alert {
        padding: 12px 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 13px;
    }

    .alert-success {
        background: rgba(40, 180, 100, 0.12);
        border: 1px solid rgba(40, 180, 100, 0.2);
        color: #8ff0b3;
    }

    .alert-error {
        background: rgba(255, 90, 90, 0.12);
        border: 1px solid rgba(255, 90, 90, 0.2);
        color: #ffaaaa;
    }

    @media (max-width: 850px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .dashboard-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .header-actions {
            width: 100%;
        }

        .header-actions .btn {
            flex: 1;
        }
    }

    @media (max-width: 550px) {
        .influencer-dashboard {
            padding: 60px 15px 40px;
        }

        .stats-grid {
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .stat-card {
            padding: 17px;
        }

        .stat-value {
            font-size: 23px;
        }

        .score-card {
            flex-direction: column;
            text-align: center;
        }

        .section-header {
            padding: 18px;
        }

        .posts-table th,
        .posts-table td {
            padding: 13px 15px;
        }
    }
</style>
@endpush

@section('content')

<div class="influencer-dashboard">

    <div class="dashboard-container">

        {{-- Header --}}
        <div class="dashboard-header">

            <div>
                <h1>Welcome, {{ $user->name }}</h1>

                <p>
                    Manage your event posts and track your influencer score.
                </p>
            </div>

            <div class="header-actions">

                {{-- Change route if your submit-post route has another name --}}
                <a href="{{ route('influencer.posts.create') }}"
                   class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Submit Post
                </a>

                {{-- <form method="POST" action="{{ route('influencer.logout') }}">
                    @csrf

                    <button type="submit" class="btn btn-secondary">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </button>
                </form> --}}

            </div>

        </div>


        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif


        {{-- Statistics --}}
        <div class="stats-grid">

            <div class="stat-card">
                <div class="stat-label">
                    Total Posts
                </div>

                <div class="stat-value">
                    {{ $totalPosts }}
                </div>
            </div>


            <div class="stat-card">
                <div class="stat-label">
                    Approved
                </div>

                <div class="stat-value">
                    {{ $approvedPosts }}
                </div>
            </div>


            <div class="stat-card">
                <div class="stat-label">
                    Pending
                </div>

                <div class="stat-value">
                    {{ $pendingPosts }}
                </div>
            </div>


            <div class="stat-card">
                <div class="stat-label">
                    Rejected
                </div>

                <div class="stat-value">
                    {{ $rejectedPosts }}
                </div>
            </div>

        </div>


        {{-- Influencer Score --}}
        <div class="score-card">

            <div class="score-content">

                <h2>
                    Your Influencer Score
                </h2>

                <p>
                    Points earned from approved event posts.
                </p>

            </div>

            <div class="score-number">

                <strong>
                    {{ $totalScore }}
                </strong>

                <span>
                    POINTS
                </span>

            </div>

        </div>


        {{-- Posts --}}
        <div class="posts-section">

            <div class="section-header">

                <div>
                    <h2>
                        My Posts
                    </h2>

                    <p>
                        Track the approval status and points of your submitted posts.
                    </p>
                </div>

            </div>


            @if($posts->count())

                <div class="posts-table-wrapper">

                    <table class="posts-table">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Platform</th>
                                <th>Type</th>
                                <th>Post</th>
                                <th>Status</th>
                                <th>Points</th>
                                <th>Admin Notes</th>
                                <th>Submitted</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($posts as $index => $post)

                                <tr>

                                    <td>
                                        {{ $index + 1 }}
                                    </td>

                                    <td>
                                        <span class="platform">
                                            {{ $post->platform }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="post-type">
                                            {{ $post->post_type }}
                                        </span>
                                    </td>

                                    <td>

                                        <a href="{{ $post->post_url }}"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="post-link">

                                            <i class="fas fa-external-link-alt"></i>

                                            <span class="post-url">
                                                {{ $post->post_url }}
                                            </span>

                                        </a>

                                    </td>

                                    <td>

                                        @if($post->status === 'approved')

                                            <span class="status-badge status-approved">
                                                ✓ Approved
                                            </span>

                                        @elseif($post->status === 'rejected')

                                            <span class="status-badge status-rejected">
                                                ✕ Rejected
                                            </span>

                                        @else

                                            <span class="status-badge status-pending">
                                                ⏳ Pending
                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        @if($post->points_awarded > 0)

                                            <span class="points points-earned">
                                                +{{ $post->points_awarded }}
                                            </span>

                                        @else

                                            <span class="points points-zero">
                                                —
                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        @if($post->admin_notes)

                                            <span class="notes">
                                                {{ $post->admin_notes }}
                                            </span>

                                        @else

                                            <span class="notes">
                                                —
                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        <span class="notes">
                                            {{ $post->created_at?->format('d M Y, h:i A') }}
                                        </span>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="empty-state">

                    <div class="empty-icon">
                        <i class="fas fa-share-alt"></i>
                    </div>

                    <h3>
                        No posts submitted yet
                    </h3>

                    <p>
                        Submit your first event post to start earning influencer points.
                    </p>

                    <div style="margin-top: 18px;">

                        <a href="{{ route('influencer.posts.create') }}"
                           class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            Submit Your First Post
                        </a>

                    </div>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection