@extends('layouts.app')

@section('title', 'Complete KYC — ArihantPLUS')

@push('styles')
<style>
    .kyc-page{min-height:100vh;padding:80px 24px 60px;background:var(--bg)}
    .kyc-card{max-width:600px;margin:0 auto;background:linear-gradient(165deg,#170b22 0%,#0b0511 100%);border:1px solid rgba(255,255,255,0.08);border-radius:26px;padding:42px 36px}
    .kyc-card h1{font-size:26px;font-weight:700;margin-bottom:8px}
    .kyc-card .subtitle{color:var(--muted);font-size:14px;margin-bottom:32px}
    .form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}
    .form-group{margin-bottom:20px}
    .form-group label{display:block;font-size:13px;font-weight:600;margin-bottom:8px;color:#e9e4f0}
    .form-group input,.form-group select,.form-group textarea{width:100%;background:rgba(255,255,255,0.055);border:1px solid rgba(255,255,255,0.1);border-radius:14px;padding:14px 16px;color:var(--ink);font-size:14px;font-family:'Inter',sans-serif;outline:none;transition:border-color .2s}
    .form-group input:focus,.form-group select:focus,.form-group textarea:focus{border-color:rgba(184,102,247,0.55)}
    .form-group input::placeholder{color:rgba(230,220,240,0.35)}
    .file-input{padding:12px !important}
    .step-bar{display:flex;gap:8px;margin-bottom:32px}
    .step-bar span{height:4px;flex:1;border-radius:2px;background:rgba(255,255,255,0.08)}
    .step-bar span.active{background:var(--purple-1)}
    @media(max-width:600px){.form-row{grid-template-columns:1fr}.kyc-card{padding:28px 22px}}
</style>
@endpush

@section('content')
<div class="kyc-page">
    <div class="kyc-card">
        <div class="step-bar">
            <span></span><span></span><span class="active"></span><span></span>
        </div>
        <h1>KYC Details</h1>
        <p class="subtitle">Required for regulatory compliance and account opening.</p>

        @if($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('registration.kyc.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label>PAN Number</label>
                    <input type="text" name="pan_number" value="{{ old('pan_number') }}" placeholder="ABCDE1234F" maxlength="10" required>
                </div>
                <div class="form-group">
                    <label>Aadhaar Number</label>
                    <input type="text" name="aadhaar_number" value="{{ old('aadhaar_number') }}" placeholder="12-digit Aadhaar" maxlength="12" required>
                </div>
            </div>
            <div class="form-group">
                <label>Full Address</label>
                <textarea name="address" rows="2" placeholder="House no, Street, Area" required>{{ old('address') }}</textarea>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>State</label>
                    <input type="text" name="state" value="{{ old('state') }}" required>
                </div>
                <div class="form-group">
                    <label>Pincode</label>
                    <input type="text" name="pincode" value="{{ old('pincode') }}" maxlength="6" required>
                </div>
            </div>
            <div class="form-group">
                <label>Income Proof Type</label>
                <select name="income_proof_type" required>
                    <option value="">Select...</option>
                    <option value="salary_slip" {{ old('income_proof_type')=='salary_slip'?'selected':'' }}>Salary Slip</option>
                    <option value="bank_statement" {{ old('income_proof_type')=='bank_statement'?'selected':'' }}>Bank Statement</option>
                    <option value="itr" {{ old('income_proof_type')=='itr'?'selected':'' }}>ITR Acknowledgment</option>
                    <option value="form16" {{ old('income_proof_type')=='form16'?'selected':'' }}>Form 16</option>
                </select>
            </div>
            <div class="form-group">
                <label>Upload Income Proof (PDF/JPG/PNG, max 2MB)</label>
                <input type="file" name="income_proof" class="file-input" accept=".pdf,.jpg,.png" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Photo (JPG/PNG, max 1MB)</label>
                    <input type="file" name="photo" class="file-input" accept=".jpg,.png" required>
                </div>
                <div class="form-group">
                    <label>Signature (JPG/PNG, max 512KB)</label>
                    <input type="file" name="signature" class="file-input" accept=".jpg,.png" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;margin-top:8px">Continue to Payment →</button>
        </form>
    </div>
</div>
@endsection
