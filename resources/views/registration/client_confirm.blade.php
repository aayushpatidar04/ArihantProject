@extends('layouts.app')

@section('title', 'Confirm Details — ArihantPLUS')

@push('styles')
<style>
    .reg-page{min-height:100vh;padding:80px 24px 60px;background:var(--bg)}
    .reg-card{max-width:520px;margin:0 auto;background:linear-gradient(165deg,#170b22 0%,#0b0511 100%);border:1px solid rgba(255,255,255,0.08);border-radius:26px;padding:42px 36px}
    .reg-card h1{font-size:26px;font-weight:700;margin-bottom:8px}
    .reg-card .subtitle{color:var(--muted);font-size:14px;margin-bottom:28px}
    .client-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(40,180,100,0.12);border:1px solid rgba(40,180,100,0.3);color:#8ff0b3;padding:8px 16px;border-radius:999px;font-size:13px;font-weight:600;margin-bottom:24px}
    .form-group{margin-bottom:20px}
    .form-group label{display:block;font-size:13px;font-weight:600;margin-bottom:8px;color:#e9e4f0}
    .form-group input,
    .form-group select{width:100%;background:rgba(255,255,255,0.055);border:1px solid rgba(255,255,255,0.1);border-radius:14px;padding:14px 16px;color:var(--ink);font-size:14px;font-family:'Inter',sans-serif;outline:none;transition:border-color .2s}
    .form-group input:focus,
    .form-group select:focus{border-color:rgba(184,102,247,0.55)}
    .form-group input[readonly]{opacity:0.6;cursor:not-allowed}
    .form-group select option{background:#1a0f24;color:#fff}
    .price-box{background:rgba(40,180,100,0.08);border:1px solid rgba(40,180,100,0.2);border-radius:14px;padding:20px;text-align:center;margin:24px 0}
    .price-box .price{font-size:36px;font-weight:800;color:#8ff0b3}
    .price-box .price span{font-size:16px;color:var(--muted);font-weight:400;text-decoration:line-through;margin-left:8px}
    .price-box .lbl{font-size:13px;color:var(--muted);margin-top:4px}
    @media(max-width:480px){.reg-card{padding:28px 22px}}
</style>
@endpush

@section('content')
<div class="reg-page">
    <div class="reg-card">
        <div class="client-badge">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
            Existing Arihant Client
        </div>

        <h1>Confirm Your Details</h1>
        <p class="subtitle">Select your Client ID. Your name will auto-fill — please enter the remaining details.</p>

        @if($errors->any())
            <div class="alert alert-error" style="margin-bottom:20px">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('registration.client.confirm.submit') }}" method="POST">
            @csrf

            <div style="margin-bottom:24px">
                {{-- NEW: UID Selector --}}
                <div class="form-group">
                    <label>Select Client ID</label>
                    <select name="selected_uid" id="uid-select" required>
                        <option value="">-- Select your Client ID --</option>
                        @foreach($client_users as $user)
                            <option value="{{ $user['uid'] }}" data-name="{{ $user['uName'] }}">
                                {{ $user['uid'] }} — {{ $user['uName'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Name auto-fills from selected UID --}}
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" id="full-name" placeholder="Select a Client ID above" readonly required>
                </div>

                {{-- Phone (from session, read-only) --}}
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" value="{{ $phone }}" required readonly>
                </div>

                {{-- Email — now manual because API doesn't send it --}}
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="your@email.com" required>
                </div>

                {{-- City — manual --}}
                <div class="form-group">
                    <label>City</label>
                    <input type="text" name="city" placeholder="e.g. Mumbai" required>
                </div>

                {{-- Type — manual --}}
                <div class="form-group">
                    <label>Type</label>
                    <select name="type" required>
                        <option value="investor" selected>Investor</option>
                        <option value="trader">Trader</option>
                    </select>
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label>Create Password</label>
                    <input type="password" name="password" placeholder="Min 8 characters" required>
                </div>
            </div>

            <div class="price-box">
                <div class="price">₹299 <span>₹599</span></div>
                <div class="lbl">Exclusive client price</div>
            </div>

            @if(request('ref'))
                <input type="hidden" name="referred_by" value="{{ request('ref') }}">
            @endif

            <button type="submit" class="btn btn-primary" style="width:100%">Confirm & Proceed to Payment</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('uid-select').addEventListener('change', function () {
        const option = this.options[this.selectedIndex];
        const name = option.dataset.name || '';
        document.getElementById('full-name').value = name;
    });
</script>
@endsection