@extends('layouts.app')

@section('title', 'Registrations — Admin')

@push('styles')
    <style>
        .admin-page {
            min-height: 100vh;
            padding: 40px 24px;
            background: var(--bg-soft)
        }

        .admin-wrap {
            max-width: 1200px;
            margin: 0 auto
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px
        }

        .filter-bar {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
            flex-wrap: wrap
        }

        .filter-bar input,
        .filter-bar select {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 10px 14px;
            color: #fff;
            font-size: 13px;
            outline: none
        }

        .filter-bar input {
            width: 240px
        }

        .filter-bar button {
            padding: 10px 20px;
            border-radius: 12px;
            background: var(--purple-1);
            color: #fff;
            border: none;
            font-weight: 600;
            cursor: pointer
        }

        .admin-section {
            background: linear-gradient(160deg, rgba(22, 12, 30, 0.9) 0%, rgba(8, 4, 12, 0.96) 100%);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 18px;
            padding: 24px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06)
        }

        th {
            color: var(--muted);
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase
        }

        td {
            color: var(--ink)
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600
        }

        .badge-paid {
            background: rgba(40, 180, 100, 0.15);
            color: #8ff0b3
        }

        .badge-pending {
            background: rgba(255, 180, 0, 0.15);
            color: #ffd700
        }

        .pagination {
            margin-top: 20px;
            display: flex;
            gap: 8px;
            justify-content: center
        }

        .pagination a,
        .pagination span {
            padding: 8px 14px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: var(--muted);
            font-size: 13px
        }

        .pagination span {
            background: var(--purple-1);
            color: #fff
        }
    </style>
@endpush

