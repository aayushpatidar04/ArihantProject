@extends('layouts.app')

@section('title', 'Registration Confirmed — ArihantPLUS')

@push('styles')
    <style>
        .success-page {
            min-height: 100vh;
            padding: 80px 24px 60px;
            background: var(--bg);
            text-align: center
        }

        .success-card {
            max-width: 520px;
            margin: 0 auto;
            background: linear-gradient(165deg, #170b22 0%, #0b0511 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 26px;
            padding: 48px 36px
        }

        .success-icon {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: rgba(40, 180, 100, 0.15);
            border: 1px solid rgba(40, 180, 100, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px
        }

        .success-icon svg {
            width: 32px;
            height: 32px;
            stroke: #8ff0b3;
            stroke-width: 2.5
        }

        .success-card h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px
        }

        .success-card p {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 28px
        }

        .qr-box {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 18px;
            padding: 24px;
            margin-bottom: 24px
        }

        .qr-box img {
            width: 200px;
            height: 200px;
            margin: 0 auto;
            display: block;
            border-radius: 12px
        }

        .qr-box .reg-num {
            font-family: 'Sora', sans-serif;
            font-size: 14px;
            color: var(--purple-1);
            margin-top: 12px;
            font-weight: 600
        }

        .qr-label {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 12px;
            letter-spacing: 0.05em
        }

        .qr-label-entry {
            background: rgba(40, 180, 100, 0.15);
            color: #8ff0b3
        }

        .qr-label-checkout {
            background: rgba(184, 102, 247, 0.15);
            color: var(--purple-1)
        }

        .checked-in-banner {
            background: rgba(184, 102, 247, 0.1);
            border: 1px solid rgba(184, 102, 247, 0.3);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
            text-align: center
        }

        .checked-in-banner .checkin-time {
            font-size: 14px;
            color: var(--muted);
            margin-top: 4px
        }

        .checked-in-banner .checkin-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--purple-1)
        }

        .seat-info {
            font-size: 20px;
            font-weight: 800;
            color: #8ff0b3;
            margin-top: 4px
        }

        .action-btns {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap
        }

        .info-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            padding: 10px 18px;
            border-radius: 999px;
            font-size: 13px;
            color: var(--muted);
            margin: 4px
        }

        .client-note {
            background: rgba(40, 180, 100, 0.08);
            border: 1px solid rgba(40, 180, 100, 0.2);
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #8ff0b3
        }
    </style>
@endpush

@section('content')
    <div class="success-page">
        <div class="success-card">
            <div class="success-icon">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M20 6L9 17l-5-5" />
                </svg>
            </div>
            <h1>You're In!</h1>
            @if($reg->status === 'pending')
                <p>Download the app open an account and get this qr scanned at the stall for goodies</p>
                <div>
                    <div style="display: flex; justify-content: center; gap: 20px;">
                        <a href="https://play.google.com/store/apps/details?id=com.msf.acml&amp;pli=1"
                            target="_blank" rel="noopener noreferrer"><img
                                src="https://web.arihantplus.com/static/media/play-btn.3fad756f5dcba711ccc75cdb4d468e7d.svg"
                                alt=""></a>
                        <a href="https://apps.apple.com/us/app/arihant-plus/id1643484698" target="_blank"
                            rel="noopener noreferrer"><img
                                src="https://web.arihantplus.com/static/media/apple_store.2e89be31c3b804716f8490a9e68c02e5.svg"
                                alt=""></a>
                    </div>
                </div>
                <br>
            @endif
            <div class="qr-box">
                @if($reg->status === 'confirmed')
                    {{-- Checked In: Show Checkout QR --}}
                    <div class="checked-in-banner">
                        <div class="checkin-title">Goodies Collected </div>
                        <div class="checkin-time">Thank you for visiting us</div>
                    </div>
                @elseif(isset($qr) && $qr)
                    <div class="qr-label qr-label-entry">Goodies QR — Scan at venue for goodies</div>
                    <img src="{{ asset('storage/' . $qr->image_path) }}" alt="Goodies QR Code">
                    <div class="reg-num">{{ $reg->registration_number }}</div>
                @else
                    <p style="color:var(--muted)">QR code generating...</p>
                @endif
            </div>
        </div>
    </div>
@endsection