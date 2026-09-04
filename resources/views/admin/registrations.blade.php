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
            overflow-x: auto
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
            text-transform: uppercase;
            letter-spacing: 0.05em
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

        .badge-checkin {
            background: rgba(184, 102, 247, 0.15);
            color: var(--purple-1)
        }

        .pagination {
            margin-top: 20px
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(6px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            transition: opacity 0.3s;
            display: none
        }

        .modal-overlay.active {
            display: flex;
            opacity: 1
        }

        .modal-box {
            max-width: 480px;
            width: 100%;
            background: linear-gradient(165deg, #1a0f28 0%, #0d0614 100%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 22px;
            padding: 32px;
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.8)
        }

        .modal-box h2 {
            font-family: 'Sora', sans-serif;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 6px
        }

        .modal-box label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--muted);
            margin-bottom: 6px
        }

        .modal-box input,
        .modal-box select {
            width: 100%;
            padding: 12px 14px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            font-size: 14px;
            outline: none;
            margin-bottom: 16px
        }

        .masked-info {
            background: rgba(255, 255, 255, 0.03);
            border: 1px dashed rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 16px
        }

        .masked-info p {
            margin: 4px 0;
            font-size: 13px;
            color: var(--muted)
        }
    </style>
@endpush

@section('content')
    <div class="admin-page">
        <div class="admin-wrap">
            <div class="admin-header">
                <h1>All Registrations</h1>
                <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
                    @permission('registrations', 'export')
                        <a href="{{ route('admin.export', request()->query()) }}" class="btn btn-primary"
                            style="font-size:13px;padding:9px 16px">
                            <i class="fas fa-file-excel" style="margin-right:6px;"></i> Export Excel
                        </a>
                    @endpermission
                    <a href="{{ route('admin.dashboard') }}" style="color:var(--purple-1);font-size:14px">← Back</a>
                </div>
            </div>

            <form class="filter-bar" method="GET" action="{{ route('admin.registrations') }}">
                <input type="text" name="search" placeholder="Search name, email, phone..."
                    value="{{ request('search') }}">
                <select name="status">
                    <option value="" style="color: #000;">All Status</option>
                    <option value="pending" style="color: #000;" {{ request('status') == 'pending' ? 'selected' : '' }}>
                        Pending</option>
                    <option value="paid" style="color: #000;" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid
                    </option>
                    <option value="checked_in" style="color: #000;"
                        {{ request('status') == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                    <option value="cancelled" style="color: #000;" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                        Cancelled</option>
                </select>
                <button type="submit">Filter</button>
            </form>

            <div class="admin-section">
                <table>
                    <thead>
                        <tr>
                            <th>Reg # / Code</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Branch List</th>
                            <th>Client List</th>
                            <th>Status</th>
                            <th>Platform</th>
                            <th>Payment</th>
                            <th>Marked By</th>
                            <th>Date</th>
                            @canAction('registrations', 'edit')
                            <th>Actions</th>
                            @endcanAction
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $r)
                            <tr>
                                <td>
                                    <strong>{{ $r->registration_number }}</strong><br>
                                    <span style="color:var(--muted);font-size:11px">{{ $r->referral_code }}</span>
                                </td>
                                <td>
                                    @if (auth()->check() && auth()->user()->canViewPii())
                                        {{ $r->full_name }}@else{{ \App\Models\User::maskName($r->full_name) }}
                                    @endif
                                </td>
                                <td>
                                    @if ($r->is_subbroker)
                                        <span class="badge"
                                            style="background:rgba(255,180,0,0.15);color:#ffd700">Sub-broker</span>
                                    @elseif($r->is_existing_client)
                                        <span class="badge"
                                            style="background:rgba(40,180,100,0.15);color:#8ff0b3">Existing</span>
                                    @else
                                        <span class="badge"
                                            style="background:rgba(100,160,255,0.15);color:#8cd4ff">New</span>
                                    @endif
                                </td>
                                <td>
                                    @if (auth()->check() && auth()->user()->canViewPii())
                                        {{ $r->email }}@else{{ \App\Models\User::maskEmail($r->email) }}
                                    @endif
                                </td>
                                <td>
                                    @if (auth()->check() && auth()->user()->canViewPii())
                                        {{ $r->phone }}@else{{ \App\Models\User::maskPhone($r->phone) }}
                                    @endif
                                </td>
                                <td style="min-width:250px;">
                                    @php
                                        $validationData = is_array($r->client_validation_data)
                                            ? $r->client_validation_data
                                            : json_decode($r->client_validation_data ?? '{}', true);

                                        $branchCodes = collect($validationData['branchlist'] ?? [])
                                            ->pluck('BranchCode')
                                            ->filter()
                                            ->unique()
                                            ->values();

                                        $clientBranchCodes = collect($validationData['clientlist'] ?? []);
                                    @endphp

                                    @if ($branchCodes->count())
                                        {{ $branchCodes->implode(', ') }}
                                    @else
                                        <span style="color:var(--muted)">—</span>
                                    @endif
                                </td>

                                <td style="min-width:250px;">
                                    @if ($clientBranchCodes->count())
                                        @foreach ($clientBranchCodes as $client)
                                            <div style="margin-bottom:6px;">
                                                <strong>{{ $client['BranchCode'] ?? '—' }}</strong>
                                                @if (!empty($client['RegionCode']))
                                                    <span style="color:var(--muted);">
                                                        — {{ $client['RegionCode'] }}
                                                    </span>
                                                @endif
                                                @if (!empty($client['ZoneCode']))
                                                    <span style="color:var(--muted);">
                                                        — {{ $client['ZoneCode'] }}
                                                    </span>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <span style="color:var(--muted)">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($r->status === 'checked_in')
                                        <span class="badge badge-checkin">Checked In</span>
                                    @elseif($r->status === 'paid')
                                        <span class="badge badge-paid">Paid</span>
                                    @else
                                        <span class="badge badge-pending">Pending</span>
                                    @endif
                                </td>
                                <td>{{ $r->platform }}</td>
                                <td>
                                    @if ($r->payment)
                                        {{ $r->payment->status === 'paid' ? 'Paid' : ucfirst($r->payment->status) }}
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>
                                    @if ($r->markedPaidBy)
                                        <span style="color:var(--purple-1);font-size:12px">
                                            {{ $r->markedPaidBy->name }}<br>
                                            <span
                                                style="color:var(--muted)">{{ $r->marked_paid_at?->format('M d, h:i A') }}</span>
                                        </span>
                                    @else
                                        <span style="color:var(--muted);font-size:12px">—</span>
                                    @endif
                                </td>
                                <td>{{ $r->created_at->format('M d, Y') }}</td>
                                @canAction('registrations', 'edit')
                                <td>
                                    @if ($r->status !== 'paid')
                                        <button type="button" class="btn btn-primary"
                                            style="font-size:12px;padding:6px 14px"
                                            onclick="openMarkPaidModal({{ Js::from([
                                                'id' => $r->id,
                                                'registration_number' => $r->registration_number,
                                                'name' => $r->full_name,
                                                'phone' => $r->phone,
                                                'is_existing_client' => $r->is_existing_client,
                                            ]) }})">
                                            Mark Paid
                                        </button>
                                    @else
                                        <span style="color:#8ff0b3;font-size:12px">Paid</span>
                                    @endif
                                </td>
                                @endcanAction
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" style="text-align:center;color:var(--muted);padding:40px">
                                    @canAction('registrations', 'view')
                                    No registrations found.
                                @else
                                    You do not have permission to view registrations.
                                    @endcanAction
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="pagination">{{ $registrations->withQueryString()->links() }}</div>
            </div>

            @canAction('registrations', 'edit')
            <div class="modal-overlay" id="markPaidModal">
                <div class="modal-box">
                    <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:20px">
                        <div>
                            <h2>Mark as Paid</h2>
                            <p style="color:var(--muted);font-size:13px;margin-top:4px">{{ $r->registration_number ?? '' }}
                            </p>
                        </div>
                        <button onclick="closeMarkPaidModal()"
                            style="background:none;border:none;color:var(--muted);font-size:24px;cursor:pointer;padding:0;line-height:1">&times;</button>
                    </div>

                    <div class="masked-info">
                        <p><strong>Participant:</strong> <span id="modalParticipantName">-</span></p>
                        <p><strong>Phone:</strong> <span id="modalParticipantPhone">-</span></p>
                        <p><strong>Type:</strong> <span id="modalParticipantType">-</span></p>
                    </div>

                    <form action="{{ route('admin.registrations.mark-paid') }}" method="POST" id="markPaidForm">
                        @csrf
                        <input type="hidden" name="registration_id" id="modalRegId">

                        <label>Gateway Payment ID (optional for complimentary)</label>
                        <input type="text" name="gateway_payment_id" placeholder="e.g. PAY_xxx or leave blank for free">

                        <label>Payment Mode</label>
                        <select name="payment_mode">
                            <option style="color: #000;" value="Complimentary">Complimentary (Free)</option>
                            <option style="color: #000;" value="Cash">Cash</option>
                            <option style="color: #000;" value="UPI">UPI</option>
                            <option style="color: #000;" value="Bank Transfer">Bank Transfer</option>
                            <option style="color: #000;" value="Cheque">Cheque</option>
                            <option style="color: #000;" value="Other">Other</option>
                        </select>

                        <label>Referral Code (12 chars, optional)</label>
                        <input type="text" name="referral_code" id="modalReferralCode" maxlength="12"
                            placeholder="e.g. ABC123XYZ456">

                        <label>Note</label>
                        <input type="text" name="note" placeholder="Optional note..." maxlength="500">

                        <div style="display:flex;gap:10px;margin-top:8px">
                            <button type="button" onclick="closeMarkPaidModal()"
                                style="flex:1;padding:12px;border-radius:12px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.08);color:var(--muted);cursor:pointer;font-weight:600">Cancel</button>
                            <button type="submit" id="markPaidSubmitBtn"
                                style="flex:1;padding:12px;border-radius:12px;background:var(--purple-1);color:#fff;border:none;cursor:pointer;font-weight:600">
                                Mark as Paid
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endcanAction
        </div>
    </div>
    </div>

    <script>
        function openMarkPaidModal(data) {
            document.getElementById('modalRegId').value = data.id;
            document.getElementById('modalParticipantName').textContent = data.name || '-';
            document.getElementById('modalParticipantPhone').textContent = data.phone || '-';
            document.getElementById('modalParticipantType').textContent = data.is_existing_client ? 'Existing Client' :
                'New Client';
            document.getElementById('modalReferralCode').value = '';
            var modal = document.getElementById('markPaidModal');
            modal.style.display = 'flex';
            requestAnimationFrame(function() {
                modal.style.opacity = '1';
            });
        }

        function closeMarkPaidModal() {
            var modal = document.getElementById('markPaidModal');
            modal.style.opacity = '0';
            setTimeout(function() {
                modal.style.display = 'none';
            }, 300);
        }

        document.getElementById('markPaidForm').addEventListener('submit', function() {
            var btn = document.getElementById('markPaidSubmitBtn');
            btn.disabled = true;
            btn.style.opacity = '0.6';
            btn.style.cursor = 'not-allowed';
            btn.textContent = 'Processing...';
        });

        document.getElementById('markPaidModal').addEventListener('click', function(e) {
            if (e.target === document.getElementById('markPaidModal')) {
                closeMarkPaidModal();
            }
        });
    </script>

@endsection
