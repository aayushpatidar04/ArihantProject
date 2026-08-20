@extends('layouts.app')

@section('title', 'Influencer Activity — ArihantPLUS')

@push('styles')
<style>
    .inf-page{min-height:100vh;padding:80px 24px 60px;background:var(--bg)}
    .inf-card{max-width:600px;margin:0 auto;background:linear-gradient(165deg,#170b22 0%,#0b0511 100%);border:1px solid rgba(255,255,255,0.08);border-radius:26px;padding:42px 36px}
    .inf-card h1{font-size:26px;font-weight:700;margin-bottom:8px}
    .inf-card p{color:var(--muted);font-size:14px;margin-bottom:28px}
    .post-list{margin-top:24px}
    .post-item{background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:14px;padding:16px;margin-bottom:12px}
    .post-item .platform{font-size:12px;color:var(--purple-1);font-weight:600;text-transform:uppercase}
    .post-item .url{font-size:13px;color:var(--muted);margin-top:4px;word-break:break-all}
    .post-item .status{font-size:11px;padding:4px 10px;border-radius:999px;display:inline-block;margin-top:8px}
    .status-pending{background:rgba(255,180,0,0.15);color:#ffd700}
    .status-approved{background:rgba(40,180,100,0.15);color:#8ff0b3}
    .status-rejected{background:rgba(220,60,60,0.15);color:#ff9e9e}
    @media(max-width:600px){.inf-card{padding:28px 22px}}
</style>
@endpush

@section('content')
<div class="inf-page">
    <div class="inf-card">
        <h1>Submit Your Post</h1>
        <p>Create a post/reel tagging @ArihantCapital and submit the URL. Earn 20 points per approved post.</p>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('influencer.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Platform</label>
                <select name="platform" required style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:14px;padding:14px 16px;color:#fff;font-size:14px;outline:none">
                    <option value="instagram">Instagram</option>
                    <option value="meta">Meta / Facebook</option>
                    <option value="x">X / Twitter</option>
                    <option value="youtube">YouTube</option>
                </select>
            </div>
            <div class="form-group">
                <label>Post Type</label>
                <select name="post_type" required style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:14px;padding:14px 16px;color:#fff;font-size:14px;outline:none">
                    <option value="reel">Reel</option>
                    <option value="post">Post</option>
                    <option value="story">Story</option>
                    <option value="video">Video</option>
                </select>
            </div>
            <div class="form-group">
                <label>Post URL</label>
                <input type="url" name="post_url" placeholder="https://instagram.com/p/..." required style="width:100%;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:14px;padding:14px 16px;color:#fff;font-size:14px;outline:none">
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%">Submit for Verification</button>
        </form>

        <div class="post-list">
            <h3 style="font-size:16px;margin-bottom:16px">Your Submissions</h3>
            @forelse($posts as $p)
            <div class="post-item">
                <div class="platform">{{ ucfirst($p->platform) }} • {{ ucfirst($p->post_type) }}</div>
                <div class="url">{{ $p->post_url }}</div>
                <span class="status status-{{ $p->status }}">{{ ucfirst($p->status) }} {{ $p->points_awarded ? '('.$p->points_awarded.' pts)' : '' }}</span>
            </div>
            @empty
            <p style="color:var(--muted);font-size:14px">No submissions yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
