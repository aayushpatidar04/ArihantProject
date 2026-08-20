@extends('layouts.app')

@section('title', 'Payment — ArihantPLUS')

@push('styles')
<style>
    .pay-page{min-height:100vh;padding:80px 24px 60px;background:var(--bg);text-align:center}
    .pay-card{max-width:480px;margin:0 auto;background:linear-gradient(165deg,#170b22 0%,#0b0511 100%);border:1px solid rgba(255,255,255,0.08);border-radius:26px;padding:48px 36px}
    .pay-card h1{font-size:26px;font-weight:700;margin-bottom:12px}
    .pay-card .amount{font-size:48px;font-weight:800;color:var(--purple-1);margin:16px 0}
    .pay-card .amount span{font-size:18px;color:var(--muted);font-weight:400}
    .pay-card .detail{color:var(--muted);font-size:14px;margin-bottom:32px}
    .secure-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);padding:10px 18px;border-radius:999px;font-size:13px;color:var(--muted);margin-bottom:24px}
    .client-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(40,180,100,0.12);border:1px solid rgba(40,180,100,0.3);color:#8ff0b3;padding:6px 14px;border-radius:999px;font-size:12px;font-weight:600;margin-bottom:16px}
</style>
@endpush

@section('content')
<div class="pay-page">
    <div class="pay-card">
        @if($reg->is_existing_client)
            <div class="client-badge">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                Client Special Price
            </div>
        @endif
        <h1>Complete Payment</h1>
        <div class="amount">₹{{ $reg->is_existing_client ? '299' : '999' }}</div>
        <div class="detail">
            {{ $reg->is_existing_client ? 'Existing Client Rate' : 'Standard Registration' }}<br>
            {{ $reg->full_name }} • {{ $reg->email }}
        </div>
        <div class="secure-badge">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
            Secure Payment via Razorpay
        </div>
        <button id="payBtn" class="btn btn-primary" style="width:100%">Pay Now</button>
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
const options = {
    key: '{{ config("services.payment.key_id") }}',
    amount: {{ $reg->is_existing_client ? '29900' : '99900' }},
    currency: 'INR',
    name: 'ArihantPLUS Conclave',
    description: 'AI & Algo Conclave 2026 Registration',
    image: '{{ asset("assets/images/logo.png") }}',
    order_id: '{{ $order["id"] ?? "" }}',
    handler: function (response) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("payment.callback") }}';
        form.innerHTML = `
            @csrf
            <input type="hidden" name="razorpay_payment_id" value="${response.razorpay_payment_id}">
            <input type="hidden" name="razorpay_order_id" value="${response.razorpay_order_id}">
            <input type="hidden" name="razorpay_signature" value="${response.razorpay_signature}">
        `;
        document.body.appendChild(form);
        form.submit();
    },
    prefill: {
        name: '{{ $reg->full_name }}',
        email: '{{ $reg->email }}',
        contact: '{{ $reg->phone }}'
    },
    theme: { color: '#8b2fd9' }
};
document.getElementById('payBtn').onclick = function() {
    const rzp = new Razorpay(options);
    rzp.open();
};
</script>
@endsection
