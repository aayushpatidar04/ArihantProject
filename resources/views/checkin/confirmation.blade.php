<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Seat — ArihantPLUS</title>
    <style>
        body{background:#060208;color:#f6f3fa;font-family:'Inter',sans-serif;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;text-align:center;padding:24px}
        .card{background:linear-gradient(165deg,#170b22 0%,#0b0511 100%);border:1px solid rgba(255,255,255,0.08);border-radius:26px;padding:48px 36px;max-width:400px;width:100%}
        h1{font-size:24px;font-weight:700;margin-bottom:8px}
        p{color:#a79bb5;font-size:14px;margin-bottom:24px}
        .seat{font-size:56px;font-weight:800;color:#b866f7;margin:16px 0}
        .detail{color:#7c7188;font-size:13px;margin-top:8px}
        .logo{height:32px;margin-bottom:24px}
    </style>
</head>
<body>
    <div class="card">
        <img src="{{ asset('assets/images/logo-2.png') }}" alt="ArihantPLUS" class="logo">
        <h1>Welcome, {{ $reg->full_name }}!</h1>
        <p>You are Checked In successfully!.</p>
        {{-- @if($seat)
        <div class="seat">{{ $seat->seat_number }}</div>
        <div class="detail">Section: {{ $seat->section }} | Row: {{ $seat->row }}</div>
        @else
        <p style="color:#ff9e9e">Seat allocation pending. Please contact venue staff.</p>
        @endif --}}
        <div class="detail" style="margin-top:24px">ArihantPLUS AI & Algo Conclave 2026</div>
    </div>
</body>
</html>
