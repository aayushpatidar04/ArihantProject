@extends('layouts.app')

@section('title', 'Stalls — ArihantPLUS')

@push('styles')
<style>
    .stall-page{min-height:100vh;padding:80px 24px 60px;background:var(--bg)}
    .stall-grid{max-width:900px;margin:0 auto;display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:20px}
    .stall-card{background:linear-gradient(160deg,rgba(22,12,30,0.9) 0%,rgba(8,4,12,0.96) 100%);border:1px solid rgba(255,255,255,0.05);border-radius:18px;padding:28px;text-align:center;transition:transform .3s}
    .stall-card:hover{transform:translateY(-4px)}
    .stall-card h3{font-size:18px;font-weight:700;margin-bottom:6px}
    .stall-card p{font-size:13px;color:var(--muted);margin-bottom:16px}
    .stall-card .status{font-size:12px;padding:6px 14px;border-radius:999px;display:inline-block}
    .status-visited{background:rgba(40,180,100,0.15);color:#8ff0b3}
    .status-open{background:rgba(184,102,247,0.15);color:var(--purple-1)}
    .stall-header{text-align:center;max-width:600px;margin:0 auto 40px}
    .stall-header h1{font-size:32px;font-weight:700}
    .stall-header p{color:var(--muted);margin-top:8px}
</style>
@endpush

@section('content')
<div class="stall-page">
    <div class="stall-header">
        <h1>Explore Stalls</h1>
        <p>Visit stalls, participate in quizzes, and earn engagement points.</p>
    </div>
    <div class="stall-grid">
        @foreach($stalls as $stall)
        <div class="stall-card">
            <h3>{{ $stall->name }}</h3>
            <p>{{ $stall->description ?? 'Visit this stall to learn more and earn points.' }}</p>
            @if(in_array($stall->id, $visitedIds))
                <span class="status status-visited">✓ Visited</span>
            @else
                <span class="status status-open">Scan QR to Check-in</span>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endsection
