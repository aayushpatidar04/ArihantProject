@extends('layouts.app')

@section('title', 'Refer & Earn — ArihantPLUS')

@push('styles')
<style>
    .ref-page{min-height:100vh;padding:80px 24px 60px;background:var(--bg)}
    .ref-card{max-width:640px;margin:0 auto;background:linear-gradient(165deg,#170b22 0%,#0b0511 100%);border:1px solid rgba(255,255,255,0.08);border-radius:26px;padding:42px 36px}
    .ref-card h1{font-size:26px;font-weight:700;margin-bottom:8px}
    .ref-card p{color:var(--muted);font-size:14px;margin-bottom:28px}
    .code-box{background:rgba(255,255,255,0.04);border:1px dashed rgba(184,102,247,0.4);border-radius:14px;padding:20px;text-align:center;margin-bottom:28px}
    .code-box .code{font-family:'Sora',sans-serif;font-size:24px;font-weight:700;color:var(--purple-1);letter-spacing:2px}
    .code-box .copy-btn{margin-top:12px;padding:8px 18px;border-radius:999px;background:rgba(184,102,247,0.15);border:1px solid rgba(184,102,247,0.3);color:var(--purple-1);font-size:13px;cursor:pointer}
    .leaderboard{background:rgba(255,255,255,0.02);border-radius:16px;padding:20px;margin-top:24px}
    .leaderboard h3{font-size:16px;margin-bottom:16px}
    .lb-row{display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid rgba(255,255,255,0.05)}
    .lb-row .rank{width:28px;height:28px;border-radius:50%;background:rgba(255,255,255,0.06);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700}
    .lb-row .name{flex:1;padding-left:12px;font-size:14px}
    .lb-row .pts{font-weight:700;color:var(--purple-1)}
    .invite-form{display:flex;gap:10px;margin-bottom:24px}
    .invite-form input{flex:1;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:12px 14px;color:#fff;font-size:14px;outline:none}
    @media(max-width:600px){.ref-card{padding:28px 22px}.invite-form{flex-direction:column}}
</style>
@endpush

@section('content')
<div class="ref-page">
    <div class="ref-card">
        <h1>Invite & Earn</h1>
        <p>Share your unique code. Earn 50 points for every friend who registers and pays.</p>

        <div class="code-box">
            <div class="code">{{ $reg->referral_code }}</div>
            <button class="copy-btn" onclick="navigator.clipboard.writeText('{{ route('registration.form', ['ref' => $reg->referral_code]) }}');alert('Link copied!')">Copy Referral Link</button>
        </div>

        <form class="invite-form" action="{{ route('referral.invite') }}" method="POST">
            @csrf
            <input type="text" name="name" placeholder="Friend's Name" required>
            <input type="email" name="email" placeholder="Friend's Email" required>
            <button type="submit" class="btn btn-primary">Invite</button>
        </form>

        <div style="margin-bottom:24px">
            <h3 style="font-size:16px;margin-bottom:12px">Your Stats</h3>
            <div style="display:flex;gap:24px">
                <div><div style="font-size:24px;font-weight:800;color:var(--purple-1)">{{ $referrals->count() }}</div><div style="font-size:12px;color:var(--muted)">Invited</div></div>
                <div><div style="font-size:24px;font-weight:800;color:var(--purple-1)">{{ $referrals->where('status','paid')->count() }}</div><div style="font-size:12px;color:var(--muted)">Converted</div></div>
                <div><div style="font-size:24px;font-weight:800;color:var(--purple-1)">{{ $totalPoints }}</div><div style="font-size:12px;color:var(--muted)">Points</div></div>
            </div>
        </div>

        <div class="leaderboard">
            <h3>🏆 Top 10 Leaderboard</h3>
            @foreach($leaderboard as $idx => $l)
            <div class="lb-row">
                <div class="rank">{{ $idx+1 }}</div>
                <div class="name">{{ $l->full_name }}</div>
                <div class="pts">{{ $l->total_points ?? 0 }} pts</div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
