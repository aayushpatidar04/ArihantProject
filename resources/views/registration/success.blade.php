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
            <p>Your registration for ArihantPLUS AI & Algo Conclave is confirmed.</p>

            @if($reg->is_existing_client)
                <div class="client-note">✓ Registered as an existing Arihant client at special pricing.</div>
            @endif

            <div class="qr-box">
                @if($reg->status === 'checked_in')
                    {{-- Checked In: Show Checkout QR --}}
                    <div class="checked-in-banner">
                        <div class="checkin-title">Checked In</div>
                        <div class="checkin-time">Checked in at {{ $reg->checked_in_at->format('d M Y, h:i A') }}</div>
                    </div>
                    @if(isset($qr) && $qr)
                        <div class="qr-label qr-label-checkout">Checkout QR — Scan to exit</div>
                        <img src="{{ asset('storage/' . $qr->image_path) }}" alt="Checkout QR Code">
                        <div class="reg-num">{{ $reg->registration_number }}</div>
                    @else
                        <p style="color:var(--muted)">QR code generating...</p>
                    @endif
                @elseif(isset($qr) && $qr)
                    {{-- Paid but not checked in: Show Entry QR --}}
                    <div class="qr-label qr-label-entry">Entry QR — Scan at venue to check in</div>
                    <img src="{{ asset('storage/' . $qr->image_path) }}" alt="Entry QR Code">
                    <div class="reg-num">{{ $reg->registration_number }}</div>
                @else
                    <p style="color:var(--muted)">QR code generating...</p>
                @endif
            </div>

            <div style="margin-bottom:24px">
                <div class="info-pill">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="5" width="18" height="16" rx="2" />
                        <path d="M3 10h18M8 3v4M16 3v4" stroke-linecap="round" />
                    </svg>
                    5 Sept 2026
                </div>
                <div class="info-pill">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="9" />
                        <path d="M12 7v5l3.5 2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    10:00 AM - 5:00 PM
                </div>
                <div class="info-pill">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 11l18-7-7 18-2.5-7.5L3 11z" stroke-linejoin="round" />
                    </svg>
                    Mariott Hotel, Indore
                </div>
            </div>

            <div class="action-btns">
                <a href="{{ route('referral.index') }}" class="btn btn-ghost">Refer & Earn</a>
                <a href="{{ route('stalls.index') }}" class="btn btn-primary">Explore Stalls</a>
            </div>
        </div>
    </div>
@endsection