@extends('layouts.app')

@section('title', 'Thank You — ArihantPLUS')

@push('styles')
<style>
    .thanks-page {
        min-height: 100vh;
        padding: 100px 24px 60px;
        background: var(--bg);
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .thanks-card {
        max-width: 480px;
        width: 100%;
        background: linear-gradient(165deg, #170b22 0%, #0b0511 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 26px;
        padding: 56px 40px;
    }

    .thanks-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 24px;
        background: rgba(40, 180, 100, 0.12);
        border: 1px solid rgba(40, 180, 100, 0.25);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .thanks-icon svg {
        width: 36px;
        height: 36px;
        color: #8ff0b3;
    }

    .thanks-card h1 {
        font-family: 'Sora', sans-serif;
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .thanks-card p {
        color: var(--muted);
        font-size: 14px;
        line-height: 1.65;
        margin-bottom: 32px;
    }

    .thanks-details {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 14px;
        padding: 18px 20px;
        margin-bottom: 28px;
        text-align: left;
    }

    .thanks-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        font-size: 13px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
    }

    .thanks-row:last-child {
        border-bottom: none;
    }

    .thanks-row .lbl {
        color: var(--muted-2);
    }

    .thanks-row .val {
        color: #f6f3fa;
        font-weight: 600;
    }

    .btn-success {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        width: 100%;
        justify-content: center;
        padding: 14px 24px;
        background: var(--btn-grad);
        color: #fff;
        font-family: 'Inter', sans-serif;
        font-size: 15px;
        font-weight: 700;
        text-decoration: none;
        border-radius: 14px;
        box-shadow: 0 8px 24px rgba(160, 40, 200, 0.45);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 32px rgba(190, 50, 230, 0.6);
    }

    .btn-success svg {
        width: 18px;
        height: 18px;
    }

    @media (max-width: 480px) {
        .thanks-card {
            padding: 40px 24px;
        }
    }
</style>
@endpush

@section('content')
    <div class="thanks-page">
        <div class="thanks-card">
            <div class="thanks-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>

            <h1>Payment Successful!</h1>
            <p>Thank you for registering for ArihantPLUS AI & Algo Conclave 2026. Your registration is confirmed.</p>

            <div class="thanks-details">
                <div class="thanks-row">
                    <span class="lbl">Registration #</span>
                    <span class="val">{{ $reg->registration_number }}</span>
                </div>
                <div class="thanks-row">
                    <span class="lbl">Name</span>
                    <span class="val">{{ $reg->full_name }}</span>
                </div>
                <div class="thanks-row">
                    <span class="lbl">Amount Paid</span>
                    <span class="val">₹{{ $reg->is_existing_client ? '399' : '599' }}</span>
                </div>
                <div class="thanks-row">
                    <span class="lbl">Status</span>
                    <span class="val" style="color:#8ff0b3">Confirmed</span>
                </div>
            </div>

            <a href="{{ route('registration.success') }}" class="btn-success">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="16" rx="2"/>
                    <path d="M16 2v4M8 2v4M3 10h18"/>
                </svg>
                View My Ticket
            </a>
        </div>
    </div>
@endsection