@extends('layouts.app')

@section('title', 'Stalls — ArihantPLUS')

@push('styles')
<style>
    .stall-page {
        min-height: 100vh;
        padding: 80px 24px 60px;
        background: var(--bg);
    }

    .stall-wrap {
        max-width: 1000px;
        margin: 0 auto;
    }

    .stall-header {
        text-align: center;
        max-width: 650px;
        margin: 0 auto 40px;
    }

    .stall-header h1 {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .stall-header p {
        color: var(--muted);
        margin: 0;
        font-size: 14px;
    }

    .scan-section {
        display: flex;
        justify-content: center;
        margin-bottom: 40px;
    }

    .scan-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        padding: 13px 22px;
        border-radius: 12px;
        border: 1px solid rgba(184, 102, 247, 0.35);
        background: rgba(184, 102, 247, 0.12);
        color: var(--purple-1);
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: .2s ease;
    }

    .scan-btn:hover {
        transform: translateY(-2px);
        background: rgba(184, 102, 247, 0.18);
        border-color: rgba(184, 102, 247, 0.55);
        color: var(--purple-1);
    }

    .stall-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 20px;
    }

    .stall-card {
        background: linear-gradient(
            160deg,
            rgba(22, 12, 30, 0.9) 0%,
            rgba(8, 4, 12, 0.96) 100%
        );
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 18px;
        padding: 28px;
        text-align: center;
        transition: transform .3s, border-color .3s;
    }

    .stall-card:hover {
        transform: translateY(-4px);
        border-color: rgba(184, 102, 247, 0.25);
    }

    .stall-card h3 {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .stall-card p {
        font-size: 13px;
        color: var(--muted);
        margin-bottom: 18px;
        line-height: 1.6;
    }

    .status {
        font-size: 12px;
        padding: 6px 14px;
        border-radius: 999px;
        display: inline-block;
    }

    .status-visited {
        background: rgba(40, 180, 100, 0.15);
        color: #8ff0b3;
    }

    .status-open {
        background: rgba(184, 102, 247, 0.15);
        color: var(--purple-1);
    }

    .stall-action {
        margin-top: 16px;
    }

    .stall-action a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 9px 15px;
        border-radius: 9px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #e9defa;
        background: rgba(255, 255, 255, 0.04);
        text-decoration: none;
        font-size: 12px;
        transition: .2s ease;
    }

    .stall-action a:hover {
        border-color: rgba(184, 102, 247, 0.55);
        background: rgba(184, 102, 247, 0.12);
    }

    @media (max-width: 640px) {
        .stall-page {
            padding: 50px 16px;
        }

        .stall-header h1 {
            font-size: 28px;
        }

        .scan-btn {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')

<div class="stall-page">

    <div class="stall-wrap">

        <div class="stall-header">
            <h1>Explore Stalls</h1>

            <p>
                Scan a stall QR code to visit the stall, participate in quizzes,
                submit feedback, and earn engagement points.
            </p>
        </div>

        {{-- Scan QR --}}
        <div class="scan-section">
            <a
                href="{{ route('stalls.scanner') }}"
                class="scan-btn"
            >
                <i class="fas fa-qrcode"></i>
                Scan Stall QR
            </a>
        </div>

        <div class="stall-grid">

            @foreach($stalls as $stall)

                <div class="stall-card">

                    <h3>{{ $stall->name }}</h3>

                    <p>
                        {{ $stall->description ?? 'Visit this stall to learn more and earn engagement points.' }}
                    </p>

                    @if(in_array($stall->id, $visitedIds))

                        <span class="status status-visited">
                            ✓ Visited
                        </span>

                        <div class="stall-action">
                            <a href="{{ route('stalls.show', $stall) }}">
                                View Stall
                            </a>
                        </div>

                    @else

                        <span class="status status-open">
                            Scan QR to Visit
                        </span>

                    @endif

                </div>

            @endforeach

        </div>

    </div>

</div>

@endsection