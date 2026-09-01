@extends('layouts.app')

@section('title', 'My Posts — ArihantPLUS')

@push('styles')
    <style>
        .influencer-page {
            min-height: 100vh;
            padding: 40px 24px 70px;
            background: var(--bg-soft);
        }

        .influencer-wrap {
            max-width: 1100px;
            margin: 0 auto;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 28px;
        }

        .page-header h1 {
            font-size: 30px;
            margin-bottom: 6px;
        }

        .page-header p {
            color: var(--muted);
            font-size: 14px;
        }

        .posts-card {
            background: linear-gradient(160deg,
                    rgba(22, 12, 30, .9),
                    rgba(8, 4, 12, .96));
            border: 1px solid rgba(255, 255, 255, .07);
            border-radius: 20px;
            overflow: hidden;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 800px;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 16px 18px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, .06);
            vertical-align: middle;
        }

        th {
            color: var(--muted);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .7px;
        }

        td {
            color: #ded7e6;
            font-size: 13px;
        }

        .post-url {
            max-width: 320px;
            word-break: break-all;
        }

        .post-url a {
            color: var(--purple-1);
        }

        .badge {
            display: inline-flex;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
        }

        .badge-pending {
            background: rgba(255, 180, 70, .1);
            color: #ffd08a;
        }

        .badge-approved {
            background: rgba(40, 180, 100, .12);
            color: #8ff0b3;
        }

        .badge-rejected {
            background: rgba(255, 80, 80, .1);
            color: #ffaaaa;
        }

        .notes {
            color: #ffaaaa;
            font-size: 12px;
            max-width: 250px;
        }

        @media(max-width:640px) {
            .influencer-page {
                padding: 28px 16px 50px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
@endpush

@section('content')

    <div class="influencer-page">

        <div class="influencer-wrap">

            <div class="page-header">

                <div>

                    <h1>My Posts</h1>

                    <p>
                        Track the approval status and points for your submitted posts.
                    </p>

                </div>

                <a href="{{ route('influencer.posts.create') }}" class="btn btn-primary">
                    + Submit Post
                </a>

            </div>

            <div class="posts-card">

                <div class="table-wrap">

                    <table>

                        <thead>
                            <tr>
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

                            @forelse($posts as $post)

                                <tr>

                                    <td>
                                        {{ ucfirst($post->platform) }}
                                    </td>

                                    <td>
                                        {{ ucfirst($post->post_type) }}
                                    </td>

                                    <td class="post-url">

                                        <a href="{{ $post->post_url }}" target="_blank" rel="noopener noreferrer">
                                            View Post
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
                                        {{ $post->points_awarded }}
                                    </td>

                                    <td>

                                        @if($post->admin_notes)

                                            <div class="notes">
                                                {{ $post->admin_notes }}
                                            </div>

                                        @else

                                            —

                                        @endif

                                    </td>

                                    <td>
                                        {{ $post->created_at?->format('d M Y') }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="7" style="text-align:center;padding:60px 20px;">
                                        No posts submitted yet.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            @if($posts->hasPages())

                <div style="margin-top:24px;">
                    {{ $posts->links() }}
                </div>

            @endif

        </div>

    </div>

@endsection