@extends('layouts.app')

@section('title', 'Payment — ArihantPLUS')

@push('styles')
<style>
    .pay-page{min-height:100vh;padding:80px 24px 60px;background:var(--bg);text-align:center}
    .pay-card{max-width:480px;margin:0 auto;background:linear-gradient(165deg,#170b22 0%,#0b0511 100%);border:1px solid rgba(255,255,255,0.08);border-radius:26px;padding:48px 36px}
    .pay-card h1{font-size:26px;font-weight:700;margin-bottom:12px}
    .pay-card .amount{font-size:48px;font-weight:800;color:var(--purple-1);margin:16px 0}
    .pay-card .detail{color:var(--muted);font-size:14px;margin-bottom:32px}
    .secure-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);padding:10px 18px;border-radius:999px;font-size:13px;color:var(--muted);margin-bottom:24px}
    .client-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(40,180,100,0.12);border:1px solid rgba(40,180,100,0.3);color:#8ff0b3;padding:6px 14px;border-radius:999px;font-size:12px;font-weight:600;margin-bottom:16px}
    .debug-info{background:rgba(255,200,0,0.08);border:1px solid rgba(255,200,0,0.3);border-radius:10px;padding:12px;margin-bottom:20px;font-size:11px;color:#ffd700;text-align:left;font-family:monospace}
</style>
@endpush

@section('content')
<div class="pay-page">
    <div class="pay-card">
        @if($reg->is_existing_client)
            <div class="client-badge">✓ Client Special Price</div>
        @endif
        <h1>Complete Payment</h1>
        <div class="amount">₹{{ $reg->is_existing_client ? '299' : '999' }}</div>
        <div class="detail">
            {{ $reg->is_existing_client ? 'Existing Client Rate' : 'Standard Registration' }}<br>
            {{ $reg->full_name }} • {{ $reg->email }}
        </div>
        <div class="secure-badge">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
            Secure Payment via Atom / NTT DATA PAY
        </div>

        {{-- @if(app()->environment('local'))
        <div class="debug-info">
            <strong>Debug:</strong><br>
            token: {{ $order['atomTokenId'] ?? 'MISSING' }}<br>
            returnUrl: {{ $order['returnUrl'] ?? 'MISSING' }}<br>
            env: {{ $order['env'] ?? 'prod' }}
        </div>
        @endif --}}

        <button id="payBtn" class="btn btn-primary" style="width:100%">Pay Now</button>
        <div id="atomError" style="color:#ff6b6b;font-size:13px;margin-top:16px;display:none"></div>
    </div>
</div>

<script src="{{ config('services.atom.js_cdn') }}"></script>
<script>
document.getElementById('payBtn').onclick = function() {
    const atomTokenId = '{{ $order["atomTokenId"] ?? "" }}';
    const merchId     = '{{ $order["merchId"] ?? "" }}';
    const custEmail   = '{{ $order["custEmail"] ?? "" }}';
    const custMobile  = '{{ $order["custMobile"] ?? "" }}';
    const returnUrl   = '{{ $order["returnUrl"] ?? "" }}';
    const env         = '{{ $order["env"] ?? "uat" }}';

    if (!atomTokenId) {
        document.getElementById('atomError').textContent = 'Payment token missing. Please refresh.';
        document.getElementById('atomError').style.display = 'block';
        return;
    }

    console.log('AtomPaynetz init:', { atomTokenId, merchId, custEmail, custMobile, returnUrl, env });

    try {
        const atom = new AtomPaynetz({
            atomTokenId: String(atomTokenId), // force string
            merchId:     String(merchId),
            custEmail:   custEmail,
            custMobile:  custMobile,
            returnUrl:   returnUrl
        }, env);

        // Some versions of Atom SDK expose this
        if (atom && atom.onError) {
            atom.onError = function(err) {
                console.error('Atom checkout error:', err);
                document.getElementById('atomError').textContent =
                    'Payment gateway error: ' + (err.message || JSON.stringify(err));
                document.getElementById('atomError').style.display = 'block';
            };
        }
    } catch (e) {
        console.error('AtomPaynetz exception:', e);
        document.getElementById('atomError').textContent =
            'Failed to load payment gateway. Please try again.';
        document.getElementById('atomError').style.display = 'block';
    }
};
</script>
@endsection