@section('content')
    <div class="admin-page">
        <div class="admin-wrap">
            <div class="admin-header">
                <h1>All Registrations</h1>
                <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                    <a
                        href="{{ route('admin.export', request()->query()) }}"
                        class="btn btn-primary"
                        style="font-size:13px;padding:9px 16px;"
                    >
                        <i class="fas fa-file-excel" style="margin-right:6px;"></i>
                        Export Excel
                    </a>

                    <a
                        href="{{ route('admin.dashboard') }}"
                        style="color:var(--purple-1);font-size:14px"
                    >
                        ← Back to Dashboard
                    </a>
                </div>
            </div>

            <form class="filter-bar" method="GET">
                <input type="text" name="search" placeholder="Search name, email, phone..." value="{{ request('search') }}">
                <select name="status">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="otp_verified" {{ request('status') == 'otp_verified' ? 'selected' : '' }}>OTP Verified
                    </option>
                    <option value="kyc_completed" {{ request('status') == 'kyc_completed' ? 'selected' : '' }}>KYC Done
                    </option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="checked_in" {{ request('status') == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                </select>
                <button type="submit">Filter</button>
            </form>

            <div class="admin-section">
                <table>
                    <thead>
                        <tr>
                            <th>Reg #</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Platform</th>
                            <th>Payment</th>
                            <th>Marked By</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $r)
                            <tr>
                                <td>{{ $r->registration_number }}<br>{{ $r->referral_code }}</td>
                                <td>{{ $r->full_name }}<br>{{ $r->is_subbroker ? 'Sub-broker' : ($r->is_existing_client ? 'Existing Client' : 'New Client') }}
                                </td>
                                <td>{{ $r->email }}</td>
                                <td>{{ $r->phone }}</td>
                                <td>{{ ucfirst($r->type) }}</td>
                                <td><span
                                        class="badge badge-{{ $r->status }}">{{ str_replace('_', ' ', ucfirst($r->status)) }}</span>
                                </td>
                                <td>{{ $r->platform }}</td>
                                <td>{{ $r->payment?->status ?? 'N/A' }}<br>{{ $r->payment?->gateway_order_id ? 'Order ID : ' . $r->payment?->gateway_order_id : '' }}<br>{{ $r->payment?->gateway_payment_id ? 'Payment ID : ' . $r->payment?->gateway_payment_id : '' }}
                                </td>
                                <td>
                                    @if($r->markedPaidBy)
                                        <span style="color:var(--purple-1);font-size:12px">
                                            {{ $r->markedPaidBy->name }}<br>
                                            <span style="color:var(--muted)">{{ $r->marked_paid_at?->format('M d, h:i A') }}</span>
                                        </span>
                                    @else
                                        <span style="color:var(--muted);font-size:12px">—</span>
                                    @endif
                                </td>
                                <td>{{ $r->created_at->format('M d') }}</td>
                                <td>
                                    @if($r->status !== 'paid')
                                    <button
                                        type="button"
                                        class="btn btn-primary"
                                        style="font-size:12px;padding:6px 14px"
                                        onclick="openMarkPaidModal({{ Js::from([
                                            'id' => $r->id,
                                            'registration_number' => $r->registration_number,
                                            'name' => $r->full_name,
                                            'phone' => $r->phone,
                                            'is_existing_client' => $r->is_existing_client,
                                        ]) }})"
                                    >
                                        Mark Paid
                                    </button>
                                @else
                                    <span style="color:#8ff0b3;font-size:12px">✓ Paid</span>
                                @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align:center;color:var(--muted);padding:40px">No registrations
                                    found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="pagination">{{ $registrations->links() }}</div>
            </div>
        </div>

        <div class="modal-overlay" id="markPaidModal"
            style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.75);backdrop-filter:blur(6px);z-index:9999;align-items:center;justify-content:center;padding:20px;opacity:0;transition:opacity 0.3s">
            <div class="modal-box"
                style="max-width:480px;width:100%;background:linear-gradient(165deg,#1a0f28 0%,#0d0614 100%);border:1px solid rgba(255,255,255,0.1);border-radius:22px;padding:32px;box-shadow:0 40px 100px rgba(0,0,0,0.8)">
                <h2 style="font-family:'Sora',sans-serif;font-size:20px;font-weight:700;margin-bottom:6px">Mark as Paid</h2>
                <p style="color:var(--muted);font-size:13px;margin-bottom:20px" id="modalRegInfo">—</p>

                <form action="{{ route('admin.registrations.mark-paid') }}" method="POST" id="markPaidForm">
                    @csrf
                    <input type="hidden" name="registration_id" id="modalRegId">

                    {{-- Toggle: Complimentary --}}
                    <div class="form-group"
                        style="margin-bottom:16px;padding:14px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:12px">
                        <label style="display:flex;align-items:center;gap:10px;cursor:pointer;font-size:14px;color:#e9e4f0">
                            <input type="checkbox" name="is_complimentary" id="isComplimentary" value="1"
                                style="width:18px;height:18px;accent-color:var(--purple-1)">
                            <span><strong>Complimentary / Free Registration</strong></span>
                        </label>
                        <small style="color:var(--muted);font-size:11px;display:block;margin-top:6px;margin-left:28px">
                            Check this for giveaways, guest passes, or referral rewards. No payment details needed.
                        </small>
                    </div>

                    {{-- Payment Fields (hidden when complimentary) --}}
                    <div id="paymentFields">
                        <div class="form-group" style="margin-bottom:14px">
                            <label
                                style="display:block;font-size:13px;font-weight:600;color:#e9e4f0;margin-bottom:6px">Transaction
                                ID / Payment Ref *</label>
                            <input type="text" name="gateway_payment_id" id="gatewayPaymentId"
                                placeholder="e.g. atomTxnId123"
                                style="width:100%;background:rgba(255,255,255,0.055);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:12px 14px;color:var(--ink);font-size:14px;outline:none">
                        </div>

                        <div class="form-group" style="margin-bottom:14px">
                            <label style="display:block;font-size:13px;font-weight:600;color:#e9e4f0;margin-bottom:6px">
                                Payment Mode *
                            </label>

                            <select name="payment_mode" id="paymentMode"
                                style="width:100%;background:rgba(255,255,255,0.055);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:12px 14px;color:var(--ink);font-size:14px;outline:none">
                                <option value="" style="background:#1a0f28">Select payment mode</option>
                                <option value="UPI" style="background:#1a0f28">UPI</option>
                                <option value="Cash" style="background:#1a0f28">Cash</option>
                                <option value="Bank Transfer" style="background:#1a0f28">Bank Transfer</option>
                                <option value="Card" style="background:#1a0f28">Card</option>
                                <option value="Cheque" style="background:#1a0f28">Cheque</option>
                                <option value="Other" style="background:#1a0f28">Other</option>
                            </select>
                        </div>
                    </div>

                    {{-- Referral Code --}}
                    <div class="form-group" style="margin-bottom:14px">
                        <label style="display:block;font-size:13px;font-weight:600;color:#e9e4f0;margin-bottom:6px">
                            Referral Code
                        </label>

                        <input type="text" name="referral_code" id="modalReferralCode"
                            placeholder="Enter referral code (optional)" maxlength="12"
                            style="width:100%;background:rgba(255,255,255,0.055);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:12px 14px;color:var(--ink);font-size:14px;outline:none;text-transform:uppercase">

                        <small style="color:var(--muted);font-size:11px;display:block;margin-top:5px">
                            Enter the referral code if this registration should be credited to a referrer.
                        </small>
                    </div>

                    {{-- Note --}}
                    <div class="form-group" style="margin-bottom:20px">
                        <label style="display:block;font-size:13px;font-weight:600;color:#e9e4f0;margin-bottom:6px">
                            Note
                        </label>

                        <textarea name="note" id="modalPaymentNote" rows="3" maxlength="500"
                            placeholder="Add an internal note (optional)..."
                            style="width:100%;resize:vertical;background:rgba(255,255,255,0.055);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:12px 14px;color:var(--ink);font-size:14px;outline:none"></textarea>
                    </div>

                    {{-- Amount Info --}}
                    <div id="paymentAmountInfo"
                        style="margin-bottom:20px;padding:14px 16px;background:rgba(124,58,237,0.08);border:1px solid rgba(124,58,237,0.2);border-radius:12px">

                        <div style="display:flex;justify-content:space-between;align-items:center">
                            <span style="font-size:13px;color:var(--muted)">
                                Registration Amount
                            </span>

                            <strong id="modalPaymentAmount" style="font-size:18px;color:#fff">
                                ₹599
                            </strong>
                        </div>

                        <small id="modalClientType" style="display:block;color:var(--muted);font-size:11px;margin-top:4px">
                            Standard registration
                        </small>
                    </div>

                    {{-- Actions --}}
                    <div style="display:flex;gap:10px;justify-content:flex-end">
                        <button type="button" onclick="closeMarkPaidModal()"
                            style="padding:11px 18px;border-radius:11px;border:1px solid rgba(255,255,255,0.1);background:rgba(255,255,255,0.05);color:#e9e4f0;font-size:13px;font-weight:600;cursor:pointer">
                            Cancel
                        </button>

                        <button type="submit" id="markPaidSubmitBtn"
                            style="padding:11px 20px;border-radius:11px;border:0;background:linear-gradient(135deg,#7c3aed,#9333ea);color:#fff;font-size:13px;font-weight:700;cursor:pointer;box-shadow:0 8px 25px rgba(124,58,237,0.25)">
                            Mark as Paid
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const markPaidModal = document.getElementById('markPaidModal');
        const markPaidForm = document.getElementById('markPaidForm');

        const modalRegId = document.getElementById('modalRegId');
        const modalRegInfo = document.getElementById('modalRegInfo');

        const isComplimentary = document.getElementById('isComplimentary');
        const paymentFields = document.getElementById('paymentFields');

        const gatewayPaymentId = document.getElementById('gatewayPaymentId');
        const paymentMode = document.getElementById('paymentMode');

        const paymentAmountInfo = document.getElementById('paymentAmountInfo');
        const modalPaymentAmount = document.getElementById('modalPaymentAmount');
        const modalClientType = document.getElementById('modalClientType');

        const markPaidSubmitBtn = document.getElementById('markPaidSubmitBtn');


        function openMarkPaidModal(registration) {

            modalRegId.value = registration.id;

            modalRegInfo.textContent =
                `${registration.registration_number ?? ''} • ${registration.name ?? ''} • ${registration.phone ?? ''}`;

            // Reset form
            isComplimentary.checked = false;
            gatewayPaymentId.value = '';
            paymentMode.value = '';
            document.getElementById('modalReferralCode').value = '';
            document.getElementById('modalPaymentNote').value = '';

            updatePaymentFields();

            // Determine registration amount
            const isExistingClient =
                registration.is_existing_client == 1 ||
                registration.is_existing_client === true;

            modalPaymentAmount.textContent =
                isExistingClient ? '₹399' : '₹599';

            modalClientType.textContent =
                isExistingClient
                    ? 'Existing client registration'
                    : 'Standard registration';

            // Show modal
            markPaidModal.style.display = 'flex';

            requestAnimationFrame(() => {
                markPaidModal.style.opacity = '1';
            });
        }


        function closeMarkPaidModal() {

            markPaidModal.style.opacity = '0';

            setTimeout(() => {
                markPaidModal.style.display = 'none';
            }, 300);
        }


        function updatePaymentFields() {

            if (isComplimentary.checked) {

                paymentFields.style.display = 'none';

                gatewayPaymentId.value = '';
                paymentMode.value = '';

                paymentAmountInfo.style.background =
                    'rgba(34,197,94,0.08)';

                paymentAmountInfo.style.borderColor =
                    'rgba(34,197,94,0.2)';

                modalPaymentAmount.textContent = '₹0';

                modalClientType.textContent =
                    'Complimentary / Free Registration';

                markPaidSubmitBtn.textContent =
                    'Mark as Complimentary';

            } else {

                paymentFields.style.display = 'block';

                paymentAmountInfo.style.background =
                    'rgba(124,58,237,0.08)';

                paymentAmountInfo.style.borderColor =
                    'rgba(124,58,237,0.2)';

                markPaidSubmitBtn.textContent =
                    'Mark as Paid';

                // Restore amount based on registration
                // Amount is updated when modal opens.
            }
        }


        isComplimentary.addEventListener('change', updatePaymentFields);


        // Close when clicking outside modal
        markPaidModal.addEventListener('click', function (e) {

            if (e.target === markPaidModal) {
                closeMarkPaidModal();
            }

        });


        // Escape key
        document.addEventListener('keydown', function (e) {

            if (e.key === 'Escape' &&
                markPaidModal.style.display === 'flex') {

                closeMarkPaidModal();
            }

        });


        // Prevent double submission
        markPaidForm.addEventListener('submit', function () {

            markPaidSubmitBtn.disabled = true;
            markPaidSubmitBtn.style.opacity = '0.6';
            markPaidSubmitBtn.style.cursor = 'not-allowed';

            markPaidSubmitBtn.textContent =
                isComplimentary.checked
                    ? 'Marking as Complimentary...'
                    : 'Marking as Paid...';
        });
    </script>
@endsection